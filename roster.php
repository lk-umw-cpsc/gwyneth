<?php
    // Template for new VMS pages. Base your new page on this one

    // Make session information accessible, allowing us to associate
    // data with the logged-in user.
    session_cache_expire(30);
    session_start();

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

    include_once('database/dbPersons.php');
    include_once('include/output.php');

    $loggedIn = false;
    $access_level = 0;
    $userID = null;
    if (isset($_SESSION['_id'])) {
        $loggedIn = true;
        // 0 = not logged in, 1 = standard user, 2 = manager (Admin), 3 super admin (TBI)
        $access_level = $_SESSION['access_level'];
        $userID = $_SESSION['_id'];
    }

    if ($access_level < 2) {
      header('Location: event.php?id='.$id.'');
      die();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc') ?>
        <link rel="stylesheet" href="css/roster.css" type="text/css" />
        <title>Gwyneth's Gift VMS | View Event Roster</title>
    </head>
    <body>
        <?php require_once('header.php') ?>
        <span class="logo_print">
          <img src="images/gwynethsgift.png">
        </span>
          <?php
            $event_name = $event_info['name'];
            $event_date = date('l, F j, Y', strtotime($event_info['date']));
            $event_startTime = date('g:i a', strtotime($event_info['startTime']));
            $event_endTime = date('g:i a', strtotime($event_info['endTime']));
            $event_location = $event_info['location'];
            $event_description = $event_info['description'];
          ?>
        <h1> Event Roster </h1>
        <h2 class="centered"><?php echo $event_name ?></h2>
        
      <main class="event-info">
        <div id="table-wrapper">
            <table class="centered">
                <tbody>
                    <tr>	
                        <td class="label">Date</td>
                        <td><?php echo $event_date ?></td>     		
                    </tr>
                    <tr>	
                        <td class="label">Time</td>
                        <td><?php echo $event_startTime.' - '.$event_endTime ?></td>     		
                    </tr>
                    <tr>	
                        <td class="label">Location</td>
                        <td><?php echo $event_location ?></td>     		
                    </tr>
                    <tr>	
                        <td class="label">Description</td><td></td>
                    </tr>
                    <tr>
                        <td colspan="2"><?php echo $event_description ?></td>     		
                    </tr>
                </tbody>
            </table>
        </div>

        <h2>Attendees</h2>

        <?php

          $event_persons = getvolunteers_byevent($id);
          $num_persons = count($event_persons);
          $emailList = '';
          for ($x = 0; $x < $num_persons; $x++) {
            $person = $event_persons[$x];
            $first_name = $person->get_first_name();
            $last_name = $person->get_last_name();
            $address = $person->get_address();
            $city = $person->get_city();
            $state = $person->get_state();
            $zip = $person->get_zip();
            $email = $person->get_email();
            if ($x > 0) {
              $emailList .= ', ';
            }
            $emailList .= $email;
            // put phone number into format (xxx)-xxx-xxxx
            $phone1 = $person->get_phone1();
            if (strlen($phone1) > 0) {
              $phone1 = formatPhoneNumber($phone1);
              $phone1_type = $person->get_phone1type();
            } else {
              $phone1 = 'N/A';
              $phone1_type = '';
            }
            $contact_name = $person->get_contact_name();
            $contact_num = $person->get_contact_num();
            if (strlen($contact_num) > 0) {
              $contact_num = formatPhoneNumber($contact_num);
            } else {
              $contact_num = 'N/A';
            }
            $age = get_age($person->get_birthday());
            $type = $person->get_type()[0];
            if ($type == 'volunteer') {
              $type = 'Volunteer';
            } else {
              $type = 'Admin';
            }
            $shirt_size = $person->get_shirt_size();
            echo '<div id="table-wrapper">'."\n";
            echo '<table class="centered">';
            echo '<tbody>'.
                    '<tr>'.
                      '<td class="label"><b>'.$first_name.' '.$last_name.'</b></td>'.
                    '</tr>'.
                    "<tr><td class='label'>Role</td><td>$type</td></tr>" .
                    '<tr>'.
                        '<td class="label">Email</td>'.
                        '<td>'.$email.'</td>'.
                    '</tr>'.
                    '<tr>'.
                        '<td class="label">Age</td>'.
                        '<td>'.$age.'</td>'.
                    '</tr>'.
                    '<tr>'.
                        '<td class="label">Address</td>'.
                        '<td>'.$address.', '.$city.', '.$state.' '.$zip.'</td>'.
                    '</tr>'.
                    '<tr>'.
                        '<td class="label">Phone</td>'.
                        '<td>'.$phone1.' ('.$phone1_type.')'.'</td>'.
                    '</tr>'.
                    '<tr>'.
                        '<td class="label">Shirt Size</td>'.
                        '<td>'.$shirt_size.'</td>'.
                    '</tr>'.
                    '<tr>'.
                        '<td class="label"><b>Emergency Contact<b></td>'.
                    '</tr>'.
                    '<tr>'.
                        '<td class="label">Contact Name</td>'.
                        '<td>'.$contact_name.'</td>'.
                    '</tr>'.
                    '<tr>'.
                        '<td class="label">Contact Phone</td>'.
                        '<td>'.$contact_num.'</td>'.
                    '</tr>'.
                 '</tbody>'.
                 '</table>';
            echo '</div>';
            echo '<hr>';
          }

        ?>

        <div class="no-print">
          <label>Mailing List</label>
          <p><?php echo $emailList; ?></p>
        </div>
        <button onClick="window.print()" style="margin-bottom: -.5rem">Print</button>
        <a class="button cancel no-print" href="event.php?id=<?php echo htmlspecialchars($_GET['id']) ?>">Return to Event Details</a>
        </main>
    </body>
</html>
