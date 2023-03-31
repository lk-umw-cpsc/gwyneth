<?php
    // Make session information accessible, allowing us to associate
    // data with the logged-in user.
    session_cache_expire(30);
    session_start();

    $loggedIn = false;
    $accessLevel = 0;
    $userID = null;
    $isAdmin = false;
    if (isset($_SESSION['_id'])) {
        $loggedIn = true;
        // 0 = not logged in, 1 = standard user, 2 = manager (Admin), 3 super admin (TBI)
        $accessLevel = $_SESSION['access_level'];
        $isAdmin = $accessLevel >= 2;
        $userID = $_SESSION['_id'];
    } else {
        header('Location: login.php');
        die();
    }
    if ($isAdmin && isset($_GET['id'])) {
        require_once('include/input-validation.php');
        $args = sanitize($_GET);
        $id = $args['id'];
    } else {
        $id = $userID;
    }
    require_once('database/dbPersons.php');
    $user = retrieve_person($id);
    if (!$user) {
        echo 'User does not exist';
        die();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc') ?>
        <title>Gwyneth's Gift VMS | View User</title>
    </head>
    <body>
        <?php 
            require_once('header.php'); 
            require_once('include/output.php');
        ?>
        <h1>View User</h1>
        <main class="general">
            <?php if (isset($_GET['editSuccess'])): ?>
                <div class="happy-toast">Profile updated successfully!</div>
            <?php endif ?>
            <?php if (isset($_GET['rscSuccess'])): ?>
                <div class="happy-toast">User's role and/or status updated successfully!</div>
            <?php endif ?>
            <h2>Viewing <?php echo $user->get_first_name() . ' ' . $user->get_last_name() ?></h2>
            <fieldset>
                <legend>General</legend>
                <label>Username</label>
                <p><?php echo $user->get_id() ?></p>
                <label>Date of Birth</label>
                <p><?php echo date('d/m/Y', strtotime($user->get_birthday())) ?></p>
                <label>Address</label>
                <p><?php echo $user->get_address() . ', ' . $user->get_city() . ', ' . $user->get_state() . ' ' . $user->get_zip() ?></p>
                <label>Role</label>
                <p><?php echo ucfirst($user->get_type()[0]) ?></p>
                <label>Status</label>
                <p><?php echo ucfirst($user->get_status()) ?></p>
                <?php if ($id != $userID): ?>
                    <a href="modifyUserRole.php?id=<?php echo $id ?>" class="button">Change Role/Status</a>
                <?php endif ?>
            </fieldset>
            <fieldset>
                <legend>Contact Information</legend>
                <label>E-mail</label>
                <p><a href="mailto:<?php echo $user->get_email() ?>"><?php echo $user->get_email() ?></a></p>
                <label>Phone Number</label>
                <p><a href="tel:<?php echo $user->get_phone1() ?>"><?php echo formatPhoneNumber($user->get_phone1()) ?></a> (<?php echo ucfirst($user->get_phone1type()) ?>)</p>
                <label>Preferred Contact Method</label>
                <p><?php echo ucfirst($user->get_cMethod()) ?></p>
                <label>Best Time to Contact</label>
                <p><?php echo ucfirst($user->get_contact_time()) ?></p>
            </fieldset>
            <fieldset>
                <legend>Emergency Contact</legend>
                <label>Name</label>
                <p><?php echo $user->get_contact_name() ?></p>
                <label>Relation</label>
                <p><?php echo $user->get_relation() ?></p>
                <label>Phone Number</label>
                <p><?php echo formatPhoneNumber($user->get_contact_num()) ?></p>
            </fieldset>
            <fieldset>
                <legend>Volunteer Information</legend>
                <label>Availability</label>
                <?php if ($user->get_sunday_availability_start()): ?>
                    <label>Sundays</label>
                    <p><?php echo time24hTo12h($user->get_sunday_availability_start()) . ' - ' . time24hTo12h($user->get_sunday_availability_end()) ?></p>
                <?php endif ?>
                <?php if ($user->get_monday_availability_start()): ?>
                    <label>Mondays</label>
                    <p><?php echo time24hTo12h($user->get_monday_availability_start()) . ' - ' . time24hTo12h($user->get_monday_availability_end()) ?></p>
                <?php endif ?>
                <?php if ($user->get_tuesday_availability_start()): ?>
                    <label>Tuedays</label>
                    <p><?php echo time24hTo12h($user->get_tuesday_availability_start()) . ' - ' . time24hTo12h($user->get_tuesday_availability_end()) ?></p>
                <?php endif ?>
                <?php if ($user->get_wednesday_availability_start()): ?>
                    <label>Wednesdays</label>
                    <p><?php echo time24hTo12h($user->get_wednesday_availability_start()) . ' - ' . time24hTo12h($user->get_wednesday_availability_end()) ?></p>
                <?php endif ?>
                <?php if ($user->get_thursday_availability_start()): ?>
                    <label>Thursdays</label>
                    <p><?php echo time24hTo12h($user->get_thursday_availability_start()) . ' - ' . time24hTo12h($user->get_thursday_availability_end()) ?></p>
                <?php endif ?>
                <?php if ($user->get_friday_availability_start()): ?>
                    <label>Fridays</label>
                    <p><?php echo time24hTo12h($user->get_friday_availability_start()) . ' - ' . time24hTo12h($user->get_friday_availability_end()) ?></p>
                <?php endif ?>
                <?php if ($user->get_saturday_availability_start()): ?>
                    <label>Saturdays</label>
                    <p><?php echo time24hTo12h($user->get_saturday_availability_start()) . ' - ' . time24hTo12h($user->get_saturday_availability_end()) ?></p>
                <?php endif ?>
                <label>Skills</label>
                <p><?php echo str_replace("\r\n", '<br>', $user->get_specialties()) ?></p>
                <label>Additional Information</label>
                <p><?php if ($user->get_computer()) echo 'Owns a computer'; else echo 'Does NOT own a computer'; ?></p>
                <p><?php if ($user->get_camera()) echo 'Owns a camera'; else echo 'Does NOT own a camera'; ?></p>
                <p><?php if ($user->get_transportation()) echo 'Has access to transportation'; else echo 'Does NOT have access to transportation'; ?></p>
                <label>T-Shirt Size</label>
                <p><?php echo $user->get_shirt_size() ?></p>
            </fieldset>
            <a class="button" href="editProfile.php<?php if ($id != $userID) echo '?id=' . $id ?>">Edit Profile</a>
            <a class="button" href="#">Reset Password (not implemented)</a>
        </main>
    </body>
</html>