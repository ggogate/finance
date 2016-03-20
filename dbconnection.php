<?php 
$dbhandle = mysql_connect('localhost', "root", "");
if (!$dbhandle) {
	die('Could not connect: ' . mysql_error());
}
$selected = mysql_select_db("test",$dbhandle) or die("Could not select forecasting database");
?>