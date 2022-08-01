<?php
//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

$PM = '';
if(isset($_GET['PM'])){
    $PM = $_GET['PM'];
}

$CID = '';
if(isset($_GET['CID'])){
    $CID = $_GET['CID'];
}

$PIDS = '';
if(isset($_GET['PIDS'])){
    $PIDS = $_GET['PIDS'];
}

$AMS = '';
if(isset($_GET['AMS'])){
    $AMS = $_GET['AMS'];
}

$DT = '';
if(isset($_GET['DT'])){
    $DT = $_GET['DT'];
}

$DD = '';
if(isset($_GET['DD'])){
    $DD = $_GET['DD'];
}

$enough = $database->checkInStock($PIDS,$AMS); //checks whether enough products in stock for every product id

if ($enough) {
	$database->insertIntoOrder($PM,$CID,$PIDS,$AMS,$DT,$DD); 
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
		<?php
			if ($enough){
				echo "<h1><center>Entry successfully added!</center></h1>";
			}
			else {
				echo "<h1><center>Entry could not be added!</center></h1>";
			}
		?>
	</div>
	<br>
	<br>
	<center><a class="btn btn-primary btn" href="index_order.php" role="button" style="width:20%">Return</a></center>
</body>


</html>