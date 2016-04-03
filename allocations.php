<html>
<head>
	<title> Resourcewise Forecast </title>
	<link rel="stylesheet" type="text/css" href="style.css"/>	
	
	<script>
	function doSomething(){
		alert("hehehe");
	};
	</script>
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
				$sql = "delete from allocations where emp_id = ".$_GET['id']." and pid = ".$_GET['pid']." limit 1";
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
				$sql = "insert into allocations (emp_id, pid, location, city, role, rate, start_dt, end_dt) values("
				.$_POST['id'].","
				.$_POST['pid'].",'"
				.$_POST['location']."','"
				.$_POST['city']."','"
				.$_POST['role']."','"
				.$_POST['rate']."','"
				.$_POST['start_dt']."','"
				.$_POST['end_dt'].		
				"')";
				$retval = mysql_query($sql,$dbhandle);
				if(! $retval)
				{
				   die('Could not insert data: ' . mysql_error());
				}
			}
		}
	?>
	<div align=center>
	<br><br>
	<h3>Add Project Assignment</h3>
	<form id="add" method="post" action="allocations.php">
	<table>
		<tr>
			<th>Emp Id</th>
			<th>PID</th>
			<th>Location</th>
			<th>City</th>
			<th>Role</th>
			<th>Rate</th>
			<th>Start Date</th>
			<th>End Date</th>
		</tr>
		<tr>
			<td><input type="text" size=10 name="id" /></td>
			<td><input type="text" size=5 name="pid" /></td>
			<td><select name="location" onclick="doSomething();">
				<option value="offshore">--select--</option>
				<option value="Onshore">On-shore</option>
				<option value="Offshore">Off-shore</option>
			</select></td>
			<td><select name="city">
				<option value="none">--select--</option>
				<option value="Mumbai">Mumbai</option>
				<option value="Pune">Pune</option>
				<option value="Chennai">Chennai</option>
				<option value="Phoenix">Phoenix</option>
			</select></td>
			<td><select name="role">
				<option value="none">--select--</option>
				<option value="Technical Project Manager">Technical Project Manager</option>
				<option value="Application Architect">Application Architect</option>
				<option value="Senior Software Engineer (Midrange)">Senior Software Engineer (Midrange)</option>
				<option value="Software Engineer (Midrange)">Software Engineer (Midrange)</option>				
				<option value="Project Manager">Project Manager</option>
				<option value="Technical Lead">Technical Lead</option>
				<option value="Business Systems Analyst">Business Systems Analyst</option>
				<option value="Senior Programmer">Senior Programmer</option>
				<option value="Programmer">Programmer</option>
			</select></td>
			<td><input type="text" size=5 name="rate" /></td>
			<td><input type="text" size=10 name="start_dt" /></td>
			<td><input type="text" size=10 name="end_dt"/></td>
		</tr>
	</table><br>
	<input type="hidden" name="action" value="add"/>
	<input type="submit" value="Save"/>
	</form><br><br><br>
	<h3>Current Assignments</h3>
	<?php
		$result = mysql_query("select a.pid, a.emp_id, b.name, a.location, a.city, a.role, a.rate, a.start_dt, a.end_dt from allocations a, employees b where a.emp_id = b.id");
		if (mysql_num_rows($result) == 0)
		{
			echo "No employee allocations found";
		}
		else
		{
			echo "<table>";
			echo "<tr>
					<th>Project Id</th>
					<th>Employee Id</th>
					<th>Name</th>
					<th>Location</th>
					<th>City</th>
					<th>Role</th>
					<th>Rate</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th>Action</th>
				 </tr>";
			while ($row = mysql_fetch_array($result)) {			
			   echo 
			   "<tr>
				   <td>".$row{'pid'}."</td>
				   <td>".$row{'emp_id'}."</td>
				   <td>".$row{'name'}."</td>
				   <td>".$row{'location'}."</td>
				   <td>".$row{'city'}."</td>
				   <td>".$row{'role'}."</td>
				   <td>$".$row{'rate'}."</td>
				   <td>".$row{'start_dt'}."</td>			   
				   <td>".$row{'end_dt'}."</td>
				   <td><a href=allocations.php?action=delete&id=".$row{'emp_id'}."&pid=".$row{'pid'}.">Delete</a></td>
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