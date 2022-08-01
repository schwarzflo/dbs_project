<?php

// Include DatabaseHelper.php file
require_once('DatabaseHelper.php');

// Instantiate DatabaseHelper class
$database = new DatabaseHelper();

// Get parameter 'person_id', 'surname' and 'name' from GET Request
// Btw. you can see the parameters in the URL if they are set

if (isset($_GET['submitquery'])) { //check if submit was pressed in order not to print results initially
	
	$CID = '';
	if (isset($_GET['CID'])) {
		$CID = $_GET['CID'];
	}

	$FN = '';
	if (isset($_GET['FN'])) {
		$FN = $_GET['FN'];
	}

	$SN = '';
	if (isset($_GET['SN'])) {
		$SN = $_GET['SN'];
	}
	
	$PC = '';
	if (isset($_GET['PC'])) {
		$PC = $_GET['PC'];
	}
	
	$customer_array = $database->selectFromCustomerWhere($CID, $FN, $SN, $PC); //fetch data

	if ($CID != '' and $FN == '' and $SN == '' and $PC == '') { //avoid unnecessary results eg querying for 4 and getting every number that contains 4
		if (count($customer_array) != 0) { //if array is empty to begin with dont print empty result 
			$helper = $customer_array[0]; //just the first number of the array is wanted here
			$customer_array = [];
			array_push($customer_array,$helper);
		}	
	}
}
else {
	$customer_array = [];
}
?>

<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">


	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <title>DBS Project</title>
</head>

<body>
<div class="card text-light bg-dark mb-3">
<a class="btn btn-primary btn" href="index_main.php" role="button" style="width:5%">Home</a>
<h1><center>Customer Methods</center></h1>
</div>
	<div class="card text-dark bg-light mb-3">
		<div class="card-body">
			<form method="get" action="addCustomer.php">
 
				<div class="form-inline" style="font-size:14px">
					<label for="new_ea">Email Address&emsp;</label>
					<input id="new_ea" name="EA" type="text" maxlength="30">
					&emsp;&emsp;
					<label for="new_pc">Postal Code&emsp;</label>
					<input id="new_pc" name="PC" type="text" maxlength="20">
					&emsp;&emsp;
					<label for="new_str">Street&emsp;</label>
					<input id="new_str" name="STR" type="text" maxlength="40">
					&emsp;&emsp;
					<label for="new_fn">Firstname&emsp;</label>
					<input id="new_fn" name="FN" type="text" maxlength="30">
					&emsp;&emsp;
					<label for="new_sn">Surname&emsp;</label>
					<input id="new_sn" name="SN" type="text" maxlength="30">
					&emsp;&emsp;
					<label for="new_tn">Telephone Number&emsp;</label>
					<input id="new_tn" name="TN" type="text" maxlength="30">
				</div>
				<br>

				<div>
					<button class="btn btn-success btn" type="submit">
						Add Entry
					</button>
					<div class="float-right"><div class="p-3 mb-2 text-muted"><h1>ADDING</h1></div></div>
				</div>
			</form>
			<br>
			<hr>

			<form method="get" action="updateCustomer.php">

				<div class="form-inline" style="font-size:14px">
					<label for="new_ea">Customer ID&emsp;</label>
					<input id="new_ea" name="CID" type="number">
					&emsp;&emsp;
					<label for="new_str">Postal Code&emsp;</label>
					<input id="new_str" name="PC" type="text" maxlength="40">
					&emsp;&emsp;
					<label for="new_fn">Street&emsp;</label>
					<input id="new_fn" name="STR" type="text" maxlength="30">
					&emsp;&emsp;
					<label for="new_pc">Telephone Number&emsp;</label>
					<input id="new_pc" name="TN" type="text" maxlength="20">
				</div>
				<br>

				<div>
					<button class="btn btn-warning btn" type='submit'>
						Update Entry
					</button>
					<div class="float-right"><div class="p-3 mb-2 text-muted"><h1>UPDATING</h1></div></div>
				</div>
			</form>
			<br>
			<hr>
			
			<form method="get" action="deleteCustomer.php">
				<div class="form-inline" style="font-size:14px">
					<label for="first">Customer ID&emsp;</label>
					<input id="first" name="CID" type="number">
				</div>
				<br>
				<div>
					<button class="btn btn-danger btn" type='submit'>
						Delete Entry
					</button>
					<div class="float-right"><div class="p-3 mb-2 text-muted"><h1>DELETING</h1></div></div>
				</div>
			</form>
			<br>
			<hr>
			
			<form method="get">
				<div class="form-inline" style="font-size:14px">
					<label for="name">Customer ID&emsp;</label>
					<input id="name" name="CID" type="number">
					&emsp;&emsp;
					<label for="name">Firstname&emsp;</label>
					<input id="name" name="FN" type="text" maxlength="30">
					&emsp;&emsp;
					<label for="surname">Surname&emsp;</label>
					<input id="surname" name="SN" type="text" maxlength="30">
					&emsp;&emsp;
					<label for="surname">Postal Code&emsp;</label>
					<input id="surname" name="PC" type="text" maxlength="30">
				</div>
				<br>
				<div>
					<button name="submitquery" class="btn btn-primary btn" type='submit'>
						Search Database
					</button>
					<br>
					<br>
					<h3><?php echo strval(count($customer_array)) . " Result(s)";?><div class="float-right"><div class="p-3 mb-2 text-muted"><h1>SEARCHING</h1></div></div></h3>
				</div>
			</form>
			<br>

			<table class="table">
				<thead>
					<tr>
						<th scope="col"><h3>Customer ID&emsp;</h3></th>
						<th scope="col"><h3>Email Address&emsp;</h3></th>
						<th scope="col"><h3>Postal Code&emsp;</h3></th>
						<th scope="col"><h3>Street&emsp;</h3></th>
						<th scope="col"><h3>Firstname&emsp;</h3></th>
						<th scope="col"><h3>Surname&emsp;</h3></th>
						<th scope="col"><h3>Telephone Number&emsp;</h3></th>
					</tr>
				</thead>
				<?php foreach ($customer_array as $customer) : ?>
					<tbody>
						<tr>
							<td><?php echo $customer['CUSTOMERID']; ?>  </td>
							<td><?php echo $customer['EMAILADDRESS']; ?>  </td>
							<td><?php echo $customer['POSTAL_CODE']; ?>  </td>
							<td><?php echo $customer['STREET']; ?>  </td>
							<td><?php echo $customer['FIRSTNAME']; ?>  </td>
							<td><?php echo $customer['SURNAME']; ?>  </td>
							<td><?php echo $customer['TELEPHONENR']; ?>  </td>
						</tr>
					<thead>
				<?php endforeach; ?>
			</table>

	</div>
</div>
</body>
</html>