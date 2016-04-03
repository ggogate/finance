<html>
<head>
	<title> Resourcewise Forecast </title>
	<link rel="stylesheet" type="text/css" href="style.css"/>
	<script src="app.js"></script>
</head>

<body>
<div id="container">
<div id="header">
Resourcewise Forecast
</div>
<div id="content">
	<div id="nav">
		<ul>
			<li> <a href="employees.php"> Manage Employees </a></li>
			<li> <a href="allocations.php"> Manage Allocations </a></li>
			<li> <a href="leaves.php"> Manage Leaves </a></li>
			<li> <a href="holidays.php"> Manage Public Holidays </a></li>
			<li> <a href="forecast.php"> View Forecast </a></li>
		</ul>
	</div>
	<div id="main">
	<?php 
		include_once('dbconnection.php');
		if (isset($_GET['action']))
		{
			if ($_GET['action'] == "delete" && isset($_GET['empid']))
			{
				$sql = "delete from leaves where emp_id = ".$_GET['empid']." limit 1";
				$retval = mysql_query($sql,$dbhandle);
				if(! $retval)
				{
				   die('Could not delete data: ' . mysql_error());
				}
			}
		}
		if (isset($_POST['action']))
		{
			if($_POST['action'] == "add")
			{
				$sql = "insert into leaves (emp_id, start_dt, end_dt) values(".$_POST['name'].",'".$_POST['start_dt']."','".$_POST['end_dt']."')";
				$retval = mysql_query($sql,$dbhandle);
				if(! $retval)
				{
				   die('Could not delete data: ' . mysql_error());
				}
			}
		}
	?>
	<div align=center>
	<br><br>
	<h3>Add Resource Leave</h3>
	<form id="add" method="post" action="leaves.php">
		<table border="0">
			<tr><td class="invisible">Employee Id:</td><td class="invisible"><input type="text" name="name" id="employee" placeholder="Search by Name"/></td></tr>
			<tr><td class="invisible">Start Date:</td><td class="invisible"><input type="text" name="start_dt" placeholder="yyyy-mm-dd" autocomplete="off"/></td></tr>
			<tr><td class="invisible">End Date:</td><td class="invisible"><input type="text" name="end_dt" placeholder="yyyy-mm-dd" autocomplete="off"/></td></tr>
			<tr><td class="invisible"></td><td class="invisible"><input type="submit" value="Save"/></td></tr>
		</table>
		<input type="hidden" name="action" value="add"/>
	</form><br><br><br>
	<h3>Current Leaves</h3>
	<?php
		$result = mysql_query("SELECT a.emp_id, b.name, a.start_dt, a.end_dt from leaves a, employees b where a.emp_id = b.id");
		if (mysql_num_rows($result) == 0)
		{
			echo "No resource leaves found";
		}
		else
		{
			echo "<table>";
			echo "<tr>
					<th>Emp Id</th>
					<th>Name</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th></th>
				 </tr>";
			while ($row = mysql_fetch_array($result)) {			
			   echo 
			   "<tr>
			   <td>".$row{'emp_id'}."</td>
			   <td>".$row{'name'}."</td>
			   <td>".$row{'start_dt'}."</td>			   
			   <td>".$row{'end_dt'}."</td>
			   <td><a href=leaves.php?action=delete&empid=".$row{'emp_id'}.">Delete</a></td>
			   </tr>";
			}
			echo "</table>";
		}
		mysql_close($dbhandle);		
	?>
	</div>
	</div>
</div>
<div id="footer">
</div>
</div>
</body>
</html>