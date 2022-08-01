<?php
//include DatabaseHelper.php file
require_once('DatabaseHelper.php');

//instantiate DatabaseHelper class
$database = new DatabaseHelper();

$CID = '';
if(isset($_GET['CID'])){
    $CID = $_GET['CID'];
}

$PC = '';
if(isset($_GET['PC'])){
    $PC = $_GET['PC'];
}

$STR = '';
if(isset($_GET['STR'])){
    $STR = $_GET['STR'];
}

$TN = '';
if(isset($_GET['TN'])){
    $TN = $_GET['TN'];
}

$database->updateCustomer($CID,$TN,$PC,$STR);

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
			if ($CID != "" and ($PC != "" or $STR != "" or $TN != "")){ //it is assumed that in case of inputting one additional attribute besides the ID, the updating will work as expected.
				echo "<h1><center>Entry successfully updated!</center></h1>";
			}
			else {
				echo "<h1><center>There was a problem when trying to update the entry.</center></h1>";
			}
		?>
	</div>
	<br>
	<br>
	<center><a class="btn btn-primary btn" href="index_customer.php" role="button" style="width:20%">Return</a></center>
</body>


</html>