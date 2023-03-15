<?php 


  session_cache_expire(30);
  session_start();

  // Ensure user is logged in
  if (!isset($_SESSION['access_level']) || $_SESSION['access_level'] < 1) {
      header('Location: login.php');
      die();
  }
  
   if (isset($_GET["id"])) {
        $id = $_GET["id"];
        echo '<title>'.$_GET["id"].' - Event</title>';
   } else {
        	header('Location: calendar.php');
        	die();
  	}
  	
  	include_once('database/dbEvents.php');
  	
  	$event_info = fetch_event_by_id($id);
  	 if ($event_info == NULL) {
        // TODO: Need to create error page for no event found
        header('Location: calendar.php');
        die();
      }

  $access_level = $_SESSION['access_level'];
  
  include_once('database/dbPersons.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_type = $_POST['request_type'];
		$eventID = $_GET["id"];


  
    if ($request_type == 'add') {
		$volunteerID = $_POST['selected_id'];
		update_event_volunteer_list($eventID, $volunteerID);
    }
    if ($request_type == 'remove') {
		  $volunteerID = $_POST['selected_removal_id'];
		  remove_volunteer_from_event($eventID, $volunteerID);
    }
  }
?>

<!DOCTYPE html>
<html>
	<head>
		<?php
			  require_once('universal.inc');
      // check if user has reached this page
      // with an event ID
      /*if (isset($_GET["id"])) {
        $id = $_GET["id"];
        echo '<title>'.$_GET["id"].' - Event</title>';
      } else {
        	header('Location: calendar.php');
        	die();
      }*/
    ?>
	</head>
	
	<body>
		<?php
      require_once('header.php');

      // grab event data using fetch_event_by_id() in dbEvents.php
      /*$event_info = fetch_event_by_id($id);
      if ($event_info == NULL) {
        // TODO: Need to create error page for no event found
        header('Location: calendar.php');
        die();
      }*/
      // print_r($event_info);
      $event_name = $event_info['name'];
      $event_date = date('F j, Y', strtotime($event_info['date']));
      $event_startTime = date('g:i a', strtotime($event_info['startTime']));
      $event_endTime = date('g:i a', strtotime($event_info['endTime']));
      $event_location = $event_info['location'];
      $event_description = $event_info['description'];
      
		  echo '<h1> View Event: '.$event_name.'</h1>';
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
      $event_persons = getvolunteers_byevent($id);
      if (count($event_persons) == 0){
				echo '<li>No volunteers assigned</li>';      
      }
      else {
      	for ($x = 0; $x < count($event_persons); $x += 1) {
        		$person = $event_persons[$x];

            // allow admins/super admins to remove assigned volunteers
            if ($access_level > 1) {
        		echo '<li class="centered">'.
                  '<div>'.
                  $person->get_first_name().
                  ' '.
                  $person->get_last_name().
                  '</div>'.
                  '<div>'.
                  '<form method="POST">'.
                  '<input type="hidden" name="request_type" value="remove" />'.
                  '<input type="hidden" name="selected_removal_id" value='.
                  $person->get_id().' />'.
                  '<input type="submit" value="Remove" />'.
                  '</form>'.
                  '</div>'.
                  '</li>';
            } else {
        		echo '<li class="centered">'.
                  '<div>'.
                  $person->get_first_name().
                  ' '.
                  $person->get_last_name().
                  '</div>'.
                  '</li>';
            }
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
		
    <?php
    // if user access is 1, then the user is a volunteer
    if ($access_level == 1 || $access_level == 2) {
      echo '<form method="POST">';
      echo '<input type="hidden" name="request_type" value="add">';
      echo '<input type="hidden" name="selected_id" value="'.$_SESSION['_id'].'">';
      echo '<input type="submit" value="Assign Self ('.$_SESSION['_id'].')">';
      echo '</form>';
    }
    if ($access_level == 2 || $access_level == 3) {

      echo '<form method="POST">';
      echo '<input type=hidden name="request_type" value="add">';
      echo '<select name="selected_id">';
        $all_volunteers = get_unassigned_available_volunteers($id);
        if ($all_volunteers) {
          for ($x = 0; $x < count($all_volunteers); $x++) {
            echo '<option value="'.$all_volunteers[$x]->get_id().'">'.$all_volunteers[$x]->get_last_name().', '.$all_volunteers[$x]->get_first_name().'</option>';
          }
        }
      echo '</select>';
      echo '<input type="submit" value="Assign Volunteer" />';
      echo '</form>';
    
      /*echo '<form method="POST">';
      echo '<input type=hidden name="request_type" value="remove">';
      echo '<select name="selected_removal_id">';
        $all_volunteers = getall_volunteers();
        for ($x = 0; $x < count($all_volunteers); $x++) {
          echo '<option value="'.$all_volunteers[$x]->get_id().'">'.$all_volunteers[$x]->get_last_name().', '.$all_volunteers[$x]->get_first_name().'</option>';
        }
      echo '</select>';
      echo '<input type="submit" value="Remove Volunteer" />';
    echo '</form>';*/

    }
    ?>


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
