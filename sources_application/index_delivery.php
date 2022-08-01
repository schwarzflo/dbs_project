<?php

// Include DatabaseHelper.php file
require_once('DatabaseHelper.php');

// Instantiate DatabaseHelper class
$database = new DatabaseHelper();

// Get parameter 'person_id', 'surname' and 'name' from GET Request
// Btw. you can see the parameters in the URL if they are set

if (isset($_GET['submitquery'])) {
	
	$OID = '';
	if (isset($_GET['OID'])) {
		$OID = $_GET['OID'];
	}

	$DT = '';
	if (isset($_GET['DT'])) {
		$DT = $_GET['DT'];
	}

	$DD = '';
	if (isset($_GET['DD'])) {
		$DD = $_GET['DD'];
	}
	
	$delivery_array = $database->selectFromDeliveryWhere($OID, $DT, $DD);
	
	if ($OID != '' and $DT == '' and $DD == '') {
		if (count($delivery_array) != 0) {
			$helper = $delivery_array[0];
			$delivery_array = [];
			array_push($delivery_array,$helper);
		}
	}
}
else {
	$delivery_array = [];
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
<h1><center>Delivery Methods</center></h1>
</div>
	<div class="card text-dark bg-light mb-3">
		<div class="card-body">
			<form method="get" action="updateDelivery.php">
				<div class="form-inline">
					<label for="new_ea">Order ID&emsp;</label>
					<input id="new_ea" name="OID" type="number">
					&emsp;&emsp;
					<label for="new_ea">Delivery Type&emsp;</label>
					<input id="new_ea" name="DT" type="text" maxlength="40">
					&emsp;&emsp;
					<label for="new_str">Delivery Date (DD.MM.YY)&emsp;</label>
					<input id="new_str" name="DD" type="text" maxlength="40">
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
			
			<form method="get">
				<div class="form-inline">
					<label for="new_ea">Order ID&emsp;</label>
					<input id="new_ea" name="OID" type="number">
					&emsp;&emsp;
					<label for="name">Delivery Type&emsp;</label>
					<input id="name" name="DT" type="text" maxlength="40">
					&emsp;&emsp;
					<label for="name">Delivery Date (DD.MM.YY)&emsp;</label>
					<input id="name" name="DD" type="text" maxlength="30">
					&emsp;&emsp;	
				</div>
				<br>
				<div>
					<button name="submitquery" class="btn btn-primary btn" type='submit'>
						Search Database
					</button>
					<br>
					<br>
					<h3><?php echo strval(count($delivery_array)) . " Result(s)";?><div class="float-right"><div class="p-3 mb-2 text-muted"><h1>SEARCHING</h1></div></div></h3>
				</div>
			</form>
			<br>
			
			<table class="table">
				<thead>
					<tr>
						<th scope="col"><h3>Order ID&emsp;</h3></th>
						<th scope="col"><h3>Type&emsp;</h3></th>
						<th scope="col"><h3>Delivery Date&emsp;</h3></th>
					</tr>
				</thead>
				<?php foreach ($delivery_array as $delivery) : ?>
					<tbody>
						<tr>
							<td><?php echo $delivery['ORDERID']; ?>  </td>
							<td><?php echo $delivery['TYPE']; ?>  </td>
							<td><?php echo $delivery['DELIVERYDATE']; ?>  </td>
						</tr>
					<thead>
				<?php endforeach; ?>
			</table>

</div>
</div>
</body>
</html>