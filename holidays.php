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
	?>
	<p>
	<div align=center style="color:red"> Note: Holidays need to be directly setup in the database as a one time setup</div>
	<div align=center>
	<br><br>
	<h3>List of holidays</h3>
	<?php
		$result = mysqli_query($dbhandle, "select id, description, city, MONTHNAME(start_dt), start_dt, end_dt from holidays order by start_dt");
		if (mysqli_num_rows($result) == 0)
		{
			echo "No public holidays found";
		}
		else
		{
			echo "<table>";
			echo "<tr>
					<th>Month</th>
					<th>Start Date</th>
					<th>End Date</th>
					<th>City</th>
					<th>Description</th>
				 </tr>";
			while ($row = mysqli_fetch_array($result)) {			
			   echo 
			   "<tr>
			   <td>".$row['MONTHNAME(start_dt)']."</td>
			   <td>".$row{'start_dt'}."</td>			   
			   <td>".$row{'end_dt'}."</td>
			   <td>".$row{'city'}."</td>
			   <td>".$row{'description'}."</td>
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