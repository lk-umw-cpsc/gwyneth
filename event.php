<?php 

  require_once('universal.inc');
  include_once('database/dbEvents.php');
  include_once('database/dbPersons.php');

  session_cache_expire(30);
  session_start();

  // Ensure user is logged in
  if (!isset($_SESSION['access_level']) || $_SESSION['access_level'] < 1) {
      header('Location: login.php');
      die();
  }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['selected_id'];
  $event_info = fetch_event_by_id($_GET['id']);
  $event_volunteer_list = $event_info[9];
  if (!str_contains($event_volunteer_list, $id)) {
    $event_volunteer_list = $event_volunteer_list."-".$id;
  }
  update_event_volunteer_list($_GET['id'], $event_volunteer_list);
}

?>

<!DOCTYPE html>
<html>
	<head>
		<?php

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
      
		  echo '<h1>''View Event: '.$event_name.'</h1>';
    ?>

    <main>
    <?php
      /* TODO: will figure out another way to center
               later
      */
      echo '<div><center>';
		  echo 'Date: '.$event_date.'<br>';
		  echo 'Time: '.$event_startTime.' - '.$event_endTime.'<br>';
		  echo 'Location: '.$event_location.'<br>';
      echo '</div></center><br>';
		  echo '
        <p>
          <center>Description: </center>
          <div width="500px" height="500px" style="overflow-y: scroll;">
            <center>'.
              $event_description.
           '</center>
          </div>
        </p>';
    ?>
	
		<h2 class="centered">Volunteers for Event</h2>
			
      <!-- TODO: will figure out another way to center
                 later -->
      <ul class="centered">
      <?php
      $event_persons = explode("-", $event_info[9]);
      for ($x = 0; $x < count($event_persons); $x += 1) {
        $event_person = retrieve_person($event_persons[$x]);
        if ($event_person === False) {
          echo '<li class="centered">No volunteers assigned</li>';
        } else {
        echo '<li class="centered">'.$event_person->get_first_name().' '.$event_person->get_last_name().'</li>';
        }
      }
      ?>
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
      <select name="selected_id">
        <?php
        $all_volunteers = getall_volunteers();
        for ($x = 0; $x < count($all_volunteers); $x++) {
          echo '<option value="'.$all_volunteers[$x]->get_id().'">'.$all_volunteers[$x]->get_last_name().', '.$all_volunteers[$x]->get_first_name().'</option>';
        }
        ?>
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
