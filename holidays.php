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
				$sql = "delete from holidays where id = ".$_GET['id']." limit 1";
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
				$sql = "insert into holidays (city, holiday_dt, description) values ('"
					.$_POST['city']."','"
					.$_POST['holiday_dt']."','"
					.$_POST['description'].
					"')";
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
	<h3>Add Public Holiday</h3>
	<form id="add" method="post" action="holidays.php">
		City:&nbsp;&nbsp;<select name="city">>
			<option value="none">--select--</option>
			<option value="Chennai">Chennai</option>
			<option value="Mumbai">Mumbai</option>
			<option value="Pune">Pune</option>
			<option value="Phoenix">Phoenix</option>
		</select><br>			
		<input type="text" name="holiday_dt" placeholder="Holiday Date" class="datepicker" autocomplete="off" />&nbsp;&nbsp;<br>
		<input type="text" name="description" placeholder="Description" autocomplete="off" />&nbsp;&nbsp;<br>
		<input type="hidden" name="action" value="add"/><br>
		<input type="submit" value="Save"/>
	</form><br><br><br>

	<h3>List of holidays</h3>
	<?php
		$result = mysqli_query($dbhandle, "select id, description, city, MONTHNAME(holiday_dt) month, holiday_dt from holidays order by city, holiday_dt");
		if (mysqli_num_rows($result) == 0)
		{
			echo "No public holidays found";
		}
		else
		{
			echo "<table>";
			echo "<tr>
					<th>City</th>
					<th>Month</th>
					<th>Holiday Date</th>
					<th>Description</th>
					<th>Action</th>
				 </tr>";
			while ($row = mysqli_fetch_array($result)) {			
			   echo 
			   "<tr>
			   <td>".$row{'city'}."</td>
			   <td>".$row['month']."</td>
			   <td>".$row{'holiday_dt'}."</td>
			   <td>".$row{'description'}."</td>
   			   <td><a href=holidays.php?action=delete&id=".$row{'id'}.">Delete</a></td>
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
