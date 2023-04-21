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
    $isAdmin = $accessLevel >= 2;
    require_once('database/dbPersons.php');
    if ($isAdmin && isset($_GET['id'])) {
        require_once('include/input-validation.php');
        $args = sanitize($_GET);
        $id = $args['id'];
        $viewingSelf = $id == $userID;
    } else {
        $id = $_SESSION['_id'];
        $viewingSelf = true;
    }
    $events = get_events_attended_by($id);
    $totalHours = get_hours_volunteered_by($id);
    $volunteer = retrieve_person($id);
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc') ?>
        <title>Gwyneth's Gift VMS | Volunteer History</title>
        <link rel="stylesheet" href="css/hours-report.css">
    </head>
    <body>
        <?php 
            require_once('header.php');
        ?>
        <h1>Volunteer History Report</h1>
        <main class="hours-report">
            <?php if (!$volunteer): ?>
                <p class="error-toast">That volunteer does not exist!</p>
            <?php elseif ($viewingSelf): ?>
                <h2 class="no-print">Your Volunteer Hours</h2>
            <?php else: ?>
                <h2 class="no-print">Hours Volunteered by <?php echo $volunteer->get_first_name() . ' ' . $volunteer->get_last_name() ?></h2>
            <?php endif ?>
            <h2 class="print-only">Hours Volunteered by <?php echo $volunteer->get_first_name() . ' ' . $volunteer->get_last_name() ?></h2>
            <?php if (count($events)  > 0): ?>
                <div class="table-wrapper"><table class="general">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Event</th>
                            <th>Location</th>
                            <th class="align-right">Hours</th>
                        </tr>
                    </thead>
                    <tbody class="standout">
                        <?php 
                            require_once('include/output.php');
                            foreach ($events as $event) {
                                $date = strtotime($event['date']);
                                $date = date('m/d/Y', $date);
                                echo '<tr>
                                    <td>' . $date . '</td>
                                    <td>' . $event["name"] . '</td>
                                    <td>' . $event["location"] . '</td>
                                    <td class="align-right">' . floatPrecision($event["duration"], 2) . '</td>
                                </tr>';
                            } 
                            echo "<tr class='total-hours'><td></td><td></td><td class='total-hours'>Total Hours</td><td class='align-right'>" . floatPrecision($totalHours, 2) . "</td></tr>";
                        ?>
                    </tbody></table>
                    <p class="print-only">I hereby certify that this volunteer has contributed the above volunteer hours to the Gwyneth's Gift organization.</p>
                    <table id="signature-table" class="print-only">
                        <tbody>
                            <tr><td>Admin Signature:  ______________________________________ Date: <?php echo date('m/d/Y') ?></td></tr>
                            <tr><td>Print Admin Name: _____________________________________</td></tr>
                        </tbody>
                    </table></div>
                    <button class="no-print" onclick="window.print()" style="margin-bottom: -.5rem">Print</button>
                <?php else: ?>
                    <p>There are no volunteer hours to report.</p>
                <?php endif ?>
                <?php if ($viewingSelf): ?>
                    <a class="button cancel no-print" href="viewProfile.php">Return to Profile</a>
                <?php else: ?>
                    <a class="button cancel no-print" href="viewProfile.php?id=<?php echo htmlspecialchars($_GET['id']) ?>">Return to Profile</a>
                <?php endif ?>
        </main>
    </body>
</html>
