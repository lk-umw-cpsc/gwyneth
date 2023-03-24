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
 * @version March 1, 2012
 * @author Oliver Radwan and Allen Tucker
 */
include_once('dbinfo.php');
include_once(dirname(__FILE__).'/../domain/Person.php');

/*
 * add a person to dbPersons table: if already there, return false
 */

function add_person($person) {
    if (!$person instanceof Person)
        die("Error: add_person type mismatch");
    $con=connect();
    $query = "SELECT * FROM dbPersons WHERE id = '" . $person->get_id() . "'";
    $result = mysqli_query($con,$query);
    //if there's no entry for this id, add it
    if ($result == null || mysqli_num_rows($result) == 0) {
        mysqli_query($con,'INSERT INTO dbPersons VALUES("' .
            $person->get_id() . '","' .
            $person->get_start_date() . '","' .
            $person->get_venue() . '","' .
            $person->get_first_name() . '","' .
            $person->get_last_name() . '","' .
            $person->get_address() . '","' .
            $person->get_city() . '","' .
            $person->get_state() . '","' .
            $person->get_zip() . '","' .
            $person->get_phone1() . '","' .
            $person->get_phone1type() . '","' .
            $person->get_phone2() . '","' .
            $person->get_phone2type() . '","' .
            $person->get_birthday() . '","' .
            $person->get_email() . '","' .
            $person->get_shirt_size() . '","' .
            $person->get_computer() . '","' .
            $person->get_camera() . '","' .
            $person->get_transportation() . '","' .
            $person->get_contact_name() . '","' .
            $person->get_contact_num() . '","' .
            $person->get_relation() . '","' .
            $person->get_contact_time() . '","' .
            $person->get_cMethod() . '","' . 
            $person->get_position() . '","' . 
            $person->get_credithours() . '","' . 
            $person->get_howdidyouhear() . '","' . 
            $person->get_commitment() . '","' . 
            $person->get_motivation() . '","' . 
            $person->get_specialties() . '","' . 
            $person->get_convictions() . '","' . 
            implode(',', $person->get_type()) . '","' .
            $person->get_status() . '","' .
            implode(',', $person->get_availability()) . '","' .
            implode(',', $person->get_schedule()) . '","' .
            implode(',', $person->get_hours()) . '","' .
            $person->get_notes() . '","' .
            $person->get_password() . '","' .
            $person->get_sunday_availability_start() . '","' .
            $person->get_sunday_availability_end() . '","' .
            $person->get_monday_availability_start() . '","' .
            $person->get_monday_availability_end() . '","' .
            $person->get_tuesday_availability_start() . '","' .
            $person->get_tuesday_availability_end() . '","' .
            $person->get_wednesday_availability_start() . '","' .
            $person->get_wednesday_availability_end() . '","' .
            $person->get_thursday_availability_start() . '","' .
            $person->get_thursday_availability_end() . '","' .
            $person->get_friday_availability_start() . '","' .
            $person->get_friday_availability_end() . '","' .
            $person->get_saturday_availability_start() . '","' .
            $person->get_saturday_availability_end() . 
            '");'
        );							
        mysqli_close($con);
        return true;
    }
    mysqli_close($con);
    return false;
}

/*
 * remove a person from dbPersons table.  If already there, return false
 */

function remove_person($id) {
    $con=connect();
    $query = 'SELECT * FROM dbPersons WHERE id = "' . $id . '"';
    $result = mysqli_query($con,$query);
    if ($result == null || mysqli_num_rows($result) == 0) {
        mysqli_close($con);
        return false;
    }
    $query = 'DELETE FROM dbPersons WHERE id = "' . $id . '"';
    $result = mysqli_query($con,$query);
    mysqli_close($con);
    return true;
}

/*
 * @return a Person from dbPersons table matching a particular id.
 * if not in table, return false
 */

function retrieve_person($id) {
    $con=connect();
    $query = "SELECT * FROM dbPersons WHERE id = '" . $id . "'";
    $result = mysqli_query($con,$query);
    if (mysqli_num_rows($result) !== 1) {
        mysqli_close($con);
        return false;
    }
    $result_row = mysqli_fetch_assoc($result);
    // var_dump($result_row);
    $thePerson = make_a_person($result_row);
//    mysqli_close($con);
    return $thePerson;
}
// Name is first concat with last name. Example 'James Jones'
// return array of Persons.
function retrieve_persons_by_name ($name) {
	$persons = array();
	if (!isset($name) || $name == "" || $name == null) return $persons;
	$con=connect();
	$name = explode(" ", $name);
	$first_name = $name[0];
	$last_name = $name[1];
    $query = "SELECT * FROM dbPersons WHERE first_name = '" . $first_name . "' AND last_name = '". $last_name ."'";
    $result = mysqli_query($con,$query);
    while ($result_row = mysqli_fetch_assoc($result)) {
        $the_person = make_a_person($result_row);
        $persons[] = $the_person;
    }
    return $persons;	
}

function change_password($id, $newPass) {
    $con=connect();
    $query = 'UPDATE dbPersons SET password = "' . $newPass . '" WHERE id = "' . $id . '"';
    $result = mysqli_query($con,$query);
    mysqli_close($con);
    return $result;
}

function update_hours($id, $new_hours) {
    $con=connect();
    $query = 'UPDATE dbPersons SET hours = "' . $new_hours . '" WHERE id = "' . $id . '"';
    $result = mysqli_query($con,$query);
    mysqli_close($con);
    return $result;
}

function update_birthday($id, $new_birthday) {
	$con=connect();
	$query = 'UPDATE dbPersons SET birthday = "' . $new_birthday . '" WHERE id = "' . $id . '"';
	$result = mysqli_query($con,$query);
	mysqli_close($con);
	return $result;
}

function update_start_date($id, $new_start_date) {
	$con=connect();
	$query = 'UPDATE dbPersons SET start_date = "' . $new_start_date . '" WHERE id = "' . $id . '"';
	$result = mysqli_query($con,$query);
	mysqli_close($con);
	return $result;
}

function update_type($id, $role) {
	$con=connect();
	$query = 'UPDATE dbPersons SET type = "' . $role . '" WHERE id = "' . $id . '"';
	$result = mysqli_query($con,$query);
	mysqli_close($con);
	return $result;
}

function update_status($id, $new_status){
    $con=connect();
    $query = 'UPDATE dbPersons SET status = "' . $new_status . '" WHERE id = "' . $id . '"';
    $result = mysqli_query($con,$query);
    mysqli_close($con);
    return $result;
}
function update_notes($id, $new_notes){
    $con=connect();
    $query = 'UPDATE dbPersons SET notes = "' . $new_notes . '" WHERE id = "' . $id . '"';
    $result = mysqli_query($con,$query);
    mysqli_close($con);
    return $result;
}

function get_dbtype($id) {
    $con=connect();
    $query = "SELECT type FROM dbPersons";
    $query.= " WHERE id = '" .$id. "'"; 
    $result = mysqli_query($con,$query);
    mysqli_close($con);
    return $result;
}

/*
 * @return all rows from dbPersons table ordered by last name
 * if none there, return false
 */

function getall_dbPersons($name_from, $name_to, $venue) {
    $con=connect();
    $query = "SELECT * FROM dbPersons";
    $query.= " WHERE venue = '" .$venue. "'"; 
    $query.= " AND last_name BETWEEN '" .$name_from. "' AND '" .$name_to. "'"; 
    $query.= " ORDER BY last_name,first_name";
    $result = mysqli_query($con,$query);
    if ($result == null || mysqli_num_rows($result) == 0) {
        mysqli_close($con);
        return false;
    }
    $result = mysqli_query($con,$query);
    $thePersons = array();
    while ($result_row = mysqli_fetch_assoc($result)) {
        $thePerson = make_a_person($result_row);
        $thePersons[] = $thePerson;
    }

    return $thePersons;
}

/*
  @return all rows from dbPersons

*/
function getall_volunteers() {
    $con=connect();
    $query = 'SELECT * FROM dbPersons WHERE id != "vmsroot"';
    $result = mysqli_query($con,$query);
    if ($result == null || mysqli_num_rows($result) == 0) {
        mysqli_close($con);
        return false;
    }
    $result = mysqli_query($con,$query);
    $thePersons = array();
    while ($result_row = mysqli_fetch_assoc($result)) {
        $thePerson = make_a_person($result_row);
        $thePersons[] = $thePerson;
    }

    return $thePersons;
}


function getall_volunteer_names() {
	$con=connect();
	$query = "SELECT first_name, last_name FROM dbPersons ORDER BY last_name,first_name";
    $result = mysqli_query($con,$query);
    if ($result == null || mysqli_num_rows($result) == 0) {
        mysqli_close($con);
        return false;
    }
    $result = mysqli_query($con,$query);
    $names = array();
    while ($result_row = mysqli_fetch_assoc($result)) {
        $names[] = $result_row['first_name'].' '.$result_row['last_name'];
    }
    mysqli_close($con);
    return $names;   	
}

function make_a_person($result_row) {
	/*
	 ($f, $l, $v, $a, $c, $s, $z, $p1, $p1t, $p2, $p2t, $e, $ts, $comp, $cam, $tran, $cn, $cpn, $rel,
			$ct, $t, $st, $cntm, $pos, $credithours, $comm, $mot, $spe,
			$convictions, $av, $sch, $hrs, $bd, $sd, $hdyh, $notes, $pass)
	 */
    $thePerson = new Person(
                    $result_row['first_name'],
                    $result_row['last_name'],
                    $result_row['venue'],
                    $result_row['address'],
                    $result_row['city'],
                    $result_row['state'],
                    $result_row['zip'],
                    $result_row['phone1'],
                    $result_row['phone1type'],
                    $result_row['phone2'],
                    $result_row['phone2type'],
                    $result_row['email'],
                    $result_row['shirt_size'],
                    $result_row['computer'],
                    $result_row['camera'],
                    $result_row['transportation'],
                    $result_row['contact_name'],
                    $result_row['contact_num'],
                    $result_row['relation'],
                    $result_row['contact_time'],
                    $result_row['type'],
                    $result_row['status'],
                    $result_row['cMethod'],  
                    $result_row['position'],
                    $result_row['hours'],
                    $result_row['commitment'],
                    $result_row['motivation'],
                    $result_row['specialties'],
                    $result_row['convictions'],
                    $result_row['availability'],
                    $result_row['schedule'],
                    $result_row['hours'],
                    $result_row['birthday'],
                    $result_row['start_date'],
                    $result_row['howdidyouhear'],
                    $result_row['notes'],
                    $result_row['password'],
                    $result_row['sundays_start'],
                    $result_row['sundays_end'],
                    $result_row['mondays_start'],
                    $result_row['mondays_end'],
                    $result_row['tuesdays_start'],
                    $result_row['tuesdays_end'],
                    $result_row['wednesdays_start'],
                    $result_row['wednesdays_end'],
                    $result_row['thursdays_start'],
                    $result_row['thursdays_end'],
                    $result_row['fridays_start'],
                    $result_row['fridays_end'],
                    $result_row['saturdays_start'],
                    $result_row['saturdays_end'],
                );   
    return $thePerson;
}

function getall_names($status, $type, $venue) {
    $con=connect();
    $result = mysqli_query($con,"SELECT id,first_name,last_name,type FROM dbPersons " .
            "WHERE venue='".$venue."' AND status = '" . $status . "' AND TYPE LIKE '%" . $type . "%' ORDER BY last_name,first_name");
    mysqli_close($con);
    return $result;
}

/*
 * @return all active people of type $t or subs from dbPersons table ordered by last name
 */

function getall_type($t) {
    $con=connect();
    $query = "SELECT * FROM dbPersons WHERE (type LIKE '%" . $t . "%' OR type LIKE '%sub%') AND status = 'active'  ORDER BY last_name,first_name";
    $result = mysqli_query($con,$query);
    if ($result == null || mysqli_num_rows($result) == 0) {
        mysqli_close($con);
        return false;
    }
    mysqli_close;
    return $result;
}

/*
 *   get all active volunteers and subs of $type who are available for the given $frequency,$week,$day,and $shift
 */

function getall_available($type, $day, $shift, $venue) {
    $con=connect();
    $query = "SELECT * FROM dbPersons WHERE (type LIKE '%" . $type . "%' OR type LIKE '%sub%')" .
            " AND availability LIKE '%" . $day .":". $shift .
            "%' AND status = 'active' AND venue = '" . $venue . "' ORDER BY last_name,first_name";
    $result = mysqli_query($con,$query);
    mysqli_close($con);
    return $result;
}

function getvolunteers_byevent($id){
	 $con = connect();
	 $query = 'SELECT * FROM dbEventVolunteers JOIN dbPersons WHERE eventID = "' . $id . '"' .
	 			"AND dbEventVolunteers.userID = dbPersons.id";
	 $result = mysqli_query($con, $query);
	 $thePersons = array();
    while ($result_row = mysqli_fetch_assoc($result)) {
       $thePerson = make_a_person($result_row);
       $thePersons[] = $thePerson;
   }
   mysqli_close($con);
   return $thePersons;
}


// retrieve only those persons that match the criteria given in the arguments
function getonlythose_dbPersons($type, $status, $name, $day, $shift, $venue) {
   $con=connect();
   $query = "SELECT * FROM dbPersons WHERE type LIKE '%" . $type . "%'" .
           " AND status LIKE '%" . $status . "%'" .
           " AND (first_name LIKE '%" . $name . "%' OR last_name LIKE '%" . $name . "%')" .
           " AND availability LIKE '%" . $day . "%'" . 
           " AND availability LIKE '%" . $shift . "%'" . 
           " AND venue = '" . $venue . "'" . 
           " ORDER BY last_name,first_name";
   $result = mysqli_query($con,$query);
   $thePersons = array();
   while ($result_row = mysqli_fetch_assoc($result)) {
       $thePerson = make_a_person($result_row);
       $thePersons[] = $thePerson;
   }
   mysqli_close($con);
   return $thePersons;
}

function phone_edit($phone) {
    if ($phone!="")
		return substr($phone, 0, 3) . "-" . substr($phone, 3, 3) . "-" . substr($phone, 6);
	else return "";
}

function get_people_for_export($attr, $first_name, $last_name, $type, $status, $start_date, $city, $zip, $phone, $email) {
	$first_name = "'".$first_name."'";
	$last_name = "'".$last_name."'";
	$status = "'".$status."'";
	$start_date = "'".$start_date."'";
	$city = "'".$city."'";
	$zip = "'".$zip."'";
	$phone = "'".$phone."'";
	$email = "'".$email."'";
	$select_all_query = "'.'";
	if ($start_date == $select_all_query) $start_date = $start_date." or start_date=''";
	if ($email == $select_all_query) $email = $email." or email=''";
    
	$type_query = "";
    if (!isset($type) || count($type) == 0) $type_query = "'.'";
    else {
    	$type_query = implode("|", $type);
    	$type_query = "'.*($type_query).*'";
    }
    
    error_log("query for start date is ". $start_date);
    error_log("query for type is ". $type_query);
    
   	$con=connect();
    $query = "SELECT ". $attr ." FROM dbPersons WHERE 
    			first_name REGEXP ". $first_name . 
    			" and last_name REGEXP ". $last_name . 
    			" and (type REGEXP ". $type_query .")". 
    			" and status REGEXP ". $status . 
    			" and (start_date REGEXP ". $start_date . ")" .
    			" and city REGEXP ". $city .
    			" and zip REGEXP ". $zip .
    			" and (phone1 REGEXP ". $phone ." or phone2 REGEXP ". $phone . " )" .
    			" and (email REGEXP ". $email .") ORDER BY last_name, first_name";
	error_log("Querying database for exporting");
	error_log("query = " .$query);
    $result = mysqli_query($con,$query);
    return $result;

}

//return an array of "last_name:first_name:birth_date", and sorted by month and day
function get_birthdays($name_from, $name_to, $venue) {
	$con=connect();
   	$query = "SELECT * FROM dbPersons WHERE availability LIKE '%" . $venue . "%'" . 
   	$query.= " AND last_name BETWEEN '" .$name_from. "' AND '" .$name_to. "'";
    $query.= " ORDER BY birthday";
	$result = mysqli_query($con,$query);
	$thePersons = array();
	while ($result_row = mysqli_fetch_assoc($result)) {
    	$thePerson = make_a_person($result_row);
        $thePersons[] = $thePerson;
	}
   	mysqli_close($con);
   	return $thePersons;
}

//return an array of "last_name;first_name;hours", which is "last_name;first_name;date:start_time-end_time:venue:totalhours"
// and sorted alphabetically
function get_logged_hours($from, $to, $name_from, $name_to, $venue) {
	$con=connect();
   	$query = "SELECT first_name,last_name,hours,venue FROM dbPersons "; 
   	$query.= " WHERE venue = '" .$venue. "'";
   	$query.= " AND last_name BETWEEN '" .$name_from. "' AND '" .$name_to. "'";
   	$query.= " ORDER BY last_name,first_name";
	$result = mysqli_query($con,$query);
	$thePersons = array();
	while ($result_row = mysqli_fetch_assoc($result)) {
		if ($result_row['hours']!="") {
			$shifts = explode(',',$result_row['hours']);
			$goodshifts = array();
			foreach ($shifts as $shift) 
			    if (($from == "" || substr($shift,0,8) >= $from) && ($to =="" || substr($shift,0,8) <= $to))
			    	$goodshifts[] = $shift;
			if (count($goodshifts)>0) {
				$newshifts = implode(",",$goodshifts);
				array_push($thePersons,$result_row['last_name'].";".$result_row['first_name'].";".$newshifts);
			}   // we've just selected those shifts that follow within a date range for the given venue
		}
	}
   	mysqli_close($con);
   	return $thePersons;
}

    function update_person_profile(
        $id,
        $first, $last, $dateOfBirth, $address, $city, $state, $zipcode,
        $email, $phone, $phoneType, $contactWhen, $contactMethod, 
        $econtactName, $econtactPhone, $econtactRelation,
        $skills, $hasComputer, $hasCamera, $hasTransportation, $shirtSize,
        $sundaysStart, $sundaysEnd, $mondaysStart, $mondaysEnd,
        $tuesdaysStart, $tuesdaysEnd, $wednesdaysStart, $wednesdaysEnd,
        $thursdaysStart, $thursdaysEnd, $fridaysStart, $fridaysEnd,
        $saturdaysStart, $saturdaysEnd
    ) {
        $query = "update dbPersons set 
            first_name='$first', last_name='$last', birthday='$dateOfBirth', address='$address', city='$city', zip='$zipcode',
            email='$email', phone1='$phone', phone1type='$phoneType', contact_time='$contactWhen', cMethod='$contactMethod',
            contact_name='$econtactName', contact_num='$econtactPhone', relation='$econtactRelation',
            specialties='$skills', computer='$hasComputer', camera='$hasCamera', transportation='$hasTransportation', shirt_size='$shirtSize',
            sundays_start='$sundaysStart', sundays_end='$sundaysEnd', mondays_start='$mondaysStart', mondays_end='$mondaysEnd',
            tuesdays_start='$tuesdaysStart', tuesdays_end='$tuesdaysEnd', wednesdays_start='$wednesdaysStart', wednesdays_end='$wednesdaysEnd',
            thursdays_start='$thursdaysStart', thursdays_end='$thursdaysEnd', fridays_start='$fridaysStart', fridays_end='$fridaysEnd',
            saturdays_start='$saturdaysStart', saturdays_end='$saturdaysEnd'
            where id='$id'";
        $connection = connect();
        $result = mysqli_query($connection, $query);
        mysqli_commit($connection);
        mysqli_close($connection);
        return $result;
    }

    /**
     * Searches the database and returns an array of all volunteers
     * that are eligible to attend the given event that have not yet
     * signed up/been assigned to the event.
     * 
     * Eligibility criteria: availability falls within event start/end time
     * and start date falls before or on the volunteer's start date.
     */
    function get_unassigned_available_volunteers($eventID) {
        $connection = connect();
        $query = "select * from dbEvents where id='$eventID'";
        $result = mysqli_query($connection, $query);
        if (!$result) {
            mysqli_close($connection);
            return null;
        }
        $event = mysqli_fetch_assoc($result);
        $event_start = $event['startTime'];
        $event_end = $event['startTime'];
        $date = $event['date'];
        $dateInt = strtotime($date);
        $dayofweek = strtolower(date('l', $dateInt));
        $dayname_start = $dayofweek . 's_start';
        $dayname_end = $dayofweek . 's_end';
        $query = "select * from dbPersons
            where 
            $dayname_start<='$event_start' and $dayname_end>='$event_end'
            and start_date<='$date'
            and id != 'vmsroot' 
            and status='Active'
            and id not in (select userID from dbEventVolunteers where eventID='$eventID')";
        $result = mysqli_query($connection, $query);
        if ($result == null || mysqli_num_rows($result) == 0) {
            mysqli_close($connection);
            return null;
        }
        $thePersons = array();
        while ($result_row = mysqli_fetch_assoc($result)) {
            $thePerson = make_a_person($result_row);
            $thePersons[] = $thePerson;
        }
        mysqli_close($connection);
        return $thePersons;
    }

    function find_users($name, $id, $phone, $type) {
        $where = 'where ';
        if (!($name || $id || $phone || $type)) {
            return [];
        }
        $first = true;
        if ($name) {
            if (strpos($name, ' ')) {
                $name = explode(' ', $name, 2);
                $first = $name[0];
                $last = $name[1];
                $where .= "first_name like '%$first%' and last_name like '%$last%'";
            } else {
                $where .= "(first_name like '%$name%' or last_name like '%$name%')";
            }
            $first = false;
        }
        if ($id) {
            if (!$first) {
                $where .= ' and ';
            }
            $where .= "id like '%$id%'";
            $first = false;
        }
        if ($phone) {
            if (!$first) {
                $where .= ' and ';
            }
            $where .= "phone1 like '%$phone%'";
            $first = false;
        }
        if ($type) {
            if (!$first) {
                $where .= ' and ';
            }
            $where .= "type='$type'";
            $first = false;
        }
        $query = "select * from dbPersons $where";
        // echo $query;
        $connection = connect();
        $result = mysqli_query($connection, $query);
        if (!$result) {
            mysqli_close($connection);
            return [];
        }
        $raw = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $persons = [];
        foreach ($raw as $row) {
            if ($row['id'] == 'vmsroot') {
                continue;
            }
            $persons []= make_a_person($row);
        }
        mysqli_close($connection);
        return $persons;
    }
?>
