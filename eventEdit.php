<?php
/*
 * Copyright 2015 by Allen Tucker. This program is part of RMHC-Homebase, which is free 
 * software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 */
/*
 * 	eventEdit.php
 *  oversees the editing of an event to be added, changed, or deleted from the database
 * 	@author Oliver Radwan, Xun Wang and Allen Tucker
 * 	@version 9/1/2008 revised 4/1/2012 revised 8/3/2015
 */

/* 
 * Created for Gwyneth's Gift in 2022 using original Homebase code as a guide
 */

session_start();
session_cache_expire(30);
include_once('database/dbEvents.php');
include_once('domain/Event.php');
include_once('database/dbLog.php'); // can be used in later iterations
$id = str_replace("_"," ",$_GET["id"]);

if ($id == 'new') {
    $event = new Event('event', $_SESSION['venue'],  
                    null, null, null, "");
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
            Editing <?PHP echo($event->get_event_name()); ?>
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
    <?php require('universal.inc') ?>
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
                    $errors = validate_form($event);  //step one is validation.
                    // errors array lists problems on the form submitted
                    if ($errors) {
                        // display the errors and the form to fix
                        show_errors($errors);
                        $event = new Event($event->get_event_name(), $_POST['location'],   
                                        $_POST['event_date'], $_POST['description'], $_POST['event_id']);
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
                    $event_name = trim(str_replace('\\\'', '\'', htmlentities($_POST['event_name'])));
                    //location = venue? may be useful for adding to calendar
                    $location = $_POST['location'];
                    $event_date = $_POST['event_date'];
                    $description = trim(str_replace('\\\'', '\'', htmlentities($_POST['description'])));
                    //$event_id = trim(str_replace('\\\'', '\'', htmlentities($_POST['event_id'])));
                    $event_id = uniqid();
                    //used for url path in linking user back to edit form
                    $path = strrev(substr(strrev($_SERVER['SCRIPT_NAME']), strpos(strrev($_SERVER['SCRIPT_NAME']), '/')));
                    //step two: try to make the deletion, addition, or change
                    if ($_POST['deleteMe'] == "DELETE") {
                        $result = retrieve_event($id);
                        if (!$result)
                            echo('<p>Unable to delete. ' . $event_name . ' is not in the database. <br>Please report this error to the Manager.');
                        else {
                                $result = remove_event($id);
                                echo("<p>You have successfully removed " . $event_name . " from the database.</p>");
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
                            echo('<p class="error">Unable to add ' . $event_name . ' to the database. <br>Another event with the same info is already there.');
                        else {
                        	$newevent = new Event($event_name, $location,  
                                        $event_date, $description, $event_id, "");
                            $result = add_event($newevent);
                            if (!$result)
                                echo ('<p class="error">Unable to add " .$event_name. " in the database. <br>Please report this error to the Manager.');
                            else if ($_SESSION['access_level'] == 0)
                                echo("<p>Your application has been successfully submitted.<br>  The Manager will contact you soon.  Thank you!");
                            else
                                echo('<p>You have successfully added <a href="' . $path . 'eventEdit.php?id=' . $id . '"><b>' . $event_name . ' </b></a> to the database.</p>');
                        }
                    }

                    // try to replace an existing event in the database by removing and adding
                    else {
                        
                        $id = $_POST['old_id'];
                        $result = remove_event($id);
                        if (!$result)
                            echo ('<p class="error">Unable to update ' . $event_name . '. <br>Please report this error to the Manager.');

                        else {
                            //Pass the old id into the new event instead of event_id, this prevents a new id being created
                            $newevent = new Event($event_name, $location,  
                                        $event_date, $description, $id);
                            $result = add_event($newevent);
                            if (!$result)
                                echo ('<p class="error">Unable to update ' . $event_name . '. <br>Please report this error to the Manager.');
                            
                            else
                                echo('<p>You have successfully edited <a href="' . $path . 'eventEdit.php?id=' . $id . '"><b>' . $event_name . ' </b></a> to the database.</p>');
                        }
                    }
                }
                ?>
            </div>
            <?PHP include('footer.inc'); ?>
        </div>
    </body>
</html> 