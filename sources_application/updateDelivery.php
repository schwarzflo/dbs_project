<?php
//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

//Grab variables from POST request
$OID = '';
if(isset($_GET['OID'])){
    $OID = $_GET['OID'];
}

$DT = '';
if(isset($_GET['DT'])){
    $DT = $_GET['DT'];
}

$DD = '';
if(isset($_GET['DD'])){
    $DD = $_GET['DD'];
}

// Insert method
$database->updateDelivery($OID,$DT,$DD);

// Check result
?>

<!-- link back to index page-->
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
		<?php
			if ($OID != "" and ($DT != "" or $DD != "" )){
				echo "<h1><center>Entry successfully updated!</center></h1>";
			}
			else {
				echo "<h1><center>There was a problem when trying to update the entry.</center></h1>";
			}
		?>
	</div>
	<br>
	<br>
	<center><a class="btn btn-primary btn" href="index_delivery.php" role="button" style="width:20%">Return</a></center>
</body>


</html>