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
		$( "#emp_id" ).autocomplete({
			source: 'getEmployeeById.php',
            
            focus: function (event, ui){
                $("#emp_id").html(ui.item.value);
                $("emp_name").html(ui.item.desc);
                return false;
            },
            
            select: function(event, ui) {
                $("#emp_id").val(ui.item.value);
                $("#emp_name").html(ui.item.desc);
                return false;
            }
		})        
        .autocomplete( "instance" )._renderItem = function( ul, item ) {
        return $( "<li>" )
        .append( "<div>" + item.value + "<br>" + item.desc + "</div>" )
        .appendTo( ul );
        }
	});
    
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
			if ($_GET['action'] == "delete" && isset($_GET['empid']))
			{
				$sql = "delete from leaves where emp_id = ".$_GET['empid']." limit 1";
				$retval = mysqli_query($dbhandle, $sql);
				if(! $retval)
				{
				   die('Could not remove data: ' . mysqli_error($dbhandle));
				}
			}
		}
		if (isset($_POST['action']))
		{
			if($_POST['action'] == "add")
			{
				$sql = "insert into leaves (emp_id, start_dt, end_dt) values(".$_POST['emp_id'].",'".$_POST['start_dt']."','".$_POST['end_dt']."')";
				$retval = mysqli_query($dbhandle, $sql);
				if(! $retval)
				{
				   die('Could not save data: ' . mysqli_error($dbhandle));
				}
			}
		}
	?>
	<div align=center>
	<br><br>
	<h3>Add Resource Leave</h3>
	<form id="add" method="post" action="leaves.php">
		<table border="0">
			<tr><td class="right-align">Employee Id:</td><td class="left-align"><div class="ui-widget"><input type="text" size=6 name="emp_id" id="emp_id" autocomplete="off"/></div></td></tr>
            <tr><td class="right-align">Employee Name:</td><td class="left-align"><span id="emp_name"></span></td></tr>
			<tr><td class="right-align">Start Date:</td><td class="left-align"><input type="text" name="start_dt" placeholder="yyyy-mm-dd" autocomplete="off" class="datepicker"/></td></tr>
			<tr><td class="right-align">End Date:</td><td class="left-align"><input type="text" name="end_dt" placeholder="yyyy-mm-dd" autocomplete="off" class="datepicker"/></td></tr>
			<tr><td class="right-align"></td><td><input type="submit" value="Save"/></td></tr>
		</table>
		<input type="hidden" name="action" value="add"/>
	</form><br><br><br>
	<h3>Current Leaves</h3>
	<?php
		$result = mysqli_query($dbhandle, "SELECT a.emp_id, b.name, a.start_dt, a.end_dt from leaves a, employees b where a.emp_id = b.id");
		if (mysqli_num_rows($result) == 0)
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
			while ($row = mysqli_fetch_array($result)) {			
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