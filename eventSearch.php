<?php
    // Template for new VMS pages. Base your new page on this one

    // Make session information accessible, allowing us to associate
    // data with the logged-in user.
    session_cache_expire(30);
    session_start();

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
            $search = 'Results for Search by Name: "' . htmlspecialchars($_POST['name']) . '"';
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

            $start = date('m/d/Y', strtotime($start));
            $end = date('m/d/Y', strtotime($end));
            $search = 'Results for Search by Date Range: ' . htmlspecialchars($_POST['date-start']) . ' - ' . htmlspecialchars($_POST['date-end']);
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
        <main class="search-form">
            <?php
                if (isset($events)) {
                    echo '<h2>' . $search . '</h2>';
                    require_once('include/output.php');
                    if (count($events) > 0) {
                        foreach ($events as $event) {
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
                    } else {
                        echo '<div class="error-toast">Your search returned no results.</div>';
                    }
                }
            ?>
            <h2>Search for an Event</h2>
            <form method="post">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" placeholder="Enter event name" required>
                <input type="submit" name="submitName" id="submitName" value="Search by Name">
            </form>
            <form id="event-date-range-search" method="post">
                <label for="date-start">Date Range Start</label>
                <input type="date" name="date-start" id="date-start" required>
                <label for="date-end">Date Range End</label>
                <input type="date" name="date-end" id="date-end" required>
                <p id="date-range-error" class="error hidden">Start date must come before end date</p>
                <input type="submit" name="submitDateRange" id="submitDateRange" value="Search by Date Range">
            </form>
            <a class="button cancel" href="index.php" style="margin-top: -.5rem">Return to Dashboard</a>
        </main>
    </body>
</html>