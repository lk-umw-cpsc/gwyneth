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
    // Require admin privileges
    if ($accessLevel < 2) {
        header('Location: login.php');
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
        <main class="date">
            <h1>Create Event</h1>
            <form>
                <label for="name"> Event Name </label>
                <input type="text" id="name" name="name" required placeholder="Enter a name"> 
                <label for="name"> Abbreviated Event Name</label>
                <input type="text" id="abbrev-name" name="addrev-name" required placeholder="Name that appears on calendar">
                <label for="name"> Event Date </label>
                <input type="date" id="date" name="date" required>
                <label for="name"> Event Start Time </label>
                <input type="text" id="start-time" name="start-time" required placeholder="Event start time">
                <label for="name"> Event End Time </label>
                <input type="text" id="end-time" name="end-time" required placeholder="Event end time">
                <label for="name"> Event Description </label>
                <input type="text" id="description" name="description" required placeholder="Enter event description">
                <label for="name"> Event Location </label>
                <input type="text" id="location" name="location" required placeholder="Enter event location">
                <label for="name"> Event Capacity </label>
                <input type="text" id="capacity" name="capacity" required placeholder="Enter event capactity">   
            </form>
        </main>
    </body>
</html>