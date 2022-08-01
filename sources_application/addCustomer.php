<?php
//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

$EA = '';
if(isset($_GET['EA'])){
    $EA = $_GET['EA'];
}

$PC = '';
if(isset($_GET['PC'])){
    $PC = $_GET['PC'];
}

$STR = '';
if(isset($_GET['STR'])){
    $STR = $_GET['STR'];
}

$FN = '';
if(isset($_GET['FN'])){
    $FN = $_GET['FN'];
}

$SN = '';
if(isset($_GET['SN'])){
    $SN = $_GET['SN'];
}

$TN = '';
if(isset($_GET['TN'])){
    $TN = $_GET['TN'];
}

// Insert method
$success = $database->insertIntoCustomer($EA,$PC,$STR,$FN,$SN,$TN); //return true if success, false if failure

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
			if ($success){
				echo "<h1><center>Entry successfully added!</center></h1>";
			}
			else {
				echo "<h1><center>Entry could not be added!</center></h1>";
			}
		?>
	</div>
	<br>
	<br>
	<center><a class="btn btn-primary btn" href="index_customer.php" role="button" style="width:20%">Return</a></center>
</body>


</html>