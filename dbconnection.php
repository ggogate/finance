<?php 
$dbhandle = mysqli_connect('localhost', "root", "", "test");
if (!$dbhandle) {
	die('Could not connect: ' . mysqli_connect_error());
}
//$selected = mysqli_select_db("test",$dbhandle) or die("Could not select forecasting database");
?>