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
 * Functions to create, update, and retrieve information from the
 * dbLog table in the database.  dbLog is not linked to an object
 * class.
 * @version May 1, 2008, August 30, 2015
 * @author Maxwell Palmer, Allen Tucker
 */
include_once('dbinfo.php');

/**
 * Sets up a new dbLog table by dropping and recreating
 * id - auto increment
 * time - timestamp time()
 * message - text
 * venue - 'portland' or 'bangor
 */
function create_dbLog() {
    $con=connect();
    mysqli_query($con,"DROP TABLE IF EXISTS dbLog");
    //NOTE: primary key set to id.  id is text in the form: yy-mm-dd-ss-se,  ss=shift start,  se=shift end
    $result = mysqli_query($con,"CREATE TABLE dbLog (id INT(3) NOT NULL AUTO_INCREMENT,time TEXT, message TEXT, PRIMARY KEY(id))");
    if (!$result)
        echo mysqli_error($con);
    mysqli_close($con);
}

/**
 * adds a new log entry, using the current time for the timestamp
 */
function add_log_entry($message) {
    $time = time();
    $con=connect();
    $query = "INSERT INTO dbLog (time, message, venue) VALUES (\"" . $time . "\",\"" . $message . "\",\"" . $_SESSION['venue'] ."\")";
    $result = mysqli_query($con,$query);
    if (!$result) {
        echo mysqli_error($con);
    }
    mysqli_close($con);
}

/**
 * deletes a log entry
 */
function delete_log_entry($id) {
    $con=connect();
    $query = "DELETE FROM dbLog WHERE id=\"" . $id . "\" AND venue=\"" .$_SESSION["venue"]."\"";
    $result = mysqli_query($con,$query);
    if (!$result)
        echo mysqli_error($con);
    mysqli_close($con);
}

/**
 * deletes log entries with ids specified in array $ids
 * @param array of log ids
 */
function delete_log_entries($ids) {
    $con=connect();
    for ($i = 0; $i < count($ids); ++$i) {
        $query = "DELETE FROM dbLog WHERE id=\"" . $ids[$i] . "\" AND venue=\"" .$_SESSION["venue"]."\"";
        $result = mysqli_query($con,$query);
        if (!$result)
            echo mysqli_error($con);
    }
    mysqli_close($con);
}

/**
 * returns all entries in the log, sorted by timestamp
 * @return array of id, time, and text
 */
function get_full_log() {
    $con=connect();
    $query = "SELECT * FROM dbLog WHERE venue=\"" .$_SESSION['venue']."\" ORDER BY time DESC";
    $result = mysqli_query($con,$query);
    mysqli_close($con);
    $log = [];
    if (!$result) {
        die("error getting log");
    } else {
        for ($i = 0; $i < mysqli_num_rows($result); ++$i) {
            $result_row = mysqli_fetch_row($result);
            if ($result_row) {
                $log[] = array($result_row[0], date("n/j/y g:ia", $result_row[1]), $result_row[2]);
            }
        }
    }
    return $log;
}

/**
 * returns the last $num log entries
 * @return array of log entries
 */
function get_last_log_entries($num) {
    $log = array();
    $l = get_full_log();
    if ($num > count($l))
        $num = count($l);
    for ($i = 0; $i < $num; $i++) {
        $log[] = $l[$i];
    }
    return $log;
}

?>
