<?php
    // Template for new VMS pages. Base your new page on this one

    // Make session information accessible, allowing us to associate
    // data with the logged-in user.
    session_cache_expire(30);
    session_start();
    date_default_timezone_set("America/New_York");

    $loggedIn = false;
    $accessLevel = 0;
    $userID = null;
    if (isset($_SESSION['_id'])) {
        $loggedIn = true;
        // 0 = not logged in, 1 = standard user, 2 = manager (Admin), 3 super admin (TBI)
        $accessLevel = $_SESSION['access_level'];
        $userID = $_SESSION['_id'];
    }
    if ($accessLevel < 1) {
        header('Location: login.php');
        die();
    }
    if (!isset($_GET['date'])) {
        header('Location: calendar.php');
        die();
    }
    $date = $_GET['date'];
    $datePattern = '/[0-9]{4}-[0-9]{2}-[0-9]{2}/';
    $timeStamp = strtotime($date);
    if (!preg_match($datePattern, $date) || !$timeStamp) {
        header('Location: calendar.php');
        die();
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
        <h1>View Day</h1>
        <main class="date">
            <h2>Events for <?php echo date('l, F j, Y', $timeStamp) ?></h2>
            <!-- Loop -->
            <?php
                require('database/dbEvents.php');
                require('include/output.php');
                $events = fetch_events_on_date($date);
                if ($events) {
                    foreach ($events as $event) {
                        echo "
                            <table class='event'>
                                <thead>
                                    <tr>
                                        <th colspan='2' data-event-id='" . $event['id'] . "'>" . $event['name'] . "</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>Time</td><td>" . time24hto12h($event['startTime']) . " - " . time24hto12h($event['endTime']) . "</td></tr>
                                    <tr><td>Location</td><td>" . $event['location'] . "</td></tr>
                                    <tr><td>Description</td><td>" . $event['description'] . "</td></tr>
                                </tbody>
                              </table>
                        ";

                        
                    }
                } else {
                    echo '<p class="none-scheduled">There are no events scheduled on this day</p>';
                }
            ?>
            <?php
            if ($accessLevel >= 2) {
                echo '
                    <a class="button" href="addEvent.php?date=' . $date . '">
                        Create New Event
                    </a>';
            }
            ?>
        </main>
    </body>
</html>