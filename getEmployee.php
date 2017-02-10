<?php

include_once('dbconnection.php');
header("content-type:application/json");
//$q = $_REQUEST["q"];
$q = $_GET['term'];
$suggestion = "";

if ($q !== "") 
{
	$result = mysqli_query($dbhandle, "select id, name from employees where name like '%".$q."%'");
	while($row = mysqli_fetch_array($result))
	{
		$suggestion[] = $row['name'];
	}
	echo json_encode($suggestion);
}


/*
if ($q !== "") 
{
	$result = mysqli_query($dbhandle, "select id, name from employees where name like '%".$q."%'");
	while($row = mysqli_fetch_array($result))
	{
		$suggestion[] = $row['name'];
	}
	echo json_encode($suggestion);
}
/*


?>
