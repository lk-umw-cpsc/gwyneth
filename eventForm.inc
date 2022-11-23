<?php
/*
 * Copyright 2015 by Allen Tucker. This program is part of RMHC-Homebase, which is free 
 * software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 */

/*
 * 	eventForm.inc
 *  shows a form for a event to be added or edited in the database
 * 	@author Oliver Radwan, Xun Wang and Allen Tucker
 * 	@version 9/1/2008, revised 4/1/2012, revised 3/11/2015
 */


 //******************************
 // need to update access level stuff
 //**********************************************
if ($_SESSION['access_level'] == 0) {
    echo('<p><strong>Volunteer Service Application</strong><br />');
    echo('Please provide as much information as you can. ' . 
       '<br>When finished, hit <b>Submit</b> at the bottom of this page, and then <b>logout</b>.');
} else if ($_SESSION['access_level'] == 1)
    if ($_SESSION['_id'] != $event->get_id()) { // delete this *******************
        echo("<p id=\"error\">You do not have sufficient permissions to edit this user.</p>");
        include('footer.inc');
        echo('</div></div></body></html>');
        die();
    } else {
        echo '<p><strong>Personnel Edit Form</strong>';
        echo(' Here you can edit your own information in the database.' .
        '<br>When finished, hit <b>Submit</b> at the bottom of this page.');
    } else if ($_SESSION['access_level'] == 2)
	    if ($id == 'new') {
	        echo('<p><strong>Event Page</strong><br />');
	        echo('Adding a new event to the database. ' .
	        '<br>When finished, hit <b>Submit</b> at the bottom of this page.');
	    } else {
	        echo '<p><strong>Personnel Edit Form</strong>'.
	        		'&nbsp;&nbsp;&nbsp;&nbsp;(View <strong><a href="volunteerLog.php?id='.$event->get_id().'">Log Sheet</a></strong>)<br>';
	        echo('Here you can edit, delete, or reset the password for a event in the database.' .
	        '<br>When finished, hit <b>Submit</b> at the bottom of this page.');
	    } 
	    else {
		    echo("<p id=\"error\">You do not have sufficient permissions to add a new event to the database.</p>");
		    include('footer.inc');
		    echo('</div></div></body></html>');
		    die();
	    }
    echo '<br> (<span style="font-size:x-small;color:FF0000">*</span> denotes required information).';
?>
<form method="POST">
    <input type="hidden" name="old_id" value=<?PHP echo("\"" . $id . "\""); ?>>
    <input type="hidden" name="old_pass" value=<?PHP echo("\"" . $event->get_password() . "\""); ?>>
    <input type="hidden" name="_form_submit" value="1">
    <script>
			$(function(){
				$( "#birthday" ).datepicker({dateFormat: 'y-mm-dd',changeMonth:true,changeYear:true,yearRange: "1920:+nn"});
				$( "#start_date" ).datepicker({dateFormat: 'y-mm-dd',changeMonth:true,changeYear:true,yearRange: "1920:+nn"});
				$( "#screening_status" ).datepicker({dateFormat: 'y-mm-dd',changeMonth:true,changeYear:true,yearRange: "1920:+nn"});
			})
	</script>
    <?PHP 
    	$venues = array('portland'=>"Portland House");       
        echo '<table><tr><td>Event Date <span style="font-size:x-small;color:FF0000">*</span>: '. 
	             '</td><td colspan=2><input name="start_date" type="text" id="start_date" value="'.$event->get_start_date().'">';
	   	foreach ($venues as $venue=>$venuename) {
	   		echo ('<td><input type="hidden" name="location" value="' .$venue.'"'. ($event->get_venue()==$venue?' checked':'').'>');
	   	}
	   	echo "</tr></table><br>"; 
    ?>
    <fieldset>
        <legend>Event information:</legend>
    <?php

    ?>  &nbsp;&nbsp;&nbsp;&nbsp;  Event Name <span style="font-size:x-small;color:FF0000">*</span>: <input type="text" name="event_name" tabindex="2" value="<?PHP echo($event->get_event_name()) ?>">
        

</select>
<?php     
        
       
        
?>
<script src="lib/jquery-1.9.1.js"></script>
<script src="lib/jquery-ui.js"></script>
</fieldset>

<?php 		  
if ($_SESSION['access_level']==2) {
    echo('<br>');
	echo('<p>Event Description:<br />');
	echo('<textarea name="description" rows="2" cols="75">');
	echo($event->get_description().'</textarea>');
}

echo('<h4>need to add:</h4>');
echo('<h4>event hours/shift hours</h4>');
echo('<h4>ability to upload pdf?</h4>');
echo('<h4>ability to add video (just a url?)?</h4>');


echo '</fieldset>';
echo '</fieldset>';

// lots of functions use status, having this commented out will make it blank for events, maybe update

/*echo ('<p>Status:');
echo('<span style="font-size:x-small;color:FF0000">*</span>&nbsp;&nbsp;');
echo('<select name="status">');
if ($_SESSION['access_level'] == 0) {
	echo ('<option value="applicant"');
    echo (' SELECTED'); 
    echo('>applicant</option>');
}
else {
	echo ('<option value="applicant"');
	if ($event->get_status() == 'applicant')
    	echo (' SELECTED'); 
    echo('>applicant</option>'); echo ('<option value="active"');
	if ($event->get_status() == 'active')
	    echo (' SELECTED'); echo('>active</option>');
	echo ('<option value="LOA"');
	if ($event->get_status() == 'LOA')
	    echo (' SELECTED'); echo('>on leave</option>');
	echo ('<option value="former"');
	if ($event->get_status() == 'former')
	    echo (' SELECTED'); echo('>former</option>');
}
echo('</select>');*/
// $st = implode(',', $event->get_type());

// events need a type as it stands now, this now works to set the type to always be CHECKED
$types = array('volunteer' => 'Volunteer');//, 'manager' => 'Manager');
$descriptions = array('volunteer' => ' *insert job description here <p>', 
		
		'manager' => ' *insert job description here');
//echo('<p>Position type:');
// $ts = $types;
//echo('<span style="font-size:x-small;color:FF0000">*</span><p>');

//foreach ($types as $key => $value) {
    echo ('&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" style="display:none;" checked name="type[]" value=' .  $types[0]);
    if (in_array($key,$event->get_type()) !== false)
        echo(' CHECKED');
    echo ('>' . $value );
    if ($_SESSION['access_level']==0)
    	echo $descriptions[$key].'<p>';
//}

//if ($_SESSION['access_level']==0)

?>

    <p>
        <?PHP
        

        echo('<input type="hidden" name="schedule" value="' . implode(',', $event->get_schedule()) . '">');
        echo('<input type="hidden" name="hours" value="' . implode(',', $event->get_hours()) . '">');
        echo('<input type="hidden" name="password" value="' . $event->get_password() . ')">');
        echo('<input type="hidden" name="_submit_check" value="1"><p>');
        if ($_SESSION['access_level'] == 0)
            echo('By hitting <input type="submit" value="Submit" name="Submit Edits">, I understand the importance of this volunteer 
            		commitment and have answered the application questions honestly and to the best of my knowledge.<br /><br />');
        else
            echo('Hit <input type="submit" value="Submit" name="Submit Edits"> to submit these edits.<br /><br />');
        if ($id != 'new' && $_SESSION['access_level'] >= 2) {
            echo ('<input type="checkbox" name="deleteMe" value="DELETE"> Check this box and then hit ' .
            '<input type="submit" value="Delete" name="Delete Entry"> to delete this entry. <br />');// .
            //'<input type="checkbox" name="reset_pass" value="RESET"> Check this box and then hit ' .
            //'<input type="submit" value="Reset Password" name="Reset Password"> to reset this event\'s password.</p>');
            
        }
        ?>
</form>