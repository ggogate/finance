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
	?>
	<div align=center>
	<br><br>
	<h3>Resourcewise Forecast</h3>
	<?php
		$employees = mysql_query("select * from employees order by pid");
		$leaves = mysql_query("select * from leaves order by start_dt");
		$holidays = mysql_query("select * from holidays order by start_dt");
		
		$totalAmt = 0;
		$workHours = array(0,0,0,0,0,0,0,0,0,0,0,0);
		//$leaveHours = array(0,0,0,0,0,0,0,0,0,0,0,0);	
		
		echo "<table>";
		echo "<tr>
				<th>PID</th>
				<th>Emp Id</th>
				<th>Name</th>
				<th>Location</th>
				<th>City</th>
				<th>Role</th>
				<th>Rate</th>
				<th>Start Date</th>
				<th>End Date</th>
				<th>Jan</th>
				<th>Feb</th>
				<th>Mar</th>
				<th>Total Q1 <br>hours</th>
				<th>Total Q1 <br>amount</th>
			 </tr>";
		
		
		while ($row = mysql_fetch_array($employees)) {	
			
			$workDays= 0;			
			
			$start = date_create($row{'start_dt'});
			$end = date_create($row{'end_dt'});
			
		/*
			$startLeave = date_create();
			$endLeave = 
		*/
			
			$workHours['Jan'] = 0;
			$workHours['Feb'] = 0;
			$workHours['Mar'] = 0;
			do
			{
				if (date_format($start, 'D') != "Sat" && date_format($start, 'D') !="Sun")
				{
					//Now check if it's not a public holiday or an employee's leave
					$month = date_format($start, 'M');
					
					$workHours[$month]=$workHours[$month]+8;
					$workDays++;
				}	
				date_add($start, date_interval_create_from_date_string('1 day'));
			}while($start <= $end);			
			
			echo "<tr>
					<td>".$row{'pid'}."</td>
					<td>".$row{'emp_id'}."</td>
					<td>".$row{'name'}."</td>
					<td>".$row{'location'}."</td>
					<td>".$row{'city'}."</td>
					<td>".$row{'role'}."</td>
					<td> $".$row{'rate'}."</td>
					<td>".$row{'start_dt'}."</td>
					<td>".$row{'end_dt'}."</td>
					<td>".$workHours['Jan']."</td>
					<td>".$workHours['Feb']."</td>
					<td>".$workHours['Mar']."</td>
					<td>".($workDays*8)."</td>
					<td> $".number_format(($workDays*8*$row{'rate'}),2)."</td>
				</tr>";
				$totalAmt = $totalAmt + ($workDays*8*$row{'rate'});
		}
		//Print totals row
		echo "<tr>
				<td>Total</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td> $".number_format($totalAmt,2)."</td>";
		echo "</table>";
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