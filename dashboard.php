<?php
    session_start();
    session_cache_expire(30);

    date_default_timezone_set("America/New_York");
    
    // Get date?
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require('universal.inc'); ?>
    </head>
    <body>
        <?php require('header.php'); ?>
        <main class='login'>
            <h1>Dashboard</h1>
            <div id="dashboard">
                <div class="dashboard-item">
                    <img src="images/view-calendar.png">
                    <span>View Calendar</span>
                </div>
                <div class="dashboard-item">
                    <img src="images/new-event.png">
                    <span>New Event</span>
                </div>
                <div class="dashboard-item">
                    <img src="images/manage-account.png">
                    <span>Manage Account</span>
                </div>
                <div class="dashboard-item">
                    <img src="images/change-password.png">
                    <span>Change Password</span>
                </div>
            </div>
        </main>
    </body>
</html>