<?php 

?>

<!DOCTYPE html>
<html>
	<head>
		<?php
      require_once('universal.inc');

      // check if user has reached this page
      // with an event ID
      if (isset($_GET["id"])) {
        echo '<title>'.$_GET["id"].' - Event</title>';
      } else {
        header('Location: calendar.php');
        // TODO: If the event id is not in the url,
        // then the user will be redirected to
        // the calendar view
		    echo '<title>No Event ID - Event</title>';
      }
    ?>
	</head>
	
	<body>
		<?php require_once('header.php');

    // check if user has reached this page
    // with an event ID
    if (isset($_GET["id"])) {
		  echo '<h1>'.$_GET["id"].' - Event: </h1>';
    } else {
      echo '<h1>No Event ID - Event:</h1>';
    }
    ?>
    <!-- TODO: will figure out another way to center
               later -->
		<p><center>Event Date(s): March 6th, 2023</center></p>
		<p><center>Event Start Time: 2:00pm</center></p>
		<p><center>Event End Time: 5:00pm</center></p>
		<p><center>Event Location: 1234 Drive Dr.</center></p>
		<p><center>Event Description: This is a description</center></p>
		<br>
	
		<body>
			<h2>
        <center>List of Volunteers for Event</center>
      </h2>
      <!-- TODO: will figure out another way to center
                 later -->
        <li>
            <ul><center>&nbsp;Joe</center></ul>
            <ul><center>&nbsp;Alice</center></ul>
            <ul><center>&nbsp;Bob</center></ul>
            <ul><center>&nbsp;Michelle</center></ul>
       </li>
		</body>
    <br>
		<body>
			<h2>
        <center>Access/Insert Training Materials</center>
      </h2>	
      <center>
        To be added
      </center>
		</body>
		
    <!-- temporary breaks to separate headers -->
    <br><br>

		<body>
			<h2>
        <center>Post-Event Media</center>
      </h2>	
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
