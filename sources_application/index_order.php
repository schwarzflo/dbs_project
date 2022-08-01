<?php

// Include DatabaseHelper.php file
require_once('DatabaseHelper.php');

// Instantiate DatabaseHelper class
$database = new DatabaseHelper();


if (isset($_GET['checkbox'])) { //if checkbox is ticked, different results are put out
	
	if (isset($_GET['submitquery'])) { //avoid printing results when initially loading the page
		$OID = '';
		if (isset($_GET['OID'])) {
			$OID = $_GET['OID'];
		}

		$PM = '';
		if (isset($_GET['PM'])) {
			$PM = $_GET['PM'];
		}

		$CID = '';
		if (isset($_GET['CID'])) {
			$CID = $_GET['CID'];
		}

		$PID = '';
		if (isset($_GET['PID'])) {
			$PID = $_GET['PID'];
		}
		$order_array = $database->selectFromOrderhas2Where($OID,$PM,$CID,$PID);	 //fetch data
	}
	else {
		$order_array = [];
	}
}
else {
	
	if (isset($_GET['submitquery'])) { //avoid printing results when initially loading the page
		$OID = '';
		if (isset($_GET['OID'])) {
			$OID = $_GET['OID'];
		}

		$PM = '';
		if (isset($_GET['PM'])) {
			$PM = $_GET['PM'];
		}

		$CID = '';
		if (isset($_GET['CID'])) {
			$CID = $_GET['CID'];
		}

		$order_array = $database->selectFromOrderWhere($OID,$PM,$CID); //fetch data
		
		if ($OID != '' and $PM == '' and $CID == '') { //avoid unnecessary results eg querying for 4 and getting every number that contains 4
			if (count($order_array) != 0) { //if array is empty to begin with dont print empty result 
				$helper = $order_array[0]; //just the first number of the array is wanted here
				$order_array = [];
				array_push($order_array,$helper);
			}
		}
	}
	else {
		$order_array = [];
	}
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
<h1><center>Order Methods</center></h1>
</div>
	<div class="card text-dark bg-light mb-3">
		<div class="card-body">
			<form method="get" action="addOrder.php">

				<div class="form-inline" style="font-size:14px">
					<label for="new_ea">Payment Method&emsp;</label>
					<input id="new_ea" name="PM" type="text" maxlength="30">
					&emsp;&emsp;
					<label for="new_pc">Customer ID&emsp;</label>
					<input id="new_pc" name="CID" type="number">
					&emsp;&emsp;
					<label for="new_pc">Product IDs (Put in with commas to separate)&emsp;</label>
					<input id="new_pc" name="PIDS" type="text" maxlength="100">
					&emsp;&emsp;
					<label for="new_pc">Product Amounts (Put in with commas to separate)&emsp;</label>
					<input id="new_pc" name="AMS" type="text" maxlength="100">
				</div>
				<br>
				<div class="form-inline" style="font-size:14px">
					<label for="new_pc">Delivery Type&emsp;</label>
					<input id="new_pc" name="DT" type="text" maxlength="30">
					&emsp;&emsp;
					<label for="new_pc">Delivery Date (DD.MM.YY)&emsp;</label>
					<input id="new_pc" name="DD" type="text" maxlength="30">
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
			<form method="get" action="deleteOrder.php">
				<div class="form-inline" style="font-size:14px">
					<label for="first">Order ID&emsp;</label>
					<input id="first" name="OID" type="number">
				</div>
				<br>

				<div>
					<button class="btn btn-danger btn" type="submit">
						Delete Entry
					</button>
					<div class="float-right"><div class="p-3 mb-2 text-muted"><h1>DELETING</h1></div></div>
				</div>
			</form>
			<br>
			<hr>
			<form method="get">

				<div class="form-inline" style="font-size:14px">
					<label for="person_id">Order ID&emsp;</label>
					<input id="person_id" name="OID" type="number">
					&emsp;&emsp;
					<label for="name">Payment Method&emsp;</label>
					<input id="name" name="PM" type="text" maxlength="20">
					&emsp;&emsp;
					<label for="surname">Customer ID&emsp;</label>
					<input id="surname" name="CID" type="number">
					&emsp;&emsp;
					<label for="surname">Product ID&emsp;</label>
					<input id="surname" name="PID" type="number">
				</div>
				<br>

				<div>
					<div class="form-inline" style="font-size:14px">
						<button name="submitquery" class="btn btn-primary btn" type="submit">
							Search Database
						</button>
						&emsp;&emsp;
						<div class="form-check">
								<input type="checkbox" name="checkbox" class="form-check-input" id="exampleCheck1">
								<label class="form-check-label" for="exampleCheck1">With Products</label>
						</div>
					</div>
					<br>
					<h3><?php echo strval(count($order_array)) . " Result(s)";?><div class="float-right"><div class="p-3 mb-2 text-muted"><h1>SEARCHING</h1></div></div></h3>
				</div>
			</form>
			<br>
			<table class="table">
				<thead>
					<tr>
						<th scope="col"><h3>Order ID&emsp;</h3></th>
						<th scope="col"><h3>Payment Method&emsp;</h3></th>
						<th scope="col"><h3>Price&emsp;</h3></th>
						<th scope="col"><h3>Customer ID&emsp;</h3></th>
						<th scope="col"><h3>Product ID&emsp;</h3></th>
						<th scope="col"><h3>Amount&emsp;</h3></th>
					</tr>
				</thead>
				<body>
				<?php foreach ($order_array as $order) : ?>
					<tr>
						<td><?php echo $order['ORDERID']; ?>  </td>
						<td><?php echo $order['PAYMENTMETHOD']; ?>  </td>
						<td><?php echo $order['PRICE']; ?>  </td>
						<td><?php echo $order['CUSTOMERID']; ?>  </td>
						<td><?php echo $order['PRODUCTID']; ?>  </td>
						<td><?php echo $order['AMOUNT']; ?>  </td>
					</tr>
				<?php endforeach; ?>
				</body>
			</table>
		</div>
	</div>
</body>
</html>