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
    // Is user authorized to view this page?
    if ($accessLevel < 2) {
        header('Location: index.php');
        die();
    }
    // Was an ID supplied?
    if ($_SERVER["REQUEST_METHOD"] != "GET" || !isset($_GET['id'])) {
        header('Location: index.php');
        die();
    }
    // Does the person exist?
    require_once('domain/Person.php');
    require_once('database/dbPersons.php');
    $id = $_GET['id'];
    $thePerson = retrieve_person($id);
    if (!$thePerson) {
        echo "That user does not exist";
        die();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc') ?>
        <title>Gwyneth's Gift VMS | Template Page</title>
        <style>
            .modUser{
                display: flex;
                flex-direction: column;
                gap: .5rem;
                padding: 0 0 4rem 0;
            }
            @media only screen and (min-width: 1024px) {
                .modUser {
                    width: 80%;
                }
                main.user-role {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                }
            }
        </style>
    </head>
    <body>
        <?php require_once('header.php') ?>
        <h1>Modify User Access</h1>
        <main class="user-role">
            <form class="modUser" method="post">
                <div>
                    <label>Name:</label>
                    <span>
                        <?php echo $thePerson->get_first_name() . " " . $thePerson->get_last_name(); ?> 
                    </span>
                </div>
                <div>
                    <label>Role:</label>
                    <span>
                        <?php echo implode(" ",$thePerson->get_type()); ?>
                    </span>
                    </div>
        
                    <?php
                        // Provides drop down of the role types to select, other than the current person's role type, to change the role
                        $roles = array('volunteer' => 'Volunteer', 'SuperAdmin' => 'SuperAdmin', 'Admin' => 'Admin');
                        echo '<label>Change Role:<select class="form-select-sm" name="s_type">' ;
                        echo '<option value="" SELECTED></option>' ;
                        foreach ($roles as $role => $typename) {
                            if($role != (implode(" ",$thePerson->get_type()))) {
                                echo '<option value="'.$role.'">'.$typename.'</option>';
                            }
                        }
                        echo '</select>';
                    ?>
                <div>
                <label>Status:</label>
                <?php
                    // Check the person's status and check the radio to signal the current status
                    // Display the current and other available statuses as well to change the status
                    $currentStatus = $thePerson->get_status();
                    if ($currentStatus == "Active") {
                        echo '<input type="radio" name="statsRadio" id = "makeActive" value="Active" checked>';
                        echo '<label for="makeActive">  Active&nbsp&nbsp&nbsp</label>';
                        echo '<input type="radio" name="statsRadio" id = "makeNotActive" value="Inactive">';
                        echo '<label for="makeNotActive">  Inactive</label><br><br>';
                    } elseif ($currentStatus = "Inactive") {
                        echo '<input type="radio" name="statsRadio" id = "makeActive" value="Active">';
                        echo '<label for="makeActive">  Active&nbsp&nbsp&nbsp</label>';
                        echo '<input type="radio" name="statsRadio" id = "makeNotActive" value="Inactive" checked>';
                        echo '<label for="makeNotActive">  Inactive</label><br><br>';
                    }
                    $reasons = array('Administrative', 'Volunteer Requested Status Change', 'Volunteer with 1 or more No Shows');
                    echo '<p>Reason:<select class="form-select-sm" name="s_type">';
                    echo '<option value="" SELECTED></option>';
                    foreach ($reasons as $reason)
                        echo '<option value='.$reason.'>'.$reason.'</option>';
                    echo '</select>';
                ?>
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="submit" name="user_access_modified" value="Update Access">
            </form>
        </main>
    </body>
</html>
