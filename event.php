<?php 

    session_cache_expire(30);
    session_start();

    // Ensure user is logged in
    if (!isset($_SESSION['access_level']) || $_SESSION['access_level'] < 1) {
        header('Location: login.php');
        die();
    }
    require_once('include/input-validation.php');
    $args = sanitize($_GET);
    if (isset($args["id"])) {
        $id = $args["id"];
    } else {
        header('Location: calendar.php');
        die();
  	}
  	
  	include_once('database/dbEvents.php');
  	
    // We need to check for a bad ID here before we query the db
    // otherwise we may be vulnerable to SQL injection(!)
  	$event_info = fetch_event_by_id($id);
    if ($event_info == NULL) {
        // TODO: Need to create error page for no event found
        // header('Location: calendar.php');

        // Lauren: changing this to a more specific error message for testing
        echo 'bad event ID';
        die();
    }

    $access_level = $_SESSION['access_level'];
    
    include_once('database/dbPersons.php');
    if (isset($args["request_type"])) {
    //if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $request_type = $args['request_type'];
        if (!valueConstrainedTo($request_type, 
                array('add self', 'add another', 'remove'))) {
            echo "Bad request";
            die();
        }
        $eventID = $args["id"];

        // Check if Get request from user is from an organization member
        // (volunteer, admin/super admin)
        if ($request_type == 'add self' && $access_level >= 1) {
            $volunteerID = $args['selected_id'];
            update_event_volunteer_list($eventID, $volunteerID);

        // Check if GET request from user is from an admin/super admin
        // (Only admins and super admins can add another user)
        } else if ($request_type == 'add another' && $access_level > 1) {
            $volunteerID = $args['selected_id'];
            update_event_volunteer_list($eventID, $volunteerID);

        } else if ($request_type == 'remove' && $access_level > 1) {
            $volunteerID = $args['selected_removal_id'];
            remove_volunteer_from_event($eventID, $volunteerID);
        } else {
          header('Location: event.php?id='.$eventID);
          die();
        }
    }
?>

<!DOCTYPE html>
<html>

<head>
    <?php
        require_once('universal.inc');
    ?>
    <title>Gwyneth's Gift VMS | View Event: <?php echo $event_info['name'] ?></title>
    <link rel="stylesheet" href="css/event.css" type="text/css" />
</head>

<body>
    <?php
        require_once('header.php');
        
        $event_name = $event_info['name'];
        $event_date = date('l, F j, Y', strtotime($event_info['date']));
        $event_startTime = date('g:i a', strtotime($event_info['startTime']));
        $event_endTime = date('g:i a', strtotime($event_info['endTime']));
        $event_location = $event_info['location'];
        $event_description = $event_info['description'];
      
        echo '<h1> View Event </h1>';
        echo '<h2><center> '.$event_name.' </center></h2>';
    ?>

    <main class="event-info">
        <div id="table-wrapper">
            <table class="centered">
                <tbody>
                    <tr>	
                        <td class="label">Date:</td>
                        <td><?php echo $event_date ?></td>     		
                    </tr>
                    <tr>	
                        <td class="label">Time:</td>
                        <td><?php echo $event_startTime.' - '.$event_endTime ?></td>     		
                    </tr>
                    <tr>	
                        <td class="label">Location:</td>
                        <td><?php echo $event_location ?></td>     		
                    </tr>
                    <tr>	
                        <td class="label">Description:</td><td></td>
                    </tr>
                    <tr>
                        <td colspan="2"><?php echo $event_description ?></td>     		
                    </tr>
                    <tr>
                        <td class="label">Training Materials:</td><td></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="inactive">None at this time</td>
                    </tr>
                    <tr>
                        <td class="label">Post-Event Media:</td><td></td>
                    </tr>
                    <tr>
                        <td colspan="2" class="inactive">None at this time</td>
                    </tr>
                    <?php
                        if ($access_level >= 2) {
                            echo '
                                <tr>
                                    <td colspan="2">
                                        <a href="editEvent.php?id=' . $id . '" class="button">Edit Event Details</a>
                                    </td>
                                </tr>
                            ';
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <h2 class="centered">Event Volunteers</h2>

        <!-- TODO: will figure out another way to center
                 later -->
        <div class="standout">
            <ul class="centered">
                <?php
                    $event_persons = getvolunteers_byevent($id);
                    $capacity = intval($event_info['capacity']);
                    $num_persons = count($event_persons);
                    $user_id = $_SESSION['_id'];
                    $remaining_slots = $capacity - count($event_persons);
                    $already_assigned = false;
                    if ($remaining_slots) {
                        echo '<li class="centered">' . $remaining_slots . ' / ' . $capacity . ' Slots Remaining</li>';
                    } else {
                        echo '<li class="centered">This event is fully booked!</li>';
                    }

                    for ($x = 0; $x < $num_persons; $x += 1) {
                        $person = $event_persons[$x];
                        if ($person->get_id() == $user_id) {
                            $already_assigned = true;
                        }
                        // allow admins/super admins to remove assigned volunteers
                        if ($access_level > 1) {
                            echo '<li class="centered remove-person">'.
                            '<span>'.
                            $person->get_first_name().
                            ' '.
                            $person->get_last_name().
                            '</span>'.
                            '<form class="remove-person" method="GET">'.
                            '<input type="hidden" name="request_type" value="remove" />'.
                            '<input type="hidden" name="id" value="'.$id.'">'.
                            '<input type="hidden" name="selected_removal_id" value='.
                            $person->get_id().' />'.
                            '<input class="stripped" type="submit" value="Remove" />'.
                            '</form></li>';
                        } else {
                            echo '
                                <li class="centered">' .
                                $person->get_first_name()
                                . ' ' .
                                $person->get_last_name().
                                '</li>
                            ';
                        }
                    }
                    for ($x = 0; $x < $remaining_slots; $x++) {
                        echo '<li class="centered empty-slot">-Empty Slot-</li>';      
                    }
                ?>
            </ul>
        <?php 
            if ($remaining_slots > 0) {
                if (!$already_assigned) {
                    echo '
                        <form method="GET">
                            <input type="hidden" name="request_type" value="add self">
                            <input type="hidden" name="id" value="'.$id.'">
                            <input type="hidden" name="selected_id" value="' . $_SESSION['_id'] . '">
                            <input type="submit" value="Sign Up">
                        </form>
                    ';
                } else {
                    // show "unassigned self" button
                    echo '<div class="centered">You are signed up for this event!</div>';
                }
            } else if ($already_assigned) {
                echo '<div class="centered">You are signed up for this event!</div>';
            }
        ?>
        </div>
        <?php
            if ($remaining_slots > 0) {
                if ($access_level >= 2) {
                    echo '<form method="GET" class="standout">';
                    echo '<input type=hidden name="request_type" value="add another">';
                    echo '<input type="hidden" name="id" value="'.$id.'">';
                    echo '<label for="volunteer-select">Assign Volunteer:</label>';
                    echo '<div class="pair"><select name="selected_id" id="volunter-select">';
                    $all_volunteers = get_unassigned_available_volunteers($id);
                    if ($all_volunteers) {
                        for ($x = 0; $x < count($all_volunteers); $x++) {
                            echo '<option value="'.$all_volunteers[$x]->get_id().'">'.$all_volunteers[$x]->get_last_name().', '.$all_volunteers[$x]->get_first_name().'</option>';
                        }
                    }
                    echo '</select>';
                    echo '<input type="submit" value="Assign" /></div>';
                    echo '</form>';
                }
            }
        ?>

        <?php
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

    ?>

        <?php
            if ($access_level >= 2) {
                echo '<a href="event.php" class="button">Delete Event</a>';
            }
        ?>

        <!-- Talk about doing volunteer registration on same page -->
        <!-- <a href="eventRegister.php" class="button">
				Register for Event!
		</a> -->


        <a href="calendar.php" class="button">Return to Calendar</a>
            <!-- Talk about doing volunteer registration on same page -->
            <!-- (this page will only be visible to logged in users,
            so we probably don't need that. -Lauren) -->
            <!-- <a href="eventRegister.php" class="button">
				Register for Event!
		</a> -->
    </main>
</body>

</html>
