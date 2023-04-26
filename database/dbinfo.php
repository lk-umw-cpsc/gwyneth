<?php
/*
 * Copyright 2015 by Allen Tucker. 
 * This program is part of RMHP-Homebase, which is free software.  It comes with 
 * absolutely no warranty. You can redistribute and/or modify it under the terms 
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 * 
 */

/*
 * This file is only the connection information for the database.
 * This file will be modified for every installation.
 * @author Max Palmer <mpalmer@bowdoin.edu>
 * @version updated 2/12/08
 */

function connect() {
    $host = "localhost"; 
    $database = "homebasedb";
    $user = "homebasedb";
    $pass = "homebasedb";
    if ($_SERVER['SERVER_NAME'] == 'jenniferp95.sg-host.com') {
        $user = 'utlkk2vz0z06y';
        $database = 'db3dpzjdij5qds';
    } else if ($_SERVER['SERVER_NAME'] == 'gwynethsgiftvms.org') {
        $user = "uybhc603shfl5";
        $pass = "f11kwvhy4yic";
        $database = "dbwgyuabseaoih";
    }
    $con = mysqli_connect($host,$user,$pass,$database);
    if (!$con) { echo "not connected to server"; return mysqli_error($con);}
    $selected = mysqli_select_db($con,$database);
    if (!$selected) { echo "database not selected"; return mysqli_error($con); }
    else return $con;
    
}

?>
