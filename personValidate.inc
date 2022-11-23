<?php
/*
 * Copyright 2013 by Jerrick Hoang, Ivy Xing, Sam Roberts, James Cook, 
 * Johnny Coster, Judy Yang, Jackson Moniaga, Oliver Radwan, 
 * Maxwell Palmer, Nolan McNair, Taylor Talmage, and Allen Tucker. 
 * This program is part of RMH Homebase, which is free software.  It comes with 
 * absolutely no warranty. You can redistribute and/or modify it under the terms 
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 * 
 */


/**
 * validate_form validates the form data, checking all legality.
 * it returns an array of the errors with the form (string warnings)
 * this array is null (aka false) if there are no errors
 */
function validate_form($person) {
    if ($_POST['status']=='applicant' && ($_POST['start_date'] == "" || strlen($_POST['start_date']) != 8)) 
        $errors[] = 'Please select a valid start date';
    //if ($_POST['location'] == null)
      //  $errors[] = 'Please select a location (Portland or Bangor)';
    if ($person->get_first_name()=="new" && ($_POST['first_name'] == NULL || $_POST['first_name'] == 'new'))
        $errors[] = 'Please enter a first name';
    if ($_POST['last_name'] == null)
        $errors[] = 'Please enter a last name';
    if ($_POST['city'] == null)
        $errors[] = 'Please enter a city';
    if ($_POST['address'] == null)
        $errors[] = 'Please enter an address';
    if (($_POST['zip'] != strval(intval($_POST['zip']))) || ($_POST['zip'] == null) || (strlen($_POST['zip']) != 5))
        $errors[] = 'Please enter a valid zip code (5 digits: #####)';
    if ($_SESSION['access_level'] == 0 && ($_POST['status'] == null))
        $_POST['status'] = 'applicant';
    if ($_POST['type'] == null && $_SESSION['access_level'] >= 1)
        $errors[] = 'Please select a Position type';
    if ($_POST['type'] != null && $_SESSION['access_level'] <= 1 && in_array('manager', $_POST['type']))
        $errors[] = "Sorry, you can't promote yourself to manager.";
    if (in_array('volunteer',$_POST['type']) || in_array('weekendmgr',$_POST['type']))
        if ($_POST['availability'] == null)
        	$errors[] = 'Please enter Availability for at least one day and time.';
    if ($person->get_phone1()==null && !valid_phone($_POST['phone1']))
        $errors[] = 'Enter a valid primary phone number (10 digits: ### ### ####)';
    //if ($_POST['phone2'] != "" && !valid_phone($_POST['phone2']))
       // $errors[] = 'Enter a valid alternate phone number (10 digits: ### ### ####)';
    if (!valid_email($_POST['email']) && $_POST['email'] != null || $_POST['email'] == null )
        $errors[] = "Please enter a valid email";
    //if ($_POST['birthday'] !== "" && strlen($_POST['birthday']) != 8) 
      //  $errors[] = 'Please select a valid birthday';
    if ($_POST['computer'] == null)
        $errors[] = 'Please select whether or not you have a computer';
    if ($_POST['camera'] == null)
        $errors[] = 'Please select whether or not you have a camera';
    if ($_POST['transportation'] == null)
        $errors[] = 'Please select whether or not you have reliable transportation';
    if ($_POST['contact_name'] == null)
        $errors[] = 'Please enter an emergency contact name';
    if ($person->get_contact_num()==null && !valid_phone($_POST['contact_num']))
        $errors[] = 'Enter a valid emergency contact number (10 digits: ### ### ####)';
    return $errors;
}

/**
 * valid_phone validates a phone on the following parameters:
 * 		it assumes the characters '-' ' ' '+' '(' and ')' are valid, but ignores them
 * 		every other digit must be a number
 * 		it should be between 7 and 11 digits
 * returns boolean if phone is valid
 */
function valid_phone(&$phone) {
    if ($phone == null)
        return false;
    $phone = str_replace(' ', '', str_replace('+', '', str_replace('(', '', str_replace('(', '', str_replace('-', '', $phone)))));
    $test = str_replace('0', '', str_replace('1', '', str_replace('2', '', str_replace('3', '', str_replace('4', '', str_replace('5', '', str_replace('6', '', str_replace('7', '', str_replace('8', '', str_replace('9', '', $phone))))))))));
    if ($test != null)
        return false;
    if ((strlen($phone)) != 10)
        return false;
    return true;
}

//Function from <http://www.phpit.net/code/valid-email/>
function valid_email($email) {
    // First, we check that there's one @ symbol, and that the lengths are right
    if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
        // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
        return false;
    }
    // Split it into sections to make life easier
    $email_array = explode("@", $email);
    $local_array = explode(".", $email_array[0]);
    for ($i = 0; $i < sizeof($local_array); $i++) {
        if (!preg_match("/^(([A-Za-z0-9!#$%&#038;'*+=?^_`{|}~-][A-Za-z0-9!#$%&#038;'*+=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i])) {
            return false;
        }
    }
    if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
        $domain_array = explode(".", $email_array[1]);
        if (sizeof($domain_array) < 2) {
            return false; // Not enough parts to domain
        }
        for ($i = 0; $i < sizeof($domain_array); $i++) {
            if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i])) {
                return false;
            }
        }
    }
    return true;
}

function show_errors($e) {
    //this function should display all of our errors.
    echo('<div class="warning">');
    echo('<ul>');
    foreach ($e as $error) {
        echo("<li><strong><font color=\"red\">" . $error . "</font></strong></li>\n");
    }
    echo("</ul></div></p>");
}

?>