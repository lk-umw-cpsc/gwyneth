<?php
    // Template for new VMS pages. Base your new page on this one

    // Make session information accessible, allowing us to associate
    // data with the logged-in user.
    session_cache_expire(30);
    session_start();
    
    ini_set("display_errors",1);
    error_reporting(E_ALL);

    // redirect to index if already logged in
    if (isset($_SESSION['_id'])) {
        header('Location: index.php');
        die();
    }
    $badLogin = false;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once('include/input-validation.php');
        $ignoreList = array('password');
        $args = sanitize($_POST, $ignoreList);
        $required = array('username', 'password');
        if (wereRequiredFieldsSubmitted($args, $required)) {
            require_once('domain/Person.php');
            require_once('database/dbPersons.php');
            $username = strtolower($args['username']);
            $password = $args['password'];
            $user = retrieve_person($username);
            if (!$user) {
                $badLogin = true;
            } else if (password_verify($password, $user->get_password())) {
                $changePassword = false;
                if ($user->is_password_change_required()) {
                    $changePassword = true;
                    $_SESSION['logged_in'] = false;
                } else {
                    $_SESSION['logged_in'] = true;
                }
                $types = $user->get_type();
                if (in_array('superadmin', $types)) {
                    $_SESSION['access_level'] = 3;
                } else if (in_array('admin', $types)) {
                    $_SESSION['access_level'] = 2;
                } else {
                    $_SESSION['access_level'] = 1;
                }
                $_SESSION['f_name'] = $user->get_first_name();
                $_SESSION['l_name'] = $user->get_last_name();
                $_SESSION['venue'] = $user->get_venue();
                $_SESSION['type'] = $user->get_type();
                $_SESSION['_id'] = $user->get_id();
                // hard code root privileges
                if ($user->get_id() == 'vmsroot') {
                    $_SESSION['access_level'] = 3;
                }
                if ($changePassword) {
                    $_SESSION['access_level'] = 0;
                    $_SESSION['change-password'] = true;
                    header('Location: changePassword.php');
                    die();
                } else {
                    header('Location: index.php');
                    die();
                }
                die();
            } else {
                $badLogin = true;
            }
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc') ?>
        <title>Gwyneth's Gift VMS | Log In</title>
    </head>
    <body>
        <?php require_once('header.php') ?>
        <main class="login">
            <h1>Volunteer Management System</h1>
            <?php if (isset($_GET['registerSuccess'])): ?>
                <div class="happy-toast">
                    Your registration was successful! Please log in below.
                </div>
            <?php else: ?>
            <p>Welcome! Please log in below.</p>
            <?php endif ?>
            <form method="post">
                <?php
                    if ($badLogin) {
                        echo '<span class="error">No login with that e-mail and password combination exists.</span>';
                    }
                ?>
                <label for="username">Username</label>
        		<input type="text" name="username" placeholder="Enter your e-mail address" required>
        		<label for="password">Password</label>
                <input type="password" name="password" placeholder="Enter your password" required>
                <input type="submit" name="login" value="Log in">
                <p>Or <a href="register.php">register as a new volunteer</a>!</p>
            </form>
        </main>
    </body>
</html>
