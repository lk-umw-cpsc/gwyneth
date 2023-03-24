<?php
    if ($_SERVER['SERVER_NAME'] != 'localhost') {
        echo "This page is unstable and currently disabled.";
        die();
    }
/*
 * Copyright 2015 by Allen Tucker. This program is part of RMHP-Homebase, which is free 
 * software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 */
/* 
 * Modified by Xun Wang on Feb 25, 2015
 */

session_start();
session_cache_expire(30);
?>
<html>
    <head>
        <title>
            Search for People
        </title>
        <!-- <link rel="stylesheet" href="lib\bootstrap\css\bootstrap.css" type="text/css" /> -->
        <link rel="stylesheet" href="styles.css" type="text/css" />
		<link rel="stylesheet" href="lib/jquery-ui.css" />
        <?php require('universal.inc') ?>
		
    </head>
    <body style="background-color: rgb(250, 249, 246);">
        <div class="container-fluid" id="container">
            <?PHP include('header.php'); ?>
            <div class="container-fluid" id="content">
                <?PHP
                // display the search form
                if (isset($_GET['area'])) {
                    $area = $_GET['area'];
                } else {
                    $area = '';
                }
                echo('<form method="post">');
                echo('<p><strong>Search for volunteers:</strong>');
                $types = array('volunteer' => 'Volunteer', 'admin' => 'Admin', 'superadmin' => 'SuperAdmin');
                echo '<p>Type:<select class="form-select-sm" name="s_type">' ;
                echo '<option value="" SELECTED></option>' ;
                foreach ($types as $type => $typename)
                	echo '<option value="'.$type.'">'.$typename.'</option>';
                
                echo '</select>';
                echo('&nbsp;&nbsp;Status:<select class="form-select-sm" name="s_status">' .
                '<option value="" SELECTED></option>' . '<option value="applicant">Applicant</option>' . '<option value="active">Active</option>' .
                '<option value="LOA">On Leave</option>' . '<option value="former">Former</option>' .
                '</select>');
                echo '<p>Name (type a few letters): ';
                echo '<input class="form-control-sm" type="text" name="s_name">';

                echo '<fieldset>
						<legend>Availability: </legend>
							<table><tr>
								<td>Day (of week)</td>
								<td>Shift</td>
								</tr>';
                echo "<tr>";
                echo "<td>";
                $days = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
                echo '<select class="form-select-sm" name="s_day">' . '<option value=""></option>';
                foreach ($days as $day) {
                    echo '<option value="' . $day . '">' . $day . '</option>';
                }
                echo '</select>';
                echo "</td><td>";
                $shifts = array('9-12' => '9am-12pm', '12-3' => '12pm-3pm', '3-6' => '3pm-6pm',
                    '6-9' => '6pm-9pm', 'night' => "Overnight");
                echo '<select class="form-select-sm" name="s_shift">' . '<option value=""></option>';
                foreach ($shifts as $shiftno => $shiftname) {
                    echo '<option value="' . $shiftno . '">' . $shiftname . '</option>';
                }
                echo '</select>';
                echo "</tr>";
                echo '</table></fieldset>';

                echo('<p><input class="btn btn-success" type="submit" name="Search" value="Search">');
                echo('</form></p>');

                // if user hit "Search"  button, query the database and display the results
                if (isset($_POST['Search'])) {
                    $type = $_POST['s_type'];
                    $status = $_POST['s_status'];
                    $name = trim(str_replace('\'', '&#39;', htmlentities($_POST['s_name'])));
                    // now go after the volunteers that fit the search criteria
                    include_once('database/dbPersons.php');
                    include_once('domain/Person.php');
                    $result = getonlythose_dbPersons($type, $status, $name, $_POST['s_day'], $_POST['s_shift'], $_SESSION['venue']); //added s_venue
                    echo '<p><strong>Search Results:</strong> <p>Found ' . sizeof($result) . ' ' . $status . ' ';
                    if ($type != "")
                        echo $type . "s";
                    else
                        echo "persons";
                    if ($name != "")
                        echo ' with name like "' . $name . '"';
                    $availability = $_POST['s_day'] ." ". $_POST['s_shift'] ; //added s_venue 
                    if ($availability != " ") {
                        echo " with availability " . $availability;
                    }
				    if (sizeof($result) > 0) {
				       echo ' (select one for more info).';
				       echo '<div class="overflow-auto" id="target" style="width: variable; height: 400px;">';
				       echo '<p><table class="table table-info table-responsive table-striped-columns table-hover table-bordered"> <tr><td>Name</td><td>Phone</td>
				                            <td>E-mail</td><td>Availability</td></tr>';
				       foreach ($result as $vol) {
				          echo "<tr><td><a href=editProfile.php?id=" . 
				               str_replace(" ","_",$vol->get_id()) . ">" .
				               $vol->get_first_name() . " " . $vol->get_last_name() . "</td><td>" .
				               phone_edit($vol->get_phone1()) . "</td><td>" .
				               $vol->get_email() . "</td><td>";
				          // little algorithm added to trim venue off of availability when displayed in search
				          foreach ($vol->get_availability() as $availableon) {
				               $count = 0;
				               $stop = 0;
				               while (true){
				                    if ($availableon[$count] == ":"){
				                        $stop = $stop + 1;
				                        if ($stop == 2){
				                            break;
				                        }
				                    }
				                    echo ($availableon[$count]);
				                    $count = $count + 1;
				               }
				               echo (", ");
				          }
				          echo "</td></a></tr>";
				       }
				       echo '</table>';
				       echo '</div>';   
				    }
				               
                }
                ?>
                </div>
        </div>
        <?PHP include('footer.inc'); ?>
    </body>
</html>

