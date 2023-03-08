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
    <style>
        .modUser{
            margin: 0 auto;
        }
    </style>
    <body>
        <?php require_once('header.php') ?>
        <main>
            <h1>Changing User Access Level</h1>
            <!-- Your code goes here. Be sure to wrap any form elements in a <form> tag -->
            <div class="formWrapper">
            <form class="modUser" style="background-color:#E6E6FA">
            <br>
            <label>
                First Name: <input type="text" placeholder="First Name" name="firstName" required> 
            </label>
            <br>
            <label>
                Last Name: <input type="text" placeholder="Last Name" name="lastName" required>
            </label>
            <br>
            <label>
                Select User:
            <select>
                <option></option>
                <option value="admin">Admin</option>
                <option value="superAdmin">Super Admin</option>
                <option value="volunteer">Volunteer</option>
            </select>
            </label>
            <label>
                Status: 
            <br>
            <input type="radio" name="statsRadio" id = "promo" value="promote">
            <label for="promo">Promote</label><br>
            <input type="radio" name="statsRadio" id = "dem" value="demote">
            <label for="demote">Demote</label><br>
            <input type="radio" name="statsRadio" id = "notActive" value="inactive">
            <label for="notActive">Inactive</label><br>
            </label>
            <br>
            <input type="submit">
            </form>
            </div>
            <p>You are <?php if (!$loggedIn) echo 'not '; ?>logged in.</p>
            <?php
                if ($userID) {
                    echo '<p>Your user ID is ' . $userID . '.</p>';
                }
            ?>
        </main>
    </body>
</html>