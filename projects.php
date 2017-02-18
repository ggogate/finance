<html>
<head>
	<title> Resourcewise Forecast </title>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">	
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<link rel="stylesheet" type="text/css" href="style.css"/>
	
	<script>
	$( function() {
		$( ".datepicker" ).datepicker(
			{dateFormat: "yy-mm-dd"}
		);
		$( "#name" ).autocomplete({
			source: 'getEmployee.php'
		});
	});
	</script>

</head>

<body>
<div id="container">
<div id="header">
Resourcewise Forecast
</div>
<div id="content">
	<?php 
		include('menu.php');
	?>
	<div id="main">
	<?php 
		include_once('dbconnection.php');
		if (isset($_GET['action']))
		{
			if ($_GET['action'] == "delete" && isset($_GET['id']))
			{
				$sql = "delete from projects where id = ".$_GET['id']." limit 1";
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
				//Check dates
				$start = date_create($_POST['start_dt']);
				$end = date_create($_POST['end_dt']);
				if ($start <= $end)
				{
					$sql = "insert into projects (id, name, start_dt, end_dt) values ("
					.$_POST['id'].",'"
					.$_POST['name']."','"
					.$_POST['start_dt']."','"
					.$_POST['end_dt'].
					"')";
				
					$retval = mysqli_query($dbhandle,$sql);
					if(! $retval)
					{
					   die('Could not insert data: ' . mysqli_error());
					}
				}
				else
				{
					echo('<span style="color:red">End Date cannot be before the Start Date</div>');
				}
			}
		}

	?>
	<div align=center>
	<br><br>
	<h3>Add Project</h3>
	<form id="add" method="post" action="projects.php">
		<input type="text" name="id" placeholder="Enter Project Id"/>&nbsp;&nbsp;<br>
		<input type="text" name="name" placeholder="Enter Name"/>&nbsp;&nbsp;<br>
		<input type="text" name="start_dt" placeholder="Start Date" class="datepicker" autocomplete="off" />&nbsp;&nbsp;<br>
		<input type="text" name="end_dt" placeholder="End Date" class="datepicker" autocomplete="off" />&nbsp;&nbsp;<br>
		<input type="hidden" name="action" value="add"/><br>
		<input type="submit" value="Save"/>
	</form><br><br><br>
	<h3>Current Employees</h3>
	<?php
		$result = mysqli_query($dbhandle, "select id, name, start_dt, end_dt from projects");
		if (mysqli_num_rows($result) == 0)
		{
			echo "No projects found";
		}
		else
		{
			echo "<table>";
			echo "<tr>
					<th>Project Id</th>
					<th>Name</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th>Action</th>
				 </tr>";
			while ($row = mysqli_fetch_array($result)) {			
			   echo 
			   "<tr>
			   <td>".$row{'id'}."</td>
			   <td>".$row{'name'}."</td>
   			   <td>".$row{'start_dt'}."</td>
   			   <td>".$row{'end_dt'}."</td>
			   <td><a href=projects.php?action=delete&id=".$row{'id'}.">Delete</a></td>
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
