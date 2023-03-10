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
            <?php 
                if ($_SERVER["REQUEST_METHOD"] == "GET") {
                    require_once('domain/Person.php');
                    require_once('database/dbPersons.php');
                    $id = $_GET['id'];
                    $thePerson = retrieve_person($id);   
                }
            ?>
            <form class="modUser" style="background-color:#E6E6FA">
            <br>
            <label>
                First Name: <?php echo $thePerson->get_first_name(); ?> 
            </label>
            <br>
            <label>
                Last Name:  <?php echo $thePerson->get_last_name(); ?> 
            </label>
            <br>
            <label>
                Select User: <?php echo implode(" ",$thePerson->get_type()); ?>
            <!-- <select>  This drop down is redundent
                <option></option>
                <option value="admin">Admin</option>
                <option value="superAdmin">Super Admin</option>
                <option value="volunteer">Volunteer</option>
            </select>
            -->
            </label>
            <br>
            <label>
                Status: 
            <br>
            <?php 
            // here I used a simple if else to check if the 'type' is volunteer then only show 'inactive' radio botton
            // if it admin or super admin it will show the other radio bottons
                if(implode(" ",$thePerson->get_type()) == "volunteer"){
                    echo "<input type='radio' name='statsRadio' id = 'notActive' value='inactive'>";
                    echo '<label for="notActive">Inactive</label><br>';

                }else{
                    echo '<input type="radio" name="statsRadio" id = "promo" value="promote">';
                    echo '<label for="promo">Promote</label><br>';
                    echo '<input type="radio" name="statsRadio" id = "promo" value="promote">';
                    echo '<label for="demote">Demote</label><br>';
                }
            ?>
            </label>
            <br>
            <input type="submit">
            </form>
            <p>You are <?php if (!$loggedIn) echo 'not '; ?>logged in.</p>
            <?php
                if ($userID) {
                    echo '<p>Your user ID is ' . $userID . '.</p>';
                }
            ?>
        </main>
    </body>
</html>