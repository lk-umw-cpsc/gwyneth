<?php
    ini_set("display_errors",1);
    error_reporting(E_ALL);
    include_once('domain/Person.php');
    include_once('database/dbPersons.php');

    $person = Array();
    $person['first_name'] = 'vmsroot';
    $person['last_name'] = '';
    $person['venue'] = 'portland';
    $person['address'] = 'N/A';
    $person['city'] = 'N/A';
    $person['state'] = 'VA';
    $person['zip'] = 'N/A';
    $person['phone1'] = '';
    $person['phone1type'] = 'N/A';
    $person['phone2'] = 'N/A';
    $person['phone2type'] = 'N/A';
    $person['email'] = 'vmsroot';
    $person['shirt_size'] = 'N/A';
    $person['computer'] = 'N/A';
    $person['camera'] = 'N/A';
    $person['transportation'] = 'N/A';
    $person['contact_name'] = 'N/A';
    $person['contact_num'] = 'N/A';
    $person['relation'] = 'N/A';
    $person['contact_time'] = 'N/A';
    $person['type'] = '';
    $person['status'] = 'N/A';
    $person['cMethod'] = 'N/A';
    $person['position'] = 'N/A';
    $person['hours'] = 'N/A';
    $person['commitment'] = 'N/A';
    $person['motivation'] = 'N/A';
    $person['specialties'] = 'N/A';
    $person['convictions'] = 'N/A';
    $person['availability'] = 'N/A';
    $person['schedule'] = 'N/A';
    $person['hours'] = 'N/A';
    $person['birthday'] = 'N/A';
    $person['start_date'] = 'N/A';
    $person['howdidyouhear'] = 'N/A';
    $person['notes'] = 'N/A';
    $person['password'] = password_hash('vmsroot', PASSWORD_BCRYPT);
    $person['profile_pic'] = '';
    $person['gender'] = '';
    $person['force_password_change'] = 1;
    $days = array('sun', 'mon', 'tues', 'wednes', 'thurs', 'fri', 'satur');
    foreach ($days as $day) {
        $person[$day . 'days_start'] = '';
        $person[$day . 'days_end'] = '';
    }
    $PERSON = make_a_person($person);
    $result = add_person($PERSON);
    if ($result) {
        echo 'ROOT USER CREATION SUCCESS';
    } else {
        echo 'USER ALREADY EXISTS';
    }
?>