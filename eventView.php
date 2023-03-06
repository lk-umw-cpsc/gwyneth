<?php 

?>

<!DOCTYPE html>
<html>
	<head>
		<?php require_once('universal.inc') ?>
		<title>Event View</title>	
	</head>
	
	<body>
		<?php require_once('header.php') ?>
		<h1>Event Name: </h1>
		<p>Event Date(s): </p>
		<p>Event Start Time: </p>
		<p>Event End Time: </p>
		<p>Event Location: </p>
		<p>Event Description: </p>
		<br>
	
		<body>
			<h1>List of Volunteers for Event</h1>	
		</body>
		
		<body>
			<h1>Access/Insert Training Materials</h1>	
		</body>
		
		<body>
			<h1>Post-Event Media</h1>	
		</body>
		
		<center>		
		<a href="calendar.php"> 
				<button class = "block" style="width:200px;"><b>Go back to Calendar!</b></button>
		</a>
		</center>
		
		<br>
			
		<center>
		<a href="eventRegister.php"> 
				<button class = "block" style="width:200px;"><b>Register for Event!</b></button>
		</a>
		</center>
		
		<br>
			
		<center>
		<a href="eventRegister.php"> 
				<button class = "block" style="width:200px;"><b>Register for Event! For Admin Use Only</b></button>
		</a>
		</center>
		
	</body>
</html>