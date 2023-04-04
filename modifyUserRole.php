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
    require_once('include/input-validation.php');

    $get = sanitize($_GET);
    $id = $get['id'];
    // Is user authorized to view this page?
    if ($accessLevel < 2) {
        header('Location: index.php');
        die();
    }
    // Was an ID supplied?
    if ($_SERVER["REQUEST_METHOD"] == "GET" && !isset($_GET['id'])) {
        header('Location: index.php');
        die();
    } else if ($_SERVER["REQUEST_METHOD"] == "POST"){
        require_once('database/dbPersons.php');
        $post = sanitize($_POST);
        $new_role = $post['s_role'];
        if (empty($new_role)){
            // echo "No new role selected";
        }else{
            update_type($id, $new_role);
            $typeChange = true;
            // echo "<meta http-equiv='refresh' content='0'>";
        }
        $new_status = $post['statsRadio'];
        if (empty($new_status)){
            // echo "No new status selected";
        }else{
            update_status($id, $new_status);
            $statusChange = true;
            // echo "<meta http-equiv='refresh' content='0'>";
        }
        $new_notes = $post['s_reason'];
        if (empty($new_notes)){
            // echo "No new notes selected";
        }else{
            update_notes($id, $new_notes);
            $notesChange = true;
            // echo "<meta http-equiv='refresh' content='0'>";
        }
        if (isset($notesChange) || isset($statusChange) || isset($typeChange)) {
            header('Location: viewProfile.php?rscSuccess&id=' . $_GET['id']);
            die();
        }
    }

    // Does the person exist?
    require_once('domain/Person.php');
    require_once('database/dbPersons.php');
    $thePerson = retrieve_person($id);
    if (!$thePerson) {
        echo "That user does not exist";
        die();
    }

    // make every submitted field SQL-safe except for password
    $ignoreList = array('password');
    $args = sanitize($_POST);
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
                <?php if (isset($typeChange) || isset($notesChange) || isset($statusChange)): ?>
                    <div class="happy-toast">User's access is updated.</div>
                <?php endif ?>
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
        	<br>
                    <?php
                        // Provides drop down of the role types to select and change the role
			//other than the person's current role type is displayed
            if ($accessLevel == 3)
				$roles = array('volunteer' => 'Volunteer', 'admin' => 'Admin', 'superadmin' => 'SuperAdmin');
			else
				$roles = array('volunteer' => 'Volunteer', 'admin' => 'Admin');
                        echo '<label>Change Role:<select class="form-select-sm" name="s_role">' ;
                        echo '<option value="" SELECTED></option>' ;
                        foreach ($roles as $role => $typename) {
                            if($typename != (implode(" ",$thePerson->get_type()))) {
                                echo '<option value="'. $role .'">'. $typename .'</option>';
                            }
                        }
                        echo '</select>';
                    ?>
                <br>
		<br>
		<label>Status:</label>
                <?php
                    // Check the person's status and check the radio to signal the current status
                    // Display the current and other available statuses as well to change the status
                    
		    $currentStatus = $thePerson->get_status();
                    if ($currentStatus == "Active") {
                        echo '<input type="radio" name="statsRadio" id = "makeActive" value="Active" checked>';
                        echo '<label for="makeActive">  Active&nbsp&nbsp&nbsp</label>';
                        echo '<input type="radio" name="statsRadio" id = "makeInactive" value="Inactive">';
                        echo '<label for="makeInactive">  Inactive</label><br><br>';
                    } elseif ($currentStatus == "Inactive") {
                        echo '<input type="radio" name="statsRadio" id = "makeActive" value="Active">';
                        echo '<label for="makeActive">  Active&nbsp&nbsp&nbsp</label>';
                        echo '<input type="radio" name="statsRadio" id = "makeInactive" value="Inactive" checked>';
                        echo '<label for="makeInactive">  Inactive</label><br><br>';
                    }
		    
		    $reasons = array('Administrative', 'Volunteer Requested Status Change', 'Volunteer with 1 or more No Shows');
                    echo '<label>Reason:<select class="form-select-sm" name="s_reason">';
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