
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


    $loggedIn = false;
    $access_level = 0;
    $userID = null;
    if (isset($_SESSION['_id'])) {
        $loggedIn = true;
        // 0 = not logged in, 1 = standard user, 2 = manager (Admin), 3 super admin (TBI)
        $access_level = $_SESSION['access_level'];
        $userID = $_SESSION['_id'];
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc') ?>
        <title>Gwyneth's Gift VMS | Template Page</title>
    </head>
    <body>
        <?php require_once('header.php') ?>
        <main>

          <?php
            $event_name = $event_info['name'];
            $event_date = date('l, F j, Y', strtotime($event_info['date']));
            $event_startTime = date('g:i a', strtotime($event_info['startTime']));
            $event_endTime = date('g:i a', strtotime($event_info['endTime']));
            $event_location = $event_info['location'];
            $event_description = $event_info['description'];
          ?>
        <h1> Event Roster </h1>
        <h2> <?php echo $event_name ?></h2>
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
                </tbody>
            </table>
        </div>

        <h2>Volunteers:</h2>

        <?php

          $event_persons = getvolunteers_byevent($id);
          $num_persons = count($event_persons);

          for ($x = 0; $x < $num_persons; $x++) {
            $person = $event_persons[$x];
            $first_name = $person->get_first_name();
            $last_name = $person->get_last_name();
            $address = $person->get_address();
            $city = $person->get_city();
            $state = $person->get_state();
            $zip = $person->get_zip();
            $email = $person->get_email();
            $phone1 = $person->get_phone1();
            $phone1_type = $person->get_phone1type();
            $phone2 = $person->get_phone1();
            $phone2_type = $person->get_phone1type();
            $contact_name = $person->get_contact_name();
            $contact_num = $person->get_contact_num();
            $birthday = $person->get_birthday();

            echo $first_name.' '.$last_name.'</br>';
            echo 'Email: '.$email.'</br>';
            // TODO: Create function that calculates age
            echo 'Age: '.$birthday.'</br>';
            echo 'Address: '.$address.'</br>';
            echo $city.', '.$state.' '.$zip.'</br>';
            echo 'Phone 1:'.$phone1.' ('.$phone1_type.')</br>';
            echo 'Phone 2:'.$phone2.' ('.$phone2_type.')</br>';
            echo 'Emergency Contact:</br>'.
                    'Contact Name: '.$contact_name.'</br>'.
                    'Contact Number: '.$contact_num.'</br>';
            echo '<hr>';
          }

        ?>


        </main>
    </body>
</html>
