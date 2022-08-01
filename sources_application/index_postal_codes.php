<?php

// Include DatabaseHelper.php file
require_once('DatabaseHelper.php');

// Instantiate DatabaseHelper class
$database = new DatabaseHelper();

// Get parameter 'person_id', 'surname' and 'name' from GET Request
// Btw. you can see the parameters in the URL if they are set

if (isset($_GET['submitquery'])) //check whether submit was pressed so that data is not printed when initially loading page
	
	$PC = '';
	if (isset($_GET['PC'])) {
		$PC = $_GET['PC'];
	}

	$CABR = '';
	if (isset($_GET['CABR'])) {
		$CABR = $_GET['CABR'];
	}

	$CI = '';
	if (isset($_GET['CI'])) {
		$CI = $_GET['CI'];
	}

	$postal_array = $database->selectFromPostalCodesWhere($PC,$CI,$CABR); //Fetch data
	
}
else {
	$postal_array = [];
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
<h1><center>Postal Code Methods</center></h1>
</div>
	<div class="card text-dark bg-light mb-3">
		<div class="card-body">
			<form method="get" action="addPostalCode.php">
				
				<div class="form-inline">
					<label for="pcs">Postal Code&emsp;</label>
					<input id="pcs" name="postal_code" type="text" maxlength="20">
					&emsp;&emsp;
					<label for="new_city">City&emsp;</label>
					<input id="new_city" name="City" type="text" maxlength="20">
					&emsp;&emsp;
					<label for="new_cabr">Country Abbreviation&emsp;</label>
					<input id="new_cabr" name="cabr" type="text" maxlength="20">
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
			
			<form method="get" action="deletePostalCode.php">
				<div class="form-inline">
					<label for="first">Postal Code&emsp;</label>
					<input id="first" name="PC" type="text" maxlength="10">
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
					<label for="first">Postal Code &emsp;</label>
					<input id="first" name="PC" type="text" maxlength="10">
					&emsp;&emsp;
					<label for="name">City &emsp;</label>
					<input id="name" name="CI" type="text" maxlength="30">
					&emsp;&emsp;
					<label for="name">Country Abbreviation &emsp;</label>
					<input id="name" name="CABR" type="text" maxlength="5">
				</div>
				<br>
				<div>
					<button name="submitquery" class="btn btn-primary btn" type='submit'>
						Search Database
					</button>
					<br>
					<br>
					<h3><?php echo strval(count($postal_array)) . " Result(s)";?><div class="float-right"><div class="p-3 mb-2 text-muted"><h1>SEARCHING</h1></div></div></h3>
				</div>
			</form>
			<br>
			<table class="table">
			<thead>
				<tr>
					<th scope="col"><h3>Postal Code&emsp;</h3></th>
					<th scope="col"><h3>City&emsp;</h3></th>
					<th scope="col"><h3>Country</h3></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($postal_array as $attribute) : ?>
					<tr>
						<td><?php echo $attribute['PC']; ?> &emsp; </td>
						<td><?php echo $attribute['CITY_NAME']; ?> &emsp; </td>
						<td><?php echo $attribute['COUNTRY_ABBR']; ?>  </td>
					</tr>
				<?php endforeach; ?>
			</tbody>
			</table>
		</div>
	</div>

</body>
</html>