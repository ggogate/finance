<?php

include_once('dbconnection.php');

//$q = $_REQUEST["q"];
$q = $_GET['term'];
$suggestion = "";

if ($q !== "") 
{
	$result = mysql_query("select id, name from employees where name like '%".$q."%'");
	while($row = mysql_fetch_array($result))
	{
		$suggestion[] = $row['name'];
	}
	echo json_encode($suggestion);
}
?>