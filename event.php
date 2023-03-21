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
    ini_set("display_errors",1);
    error_reporting(E_ALL);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['request_type'])) {
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
        } else {
            require_once('include/input-validation.php');
            $args = sanitize($_POST);
            $get = sanitize($_GET);
            if (isset($_POST['attach-post-media-submit'])) {
                $required = [
                    'url', 'description', 'format', 'id'
                ];
                if (!wereRequiredFieldsSubmitted($args, $required)) {
                    echo "dude, args missing";
                    die();
                }
                $type = 'post';
                $format = $args['format'];
                $url = $args['url'];
                if ($format == 'video') {
                    $url = convertYouTubeURLToEmbedLink($url);
                    if (!$url) {
                        echo "bad video link";
                        die();
                    }
                } else if (!validateURL($url)) {
                    echo "bad url";
                    die();
                }
                $eid = $args['id'];
                $description = $args['description'];
                if (!valueConstrainedTo($format, ['link', 'video', 'picture'])) {
                    echo "dude, bad format";
                    die();
                }
                attach_post_event_media($eid, $url, $format, $description);
                header('Location: event.php?id=' . $id);
                die();
            }
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
                    <?php
                        $medias = get_post_event_media($id);
                        foreach ($medias as $media) {
                            echo '<tr><td colspan="2">';
                            if ($media['format'] == 'link') {
                                echo '<a href="' . $media['url'] . '">' . $media['description'] . '</a>';
                            } else if ($media['format'] == 'picture') {
                                echo '<span>' . $media['description'] . '</span><br><img style="max-width: 30vw" src="' . $media['url'] . '" alt="' . $media['description'] . '">';
                            } else {
                                echo '<span>' . $media['description'] . '</span><br><iframe width="560" height="315" src="' . $media['url'] .'" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>';
                            }
                            echo '</td></tr>';
                        }
                        if (count($medias) == 0) {
                            echo '<td colspan="2" class="inactive">None at this time</td>';
                        }
                    ?>
                    <?php if ($access_level >= 2): ?>
                        <tr><td colspan="2">
                            <form class="media-form hidden" method="post" id="attach-post-media-form">
                                <label>Attach Post-Event Media</label>
                                <label for="url">URL</label>
                                <input type="text" id="url" name="url" required>
                                <label for="description">Description</label>
                                <input type="text" id="description" name="description" required>
                                <label for="format">Format</label>
                                <select id="format" name="format">
                                    <option value="link">Link</option>
                                    <option value="video">YouTube video (embeds video)</option>
                                    <option value="picture">Picture (embeds picture)</option>
                                </select>
                                <input type="hidden" name="id" value="<?php echo $id ?>">
                                <input type="submit" name="attach-post-media-submit" value="Attach">
                            </form>
                            <a id="attach-post-media">Attach Post-Event Media</a>
                        </td></tr>
                    <?php endif ?>
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
                            '<form class="remove-person" method="POST">'.
                            '<input type="hidden" name="request_type" value="remove" />'.
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
                        <form method="POST">
                            <input type="hidden" name="request_type" value="add">
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
                    echo '<form method="POST" class="standout">';
                    echo '<input type=hidden name="request_type" value="add">';
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