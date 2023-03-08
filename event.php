<?php 

  session_cache_expire(30);
  session_start();

  // Ensure user is logged in
  if (!isset($_SESSION['access_level']) || $_SESSION['access_level'] < 1) {
      header('Location: login.php');
      die();
  }

?>

<!DOCTYPE html>
<html>
	<head>
		<?php
      require_once('universal.inc');
      include_once('database/dbEvents.php');

      // check if user has reached this page
      // with an event ID
      if (isset($_GET["id"])) {
        $id = $_GET["id"];
        echo '<title>'.$_GET["id"].' - Event</title>';
      } else {
        header('Location: calendar.php');
        die();
      }
    ?>
	</head>
	
	<body>
		<?php
      require_once('header.php');

      // grab event data using fetch_event_by_id() in dbEvents.php
      $event_info = fetch_event_by_id($id);
      if ($event_info == NULL) {
        // TODO: Need to create error page for no event found
        header('Location: calendar.php');
        die();
      }
      // print_r($event_info);
      $event_name = $event_info[1];
      $event_date = date('F j, Y', strtotime($event_info[3]));
      $event_startTime = date('g:i a', strtotime($event_info[4]));
      $event_endTime = date('g:i a', strtotime($event_info[5]));
      $event_location = $event_info[7];
      $event_description = $event_info[6];
      
		  echo '<h1>'.$id.' - Event: '.$event_name.'</h1>';
    ?>

    <main>
    <?php
      /* TODO: will figure out another way to center
               later
      */
      echo '<div><center>';
		  echo 'Event Date: '.$event_date.'<br>';
		  echo 'Event Start Time: '.$event_startTime.'<br>';
		  echo 'Event End Time: '.$event_endTime.'<br>';
		  echo 'Event Location: '.$event_location.'<br>';
      echo '</div></center><br>';
		  echo '
        <p>
          <center>Event Description: </center>
          <div width="500px" height="500px" style="overflow-y: scroll;">
            <center>'.
              $event_description.
           '</center>
          </div>
        </p>';
    ?>
	
			<h2 class="centered">
        List of Volunteers for Event
      </h2>
      <!-- TODO: will figure out another way to center
                 later -->
      <ul class="centered">
            <li class="centered">Joe Doe</li>
            <li class="centered">Alice Bob</li>
            <li class="centered">Bob Looker</li>
            <li class="centered">Michelle Hobbins</li>
      </ul>

			<h2 class="centered">
        Access/Insert Training Materials
      </h2>	
      <p class="centered">
        To be added
      </p>
		
    <!-- temporary breaks to separate headers -->

			<h2>
        <center>Post-Event Media</center>
      </h2>	
		
    <form method="POST">
      <select>
        <option value="jdoe@umw.edu">Doe, John</option>
        <option value="abob@umw.edu">Alice, Bob</option>
      </select>
      <input type="submit" value="Assign Volunteer" />
    </form>

    <div>
		<a href="calendar.php" class="button">
				Go back to Calendar!
		</a>
		
    <!-- Talk about doing volunteer registration on same page -->
		<!-- <a href="eventRegister.php" class="button">
				Register for Event!
		</a> -->

    </div>
		</main>
	</body>
</html>
