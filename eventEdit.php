<?php
/*
 * Copyright 2015 by Allen Tucker. This program is part of RMHC-Homebase, which is free 
 * software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 */
/*
 * 	eventEdit.php
 *  oversees the editing of a event to be added, changed, or deleted from the database
 * 	@author Oliver Radwan, Xun Wang and Allen Tucker
 * 	@version 9/1/2008 revised 4/1/2012 revised 8/3/2015
 */
session_start();
session_cache_expire(30);
include_once('database/dbEvents.php');
include_once('domain/Event.php');
include_once('database/dbApplicantScreenings.php');
include_once('domain/ApplicantScreening.php');
include_once('database/dbLog.php');
$id = str_replace("_"," ",$_GET["id"]);

if ($id == 'new') {
    $event = new Event('new', 'event', $_SESSION['venue'],  
                    null, null, null, null, null, null, null, "");
} else {
    $event = retrieve_event($id);
    if (!$event) { // try again by changing blanks to _ in id
        $id = str_replace(" ","_",$_GET["id"]);
        $event = retrieve_event($id);
        if (!$event) {
            echo('<p id="error">Error: there\'s no event with this id in the database</p>' . $id);
            die();
        }
    }
}
?>
<html>
    <head>
        <title>
            Editing <?PHP echo($event->get_first_name() . " " . $event->get_event_name()); ?>
        </title>
        <link rel="stylesheet" href="lib/jquery-ui.css" />
        <link rel="stylesheet" href="styles.css" type="text/css" />
        <script src="lib/jquery-1.9.1.js"></script>
		<script src="lib/jquery-ui.js"></script>
		<script>
			$(function(){
				$( "#start_date" ).datepicker({dateFormat: 'y-mm-dd',changeMonth:true,changeYear:true,yearRange: "1920:+nn"});
				$( "#end_date" ).datepicker({dateFormat: 'y-mm-dd',changeMonth:true,changeYear:true,yearRange: "1920:+nn"});
			})
		</script>
    </head>
    <body>
        <div id="container">
            <?PHP include('header.php'); ?>
            <div id="content">
                <?PHP
                include('eventValidate.inc');
                if ($_POST['_form_submit'] != 1)
                //in this case, the form has not been submitted, so show it
                    include('eventForm.inc');
                else {
                    //in this case, the form has been submitted, so validate it
                    //******************************************************************************************
                    $errors = validate_form($event);  //step one is validation.
                    // errors array lists problems on the form submitted
                    if ($errors) {
                        // display the errors and the form to fix
                        show_errors($errors);
                        if (!$_POST['availability'])
                          $availability = null;
                        else {
                          $postavail = array();
                          foreach ($_POST['availability'] as $postday) 
                        	  $postavail[] = $postday;
                          $availability = implode(',', $postavail);
                        }
                        $event = new Event($event->get_first_name(), $_POST['event_name'], $_POST['location'],  
                                        $_POST['status'],  
                                        $availability, $_POST['schedule'], $_POST['hours'], 
                                        $_POST['start_date'], 
                                        $_POST['description'], $_POST['event_id'], $_POST['old_pass']);
                        include('eventForm.inc');
                    }
                    // this was a successful form submission; update the database and exit
                    else
                        process_form($id,$event);
                        echo "</div>";
                    include('footer.inc');
                    echo('</div></body></html>');
                    die();
                }

                /**
                 * process_form sanitizes data, concatenates needed data, and enters it all into a database
                 */
                function process_form($id,$event) {
                    //step one: sanitize data by replacing HTML entities and escaping the ' character
                    if ($event->get_first_name()=="new")
                   		$first_name = trim(str_replace('\\\'', '', htmlentities(str_replace('&', 'and', $_POST['first_name']))));
                    else
                    	$first_name = $event->get_first_name();
                    $event_name = trim(str_replace('\\\'', '\'', htmlentities($_POST['event_name'])));
                    $location = $_POST['location'];
                    $status = $_POST['status'];
                    
                    if (!$_POST['availability'])
                          $availability = null;
                    else {
                          $availability = implode(',', $_POST['availability']);
                    }
                    // these two are not visible for editing, so they go in and out unchanged
                    $schedule = $_POST['schedule'];
                    $hours = $_POST['hours'];
                    $start_date = $_POST['start_date'];
                    $description = trim(str_replace('\\\'', '\'', htmlentities($_POST['description'])));
                    //$event_id = trim(str_replace('\\\'', '\'', htmlentities($_POST['event_id'])));
                    $event_id = uniqid();//$_POST['schedule'];
                    //used for url path in linking user back to edit form
                    $path = strrev(substr(strrev($_SERVER['SCRIPT_NAME']), strpos(strrev($_SERVER['SCRIPT_NAME']), '/')));
                    //step two: try to make the deletion, password change, addition, or change
                    if ($_POST['deleteMe'] == "DELETE") {
                        $result = retrieve_event($id);
                        if (!$result)
                            echo('<p>Unable to delete. ' . $first_name . ' ' . $event_name . ' is not in the database. <br>Please report this error to the House Manager.');
                        else {
                                $result = remove_event($id);
                                echo("<p>You have successfully removed " . $first_name . " " . $event_name . " from the database.</p>");
                                if ($id == $_SESSION['_id']) {
                                    session_unset();
                                    session_destroy();
                                }
                        }
                    }


                    // try to add a new event to the database
                    else if ($_POST['old_id'] == 'new') {
                        //$id = $first_name . $clean_phone1; 
                        $id = $event_id; 
                        //check if there's already an entry
                        $dup = retrieve_event($id);
                        if ($dup)
                            echo('<p class="error">Unable to add ' . $first_name . ' ' . $event_name . ' to the database. <br>Another event with the same info is already there.');
                        else {
                        	$newevent = new Event($first_name, $event_name, $location, 
                                        $status, $availability, $schedule, $hours, 
                                        $start_date, $description, $event_id, "");
                            $result = add_event($newevent);
                            if (!$result)
                                echo ('<p class="error">Unable to add " .$first_name." ".$event_name. " in the database. <br>Please report this error to the House Manager.');
                            else if ($_SESSION['access_level'] == 0)
                                echo("<p>Your application has been successfully submitted.<br>  The House Manager will contact you soon.  Thank you!");
                            else
                                echo('<p>You have successfully added <a href="' . $path . 'eventEdit.php?id=' . $id . '"><b>' . $first_name . ' ' . $event_name . ' </b></a> to the database.</p>');
                        }
                    }

                    // try to replace an existing event in the database by removing and adding
                    else {
                        $backUpEventId = $event_id;
                        $id = $_POST['old_id'];
                        $pass = $_POST['old_pass'];
                        $result = remove_event($id);
                        if (!$result)
                            echo ('<p class="error">Unable to update ' . $first_name . ' ' . $event_name . '. <br>Please report this error to the House Manager.');
//*******************************************************************************************
//CLEAN UP THIS CODE!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//. $first_name . should not be in ANY echo statements, field needs to be deleted anyway
//********************************************************************************************
                            /*else {
                            $newevent = new Event($first_name, $event_name, $location, $clean_phone1, $phone1type, 
                                        $type, $status, $availability, $schedule, $hours, 
                                        $birthday, $start_date, $description, $backUpEventId, $pass);
                            $result = add_event($newevent);
                            if (!$result)
                                echo ('<p class="error">Unable to update ' . $first_name . ' ' . $event_name . '. <br>Please report this error to the House Manager.');
                            //else echo("<p>You have successfully edited " .$first_name." ".$event_name. " in the database.</p>");
                            else
                            // this was creating errors w/ the a new id being created, fixed w/ backUpEventId variable and event_id instead of id
                                echo('<p>You have successfully edited <a href="' . $path . 'eventEdit.php?id=' . $event_id . '"><b>' . $first_name . ' ' . $event_name . ' </b></a> to the database.</p>');
                                //echo('<p>You have successfully edited <a href="' . $path . 'eventEdit.php?id=' . $id . '"><b>' . $first_name . ' ' . $event_name . ' </b></a> in the database.</p>');
                            //add_log_entry('<a href=\"eventEdit.php?id=' . $id . '\">' . $first_name . ' ' . $event_name . '</a>\'s Eventnel Edit Form has been changed.');
                        }*/
                        else {
                            //Pass the old id into the new event instead of event_id, this prevents a new id being created
                            $newevent = new Event($first_name, $event_name, $location,  
                                        $status, $availability, $schedule, $hours, 
                                        $start_date, $description, $id, $pass);
                            $result = add_event($newevent);
                            if (!$result)
                                echo ('<p class="error">Unable to update ' . $first_name . ' ' . $event_name . '. <br>Please report this error to the House Manager.');
                            //else echo("<p>You have successfully edited " .$first_name." ".$event_name. " in the database.</p>");
                            else
                            // this was creating errors w/ the a new id being created, fixed w/ backUpEventId variable and event_id instead of id
                                echo('<p>You have successfully edited <a href="' . $path . 'eventEdit.php?id=' . $id . '"><b>' . $first_name . ' ' . $event_name . ' </b></a> to the database.</p>');
                                //echo('<p>You have successfully edited <a href="' . $path . 'eventEdit.php?id=' . $id . '"><b>' . $first_name . ' ' . $event_name . ' </b></a> in the database.</p>');
                            //add_log_entry('<a href=\"eventEdit.php?id=' . $id . '\">' . $first_name . ' ' . $event_name . '</a>\'s Eventnel Edit Form has been changed.');
                        }
                    }
                }
                ?>
            </div>
            <?PHP include('footer.inc'); ?>
        </div>
    </body>
</html> 