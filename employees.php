<html>
<head>
	<title> Resourcewise Forecast </title>
	<link rel="stylesheet" type="text/css" href="style.css"/>	
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
			if ($_GET['action'] == "delete" && isset($_GET['id']))
			{
				$sql = "delete from employees where id = ".$_GET['id']." limit 1";
				$retval = mysqli_query($dbhandle,$sql);
				if(! $retval)
				{
				   die('Could not delete data: ' . mysqli_error());
				}
			}
		}
		if (isset($_POST['action']))
		{
			if($_POST['action'] == "add")
			{
				$sql = "insert into employees (id, name) values(".$_POST['id'].",'".$_POST['name']."')";
				$retval = mysqli_query($dbhandle,$sql);
				if(! $retval)
				{
				   die('Could not insert data: ' . mysqli_error());
				}
			}
		}

	?>
	<div align=center>
	<br><br>
	<h3>Add Employee</h3>
	<form id="add" method="post" action="employees.php">
		<input type="text" name="id" placeholder="Enter Employee Id"/>&nbsp;&nbsp;<br>
		<input type="text" name="name" placeholder="Enter Name"/>&nbsp;&nbsp;<br>
		<input type="hidden" name="action" value="add"/><br>
		<input type="submit" value="Save"/>
	</form><br><br><br>
	<h3>Current Employees</h3>
	<?php
		$result = mysqli_query($dbhandle, "select id, name from employees");
		if (mysqli_num_rows($result) == 0)
		{
			echo "No employees found";
		}
		else
		{
			echo "<table>";
			echo "<tr>
					<th>Employee Id</th>
					<th>Name</th>
					<th>Action</th>
				 </tr>";
			while ($row = mysqli_fetch_array($result)) {			
			   echo 
			   "<tr>
			   <td>".$row{'id'}."</td>
			   <td>".$row{'name'}."</td>
			   <td><a href=employees.php?action=delete&id=".$row{'id'}.">Delete</a></td>
			   </tr>";
			}
			echo "</table>";
		}
		mysqli_close($dbhandle);		
	?>
	</div>
	</div>
</div>
<div id="footer">
</div>
</div>
</body>

</html>