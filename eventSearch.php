<?php
    // Template for new VMS pages. Base your new page on this one

    // Make session information accessible, allowing us to associate
    // data with the logged-in user.
    session_cache_expire(30);
    session_start();

    ini_set("display_errors",1);
    error_reporting(E_ALL);

    $loggedIn = false;
    $accessLevel = 0;
    $userID = null;
    if (isset($_SESSION['_id'])) {
        $loggedIn = true;
        // 0 = not logged in, 1 = standard user, 2 = manager (Admin), 3 super admin (TBI)
        $accessLevel = $_SESSION['access_level'];
        $userID = $_SESSION['_id'];
    }
    if (!$loggedIn) {
        header('Location: login.php');
        die();
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once('include/input-validation.php');
        require_once('database/dbEvents.php');
        $args = sanitize($_POST);
        if (isset($args['submitName'])) {
            if (!wereRequiredFieldsSubmitted($args, array('name'))) {
                echo 'missing form data';
                die();
            }
            $events = find_event($args['name']);
        } else if (isset($args['submitDateRange'])) {
            if (!wereRequiredFieldsSubmitted($args, array('date-start', 'date-end'))) {
                echo 'missing form data';
                die();
            }
            $start = validateDate($args['date-start']);
            $end = validateDate($args['date-end']);
            if (!$start || !$end || $start > $end) {
                echo 'bad date range';
                die();
            }
            $events = fetch_events_in_date_range_as_array($start, $end);
        }
    } else {
        $events = null;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc') ?>
        <title>Gwyneth's Gift VMS | Event Search</title>
    </head>
    <body>
        <?php require_once('header.php') ?>
        <h1>Event Search</h1>
        <main class="date">
            <h2>Search for an Event</h2>
            <form method="post">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" placeholder="Enter event name" required>
                <input type="submit" name="submitName" id="submitName" value="Search by name">
            </form>
            <form method="post">
                <label for="date-start">Date Range Start</label>
                <input type="date" name="date-start" id="date-start" required>
                <label for="date-end">Date Range End</label>
                <input type="date" name="date-end" id="date-end" required>
                <input type="submit" name="submitDateRange" id="submitDateRange" value="Search by date range">
            </form>
            <?php
                    if ($events) {
                        require_once('include/output.php');
                        foreach ($events as $event) {
                            // echo '
    
                            //     <fieldset class="event">
                            //         <legend>' . $event['name'] . '</legend>
                            //         <span>Time: ' . time24hTo12h($event['startTime']) . ' - ' . time24hto12h($event['endTime']) . '</span>
                            //         <span>Description: ' . $event['description'] . '</span>
                            //         <span>Location:' . $event['location'] . '</span>
                            //     </fieldset>
                            // ';
                            $date = $event['date'];
                            $date = strtotime($date);
                            $date = date('l, F j, Y', $date);
                            echo "
                                <table class='event'>
                                    <thead>
                                    <tr>
                                    <th colspan='2' data-event-id='" . $event['id'] . "'>" . $event['name'] . "</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr><td>Date</td><td>" . $date . "</td></tr>
                                    <tr><td>Time</td><td>" . time24hto12h($event['startTime']) . " - " . time24hto12h($event['endTime']) . "</td></tr>
                                    <tr><td>Location</td><td>" . $event['location'] . "</td></tr>
                                    <tr><td>Description</td><td>" . $event['description'] . "</td></tr>
                                    </tbody>
                                    </table>
                        
        
                                    ";
    
                            
                        }
                    }
                ?>
        </main>
    </body>
</html>