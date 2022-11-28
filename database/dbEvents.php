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
include_once(dirname(__FILE__).'/../domain/Event.php');

/*
 * add a event to dbEvents table: if already there, return false
 */

function add_event($event) {
    if (!$event instanceof Event)
        die("Error: add_event type mismatch");
    $con=connect();
    $query = "SELECT * FROM dbEvents WHERE id = '" . $event->get_id() . "'";
    $result = mysqli_query($con,$query);
    //if there's no entry for this id, add it
    if ($result == null || mysqli_num_rows($result) == 0) {
        mysqli_query($con,'INSERT INTO dbEvents VALUES("' .
                $event->get_id() . '","' .
                $event->get_start_date() . '","' .
                $event->get_venue() . '","' .
                $event->get_first_name() . '","' .
                $event->get_event_name() . '","' .  //changed all instances of last_name to event_name
                $event->get_status() . '","' .
                implode(',', $event->get_availability()) . '","' .
                implode(',', $event->get_schedule()) . '","' .
                implode(',', $event->get_hours()) . '","' .
                $event->get_description() . '","' .
                $event->get_event_id() .            
                '");');							
        mysqli_close($con);
        return true;
    }
    mysqli_close($con);
    return false;
}

/*
 * remove a event from dbEvents table.  If already there, return false
 */

function remove_event($id) {
    $con=connect();
    $query = 'SELECT * FROM dbEvents WHERE id = "' . $id . '"';
    $result = mysqli_query($con,$query);
    if ($result == null || mysqli_num_rows($result) == 0) {
        mysqli_close($con);
        return false;
    }
    $query = 'DELETE FROM dbEvents WHERE id = "' . $id . '"';
    $result = mysqli_query($con,$query);
    mysqli_close($con);
    return true;
}



/*
 * @return a Event from dbEvents table matching a particular id.
 * if not in table, return false
 */

function retrieve_event($id) {
    $con=connect();
    $query = "SELECT * FROM dbEvents WHERE id = '" . $id . "'";
    $result = mysqli_query($con,$query);
    if (mysqli_num_rows($result) !== 1) {
        mysqli_close($con);
        return false;
    }
    $result_row = mysqli_fetch_assoc($result);
    // var_dump($result_row);
    $theEvent = make_a_event($result_row);
//    mysqli_close($con);
    return $theEvent;
}
// Name is first concat with event name. Example 'James Jones'
// return array of Events.
function retrieve_events_by_name ($name) {
	$events = array();
	if (!isset($name) || $name == "" || $name == null) return $events;
	$con=connect();
	$name = explode(" ", $name);
	$first_name = $name[0];
	$event_name = $name[1];
    $query = "SELECT * FROM dbEvents WHERE first_name = '" . $first_name . "' AND event_name = '". $event_name ."'";
    $result = mysqli_query($con,$query);
    while ($result_row = mysqli_fetch_assoc($result)) {
        $the_event = make_a_event($result_row);
        $events[] = $the_event;
    }
    return $events;	
}


function update_hours($id, $new_hours) {
    $con=connect();
    $query = 'UPDATE dbEvents SET hours = "' . $new_hours . '" WHERE id = "' . $id . '"';
    $result = mysqli_query($con,$query);
    mysqli_close($con);
    return $result;
}


function update_start_date($id, $new_start_date) {
	$con=connect();
	$query = 'UPDATE dbEvents SET start_date = "' . $new_start_date . '" WHERE id = "' . $id . '"';
	$result = mysqli_query($con,$query);
	mysqli_close($con);
	return $result;
}

/*
 * @return all rows from dbEvents table ordered by event name
 * if none there, return false
 */

function getall_dbEvents($name_from, $name_to, $venue) {
    $con=connect();
    $query = "SELECT * FROM dbEvents";
    $query.= " WHERE venue = '" .$venue. "'"; 
    $query.= " AND event_name BETWEEN '" .$name_from. "' AND '" .$name_to. "'"; 
    $query.= " ORDER BY event_name,first_name";
    $result = mysqli_query($con,$query);
    if ($result == null || mysqli_num_rows($result) == 0) {
        mysqli_close($con);
        return false;
    }
    $result = mysqli_query($con,$query);
    $theEvents = array();
    while ($result_row = mysqli_fetch_assoc($result)) {
        $theEvent = make_a_event($result_row);
        $theEvents[] = $theEvent;
    }

    return $theEvents;
}

function getall_volunteer_names() {
	$con=connect();
	$query = "SELECT first_name, event_name FROM dbEvents ORDER BY event_name,first_name";
    $result = mysqli_query($con,$query);
    if ($result == null || mysqli_num_rows($result) == 0) {
        mysqli_close($con);
        return false;
    }
    $result = mysqli_query($con,$query);
    $names = array();
    while ($result_row = mysqli_fetch_assoc($result)) {
        $names[] = $result_row['first_name'].' '.$result_row['event_name'];
    }
    mysqli_close($con);
    return $names;   	
}

function make_a_event($result_row) {
	/*
	 ($f, $l, $v, $a, $c, $s, $z, $p1, $p1t, $p2, $p2t, $e, $ts, $comp, $cam, $tran, 
            $cn, $cpn, $ct, $cm, $rel, $ct, $cm, $t, $screening_type, $screening_status, $st, 
            $emp, $pos, $hours, $comm, $mot, $spe, 
    		$convictions, $av, $sch, $hrs, $bd, $sd, $hdyh, $description, $pass)
	 */
    $theEvent = new Event(
                    $result_row['first_name'],
                    $result_row['event_name'],
                    $result_row['venue'],                   
                    $result_row['status'],
                    $result_row['availability'],
                    $result_row['schedule'],
                    $result_row['hours'],
                    $result_row['start_date'],
                    $result_row['description'],
                    $result_row['event_id']);  
    return $theEvent;
}


// retrieve only those events that match the criteria given in the arguments
function getonlythose_dbEvents($status, $name, $day, $shift, $venue) {
   $con=connect();
   $query = "SELECT * FROM dbEvents WHERE status LIKE '%" . $status . "%'" .
   //"SELECT * FROM dbEvents WHERE type LIKE '%" . $type . "%'" .
           //" AND status LIKE '%" . $status . "%'" .
           " AND (first_name LIKE '%" . $name . "%' OR event_name LIKE '%" . $name . "%')" .
           " AND availability LIKE '%" . $day . "%'" . 
           " AND availability LIKE '%" . $shift . "%'" . 
           " AND venue = '" . $venue . "'" . 
           " ORDER BY event_name,first_name";
   $result = mysqli_query($con,$query);
   $theEvents = array();
   while ($result_row = mysqli_fetch_assoc($result)) {
       $theEvent = make_a_event($result_row);
       $theEvents[] = $theEvent;
   }
   mysqli_close($con);
   return $theEvents;
}


//return an array of "event_name;first_name;hours", which is "event_name;first_name;date:start_time-end_time:venue:totalhours"
// and sorted alphabetically
function get_logged_hours($from, $to, $name_from, $name_to, $venue) {
	$con=connect();
   	$query = "SELECT first_name,event_name,hours,venue FROM dbEvents "; 
   	$query.= " WHERE venue = '" .$venue. "'";
   	$query.= " AND event_name BETWEEN '" .$name_from. "' AND '" .$name_to. "'";
   	$query.= " ORDER BY event_name,first_name";
	$result = mysqli_query($con,$query);
	$theEvents = array();
	while ($result_row = mysqli_fetch_assoc($result)) {
		if ($result_row['hours']!="") {
			$shifts = explode(',',$result_row['hours']);
			$goodshifts = array();
			foreach ($shifts as $shift) 
			    if (($from == "" || substr($shift,0,8) >= $from) && ($to =="" || substr($shift,0,8) <= $to))
			    	$goodshifts[] = $shift;
			if (count($goodshifts)>0) {
				$newshifts = implode(",",$goodshifts);
				array_push($theEvents,$result_row['event_name'].";".$result_row['first_name'].";".$newshifts);
			}   // we've just selected those shifts that follow within a date range for the given venue
		}
	}
   	mysqli_close($con);
   	return $theEvents;
}
?>