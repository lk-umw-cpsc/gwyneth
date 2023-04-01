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
    $events = get_events_attended_by($_SESSION['_id']);
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc') ?>
        <title>Gwyneth's Gift VMS | Template Page</title>
    </head>
    <body>
        <?php 
            require_once('header.php');
            require_once('database/dbPersons.php');
        ?>
        <h1>Volunteer History Report</h1>
        <main class="general">
            <h2>Your Volunteer Hours</h2>
            <?php foreach ($events as $event): ?>
                
            <?php endforeach ?>
        </main>
    </body>
</html>