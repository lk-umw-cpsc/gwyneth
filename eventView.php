<?php 

?>

<!DOCTYPE html>
<html>
	<head>
		<?php
      require_once('universal.inc');

      // check if user has reached this page
      // with an event ID
      if (isset($_GET["event"])) {
        echo '<title>'.$_GET["event"].' - Event View</title>';
      } else {
        // TODO: If the event id is not in the url,
        // then the user will be redirected to
        // the calendar view
		    echo '<title>No Event ID - Event View</title>';
      }
    ?>
	</head>
	
	<body>
		<?php require_once('header.php');

    // check if user has reached this page
    // with an event ID
    if (isset($_GET["event"])) {
		  echo '<h1>'.$_GET["event"].' - Event View: </h1>';
    } else {
      echo '<h1>No Event ID - Event View:</h1>';
    }
    ?>
		<p>Event Date(s): March 6th, 2023</p>
		<p>Event Start Time: 2:00pm</p>
		<p>Event End Time: 5:00pm</p>
		<p>Event Location: 1234 Drive Dr.</p>
		<p>Event Description: This is a description</p>
		<br>
	
		<body>
			<h1>List of Volunteers for Event</h1>	
      <li>
        <ul>&nbsp;Joe</ul>
        <ul>&nbsp;Alice</ul>
        <ul>&nbsp;Bob</ul>
        <ul>&nbsp;Michelle</ul>
      </li>
		</body>
    <br>
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
