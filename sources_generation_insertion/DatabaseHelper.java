import java.io.FileReader;
import java.sql.*;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.concurrent.ThreadLocalRandom;

import com.opencsv.CSVReader;

class DatabaseHelper {
    private static final String DB_CONNECTION_URL = "jdbc:oracle:thin:@oracle-lab.cs.univie.ac.at:1521:lab";
    private static final String USER = "a01505559"; //TODO: use a + matriculation number
    private static final String PASS = "dbs20"; //TODO: use your password (default: dbs19)

    private static Statement stmt;
    private static Connection con;
 
    
    DatabaseHelper() {
        try {
            con = DriverManager.getConnection(DB_CONNECTION_URL, USER, PASS);
            stmt = con.createStatement();

        } catch (Exception e) {
            e.printStackTrace();
        }
    }
    
    
    //HELPING FUNCTIONS below
    
    
    String givemecode() { //returns random postalcode out of the textfile which is used to insert postal codes into the database
    	
    	try {
         	
			CSVReader reader = new CSVReader(new FileReader("inserts\\java_postalcodes.txt"));
			     	
			     	String[] codes = new String[0];
			        String[] nextline;
			        while((nextline = reader.readNext()) != null) {
			        	if(nextline != null) {
			        		codes = Arrays.copyOf(codes, codes.length + 1);
			                codes[codes.length - 1] = nextline[0];
			            }
			        }
			        int randomNum = ThreadLocalRandom.current().nextInt(0, 100 + 1); 
			        return codes[randomNum];
    		}       
       catch(Exception e) {
    	   System.out.println(e);
       }
    
    System.out.println("Error in GIVEMECODE");
    return "fail";
    }
     

    int givemeeid() { //returns random employee id using sql intrinsic dbms_random.random function
      	
    	int eid;
    	 
    	try {
        	ResultSet rs = stmt.executeQuery("SELECT employeeid\n" + 
             		"FROM   (" + 
             		"    SELECT *" + 
             		"    FROM employee" + 
             		"    ORDER BY DBMS_RANDOM.RANDOM)" + 
             		"WHERE  rownum < 2");
             while (rs.next()) {
                 eid = rs.getInt("employeeid");
                 return eid;
             }
             rs.close();
        } catch (Exception e) {
             System.err.println(("Error at: selectrandomcustomerid\n message: " + e.getMessage()).trim());
        }
    	System.out.println("Error in GIVEMEEID");
    	return 0;
    }
     
     
    int givemecid() { //returns random customer id using sql intrinsic dbms_random.random function
     	
    	 int cid;
    	 
         try {
        	 ResultSet rs = stmt.executeQuery("SELECT customerid\n" + 
             		"FROM   (" + 
             		"    SELECT *" + 
             		"    FROM customer" + 
             		"    ORDER BY DBMS_RANDOM.RANDOM)" + 
             		"WHERE  rownum < 2");
             while (rs.next()) {
                 cid = rs.getInt("customerid");
                 return cid;
             }
             rs.close();
         } catch (Exception e) {
             System.err.println(("Error at: selectrandomcustomerid\n message: " + e.getMessage()).trim());
         }
         System.out.println("Error in GIVEMECID");
         return 0;
    }
    
    
    int givemepid() { //returns random product id using sql intrinsic dbms_random.random function
    	 
    	 int pid;
    	 
         try {
        	 ResultSet rs = stmt.executeQuery("SELECT productid\n" + 
             		"FROM   (" + 
             		"    SELECT *" + 
             		"    FROM product" + 
             		"    ORDER BY DBMS_RANDOM.RANDOM)" + 
             		"WHERE  rownum < 2");
             while (rs.next()) {
                 pid = rs.getInt("productid");
                 return pid;
             }
             rs.close();
         } catch (Exception e) {
             System.err.println(("Error at: selectrandomproductid\n message: " + e.getMessage()).trim());
         }
         System.out.println("Error in GIVEMEPID");
         return 0;
     }
    
     
    int rowsinOrder() { //returns the amount of orders in the database
    	 
    	 try {
    		ResultSet rs = stmt.executeQuery("select count(*) from orderr");
    	 	int rows;
			while (rs.next()) {
				rows = rs.getInt("count(*)");
				return rows;
			}
    	 } catch (Exception e) {
         System.err.println("Error at: rowsinOrder\nmessage: " + e.getMessage());
    	 }
    	 System.out.println("Error in ROWSINORDER");
    	 return 0;
    }
     
    
    void fillPriceinOrder() { //updates price values in table Order after table has2 has been filled in
 		try {
 			int oid = 1;
 			double price = 0;
 			int rows = rowsinOrder();
            while (oid <= rows) {
            	ResultSet rs = stmt.executeQuery("with temp as(" + 
	 					"select orderid, amount*sum(price) as newprice from has2 natural join " + 
	 					"product group by orderid, amount order by orderid asc)" + 
	 					"select sum(newprice) from temp group by orderid having orderid = " + oid);
            	while (rs.next()) {
                    price = rs.getDouble("sum(newprice)");
            	}
            	String sql = "UPDATE orderr SET price = " + price + " WHERE orderid = " + oid;
                stmt.execute(sql);
	 			oid++;
            }
 		} catch (Exception e) {
 			System.err.println("Error at: fill in price\nmessage: " + e.getMessage());
 		}
 	}
    
    
    ArrayList<Integer> selectOIDS() { //returns list of all Orders that have been inserted
    	
        ArrayList<Integer> OIDs = new ArrayList<>();

        try {
            ResultSet rs = stmt.executeQuery("SELECT orderid FROM orderr");
            while (rs.next()) {
                OIDs.add(rs.getInt("orderid"));
            }
            rs.close();
        } catch (Exception e) {
            System.err.println(("Error at: selectPersonIsFromPerson\n message: " + e.getMessage()).trim());
        }
        return OIDs;
    }
    
    
    //INSERTS below
    
    
    void insertIntoCustomer() { //Inserts tuples into Customer, foreign key postal_code is handled via givemecode()
    	
    	try {
        	
    		CSVReader reader = new CSVReader(new FileReader("inserts\\java_customer.txt"));

            String[] nextline;
            while((nextline = reader.readNext()) != null) {
                if(nextline != null) {
                	try {	
                		String email = nextline[0];
                		String street = nextline[1];
                		String firstname = nextline[2];
                		String surname = nextline[3];
                		String tn = nextline[4];
                		String poc = givemecode();
                		
                		String sql = "INSERT INTO CUSTOMER (emailAddress, postal_code, street, firstname, surname,"
	            		+ "telephonenr) VALUES ('" +
		                    email +
		                    "', '" +
		                    poc +
		                    "', '" +
		                    street +
		                    "', '" +
		                    firstname +
		                    "', '" +
		                    surname +
		                    "', '" +
		                    tn +
		                    "')";
                		stmt.execute(sql);
			        } catch (Exception e) {
			            System.err.println("Error at: insertIntoCustomer\nmessage: " + e.getMessage());
			        }
			    }
            }
       }       
       catch(Exception e) {
    	   System.out.println(e);
       }
    }
    
   
    void insertIntoEmployee() { //Inserts tuples into Employee, foreign key postal_code is handled via givemecode()
    	    	
        try {
        	
        	CSVReader reader = new CSVReader(new FileReader("inserts\\java_employee.txt"));

            String[] nextline;
            while((nextline = reader.readNext()) != null) {
                if(nextline != null) {
                	try {	
                		String firstname = nextline[0];
                		String surname = nextline[1];
                		String tn = nextline[2];
                		double wh = Double.parseDouble(nextline[3]);
                		double pc = Double.parseDouble(nextline[4]);
                		String str = nextline[5];
                		String pos = nextline[6];
                		String poc = givemecode();
                		
                		String sql = "INSERT INTO EMPLOYEE (FIRSTNAME, SURNAME, TELEPHONENR, workinghours, paycheck,"
	            		+ "postal_code, street, position) VALUES ('" +
		                    firstname +
		                    "', '" +
		                    surname +
		                    "', '" +
		                    tn +
		                    "', " +
		                    wh +
		                    ", " +
		                    pc +
		                    ", '" +
		                    poc +
		                    "', '" +
		                    str +
		                    "', '" +
		                    pos +
		                    "')";
                		stmt.execute(sql);
			        } catch (Exception e) {
			            System.err.println("Error at: insertIntoEmployee\nmessage: " + e.getMessage());
			        }
			    }
            }
       }       
       catch(Exception e) {
    	   System.out.println(e);
       }
    }

    
    void insertIntoPostalCode() { //Inserts tuples into Postal_Code
    	
    	try {

            CSVReader reader = new CSVReader(new FileReader("inserts\\java_postalcodes.txt"));

            String[] nextline;
            while((nextline = reader.readNext()) != null) {
                if(nextline != null) {
                	try {
                		String pc = nextline[0];
                		String city = nextline[1];
                		String ca = nextline[2];
            			String sql = "INSERT INTO postal_code (pc,city_name,country_abbr) VALUES ('" +
            			    pc +
            			    "', '" +
            			    city +
            			    "', '" +
            			    ca +
            			    "')";
            			stmt.execute(sql);
            		} catch (Exception e) {
            			System.err.println("Error at: insertIntopostal_codes\nmessage: " + e.getMessage());
            		}
                }
            }
        }
        catch(Exception e) {
            System.out.println(e);
        }
	}
    
    
    void insertIntoTargetGroup() { //Inserts tuples into Target Group
    	
    	try {

            CSVReader reader = new CSVReader(new FileReader("inserts\\java_targetgroup.txt"));

            String[] nextline;
            while((nextline = reader.readNext()) != null) {
                if(nextline != null) {
                	try {
                		String tgn = nextline[0];
            			String sql = "INSERT INTO TargetGroup (name) VALUES ('" +
            			    tgn +
            			    "')";
            			stmt.execute(sql);
            		} catch (Exception e) {
            			System.err.println("Error at: insertIntopostal_codes\nmessage: " + e.getMessage());
            		}
                }
            }
        }
        catch(Exception e) {
            System.out.println(e);
        }
	}

 
    void insertIntoCategory() { //Inserts tuples into Category
 	
    	try {

    		CSVReader reader = new CSVReader(new FileReader("inserts\\java_category.txt"));

            String[] nextline;
            while((nextline = reader.readNext()) != null) {
            	if(nextline != null) {
            		try {
	             		String cn = nextline[0];
	         			String sql = "INSERT INTO category (name) VALUES ('" +
	         			    cn +
	         			    "')";
	         			stmt.execute(sql);
            		} catch (Exception e) {
            			System.err.println("Error at: insertIntopostal_codes\nmessage: " + e.getMessage());
            		}
            	}
            }
    	}
    	catch(Exception e) {
    		System.out.println(e);
    	}
	}
 

    void insertIntoProduct() { //Inserts tuples into Product, Foreign Key Handeling not possible, realism should be conserved, not every product can be part of every category
	 	
	 	try {

	         CSVReader reader = new CSVReader(new FileReader("inserts\\java_product.txt"));

	         String[] nextline;
	         while((nextline = reader.readNext()) != null) {
	             if(nextline != null) {
	             	try {
	             		String name = nextline[0];
	             		double is = Double.parseDouble(nextline[1]);
	             		String supplier = nextline[2];
	             		double price = Double.parseDouble(nextline[3]);
	             		int cid = Integer.parseInt(nextline[4]);
	         			String sql = "INSERT INTO product (name, instock, supplier, price, categoryid) VALUES ('" +
	         			    name +
	         			    "', " + 
	         			    is +
	         			    ", '" +
	         			    supplier +
	         			    "', " +
	         			    price +
	         			    ", " +
	         			    cid +
	         			    ")";
	         			stmt.execute(sql);
	         		} catch (Exception e) {
	         			System.err.println("Error at: insertIntoProduct\nmessage: " + e.getMessage());
	         		}
	             }
	         }
	     }
	     catch(Exception e) {
	         System.out.println(e);
	     }
	}
    
    
    void insertIntoOrder() { //Insert tuples into Order, foreign key customerid is handled via givemecid(); price is not yet inserted, instead it is updated after insertion into has2
 	
    	try {

    		CSVReader reader = new CSVReader(new FileReader("inserts\\java_order.txt"));

            String[] nextline;
            while((nextline = reader.readNext()) != null) {
            	if(nextline != null) {
            		try {
	             		String pm = nextline[0];
	             		int cid = givemecid();
	         			String sql = "INSERT INTO Orderr (paymentmethod,customerid) VALUES ('" +
	         			    pm +
	         			    "', " +
	         			    cid +
	         			    ")";
	         			stmt.execute(sql);
            		} catch (Exception e) {
         			System.err.println("Error at: insertintoorder\nmessage: " + e.getMessage());
            		}
            	}
            }
    	}
    	catch(Exception e) {
         System.out.println(e);
    	}
	}

 
    void insertIntohas2() { //Insert tuples into has2, for a 50% chance any order can have two instead of one products, for a 25% chance three, ect..; foreign key of product id is handled via givemepid()  
	 	
	 	int oid = 1;
	 	boolean breaker;
	 	ArrayList<Integer> dontuse = new ArrayList<>();
	 
	 	while (oid <= 500) {
	 		try {
	 			int pid;
	 			while (true) {
	 				breaker = true;
	 				pid = givemepid();
	 				for (int i = 0; i < dontuse.size(); i++) {
	 					if (dontuse.get(i) == pid) {
	 						breaker = false;
	 					}
	 				}
	 				if (breaker == true) {
	 					break;
	 				}	
	 			}
	 			dontuse.add(pid);
	 			
	 			int am = ThreadLocalRandom.current().nextInt(1, 5 + 1);
	 			String sql = "INSERT INTO has2 (orderid,productid,amount) VALUES (" +
	  			    oid +
	  			    ", " +
	  			    pid +
	  			    ", " +
	  			    am +
	  			    ")";
	 			if (Math.random() < 0.5) {
	  				oid++;
	  				dontuse.clear();
	 			}
	 			stmt.execute(sql);
	 		} catch (Exception e) {
	 			System.err.println("Error at: insertintoorder\nmessage: " + e.getMessage());
	 		}
	 	}
    }
 

 	void insertIntoDelivery() { //Inserts tuples into delivery, goes through list of all inserted orders to do so
 	 	
 	 	try {

 	         CSVReader reader = new CSVReader(new FileReader("inserts\\java_delivery.txt"));
 	         ArrayList<Integer> OIDS = selectOIDS();
 	         int oid, i = 0;
 	         
 	         String[] nextline;
 	         while((nextline = reader.readNext()) != null) {
 	             if(nextline != null) {
 	             	try {
 	             			oid = OIDS.get(i);
	 	             		String type = nextline[0];
	 	             		String date = nextline[1];
	 	         			String sql = "INSERT INTO delivery (orderid,type,deliverydate) VALUES (" +
	 	         			    oid +
	 	         			    ", '" +
	 	         			    type +
	 	         			    "', TO_DATE('" +
	 	         			    date +
	 	         			    "','DD/MM/YY'))";
	 	         			stmt.execute(sql);
	 	         			i += 1;
 	         		} catch (Exception e) {
 	         			System.err.println("Error at: insertintodelivery\nmessage: " + e.getMessage());
 	         		}
 	             }
 	         }
 	     }
 	     catch(Exception e) {
 	         System.out.println(e);
 	     }
 	}
 	
 	
 	void insertIntohas1() { //using two columns of order to fill this table (it is basically redundant)
 		try {
 			String sql = "INSERT INTO has1 (orderid,customerid) SELECT "
 					+ "orderid,customerid FROM orderr order by orderid asc";
 			stmt.execute(sql);
 		}catch (Exception e) {
  			System.err.println("Error at: insertintohas1\nmessage: " + e.getMessage());
 			
 		}
 		
 	}

 	
 	void insertIntoworksOn() { //similar approach to insertIntohas2(), foreign key employee id is handled via givemeeid
 	 	
 		int oid = 1;
 	 	boolean breaker;
	 	ArrayList<Integer> dontuse = new ArrayList<>();
	 
	 	while (oid <= 500) {
	 		try {
	 			int eid;
	 			while (true) {
	 				breaker = true;
	 				eid = givemeeid();
	 				for (int i = 0; i < dontuse.size(); i++) {
	 					if (dontuse.get(i) == eid) {
	 						breaker = false;
	 					}
	 				}
	 				if (breaker == true) {
	 					break;
	 				}	
	 			}
	 			dontuse.add(eid);
	 			
	 			String sql = "INSERT INTO worksOn (orderid,employeeid) VALUES (" +
	   			    oid +
	   			    ", " +
	   			    eid +
	   			    ")";
	   			if (Math.random() < 0.5) {
	   				oid++;
	   				dontuse.clear();
	   			}
	   			stmt.execute(sql);
	 		} catch (Exception e) {
	 			System.err.println("Error at: insertintoworkson\nmessage: " + e.getMessage());
	 		}
 	 	}
 	}

 	 
 	void inserintoRefers() { //insert 100 referral tuples into refers, foreign keys customerid are handled via givemecid, the same customer can't refer himself
 		 
 		 try {
 			 int i = 0;
 			 while (i < 100) {
 				int cid1 = givemecid();
 				int cid2 = givemecid();
 				
 				if (cid1 != cid2) {
 					String sql = "INSERT INTO refers (customer1id,customer2id) VALUES (" +
 							cid1 +
 							"," +
 							cid2 +
 							")";
 					stmt.execute(sql);
 					i++;
 				}
 			 }
 		 } catch (Exception e) {
 	   		System.err.println("Error at: insertintoRefers\nmessage: " + e.getMessage());
 	   	 }	 
 	 }

 	
 	void insertintohasTG() { //insert into hasTargetGroup, Foreign Key Handeling not possible, realism should be conserved, not every target group can like every category 
 		try {

            CSVReader reader = new CSVReader(new FileReader("inserts\\java_hasTG.txt"));

            String[] nextline;
            while((nextline = reader.readNext()) != null) {
                if(nextline != null) {
                	try {
                		String tg = nextline[0];
                		int cid = Integer.parseInt(nextline[1]);
            			String sql = "INSERT INTO hastargetgroup (TGName, categoryID) VALUES ('" +
            			    tg +
            			    "', " +
            			    cid +
            			    ")";
            			stmt.execute(sql);
            		} catch (Exception e) {
            			System.err.println("Error at: insertIntohasTG\nmessage: " + e.getMessage());
            		}
                }
            }
        }
        catch(Exception e) {
            System.out.println(e);
        }
	}
 	 
 	
 	//CLEAN UP below

 	
    public void close()  {
        try {
            stmt.close(); //clean up
            con.close();
        } catch (Exception ignored) {
        }
    }
}