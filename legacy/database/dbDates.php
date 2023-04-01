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
 * Functions to create, update, and retrieve information from the
 * dbDates table in the database.  This table is used with the RMHDate
 * class.  Dates are generated using the master schedule (through the
 * addWeek.php form), and retrieved by the calendar forms.
 * @version February 10, 2015
 * @author Phuong Le andMaxwell Palmer
 */
include_once(dirname(__FILE__).'/../domain/RMHdate.php');
include_once(dirname(__FILE__).'/dbShifts.php');
include_once(dirname(__FILE__).'/../domain/Shift.php');
include_once(dirname(__FILE__).'/dbinfo.php');

/**
 * reformats dbDates table from 2013 format to 2015 format 
 * Elements of dbDates:
 *  id: yy-mm-dd:venue
 *  shifts - * delimited list of shift ids
 *  manager notes
 */
function massage_dbDates() {
    $con=connect();
    $query="select * from dbDates";
    $result = mysqli_query($con,$query,mysqli_ASSOC);
    foreach ($result as $r) {
    	
    	$r['id']=substr($r['id'],6,2).'-'.substr($r['id'],0,5).':portland';
    	$ss = explode('*',$r['shifts']);
    	$ssnew = array();
    	foreach ($ss as $s) {
    		$s = substr($s,6,2).'-'.substr($s,0,5).":".substr($s,9).':portland';
    		$ssnew[] = $s;
    	}
    	$r['shifts']=implode('*',$ss);
    	insert_dbDates($r);
    }
    mysqli_close($con);
}

/**
 * Adds a RMHDate to the table
 * If the date already exists, the date is deleted and replaced.
 */
function insert_dbDates($d) {
	if (!$d instanceof RMHdate) {
        die("Invalid argument for dbDates->insert_dbdates function call");
    }
    $con=connect();
    $query = "SELECT * FROM dbDates WHERE id =\"" . $d->get_id() . "\"";
    $result = mysqli_query($con,$query);
    if (mysqli_num_rows($result) != 0) {
        delete_dbDates($d);
        $con=connect();
    }
    $query = "INSERT INTO dbDates VALUES
				(\"" . $d->get_id() . "\",\"" .
            get_shifts_text($d) . "\",\"" . $d->get_mgr_notes() . "\")";
    $result = mysqli_query($con,$query);
    if (!$result) {
        echo ("unable to insert into dbDates: " . $d->get_id() . mysqli_error($con));
        mysqli_close($con);
        return false;
    }
    mysqli_close($con);
    $shifts = $d->get_shifts();
    foreach ($shifts as $key => $value) {
        insert_dbShifts($d->get_shift($key));
    }
    return true;
}

/**
 * deletes a date from the table
 */
function delete_dbDates($d) {
    if (!$d instanceof RMHdate)
        die("Invalid argument for dbShifts->delete_dbDates function call");
    $con=connect();
    $query = "DELETE FROM dbDates WHERE id=\"" . $d->get_id() . "\"";
    $result = mysqli_query($con,$query);
    if (!$result) {
        echo ("unable to delete from dbDates: " . $d->get_id() . mysqli_error($con));
        mysqli_close($con);
        return false;
    }
    mysqli_close($con);
    $shifts = $d->get_shifts();
    foreach ($shifts as $key => $value) {
        $s = $d->get_shift($key);
        delete_dbShifts($s);
    }
    return true;
}

/**
 * updates a date in the dbDates table
 */
function update_dbDates($d) {
    if (!$d instanceof RMHdate)
        die("Invalid argument for dbDates->update_dbDates function call");
    delete_dbDates($d);
    insert_dbDates($d);
    return true;
}

/**
 * replaces a date in the dbDates table by a new one (with a different shift);
 * makes no changes to the dbShifts table
 */
function replace_dbDates($old_s, $new_s) {
    if (!$old_s instanceof Shift || !$new_s instanceof Shift)
        die("Invalid argument for dbDates->replace_dbDates function call");
    $d = select_dbDates($old_s->get_yy_mm_dd().":".$old_s->get_venue());
    $d = $d->replace_shift($old_s, $new_s);
    update_dbDates($d);
    return true;
}

/**
 * selects a date from the table
 * @return RMHDate
 */
function select_dbDates($id) {
    if (strlen($id) < 12)
        die("Invalid argument for dbDates->select_dbDates call =" . $id);
    $con=connect();
    $query = "SELECT * FROM dbDates WHERE id =\"" . $id . "\"";
    $result = mysqli_query($con,$query);
    mysqli_close($con);
    if (!$result) {
        echo 'Could not select from dbDates: ' . $id;
        error_log('Could not select from dbDates: '. $id);
        return null;
    } 
    else {
        $result_row = mysqli_fetch_row($result);
        if ($result_row) {
            $shifts = $result_row[1];
            $shifts = explode("*", $shifts);
            $s = array();
            foreach ($shifts as $i) {
            	$temp = select_dbShifts($i);
                if ($temp instanceof Shift) {
                	$s[$temp->get_hours()] = $temp;
                }
            }
            $parts = explode(":",$result_row[0]);
            $d = new RMHdate($parts[0],$parts[1], $s, $result_row[2]);
            return $d;
        }
        else {
        	error_log("Could not fetch from dbDates ". $id);
			return null;        	
        }
    }
}

/**
 * @return *-delimited list of the ids of the shifts for the specified day
 */
function get_shifts_text($d) {
    $shifts = $d->get_shifts();
    $shift_text = "";
    foreach ($shifts as $s)
        $shift_text = $shift_text . "*" . $s->get_id();
    $shift_text = substr($shift_text, 1);
    
    return $shift_text;
}

?>