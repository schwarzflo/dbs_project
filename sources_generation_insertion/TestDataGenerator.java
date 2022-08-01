import java.io.FileReader;
import java.util.ArrayList;
import com.opencsv.CSVReader;

public class Tester {

	public static void main(String[] args) {
		DatabaseHelper dbHelper=new DatabaseHelper();

		System.out.println("Inserting PostalCodes..");
		dbHelper.insertIntoPostalCode();
		System.out.println("Inserting Employees..");
		dbHelper.insertIntoEmployee();
		System.out.println("Inserting Customers..");
		dbHelper.insertIntoCustomer();
		System.out.println("Inserting Category..");
		dbHelper.insertIntoCategory();
		System.out.println("Inserting TargetGroup..");
		dbHelper.insertIntoTargetGroup();
		System.out.println("Inserting Product..");
		dbHelper.insertIntoProduct();
		System.out.println("Inserting Orders..");
		dbHelper.insertIntoOrder();
		System.out.println("Inserting has2..");
		dbHelper.insertIntohas2();
		System.out.println("Updating Price in Order..");
		dbHelper.fillPriceinOrder();
		System.out.println("Inserting Deliveries..");
		dbHelper.insertIntoDelivery();
		System.out.println("Inserting has1..");
		dbHelper.insertIntohas1();
		System.out.println("Inserting worksOn..");
		dbHelper.insertIntoworksOn();
		System.out.println("Inserting refers..");
		dbHelper.inserintoRefers();
		System.out.println("Inserting hasTG..");
		dbHelper.insertintohasTG();

		dbHelper.close();
	}

}
