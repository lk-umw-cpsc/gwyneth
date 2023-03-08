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
    if ($accessLevel < 1) {
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
            <h1>View Day</h1>
            <!-- Loop -->
            <div class="event">
                <span>Event 1</span>
                <span>8:00am</span>
                <span>10:00am</span>
                <span>This is the description.</span>
                <span>12345 Test st. Fredericksburg, VA 22401</span>
            </div>
            <button>
                Create New Event
            </button>
        </main>
    </body>
</html>