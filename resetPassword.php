<?php
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
    } else if ($accessLevel < 2) {
        header('Location: index.php');
        die();
    }
    require_once('include/input-validation.php');
    $args = sanitize($_GET);
    $errors = null;
    if (!wereRequiredFieldsSubmitted($args, ['id'])) {
        $errors = 'No user ID was supplied';
    } else {
        $resetID = strtolower($args['id']);
        require_once('database/dbPersons.php');
        $targetUser = retrieve_person($resetID);
        if (!$targetUser) {
            $errors = 'No user with that ID exists';
        }   
    }
    if ($resetID == 'vmsroot') {
        $errors = 'This form cannot be used to reset the root user password';
    } else if ($resetID == $userID) {
        $errors = 'This form cannot be used to reset your own password';
    } else if ($accessLevel == 2 && $targetUser->get_access_level() > 1) {
        // Admins (AL2) can only reset the passwords of standard user accounts (AL1)
        $errors = "You do not have permission to modify this user's password";
    }
    $passwordReset = false;
    if (!$errors && $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change'])) {
        $password = '';
        // generate random 8-digit, temporary PIN
        for ($i = 0; $i < 8; $i++) {
            $password .= mt_rand(0, 9);
        }
        $hash = password_hash($password, PASSWORD_BCRYPT);
        reset_password($resetID, $hash);
        $passwordReset = true;
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc') ?>
        <title>Gwyneth's Gift VMS | Reset Password</title>
    </head>
    <body>
        <?php require_once('header.php') ?>
        <h1>Reset User Password</h1>
        <main class="general">
            <?php if ($errors): ?>
                <p class="error-toast"><?php echo $errors ?></p>
            <?php elseif ($passwordReset): ?>
                <p class="happy-toast">Password reset successful!</p>
                <p class="centered"><?php echo $targetUser->get_first_name() . ' ' . $targetUser->get_last_name() ?>'s password was reset to:</p>
                <div class="new-password"><?php echo $password ?></div>
            <?php else: ?>
                <h2>Password Reset Form</h2>
                <p>Use the button below to reset <?php echo $targetUser->get_first_name() . ' ' . $targetUser->get_last_name()?>'s password</p>
                <form method="post">
                    <input type="hidden" name="change">
                    <input type="submit" value="Reset Password">
                </form>
            <?php endif ?>
        </main>
    </body>
</html>