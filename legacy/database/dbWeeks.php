 <?php
/*
 * Copyright 2015 by Adrienne Beebe, Connor Hargus, Phuong Le, 
 * Xun Wang, and Allen Tucker. This program is part of RMHP-Homebase, which is free 
 * software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 * 
 */

/**
 * Functions to create, update, and retrieve information from the
 * dbWeeks table in the database.  This table is used with the week
 * class.  Weeks are generated using the master schedule (through the
 * addWeek.php form), and retrieved by the calendar form and addWeek.php.
 * @version May 1, 2008, modifications September 15, 2008, February 10, 2015
 * @author Adrienne Beebe, Maxwell Palmer and Allen Tucker
 */
 include_once(dirname(__FILE__).'/../domain/Week.php');
include_once('dbinfo.php');
include_once('dbDates.php');
include_once('dbShifts.php');
include_once(dirname(__FILE__).'/../domain/Shift.php');

/**
 * Inserts a week into the db
 * @param week to insert
 */
function insert_dbWeeks($w) {
    if (!$w instanceof Week) {
        die("Invalid argument for dbWeeks->insert_dbWeeks function call");
    }
    $con=connect();
    $query = "SELECT * FROM dbWeeks WHERE id =\"" . $w->get_id() . "\"";
    $result = mysqli_query($con,$query);
    if (mysqli_num_rows($result) != 0) {
        delete_dbWeeks($w);
        $con=connect();
    }
    $query = "INSERT INTO dbWeeks VALUES (\"" . $w->get_id() . "\"," . get_dates_text($w->get_dates()) . ",\"" .
            $w->get_venue() . "\",\"" .
            $w->get_status() . "\",\"" .
            $w->get_name() . "\",\"" .
            $w->get_end() . "\")";
    $result = mysqli_query($con,$query);
    mysqli_close($con);
    if (!$result) {
        echo ("<br>unable to insert into dbWeeks: " . $w->get_id() . get_dates_text($w->get_dates()) .
        $w->get_venue() . $w->get_status() . $w->get_name() . $w->get_end() );
        return false;
    }
    else
        foreach ($w->get_dates() as $i)
            insert_dbDates($i);
    return true;
}

/**
 * Deletes a week from the db
 * @param week to delete
 */
function delete_dbWeeks($w) {
    if (!$w instanceof Week)
        die("Invalid argument for delete_dbWeeks function call");
    $con=connect();
    $query = "DELETE FROM dbWeeks WHERE id=\"" . $w->get_id() . "\"";
    $result = mysqli_query($con,$query);
    mysqli_close($con);
    if (!$result) {
        echo ("unable to delete from dbWeeks: " . $w->get_id() . mysqli_error($con));
        return false;
    }
    else
        foreach ($w->get_dates() as $i)
            delete_dbDates($i);
    return true;
}

/**
 * Updates a week in the db by deleting it and re-inserting it
 * @param week to update
 */
function update_dbWeeks($w) {
    if (!$w instanceof Week)
        die("Invalid argument for dbWeeks->replace_week function call");
    if (delete_dbWeeks($w))
        return insert_dbWeeks($w);
    else
        return false;
}

/**
 * Selects a week from the database
 * @param week id
 * @return week corresponding to that id
 */
function select_dbWeeks($id) {

    if (strlen($id) < 12) {
        die("Invalid week id." . $id);
    } else {
        $timestamp = mktime(0, 0, 0, substr($id, 3, 2), substr($id, 6, 2), substr($id, 0, 2));
        $dow = date("N", $timestamp);
        $id2 = date("y-m-d", mktime(0, 0, 0, substr($id, 3, 2), substr($id, 6, 2) - $dow + 1, substr($id, 0, 2)))
        . ":" . substr($id,9);
    }
    $con=connect();
    $query = "SELECT * FROM dbWeeks WHERE id =\"" . $id2 . "\"";
    $result = mysqli_query($con,$query);
    
    if (!$result || mysqli_num_rows($result) == 0) {
        $query = "SELECT * FROM dbWeeks WHERE id =\"" . $id . "\"";
        $result = mysqli_query($con,$query);
        
        if (!$result) {
            echo '<br>Could not run query: ' . mysqli_error($con);
            $result_row = false;
        }
        else
            $result_row = mysqli_fetch_assoc($result);
    }
    else
        $result_row = mysqli_fetch_assoc($result);
    mysqli_close($con);
    
    return $result_row;
}

/**
 * retrieves a Week from the database
 * @param $id = mm-dd-yy of the week to retrieve
 * @return week with that id, or null
 */
function get_dbWeeks($id) {
    $result_row = select_dbWeeks($id);
    if ($result_row!=null) {
    	$dates = explode("*", $result_row['dates']);
    	$d = array();
        foreach ($dates as $date) {
        	$d[] = select_dbDates($date);
        }
        
        $w = new Week($d, $result_row['venue'],
                        $result_row['status']);
        error_log("3");
        return $w;
    }
    else
        return null;
}

/**
 * the full contents of dbWeeks, used by addWeek to list all scheduled weeks
 * @return $weeks -- all weeks in the database
 */
function get_all_dbWeeks($venue) {
	$con=connect();
	$query = "SELECT * FROM dbWeeks WHERE venue =\"" . $venue . "\" ORDER BY end";
	$result = mysqli_query($con,$query);
	mysqli_close($con);
    $weeks = array();
    while ($result_row = mysqli_fetch_assoc($result)) {
    	error_log($result_row['id']);
    	$w = get_dbWeeks($result_row['id']);
    	$weeks[] = $w;
    }
    return $weeks;
}

/**
 * generates a string of date ids
 * @param $dates array of dates for a week
 * @return string of date ids, * delimited
 */
function get_dates_text($dates) {
    $d = "\"" . $dates[0]->get_id();
    for ($i = 1; $i < 7; ++$i) {
        $d = $d . "*" . $dates[$i]->get_id();
    }
    return $d . "\"";
}

?>
