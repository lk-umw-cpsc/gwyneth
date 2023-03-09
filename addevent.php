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
    // Require admin privileges
    if ($accessLevel < 2) {
        header('Location: login.php');
        echo 'bad access level';
        die();
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once('include/input-validation.php');
        require_once('database/dbEvents.php');
        $args = sanitize($_POST, null);
        $required = array(
            "name", "abbrev-name", "date", "start-time", "end-time", "description", "location", "capacity"
        );
        if (!wereRequiredFieldsSubmitted($args, $required)) {
            echo 'bad form data';
            die();
        } else {
            $validated = validate12hTimeRangeAndConvertTo24h($args["start-time"], $args["end-time"]);
            if (!$validated) {
                echo 'bad time range';
                die();
            }
            $startTime = $args['start-time'] = $validated[0];
            $endTime = $args['end-time'] = $validated[1];
            $date = $args['date'] = validateDate($args["date"]);
            $capacity = intval($args["capacity"]);
            if (!$startTime || !$endTime || !$date || $capacity < 1){
                echo 'bad args';
                die();
            }
            $success = create_event($args);
            if(!$success){
                echo "Oopsy!";
                die();
            }
        }
    }
    $date = null;
    if (isset($_GET['date'])) {
        $date = $_GET['date'];
        $datePattern = '/[0-9]{4}-[0-9]{2}-[0-9]{2}/';
        $timeStamp = strtotime($date);
        if (!preg_match($datePattern, $date) || !$timeStamp) {
            header('Location: calendar.php');
            die();
        }
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
        <h1>Create Event</h1>
        <main class="date">
            <h2>New Event Form</h2>
            <form id="new-event-form" method="post">
                <label for="name">Event Name </label>
                <input type="text" id="name" name="name" required placeholder="Enter name"> 
                <label for="name">Abbreviated Name</label>
                <input type="text" id="abbrev-name" name="abbrev-name" required placeholder="Enter name that will appear on calendar">
                <label for="name">Date </label>
                <input type="date" id="date" name="date" <?php if ($date) echo 'value="' . $date . '"'; ?> min="<?php echo date('Y-m-d'); ?>" required>
                <label for="name">Start Time </label>
                <input type="text" id="start-time" name="start-time" pattern="([1-9]|10|11|12):[0-5][0-9]([aApP][mM])" required placeholder="Enter start time. Ex. 12:00PM">
                <label for="name">End Time </label>
                <input type="text" id="end-time" name="end-time" pattern="([1-9]|10|11|12):[0-5][0-9]([aApP][mM])" required placeholder="Enter end time. Ex. 4:00PM">
                <p id="date-range-error" class="error hidden">Start time must come before end time</p>
                <label for="name">Description </label>
                <input type="text" id="description" name="description" required placeholder="Enter description">
                <label for="name">Location </label>
                <input type="text" id="location" name="location" required placeholder="Enter location">
                <label for="name">Volunteer Slots</label>
                <input type="text" id="capacity" name="capacity" pattern="([1-9])|([01][0-9])|(20)" required placeholder="Enter a number up to 20">   
                <input type="submit" value="Create Event">
            </form>
        </main>
    </body>
</html>