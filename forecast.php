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
	<div align=center>
	<br><br>
	<h3>Resourcewise Forecast</h3>
	<?php
		$allocations = mysqli_query($dbhandle, "select * from allocations order by pid");
		$leaves = mysqli_query($dbhandle, "select * from leaves order by start_dt");
		$holidays = mysqli_query($dbhandle, "select * from holidays order by start_dt");
		
		$totalHours = 0;
		$totalAmt = 0;
		$workHours = array(0,0,0,0,0,0,0,0,0,0,0,0);
		//$leaveHours = array(0,0,0,0,0,0,0,0,0,0,0,0);	
		
		echo "<div style='font:8pt Arial'><table>";
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
				<th>Apr</th>
				<th>May</th>
				<th>Jun</th>
				<th>Jul</th>
				<th>Aug</th>
				<th>Sep</th>
				<th>Oct</th>
				<th>Nov</th>
				<th>Dec</th>
				<th>Total <br>Hours</th>
				<th>Total <br>Amount</th>
			 </tr>";
		
		
		while ($row = mysqli_fetch_array($allocations)) {	
			
			$workDays= 0;
			
			$employee = mysqli_query($dbhandle, "select * from employees where id = ".$row{'emp_id'}." limit 1");
			$emp_row = mysqli_fetch_array($employee);
			
			$start = date_create($row{'start_dt'});
			$end = date_create($row{'end_dt'});
			
		/*
			$startLeave = date_create();
			$endLeave = 
		*/
			
			$workHours['Jan'] = 0;
			$workHours['Feb'] = 0;
			$workHours['Mar'] = 0;
			$workHours['Apr'] = 0;
			$workHours['May'] = 0;
			$workHours['Jun'] = 0;
			$workHours['Jul'] = 0;
			$workHours['Aug'] = 0;
			$workHours['Sep'] = 0;
			$workHours['Oct'] = 0;
			$workHours['Nov'] = 0;
			$workHours['Dec'] = 0;
			do
			{
				if (date_format($start, 'D') != "Sat" && date_format($start, 'D') !="Sun")
				{
					//Now check if it's not a public holiday or the employee's leave
					$month = date_format($start, 'M');
					
					$workHours[$month]=$workHours[$month]+8;
					$workDays++;
				}	
				date_add($start, date_interval_create_from_date_string('1 day'));
			}while($start <= $end);			
			
			echo "<tr>
					<td>".$row{'pid'}."</td>
					<td>".$row{'emp_id'}."</td>
					<td>".$emp_row{'name'}."</td>
					<td>".$row{'location'}."</td>
					<td>".$row{'city'}."</td>
					<td>".$row{'role'}."</td>
					<td> $".$row{'rate'}."</td>
					<td>".$row{'start_dt'}."</td>
					<td>".$row{'end_dt'}."</td>
					<td>".$workHours['Jan']."</td>
					<td>".$workHours['Feb']."</td>
					<td>".$workHours['Mar']."</td>
					<td>".$workHours['Apr']."</td>
					<td>".$workHours['May']."</td>
					<td>".$workHours['Jun']."</td>
					<td>".$workHours['Jul']."</td>
					<td>".$workHours['Aug']."</td>
					<td>".$workHours['Sep']."</td>
					<td>".$workHours['Oct']."</td>
					<td>".$workHours['Nov']."</td>
					<td>".$workHours['Dec']."</td>					
					<td class='summary'>".($workDays*8)."</td>
					<td class='summary'> $".number_format(($workDays*8*$row{'rate'}),2)."</td>
				</tr>";
				$totalHours = $totalHours + ($workDays*8);
				$totalAmt = $totalAmt + ($workDays*8*$row{'rate'});
		}
		//Print totals row
		echo "<tr class='summaryTotal'>
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
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td> ".$totalHours."</td>				
				<td> $".number_format($totalAmt,2)."</td>";
		echo "</table></div>";
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