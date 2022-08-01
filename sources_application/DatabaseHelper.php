<?php

class DatabaseHelper
{

    const username = 'a01505559'; // use a + your matriculation number
    const password = 'dbs20'; // use your oracle db password
    const con_string = 'oracle-lab.cs.univie.ac.at:1521/lab';  //on almighty "lab" is sufficient

    protected $conn;

    public function __construct()
    {
        try {
            $this->conn = @oci_connect(
                DatabaseHelper::username,
                DatabaseHelper::password,
                DatabaseHelper::con_string
            );

            if (!$this->conn) {
                die("DB error: Connection can't be established!");
            }

        } catch (Exception $e) {
            die("DB error: {$e->getMessage()}");
        }
    }

    public function __destruct()
    {
        @oci_close($this->conn);
    }
	
	//SELECT BELOW
	
	public function selectFromPostalCodesWhere($PC,$CI,$CABR)
    {

        $sql = "SELECT * FROM postal_code
            WHERE pc LIKE '%{$PC}%'
			AND upper(city_name) LIKE upper('%{$CI}%')
            AND upper(country_abbr) LIKE upper('%{$CABR}%')
            ORDER BY PC ASC";

        $statement = @oci_parse($this->conn, $sql);

        @oci_execute($statement);

        @oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);

        @oci_free_statement($statement);

        return $res;
    }
	
	public function selectFromProCatWhere($PID,$NA,$SU,$CID)
    {

		if ($CID == '') { //to avoid putting out every id with a 1 when querying for id 1
			$sql = "select productid, product.name, instock, supplier, price, category.categoryid, category.name as categoryname
				from product join category on category.categoryid = product.categoryid
				WHERE productid LIKE '%{$PID}%'
				AND upper(product.name) LIKE upper('%{$NA}%')
				AND upper(supplier) LIKE upper('%{$SU}%')
				ORDER BY productid ASC";
		}
		else {
			$sql = "select productid, product.name, instock, supplier, price, category.categoryid, category.name as categoryname
				from product join category on category.categoryid = product.categoryid
				WHERE productid LIKE '%{$PID}%'
				AND upper(product.name) LIKE upper('%{$NA}%')
				AND upper(supplier) LIKE upper('%{$SU}%')
				AND category.categoryid = '{$CID}'
				ORDER BY productid ASC";
		}

        $statement = @oci_parse($this->conn, $sql);

        @oci_execute($statement);

        @oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);

        @oci_free_statement($statement);

        return $res;
    }

	public function selectFromOrderhas2Where($OID,$PM,$CID,$PID)
    {
		//Need different if clauses in order to avoid spitting out e.g. 44 when searching for 4 (due to LIKE), multiple ids in one table make this tedious
		
		if ($OID != '' and $PM == '' and $CID == '' and $PID == '') { //if JUST orderid is imput 
			$sql = "select orderr.orderid, paymentmethod, price, customerid, productid, amount 
				from orderr join has2 on has2.orderid = orderr.orderid
				WHERE orderr.orderid = '{$OID}'
				ORDER BY orderr.orderid ASC";
		}
		else {
			//analogous principle
			if ($CID == '' and $PID == '') {
				$sql = "select orderr.orderid, paymentmethod, price, customerid, productid, amount 
				from orderr join has2 on has2.orderid = orderr.orderid
				WHERE orderr.orderid LIKE '%{$OID}%'
				AND upper(paymentmethod) LIKE upper('%{$PM}')
				ORDER BY orderr.orderid ASC";
			}
			else if ($CID != '' and $PID == '') {
				$sql = "select orderr.orderid, paymentmethod, price, customerid, productid, amount 
				from orderr join has2 on has2.orderid = orderr.orderid
				WHERE orderr.orderid LIKE '%{$OID}%'
				AND upper(paymentmethod) LIKE upper('%{$PM}')
				AND customerid = '{$CID}'
				ORDER BY orderr.orderid ASC";
			}
			else if ($CID == '' and $PID != '') {
				$sql = "select orderr.orderid, paymentmethod, price, customerid, productid, amount 
				from orderr join has2 on has2.orderid = orderr.orderid
				WHERE orderr.orderid LIKE '%{$OID}%'
				AND upper(paymentmethod) LIKE upper('%{$PM}')
				AND productid = '{$PID}'
				ORDER BY orderr.orderid ASC";
			}
			else {
				$sql = "select orderr.orderid, paymentmethod, price, customerid, productid, amount 
				from orderr join has2 on has2.orderid = orderr.orderid
				WHERE orderr.orderid LIKE '%{$OID}%'
				AND upper(paymentmethod) LIKE upper('%{$PM}')
				AND customerid = '{$CID}'
				AND productid LIKE '%{$PID}%'
				ORDER BY orderr.orderid ASC";
			}
		}
		
        $statement = @oci_parse($this->conn, $sql);

        @oci_execute($statement);

        @oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);

        @oci_free_statement($statement);

        return $res;
    }
	
	public function selectFromOrderWhere($OID,$PM,$CID)
    {
		
		//analogous to cases above
		
		if ($CID == '') {
			$sql = "SELECT * FROM orderr
				WHERE orderid LIKE '%{$OID}%'
				AND upper(paymentMethod) LIKE upper('%{$PM}%')
				ORDER BY orderid ASC";
		}
		else {
			$sql = "SELECT * FROM orderr
				WHERE orderid LIKE '%{$OID}%'
				AND upper(paymentMethod) LIKE upper('%{$PM}%')
				AND customerid = '{$CID}'
				ORDER BY orderid ASC";
		}
		
        $statement = @oci_parse($this->conn, $sql);

        @oci_execute($statement);

        @oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);

        @oci_free_statement($statement);

        return $res;
    }
	
	public function selectFromCustomerWhere($CID,$FN,$SN,$PC)
    {
        $sql = "SELECT * FROM customer
			WHERE customerID LIKE '%{$CID}%'
			AND upper(firstName) LIKE upper('%{$FN}%')
            AND upper(surname) LIKE upper('%{$SN}%')
			AND upper(postal_code) LIKE upper('%{$PC}%')
            ORDER BY customerID ASC";

        $statement = @oci_parse($this->conn, $sql);

        @oci_execute($statement);

        @oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);

        @oci_free_statement($statement);

        return $res;
    }
	
	public function selectFromDeliveryWhere($OID, $DT, $DD)
    {
		//analogous to cases above
		if ($DD == '') {
			$sql = "SELECT * FROM delivery
			WHERE orderid LIKE '%{$OID}%'
			AND upper(type) LIKE upper('%{$DT}%')
			ORDER BY orderid ASC";
		}
		else {
			$sql = "SELECT * FROM delivery
			WHERE orderid LIKE '%{$OID}%'
			AND upper(type) LIKE upper('%{$DT}%')
            AND deliverydate LIKE TO_DATE('{$DD}','DD.MM.YY')
            ORDER BY orderid ASC";
		}

        $statement = @oci_parse($this->conn, $sql);


        @oci_execute($statement);

        @oci_fetch_all($statement, $res, 0, 0, OCI_FETCHSTATEMENT_BY_ROW);

        @oci_free_statement($statement);

        return $res;
    }
	
	//UPDATE BELOW
	
	public function updateProduct($PID,$NP,$NS,$ATS) 
	{
		$sql = "UPDATE product SET ";
		
		$counter = 1;
		
		//need to diffentiate how much input I get (how many columns to update)
		if ($NP != "") {
			$sql = $sql . "price = {$NP}";
			$counter += 1;
		}
		if ($NS != "") {
			if ($counter != 1) {
				$sql = $sql . ", ";
			}
			$sql = $sql . "supplier = '{$NS}'";
			$counter += 1;
		}
		if ($ATS != "") {
			if ($counter != 1) {
				$sql = $sql . ", ";
			}
			$sql = $sql . "inStock = inStock + {$ATS}";
		}
		$sql = $sql . " WHERE productid = {$PID}";
		
		$statement = @oci_parse($this->conn, $sql);

        @oci_execute($statement) && @oci_commit($this->conn);
        @oci_free_statement($statement);
	}
	
	public function updateCustomer($CID,$TN,$PC,$STR)
    {
        $sql = "UPDATE customer SET ";
		
		$counter = 1;
		//need to diffentiate how much input I get (how many columns to update)
		if ($TN != "") {
			$sql = $sql . "telephoneNr = '{$TN}'";
			$counter += 1;
		}
		if ($PC != "") {
			if ($counter != 1) {
				$sql = $sql . ", ";
			}
			$sql = $sql . "postal_code = '{$PC}'";
			$counter += 1;
		}
		if ($STR != "") {
			if ($counter != 1) {
				$sql = $sql . ", ";
			}
			$sql = $sql . "street = '{$STR}'";
		}
        $sql = $sql . " WHERE customerid = {$CID}";
		
		//echo $sql;
        $statement = @oci_parse($this->conn, $sql);

        @oci_execute($statement) && @oci_commit($this->conn);
        @oci_free_statement($statement);
    }
	
	public function updateDelivery($OID,$DT,$DD)
    {
        $sql = "UPDATE delivery SET ";
		
		$counter = 1;
		//need to diffentiate how much input I get (how many columns to update)
		if ($DT != "") {
			$sql = $sql . "type = '{$DT}'";
			$counter += 1;
		}
		if ($DD != "") {
			if ($counter != 1) {
				$sql = $sql . ", ";
			}
			$sql = $sql . "deliverydate = TO_DATE('{$DD}','DD.MM.YY')";
			$counter += 1;
		}
        $sql = $sql . " WHERE orderid = {$OID}";
		
		//echo $sql;
        $statement = @oci_parse($this->conn, $sql);

        @oci_execute($statement) && @oci_commit($this->conn);
        @oci_free_statement($statement);
    }
	
	//INSERT BELOW
	
    public function insertIntoPostalCode($PostalCode, $City, $cabr)
    {
        $sql = "INSERT INTO postal_code (pc, city_name, country_abbr) VALUES ('{$PostalCode}', '{$City}', '{$cabr}')";

        $statement = @oci_parse($this->conn, $sql);
        $success = @oci_execute($statement) && @oci_commit($this->conn);
        @oci_free_statement($statement);
        return $success;
    }
	
	public function insertIntoCustomer($EA,$PC,$STR,$FN,$SN,$TN)
    {
        $sql = "INSERT INTO customer (emailAddress, postal_code, street, firstName, surname, telephoneNr) VALUES ('{$EA}', '{$PC}', '{$STR}','{$FN}','{$SN}','{$TN}')";

        $statement = @oci_parse($this->conn, $sql);
        $success = @oci_execute($statement) && @oci_commit($this->conn);
        @oci_free_statement($statement);
        return $success;
    }
	
	public function insertIntoProduct($NA,$IS,$SU,$PR,$CID)
    {
        $sql = "INSERT INTO product (name, inStock, supplier, price, categoryID) VALUES ('{$NA}', {$IS}, '{$SU}',{$PR},{$CID})";

        $statement = @oci_parse($this->conn, $sql);
        $success = @oci_execute($statement) && @oci_commit($this->conn);
        @oci_free_statement($statement);
        return $success;
    } 
	
	public function checkInStock($PIDS,$AMS)
	{
		//Check whether a certain product has enough in stock to be sold 
		$pids_arr = explode(",",$PIDS);
		$ams_arr = explode(",",$AMS);
		
		$i = 0;
		foreach ($pids_arr as $pid) {
			$sql = "SELECT INSTOCK FROM PRODUCT WHERE PRODUCTID = {$pid}";
			$statement = @oci_parse($this->conn, $sql);
			oci_define_by_name($statement, 'INSTOCK', $comparison);
			@oci_execute($statement);
			while (oci_fetch($statement)) {
				$instock = $comparison;
			}
			@oci_commit($this->conn);
			@oci_free_statement($statement);

			if ($instock < $ams_arr[$i]) { //actual check
				echo "ERROR NOT ENOUGH PRODUCTS OF ID {$pid} IN STOCK! ({$instock})";
				return false;
			}
			$i = $i + 1;
		}
		return true;
	}
	
	public function insertIntoOrder($PM,$CID,$PIDS,$AMS,$DT,$DD)
    {	
	
		$pids_arr = explode(",",$PIDS);
		$ams_arr = explode(",",$AMS);
			
        $sql = "INSERT INTO orderr (PaymentMethod, CustomerID) VALUES ('{$PM}',{$CID})"; //generates a new order entry
        $statement = @oci_parse($this->conn, $sql);
		@oci_execute($statement) && @oci_commit($this->conn);
		@oci_free_statement($statement);
	
		$sql = "SELECT MAX(ORDERID) FROM ORDERR"; //fetches the orderid of that last entry
		$statement = @oci_parse($this->conn, $sql);
		oci_define_by_name($statement, 'MAX(ORDERID)', $OID);
		@oci_execute($statement);
		while (oci_fetch($statement)) {
			$helpOID = $OID;
		}
		@oci_commit($this->conn);
		@oci_free_statement($statement);
		
		$sql = "INSERT INTO delivery (orderid, type, deliverydate) VALUES ({$helpOID},'{$DT}', TO_DATE('{$DD}','DD.MM.YY'))"; //inserts into delivery
		$statement = @oci_parse($this->conn, $sql);
		@oci_execute($statement) && @oci_commit($this->conn);
		@oci_free_statement($statement);
		
		$i = 0;
		foreach ($pids_arr as $pid) {
			
			$helper = $ams_arr[$i];
			$sql = "INSERT INTO has2 (orderid, productid, amount) VALUES ({$helpOID},{$pid},{$helper})"; //generates a new 'has2' entry
			$statement = @oci_parse($this->conn, $sql);
			@oci_execute($statement);
			@oci_commit($this->conn);
			@oci_free_statement($statement);
			
			$sql = "UPDATE PRODUCT SET instock = instock - {$helper} WHERE productid = {$pid}"; //updates instock of certain product
			$statement = @oci_parse($this->conn, $sql);
			@oci_execute($statement);
			@oci_commit($this->conn);
			@oci_free_statement($statement);
			
			$i = $i + 1;
		}
		
		$prices = [];
		foreach ($pids_arr as $pid) {
			$sql = "SELECT PRICE FROM PRODUCT WHERE PRODUCTID = ({$pid})"; //fetches the price of a product
			$statement = @oci_parse($this->conn, $sql);
			oci_define_by_name($statement, 'PRICE', $price);
			@oci_execute($statement);
			while (oci_fetch($statement)) {
				array_push($prices,$price);
			}
			@oci_commit($this->conn);
			@oci_free_statement($statement);
		}
		$totalprice = 0; //calculate total price
		$i = 0;
		foreach($ams_arr as $am) {
			$totalprice = $totalprice + $am * $prices[$i];
			$i = $i + 1;
		}
		
		$sql = "UPDATE orderr SET PRICE = ({$totalprice}) WHERE ORDERID = ({$helpOID})"; //updates price in order table
        $statement = @oci_parse($this->conn, $sql);
		@oci_execute($statement) && @oci_commit($this->conn);
		@oci_free_statement($statement);
		
    } 
	
	//DELETE BELOW
	
	public function deletePostalCode($pc)
    {

		$errorcode = -1;
        $sql = 'BEGIN P_DELETE_POSTAL_CODE(:pc, :errorcode); END;';
        $statement = @oci_parse($this->conn, $sql);

        @oci_bind_by_name($statement, ':pc', $pc);
		@oci_bind_by_name($statement, ':errorcode', $errorcode);

        @oci_execute($statement);


        @oci_free_statement($statement);
		return $errorcode;
    }
	
	public function deleteCustomer($CID)
    {

		$errorcode = -1;
        $sql = 'BEGIN P_DELETE_CUSTOMER(:CID, :errorcode); END;';
        $statement = @oci_parse($this->conn, $sql);

        @oci_bind_by_name($statement, ':CID', $CID);
		@oci_bind_by_name($statement, ':errorcode', $errorcode);

        @oci_execute($statement);


        @oci_free_statement($statement);
		return $errorcode;
    }
	
	public function deleteProduct($PID)
    {

		$errorcode = -1;
        $sql = 'BEGIN P_DELETE_PRODUCT(:PID, :errorcode); END;';
        $statement = @oci_parse($this->conn, $sql);

        @oci_bind_by_name($statement, ':PID', $PID);
		@oci_bind_by_name($statement, ':errorcode', $errorcode);

        @oci_execute($statement);


        @oci_free_statement($statement);
		return $errorcode;
    }
	
	public function deleteOrder($OID)
    {

		$errorcode = -1;
        $sql = 'BEGIN P_DELETE_ORDER(:OID, :errorcode); END;';
        $statement = @oci_parse($this->conn, $sql);

        @oci_bind_by_name($statement, ':OID', $OID);
		@oci_bind_by_name($statement, ':errorcode', $errorcode);

        @oci_execute($statement);


        @oci_free_statement($statement);
		return $errorcode;
    }
	
}