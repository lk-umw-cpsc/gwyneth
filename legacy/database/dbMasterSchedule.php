<?php
/*
 * Copyright 2015 by Adrienne Beebe, Connor Hargus, Phuong Le, Xun Wang, and Allen Tucker. 
 * This program is part of RMH Homebase, which is free software.  It comes with 
 * absolutely no warranty. You can redistribute and/or modify it under the terms 
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 * 
 */

/**
 * @version February 4, 2015
 * @author Phuong Le and Allen Tucker
 */

include_once(dirname(__FILE__) . '/../domain/MasterScheduleEntry.php');
include_once(dirname(__FILE__) . '/dbinfo.php');

function create_dbMasterSchedule() {
    $con=connect();
    mysqli_query($con,"DROP TABLE IF EXISTS dbMasterSchedule");
    $result = mysqli_query($con,"CREATE TABLE dbMasterSchedule (venue TEXT NOT NULL, day TEXT NOT NULL, week_no TEXT NOT NULL,
							hours TEXT, slots INT, persons TEXT, notes TEXT, id TEXT)");
    // id is a unique string for each entry: id = week_no:day:time:venue and week_no == odd, even, 1st, 2nd, ... 5th
    if (!$result) {
        echo mysqli_error($con) . " - Error creating dbMasterSchedule table.\n";
        return false;
    }
    $venues = array("portland","bangor");
    $days = array("Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun");
    $weeks = array("1st", "2nd", "3rd", "4th", "5th", "odd", "even");
    mysqli_close($con);
    return true;
}

function insert_dbMasterSchedule($entry) {
    if (!$entry instanceof MasterScheduleEntry) {
        return false;
    }
    $con=connect();
    $result = mysqli_query($con,"SELECT * FROM dbMasterSchedule WHERE id = '" . $entry->get_id() . "'");
    if (mysqli_num_rows($result) != 0) {
        delete_dbMasterSchedule($entry->get_id());
        $con=connect();
    }
    $query = "INSERT INTO dbMasterSchedule VALUES ('" .
            $entry->get_venue() . "','" .
            $entry->get_day() . "','" .
            $entry->get_week_no() . "','" .
            $entry->get_hours() . "','" .
            $entry->get_slots() . "','" .
            implode(',', $entry->get_persons()) . "','" .
            $entry->get_notes() . "','" .
            $entry->get_id() .
            "');";
    $result = mysqli_query($con,$query);
    if (!$result) {
        echo mysqli_error($con) . " - Unable to insert in dbMasterSchedule: " . $entry->get_id() . "\n";
        mysqli_close($con);
        return false;
    }
    mysqli_close($con);
    return true;
}

function retrieve_dbMasterSchedule($id) {
	$con=connect();
    $query = "SELECT * FROM dbMasterSchedule WHERE id LIKE '%" . $id . "%'";
    $result = mysqli_query($con,$query);
    if (mysqli_num_rows($result) != 1) {
    	mysqli_close($con);
        return false;
    }
    $result_row = mysqli_fetch_assoc($result);
    $theEntry = new MasterScheduleEntry($result_row['venue'], $result_row['day'], $result_row['week_no'],
                    $result_row['hours'], $result_row['slots'], $result_row['persons'],
                    $result_row['notes']);
    mysqli_close($con);
    return $theEntry;
}

function update_dbMasterSchedule($entry) {
    $con=connect();
    if (!$entry instanceof MasterScheduleEntry) {
        echo("Invalid argument for update_dbMasterSchedule function call");
        return false;
    }
    if (delete_dbMasterSchedule($entry->get_id()))
        return insert_dbMasterSchedule($entry);
    else {
        echo (mysqli_error($con) . " - Unable to update dbMasterSchedule: " . $entry->get_id() . "\n");
        return false;
    }
    mysqli_close($con);
    return true;
}

function delete_dbMasterSchedule($id) {
    // first, unschedule people from the shift
    $msentry = retrieve_dbMasterSchedule($id);
    if ($msentry!=null) {
    	$ids = get_person_ids($msentry->get_venue(),$msentry->get_week_no(),
    							$msentry->get_day(),$msentry->get_hours());
    	foreach ($ids as $person_id) 
    	    if ($person_id)
    			unschedule_person($msentry, $person_id);
    }
    $con=connect();
    $query = "DELETE FROM dbMasterSchedule WHERE id = '" . $id . "'";
    $result = mysqli_query($con,$query);
    if (!$result) {
        echo (mysqli_error($con) . " - Unable to delete from dbMasterSchedule: " . $id . "\n");
        return false;
    }
    mysqli_close($con);
    return true;
}

/*
 * @return all master schedule entries for a particular venue and day
 * Each row in the array is a MasterScheduleEntry
 * If there are no entries, return an empty array
 */

function get_master_shifts($venue, $week_no, $day) {
    $con=connect();
    $query = "SELECT * FROM dbMasterSchedule WHERE week_no = '" . $week_no . "' AND day = '" . $day .
            "' AND venue = '" . $venue . "'";
    $result = mysqli_query($con,$query);
    mysqli_close($con);
    $outcome = array();
    if (mysqli_num_rows($result) == 0)
        return $outcome;
    for ($i = 0; $i < mysqli_num_rows($result); $i++)
    {
    	$result_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    	// problem - something about this call is faulty - it does not seem to be going through
    	// to the constructor. 
        $testVar = new MasterScheduleEntry($result_row['venue'], $result_row['day'], 
            $result_row['week_no'], $result_row['hours'], 
            $result_row['slots'], $result_row['persons'], $result_row['notes']); 
        $outcome[] = $testVar;
    }
    return $outcome;
}

/* schedule a person for a given week_no, day, time, and venue
 * update that persons schedule in the dbPersons table
 *
 */

function schedule_person($msentry, /*$venue, $group, $day, $time,*/ $person_id) {
	$con=connect();
    $query1 = "SELECT * FROM dbMasterSchedule WHERE id = '" .
            $msentry->get_id() . "'";
    $query2 = "SELECT * FROM dbPersons WHERE id = '" . $person_id . "'";
    $result = mysqli_query($con,$query1);
    $resultp = mysqli_query($con,$query2);
    if (!$result || !$resultp)
        die("schedule_person could not query the database");
    // be sure the master shift and person both exist
    if (mysqli_num_rows($result) !== 1 || mysqli_num_rows($resultp) !== 1) {
        mysqli_close($con);
        die("schedule_person couldnt retrieve 1 person and 1 dbScheduleEntry");
    }
    $result_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $resultp_row = mysqli_fetch_array($resultp, MYSQLI_ASSOC);
    $persons = explode(',', $result_row['persons']);    // get an array of scheduled person id's
    $schedule = explode(',', $resultp_row['schedule']); // get an array of person's scheduled times
    $availability = explode(',', $resultp_row['availability']);     // and their availabiltiy
    if (    !in_array($person_id, $persons) &&
            !in_array($msentry->get_id(), $schedule)) {
        $persons[] = $person_id;             // add the person to the array, and
        $schedule[] = $msentry->get_id();    // add the time to the person's schedule
        $result_row['persons'] = implode(',', $persons);     // and update one row in each table
        $resultp_row['schedule'] = implode(',', $schedule);  // in the database
        mysqli_query($con,"UPDATE dbMasterSchedule SET persons = '" . $result_row['persons'] .
                "' WHERE id = '" . $msentry->get_id() . "'");
        mysqli_query($con,"UPDATE dbPersons SET schedule = '" . $resultp_row['schedule'] .
                "' WHERE id = '" . $person_id . "'");
        mysqli_close($con);
        return "";
    }
    mysqli_close($con);
    return "Error: can't schedule a person not available or already scheduled";
}

/* unschedule a volunteer from a week_no, day, time, and venue
 * update that person's schedule in the dbPersons table
 *
 */

function unschedule_person($msentry, $person_id) {
    $con=connect();
    $query = "SELECT * FROM dbMasterSchedule WHERE id = '" .
            $msentry->get_id() . "'";
    $queryp = "SELECT * FROM dbPersons WHERE id = '" . $person_id . "'";
    $result = mysqli_query($con,$query);
    $resultp = mysqli_query($con,$queryp);
    // be sure the person exists and is scheduled
    if (!$result || mysqli_num_rows($result) !== 1) {
        mysqli_close($con);
        die("Error: week_no:day:time:venue not valid person_id=".$person_id);
    } else if (!$resultp || mysqli_num_rows($resultp) !== 1) {
        $result_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $persons = explode(',', $result_row['persons']);    // get an array of scheduled person id's
        if (in_array($person_id, $persons)) {
            $index = array_search($person_id, $persons);
            array_splice($persons, $index, 1);               // remove the person from the array, and
            $result_row['persons'] = implode(',', $persons); // and update one row in the schedule
            mysqli_query($con,"UPDATE dbMasterSchedule SET persons = '" . $result_row['persons'] .
                    "' WHERE id = '" . $msentry->get_id() . "'");
        }
        mysqli_close($con);
        die("Error: person not in database" . $person_id);
    }
    $result_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $resultp_row = mysqli_fetch_array($resultp, MYSQLI_ASSOC);
    $persons = explode(',', $result_row['persons']);    // get an array of scheduled person id's
    $schedule = explode(',', $resultp_row['schedule']); // get an array of person's scheduled times
    if (in_array($person_id, $persons) /* && in_array($venue . $day . $group . "-" . $time, $schedule)*/) {
        $index = array_search($person_id, $persons);
        $indexp = array_search($msentry->get_id(), $schedule);
        array_splice($persons, $index, 1);   // remove the person from the array, and
        if (in_array($msentry->get_id(), $schedule))       	
        	array_splice($schedule, $indexp, 1); // remove the time from the person's schedule
        $result_row['persons'] = implode(',', $persons);     // and update one row in each table
        $resultp_row['schedule'] = implode(',', $schedule);  // in the database
        mysqli_query($con,"UPDATE dbMasterSchedule SET persons = '" . $result_row['persons'] .
                "' WHERE id = '" . $msentry->get_id() . "'");
        mysqli_query($con,"UPDATE dbPersons SET schedule = '" . $resultp_row['schedule'] .
                "' WHERE id = '" . $person_id . "'");
        mysqli_close($con);
        return "";
    }
    mysqli_close($con);
    die("Error: can't unschedule a person not scheduled");
}

/* insert a note in the schedule for a given venue, group, day, and time.
 *
 */

function make_notes($venue, $group, $day, $time, $notes) {
    $con=connect();
    $query = "SELECT * FROM dbMasterSchedule WHERE venue = '" .
            $venue . "' AND week_no = '" .
            $group . "' AND day = '" .
            $day . "' AND time = '" . $time . "'";
    $result = mysqli_query($con,$query);
    if (!$result)
        die("make_notes could not query the database");
    // be sure the person exists and is scheduled
    if (mysqli_num_rows($result) !== 1) {
        mysqli_close($con);
        return "Error: group-day-time not valid:see make_notes";
    }
    $result_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $result_row['notes'] = $notes;
    mysqli_query($con,"UPDATE dbMasterSchedule SET notes = '" . $result_row['notes'] . "' WHERE venue = '" .
            $venue . "' AND week_no = '" .
            $group . "' AND day = '" . $day . "' AND time = '" . $time . "'");
    mysqli_close($con);
    return "";
}

/*
 * @return whether or not a person is scheduled in a given venue, group, day and time
 *
 */

function is_scheduled($venue, $group, $day, $time, $person_id) {
    $con=connect();
    $query = "SELECT * FROM dbMasterSchedule WHERE venue = '" .
            $venue . "' AND week_no = '" .
            $group . "' AND day = '" .
            $day . "' AND time = '" . $time . "'";
    $result = mysqli_query($con,$query);
    if (!$result)
        die("is_scheduled could not query the database");
    if (mysqli_num_rows($result) !== 1) {
        mysqli_close($con);
        return "Error: group-day-time not valid:see is_scheduled";
    }
    $result_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $persons = explode(',', $result_row['persons']);    // get array of scheduled person id's
    mysqli_close($con);
    if (in_array($person_id, $persons))
        return true;
    else
        return false;
}

/*
 * @return all persons scheduled for a particular venue, group, day, and time
 * as an array of associative arrays.  Each associative array has
 * entries indexed by the field names of a person in dbPersons.
 */

function get_persons($id) {
    $con=connect();
    $query1 = "SELECT * FROM dbMasterSchedule WHERE id = '" .
            $id . "'";
    $result = mysqli_query($con,$query1);
    if (!$result)
        die("get_persons could not query the database");
    $out = array();
    if (mysqli_num_rows($result) !== 1) {
        mysqli_close($con);
        return $out;
    }
    $result_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $person_ids = explode(',', $result_row['persons']);    // get an array of scheduled person id's
    foreach ($person_ids as $person_id)
        if ($person_id != "") {
            $query2 = "SELECT * FROM dbPersons WHERE id = '" . $person_id . "'";
            $resultp = mysqli_query($con,$query2);
            if (!$resultp)
                die("get_persons could not query the database");
            if (mysqli_num_rows($resultp) !== 1) {
                mysqli_close($con);
                $out[] = $person_id;
                return $out;
            }
            $out[] = mysqli_fetch_array($resultp, MYSQLI_ASSOC);
        }
    mysqli_close($con);
    return $out;
}

/*
 * @return ids of all persons scheduled for a particular venue, week_no, day, and time
 */

function get_person_ids($venue, $week_no, $day, $time) {
    $con=connect();
    $query1 = "SELECT * FROM dbMasterSchedule WHERE id = '" .
            $week_no . ":" . $day . ":" . $time . ":" . $venue. "'";
    $result = mysqli_query($con,$query1);
    if (!$result)
        die("get_person_ids could not query the database");
    if (mysqli_num_rows($result) !== 1) {
        mysqli_close($con);
        return array();
      //  die("Error: week-day-time-venue not valid:see get_person_ids");
    }
    $result_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $person_ids = explode(',', $result_row['persons']);
    mysqli_close($con);
    return $person_ids;
}

/*
 * @return number of slots for a particular venue, week_no, day, and time
 * this is fixed with a kluge.
 */

function get_total_slots($id) {
    $con=connect();
    $query1 = "SELECT * FROM dbMasterSchedule WHERE id = '" .
            $id . "'";
    $result = mysqli_query($con,$query1);
    if (!$result)
        die("get_total_slots could not query the database");
    if (mysqli_num_rows($result) !== 1) {
        mysqli_close($con);
    //    echo "Error: group-day-time not valid:see get_total_slots".$id;
        return 0;
    }
    $result_row = mysqli_fetch_assoc($result);
    return $result_row['slots'];
}

/*
 * @return number of vacancies for a particular venue, week_no, day, and time
 */

function check_valid_schedule($venue, $week_no, $day, $time) {
    $con=connect();
    $query1 = "SELECT * FROM dbMasterSchedule WHERE id = '" .
            $venue . $day . $week_no . "-" . $time . "'";
    $result = mysqli_query($con,$query1);
    mysqli_close($con);
    if (!$result)
        die("check_valid_schedule could not query the database");
    if (mysqli_num_rows($result) !== 1) {
        return false;
    }
    return true;
}

/*
 * update the number of vacancies for a particular venue, group, day, and time
 */

function edit_schedule_vacancy($msentry, $change) {
    $con=connect();
    $query1 = "SELECT * FROM dbMasterSchedule WHERE id = '" .
            $msentry->get_id() . "'";
    $result = mysqli_query($con,$query1);
    if (!$result)
        die("edit_schedule_vacancy could not query the database");
    if (mysqli_num_rows($result) !== 1) {
    	mysqli_close($con);
        return false;
    }
    $result_row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $result_row['slots'] = $result_row['slots'] + $change;
    // id = venue.day.week_no.start_time."-".end_time
    mysqli_query($con,"UPDATE dbMasterSchedule SET slots = '" . $result_row['slots'] .
            "' WHERE id = '" . $msentry->get_id() . "'");
    mysqli_close($con);
    return true;
}

?>