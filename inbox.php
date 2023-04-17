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
        <title>Gwyneth's Gift VMS | Inbox</title>
    </head>
    <body>
        <?php require_once('header.php') ?>
        <h1>Inbox</h1>
        <main class="general">
            <h2>Your Messages</h2>
            <div class="table-wrapper">
                <table class="general">
                    <thead>
                        <tr>
                            <th style="width:1px">From</th>
                            <th>Title</th>
                            <th style="width:1px">Received</th>
                        </tr>
                    </thead>
                    <tbody class="standout">
                        <?php 
                            require_once('database/dbMessages.php');
                            require_once('database/dbPersons.php');
                            require_once('include/output.php');
                            $id_to_name_hash = [];
                            foreach (get_user_messages($userID) as $message) {
                                $sender = $message['senderID'];
                                if (isset($id_to_name_hash[$sender])) {
                                    $sender = $id_to_name_hash[$sender];
                                } else {
                                    $lookup = get_name_from_id($sender);
                                    $id_to_name_hash[$sender] = $lookup;
                                    $sender = $lookup;
                                }
                                $title = htmlspecialchars($message['title']);
                                $timeUnpacked = $message['time'];
                                $pieces = explode('-', $timeUnpacked);
                                $year = $pieces[0];
                                $month = $pieces[1];
                                $day = $pieces[2];
                                $time = time24hto12h($pieces[3]);
                                echo "
                                <tr>
                                    <td>$sender</td>
                                    <td>$title</td>
                                    <td>$month/$day/$year $time</td>
                                </tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </body>
</html>