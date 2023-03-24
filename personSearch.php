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
    // admin-only access
    if ($accessLevel < 2) {
        header('Location: index.php');
        die();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require_once('universal.inc') ?>
        <title>Gwyneth's Gift VMS | User Search</title>
    </head>
    <body>
        <?php require_once('header.php') ?>
        <h1>User Search</h1>
        <form class="general" method="get">
            <h2>Find User</h2>
            <?php 
                if (isset($_GET['name'])) {
                    require_once('include/input-validation.php');
                    require_once('database/dbPersons.php');
                    $args = sanitize($_GET);
                    $required = ['name', 'id', 'phone', 'role'];
                    if (!wereRequiredFieldsSubmitted($args, $required, true)) {
                        echo 'Missing expected form elements';
                    }
                    $name = $args['name'];
                    $id = $args['id'];
                    $phone = preg_replace("/[^0-9]/", "", $args['phone']);
                    $role = $args['role'];
                    if (!valueConstrainedTo($role, ['admin', 'superadmin', 'volunteer', ''])) {
                        echo '<p>The system did not understand your request.';
                    } else {
                        echo "<h3>Seach Results</h3>";
                        $persons = find_users($name, $id, $phone, $role);
                        require_once('include/output.php');
                        if (count($persons) > 0) {
                            echo '
                            <table class="general">
                                <thead>
                                    <tr>
                                        <th>First</th>
                                        <th>Last</th>
                                        <th>E-mail</th>
                                        <th>Phone Number</th>
                                        <th>Role</th>
                                    </tr>
                                </thead>
                                <tbody>';
                            foreach ($persons as $person) {
                                echo '
                                    <tr>
                                        <td>' . $person->get_first_name() . '</td>
                                        <td>' . $person->get_last_name() . '</td>
                                        <td><a href="mailto:' . $person->get_id() . '">' . $person->get_id() . '</a></td>
                                        <td><a href="tel:' . $person->get_phone1() . '">' . formatPhoneNumber($person->get_phone1()) .  '</td>
                                        <td>' . ucfirst($person->get_type()[0]) . '</td>
                                    </tr>';
                            }
                            echo '
                                </tbody>
                            </table>';
                        } else {
                            echo '<p>Your search returned no results.</p>';
                        }
                    }
                    echo '<h3>Search Again</h3>';
                }
            ?>
            <p>Use the form below to find a volunteer or staff member account. At least one search criteria is required.</p>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter the user's first and/or last name">
            <label for="id">E-mail</label>
            <input type="text" id="id" name="id" placeholder="Enter the user's email address (login ID)">
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" placeholder="Enter the user's phone number">
            <label for="role">Role</label>
            <select id="role" name="role">
                <option></option>
                <option value="volunteer">Volunteer</option>
                <option value="admin">Admin</option>
                <option value="superadmin">Super Admin</option>
            </select>
            <input type="submit" value="Search">
        </form>
    </body>
</html>