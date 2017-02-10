<?php

// prevent direct access
$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
  $user_error = 'Access denied - not an AJAX request...';
  trigger_error($user_error, E_USER_ERROR);
}

include_once('dbconnection.php');
header("content-type:application/json");
$q = $_GET['term'];

$a_json = array();
$a_json_row = array();

if ($q !== "") 
{
	$result = mysqli_query($dbhandle, "select id, name from employees where id like '%".$q."%'");
	while($row = mysqli_fetch_array($result))
	{
        //$a_json_row["id"] = $row['name'];
        $a_json_row["value"] = $row['id'];
        $a_json_row["desc"] = $row['name'];
        array_push($a_json, $a_json_row);
	}
    echo json_encode($a_json);
}

?>