<?php
    session_cache_expire(30);
    session_start();

    date_default_timezone_set("America/New_York");
    
        
    include_once('database/dbPersons.php');
    include_once('domain/Person.php');
    // Get date?
    date('l F j, Y');
    if (isset($_SESSION['_id'])) {
        $person = retrieve_person($_SESSION['_id']);
    }
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
                <div class="dashboard-item" data-link="calendar.php">
                    <img src="images/view-calendar.svg">
                    <span>View Calendar</span>
                </div>
                <?php
                if ($_SESSION['access_level'] >= 2) {
                    echo '
                        <div class="dashboard-item">
                            <img src="images/new-event.svg">
                            <span>New Event</span>
                        </div>';
                }
                ?>
                <div class="dashboard-item" data-link="personEdit.php?id=<?php echo $person->get_id(); ?>">
                    <img src="images/manage-account.svg">
                    <span>Manage Account</span>
                </div>
                <div class="dashboard-item" data-link="changePassword.php">
                    <img src="images/change-password.svg">
                    <span>Change Password</span>
                </div>
                <div class="dashboard-item" data-link="logout.php">
                    <img src="images/logout.svg">
                    <span>Log out</span>
                </div>
            </div>
        </main>
    </body>
</html>