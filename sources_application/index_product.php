<?php

// Include DatabaseHelper.php file
require_once('DatabaseHelper.php');

// Instantiate DatabaseHelper class
$database = new DatabaseHelper();


if (isset($_GET['submitquery'])) { //avoid printing results when initially loading the page
	$PID = '';
	if (isset($_GET['PID'])) {
		$PID = $_GET['PID'];
	}

	$NA = '';
	if (isset($_GET['NA'])) {
		$NA = $_GET['NA'];
	}

	$SU = '';
	if (isset($_GET['SU'])) {
		$SU = $_GET['SU'];
	}

	$CID = '';
	if (isset($_GET['CID'])) {
		$CID = $_GET['CID'];
	}

	//Fetch data from database
	$product_array = $database->selectFromProCatWhere($PID,$NA,$SU,$CID);
	
	if ($PID != '' and $NA == '' and $SU == '' and $CID == '') { //avoid unnecessary results eg querying for 4 and getting every number that contains 4
		if (count($product_array) != 0) { //if array is empty to begin with dont print empty result 
			$helper = $product_array[0]; //just the first number of the array is wanted here
			$product_array = [];
			array_push($product_array,$helper);
		}
	}
}
else {
	$product_array = [];
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
<h1><center>Product Methods</center></h1>
</div>
	<div class="card text-dark bg-light mb-3">
		<div class="card-body">
			<form method="get" action="addProduct.php">

				<div class="form-inline">
					<label for="new_pc">Name&emsp;</label>
					<input id="new_pc" name="NA" type="text" maxlength="20">
					&emsp;&emsp;
					<label for="new_city">In Stock&emsp;</label>
					<input id="new_city" name="IS" type="number" min="0">
					&emsp;&emsp;
					<label for="new_cabr">Supplier&emsp;</label>
					<input id="new_cabr" name="SU" type="text" maxlength="20">
					&emsp;&emsp;
					<label for="new_cabr">Price (€)&emsp;</label>
					<input id="new_cabr" name="PR" type="number" step="0.01" min="0">
					&emsp;&emsp;
					<label for="cat">Category&emsp;</label>
					<select id="cat" name="CID">
					<option value="1">Home</option>
					<option value="2">Garden</option>
					<option value="3">Kitchen</option>
					<option value="4">Living Room</option>
					<option value="5">Bathroom</option>
					<option value="6">Electronics</option>
					<option value="7">Gaming</option>
					<option value="8">Kids</option>
					<option value="9">Literature</option>
					<option value="10">Art and Music</option>
					<option value="11">Deco</option>
					<option value="12">Pets</option>
					<option value="13">Beauty</option>
					<option value="14">Health</option>
					<option value="15">Grocery</option>
					<option value="16">Sports and Outdoors</option>
					<option value="17">Car</option>
					<option value="18">Clothing</option>
					<option value="19">Accessories</option>
					<option value="20">Office</option>
					<option value="21">Bedroom</option>
					</select>
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
			<form method="get" action="updateProduct.php">

					<div class="form-inline">
						<label for="new_ea">Product ID&emsp;</label>
						<input id="new_ea" name="PID" type="number">
						&emsp;&emsp;
						<label for="new_pc">New Price (€)&emsp;</label>
						<input id="new_pc" name="NP" type="number" step="0.01" min="0">
						&emsp;&emsp;
						<label for="new_str">New Supplier&emsp;</label>
						<input id="new_str" name="NS" type="text" maxlength="40">
						&emsp;&emsp;
						<label for="new_fn">Add Amount to Stock&emsp;</label>
						<input id="new_fn" name="ATS" type="text" maxlength="30">
					</div>
					<br>

					<div>
					<button class="btn btn-warning btn" type="submit">
						Update Entry
					</button>
					<div class="float-right"><div class="p-3 mb-2 text-muted"><h1>UPDATING</h1></div></div>
				</div>
				</form>
				<br>
				<hr>
			<form method="get" action="deleteProduct.php">
				<div class="form-inline">
					<label for="first">Product ID&emsp;</label>
					<input id="first" name="PID" type="text" maxlength="10">
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

				<div class="form-inline">
					<label for="person_id">Product ID&emsp;</label>
					<input id="person_id" name="PID" type="number">
					&emsp;&emsp;
					<label for="name">Name&emsp;</label>
					<input id="name" name="NA" type="text" maxlength="30">
					&emsp;&emsp;
					<label for="surname">Supplier&emsp;</label>
					<input id="surname" name="SU" type="text" maxlength="40">
					&emsp;&emsp;
					<label for="cat">Category&emsp;</label>
					<select id="cat" name="CID">
					<option value=""> </option>
					<option value="1">Home</option>
					<option value="2">Garden</option>
					<option value="3">Kitchen</option>
					<option value="4">Living Room</option>
					<option value="5">Bathroom</option>
					<option value="6">Electronics</option>
					<option value="7">Gaming</option>
					<option value="8">Kids</option>
					<option value="9">Literature</option>
					<option value="10">Art and Music</option>
					<option value="11">Deco</option>
					<option value="12">Pets</option>
					<option value="13">Beauty</option>
					<option value="14">Health</option>
					<option value="15">Grocery</option>
					<option value="16">Sports and Outdoors</option>
					<option value="17">Car</option>
					<option value="18">Clothing</option>
					<option value="19">Accessories</option>
					<option value="20">Office</option>
					<option value="21">Bedroom</option>
					</select>
				</div>
				<br>

				<div>
				<button name="submitquery" class="btn btn-primary btn" type='submit'>
					Search Database
				</button>
				<br>
				<br>
				<h3><?php echo strval(count($product_array)) . " Result(s)";?><div class="float-right"><div class="p-3 mb-2 text-muted"><h1>SEARCHING</h1></div></div></h3>
			</div>
			</form>
			<br>

			<table class="table">
				<thead>
					<tr>
						<th scope="col"><h3>Product ID&emsp;</h3></th>
						<th scope="col"><h3>Name&emsp;</h3></th>
						<th scope="col"><h3>In Stock&emsp;</h3></th>
						<th scope="col"><h3>Supplier&emsp;</h3></th>
						<th scope="col"><h3>Price (€)&emsp;</h3></th>
						<th scope="col"><h3>Category ID&emsp;</h3></th>
						<th scope="col"><h3>Category Name&emsp;</h3></th>
					</tr>
				</thead>
				
				<tbody>
					<?php foreach ($product_array as $product) : ?>
						<tr>
							<td><?php echo $product['PRODUCTID']; ?> &emsp; </td>
							<td><?php echo $product['NAME']; ?> &emsp; </td>
							<td><?php echo $product['INSTOCK']; ?> &emsp; </td>
							<td><?php echo $product['SUPPLIER']; ?> &emsp; </td>
							<td><?php echo $product['PRICE']; ?> &emsp; </td>
							<td><?php echo $product['CATEGORYID']; ?> &emsp; </td>
							<td><?php echo $product['CATEGORYNAME']; ?> &emsp; </td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>