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
			<li> <a href="resources.php"> Manage Resources </a></li>
			<li> <a href="leaves.php"> Manage Resource Leaves </a></li>
			<li> <a href="holidays.php"> Manage Public Holidays </a></li>
			<li> <a href="forecast.php"> View Forecast </a></li>
		</ul>
	</div>
	<div id="main">
	<?php 
		include_once('dbconnection.php');
		//if $_POST['command'] == "addLeave"
	?>
	<div align=center>
	<br><br>
	<h3>Add Employee</h3>
	<form id="add" method="post" action="leaves.php">
		<input type="text" name="id" placeholder="Enter Employee Id"/>&nbsp;&nbsp;<br>
		<input type="text" name="start_dt" placeholder="Enter Start Date"/>&nbsp;&nbsp;<br>
		<input type="text" name="end_dt" placeholder="Enter End Date"/>&nbsp;&nbsp;<br>
		<input type="hidden" name="command" value="addLeave"/><br>
		<input type="submit" value="Submit"/>
	</form><br><br><br>
	<h3>Current Employees</h3>
	<?php
		$result = mysql_query("select a.id, b.name, a.start_dt, a.end_dt from leaves a, employees b where a.id = b.id");
		if (mysql_num_rows($result) == 0)
		{
			echo "No resource leaves found";
		}
		else
		{
			echo "<table>";
			echo "<tr>
					<th>Employee Id</th>
					<th>Name</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th></th>
				 </tr>";
			while ($row = mysql_fetch_array($result)) {			
			   echo 
			   "<tr>
			   <td>".$row{'id'}."</td>
			   <td>".$row{'name'}."</td>
			   <td>".$row{'start_dt'}."</td>			   
			   <td>".$row{'end_dt'}."</td>
			   <td><a href=leaves.php?action=delete&id=".$row{'id'}.">Delete</a></td>
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