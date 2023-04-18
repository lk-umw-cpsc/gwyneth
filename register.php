<?php
    // Author: Lauren Knight
    // Description: Registration page for new volunteers
    session_cache_expire(30);
    session_start();
    
    require_once('include/input-validation.php');

    $loggedIn = false;
    if (isset($_SESSION['change-password'])) {
        header('Location: changePassword.php');
        die();
    }
    if (isset($_SESSION['_id'])) {
        $loggedIn = true;
    }

    // if (isset($_SESSION['_id'])) {
    //     header('Location: index.php');
    // } else {
    //     $_SESSION['logged_in'] = 1;
    //     $_SESSION['access_level'] = 0;
    //     $_SESSION['venue'] = "";
    //     $_SESSION['type'] = "";
    //     $_SESSION['_id'] = "guest";
    //     header('Location: personEdit.php?id=new');
    // }
?>
<!DOCTYPE html>
<html>
<head>
    <?php require_once('universal.inc'); ?>
    <title>Gwyneth's Gift VMS | Register <?php if ($loggedIn) echo ' New Volunteer' ?></title>
</head>
<body>
    <?php
        require_once('header.php');
        require_once('domain/Person.php');
        require_once('database/dbPersons.php');
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // make every submitted field SQL-safe except for password
            $ignoreList = array('password');
            $args = sanitize($_POST, $ignoreList);

            // echo "<p>The form was submitted:</p>";
            // foreach ($args as $key => $value) {
            //     echo "<p>$key: $value</p>";
            // }

            $required = array(
                'first-name', 'last-name', 'birthdate',
                'address', 'city', 'state', 'zip', 
                'email', 'phone', 'phone-type', 'contact-when', 'contact-method',
                'start-date', 'shirt-size', 'password', 'gender'
            );
            $errors = false;
            if (!wereRequiredFieldsSubmitted($args, $required)) {
                $errors = true;
            }
            $first = $args['first-name'];
            $last = $args['last-name'];
            $dateOfBirth = validateDate($args['birthdate']);
            if (!$dateOfBirth) {
                $errors = true;
                echo 'bad dob';
            }

            $address = $args['address'];
            $city = $args['city'];
            $state = $args['state'];
            if (!valueConstrainedTo($state, array('AK', 'AL', 'AR', 'AZ', 'CA', 'CO', 'CT', 'DC', 'DE', 'FL', 'GA',
                    'HI', 'IA', 'ID', 'IL', 'IN', 'KS', 'KY', 'LA', 'MA', 'MD', 'ME',
                    'MI', 'MN', 'MO', 'MS', 'MT', 'NC', 'ND', 'NE', 'NH', 'NJ', 'NM',
                    'NV', 'NY', 'OH', 'OK', 'OR', 'PA', 'RI', 'SC', 'SD', 'TN', 'TX',
                    'UT', 'VA', 'VT', 'WA', 'WI', 'WV', 'WY'))) {
                $errors = true;
            }
            $zipcode = $args['zip'];
            if (!validateZipcode($zipcode)) {
                $errors = true;
                echo 'bad zip';
            }
            $email = strtolower($args['email']);
            $email = validateEmail($email);
            if (!$email) {
                $errors = true;
                echo 'bad email';
            }
            $phone = validateAndFilterPhoneNumber($args['phone']);
            if (!$phone) {
                $errors = true;
                echo 'bad phone';
            }
            $phoneType = $args['phone-type'];
            if (!valueConstrainedTo($phoneType, array('cellphone', 'home', 'work'))) {
                $errors = true;
                echo 'bad phone type';
            }
            $contactWhen = $args['contact-when'];
            $contactMethod = $args['contact-method'];
            if (!valueConstrainedTo($contactMethod, array('phone', 'text', 'email'))) {
                $errors = true;
                echo 'bad contact method';
            }

            $econtactName = $args['econtact-name'];
            $econtactPhone = validateAndFilterPhoneNumber($args['econtact-phone']);
            if (!$econtactPhone) {
                $errors = true;
                echo 'bad e-contact phone';
            }
            $econtactRelation = $args['econtact-relation'];

            $startDate = validateDate($args['start-date']);
            if (!$startDate) {
                $errors = true;
                echo 'bad start date';
            }
            $gender = $args['gender'];
            if (!valueConstrainedTo($gender, ['Male', 'Female', 'Other'])) {
                $errors = true;
                echo 'bad gender';
            }
            $skills = '';
            if (isset($args['skills'])) {
                $skills = $args['skills'];
            }
            $hasComputer = isset($args['has-computer']);
            $hasCamera = isset($args['has-camera']);
            $hasTransportation = isset($args['has-transportation']);
            $shirtSize = $args['shirt-size'];
            if (!valueConstrainedTo($shirtSize, array('S', 'M', 'L', 'XL', 'XXL'))) {
                $errors = true;
                echo 'bad shirt size';
            }

            // May want to enforce password requirements at this step
            $password = password_hash($args['password'], PASSWORD_BCRYPT);

            $days = array('sundays', 'mondays', 'tuesdays', 'wednesdays', 'thursdays', 'fridays', 'saturdays');
            $availability = array();
            $availabilityCount = 0;
            foreach ($days as $day) {
                if (isset($args['available-' . $day])) {
                    $startKey = $day . '-start';
                    $endKey = $day . '-end';
                    if (!isset($args[$startKey]) || !isset($args[$endKey])) {
                        $errors = true;
                    }
                    $start = $args[$startKey];
                    $end = $args[$endKey];
                    // $range24h = validate12hTimeRangeAndConvertTo24h($start, $end);
                    $range24h = null;
                    if (validate24hTimeRange($start, $end)) {
                        $range24h = [$start, $end];
                    }
                    if (!$range24h) {
                        $errors = true;
                        echo "bad $day availability";
                    }
                    $availability[$day] = $range24h;
                    $availabilityCount++;
                } else {
                    $availability[$day] = null;
                }
            }
            if ($availabilityCount == 0) {
                $errors = true;
                echo 'bad availability - none chosen';
            }
            $sundaysStart = '';
            $sundaysEnd = '';
            if ($availability['sundays']) {
                $sundaysStart = $availability['sundays'][0];
                $sundaysEnd = $availability['sundays'][1];
            }
            $mondaysStart = '';
            $mondaysEnd = '';
            if ($availability['mondays']) {
                $mondaysStart = $availability['mondays'][0];
                $mondaysEnd = $availability['mondays'][1];
            }
            $tuesdaysStart = '';
            $tuesdaysEnd = '';
            if ($availability['tuesdays']) {
                $tuesdaysStart = $availability['tuesdays'][0];
                $tuesdaysEnd = $availability['tuesdays'][1];
            }
            $wednesdaysStart = '';
            $wednesdaysEnd = '';
            if ($availability['wednesdays']) {
                $wednesdaysStart = $availability['wednesdays'][0];
                $wednesdaysEnd = $availability['wednesdays'][1];
            }
            $thursdaysStart = '';
            $thursdaysEnd = '';
            if ($availability['thursdays']) {
                $thursdaysStart = $availability['thursdays'][0];
                $thursdaysEnd = $availability['thursdays'][1];
            }
            $fridaysStart = '';
            $fridaysEnd = '';
            if ($availability['fridays']) {
                $fridaysStart = $availability['fridays'][0];
                $fridaysEnd = $availability['fridays'][1];
            }
            $saturdaysStart = '';
            $saturdaysEnd = '';
            if ($availability['saturdays']) {
                $saturdaysStart = $availability['saturdays'][0];
                $saturdaysEnd = $availability['saturdays'][1];
            }

            if ($errors) {
                echo '<p>Your form submission contained unexpected input.</p>';
                die();
            }
            // need to incorporate availability here
            $newperson = new Person($first, $last, 'portland', 
                $address, $city, $state, $zipcode, "",
                $phone, $phoneType, null, null,
                $email, $shirtSize, $hasComputer, $hasCamera, $hasTransportation, $econtactName, $econtactPhone, $econtactRelation, 
                $contactWhen, 'volunteer', 'Active', $contactMethod, null, null,
                null, null, $skills, null, '', '', '', 
                $dateOfBirth, $startDate, null, null, $password,
                $sundaysStart, $sundaysEnd, $mondaysStart, $mondaysEnd,
                $tuesdaysStart, $tuesdaysEnd, $wednesdaysStart, $wednesdaysEnd,
                $thursdaysStart, $thursdaysEnd, $fridaysStart, $fridaysEnd,
                $saturdaysStart, $saturdaysEnd, 0, $gender
            );
            $result = add_person($newperson);
            if (!$result) {
                echo '<p>That e-mail address is already in use.</p>';
            } else {
                if ($loggedIn) {
                    echo '<script>document.location = "index.php?registerSuccess";</script>';
                } else {
                    echo '<script>document.location = "login.php?registerSuccess";</script>';
                }
            }
        } else {
            require_once('registrationForm.php'); 
        }
    ?>
</body>
</html>
