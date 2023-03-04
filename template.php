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
            <!-- Your code goes here. Be sure to wrap any form elements in a <form> tag -->
            <p>Here's an example paragraph tag!</p>
            <p>You are <?php if (!$loggedIn) echo 'not '; ?>logged in.</p>
            <?php
                if ($userID) {
                    echo '<p>Your user ID is ' . $userID . '.</p>';
                }
            ?>
        </main>
    </body>
</html>