<?php
/*
 * Copyright 2015 by Allen Tucker. This program is part of RMHC-Homebase, which is free 
 * software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 */

/*
 * 	personForm.inc
 *  shows a form for a person to be added or edited in the database
 * 	@author Oliver Radwan, Xun Wang and Allen Tucker
 * 	@version 9/1/2008, revised 4/1/2012, revised 3/11/2015
 */

if ($_SESSION['access_level'] == 0) {
    echo('<p><strong>Volunteer Service Application</strong><br />');
    echo('Please provide as much information as you can. ' . 
       '<br>When finished, hit <b>Submit</b> at the bottom of this page, and then <b>logout</b>.');
} else if ($_SESSION['access_level'] == 1)
    if ($_SESSION['_id'] != $person->get_id()) {
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
	        echo('<p><strong>Volunteer Service Application</strong><br />');
	        echo('Adding a new volunteer to the database. ' .
	        '<br>When finished, hit <b>Submit</b> at the bottom of this page.');
	    } else {
	        echo '<p><strong>Personnel Edit Form</strong>'.
	        		'&nbsp;&nbsp;&nbsp;&nbsp;(View <strong><a href="volunteerLog.php?id='.$person->get_id().'">Log Sheet</a></strong>)<br>';
	        echo('Here you can edit, delete, or reset the password for a person in the database.' .
	        '<br>When finished, hit <b>Submit</b> at the bottom of this page.');
	    } 
	    else {
		    echo("<p id=\"error\">You do not have sufficient permissions to add a new person to the database.</p>");
		    include('footer.inc');
		    echo('</div></div></body></html>');
		    die();
	    }
    echo '<br> (<span style="font-size:x-small;color:FF0000">*</span> denotes required information).';
?>
<form method="POST">
    <input type="hidden" name="old_id" value=<?PHP echo("\"" . $id . "\""); ?>>
    <input type="hidden" name="old_pass" value=<?PHP echo("\"" . $person->get_password() . "\""); ?>>
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
        echo '<table><tr><td>Date: '. 
	             '</td><td colspan=2><input name="start_date" type="text" id="start_date" value="'.$person->get_start_date().'">';
	   	foreach ($venues as $venue=>$venuename) {
	   		echo ('<td><input type="hidden" name="location" value="' .$venue.'"'. ($person->get_venue()==$venue?' checked':'').'>');
	   	}
	   	echo "</tr></table><br>"; 
    ?>
    <fieldset>
        <legend>Personal information:</legend>
    <?php
        if ($person->get_first_name()=="new")
        	echo '<p>First Name<span style="font-size:x-small;color:FF0000">*</span>: <input type="text" name="first_name" tabindex="1" value="'.$person->get_first_name().'">';
        else 
        	echo '<p>First Name: '.$person->get_first_name();
    ?>  &nbsp;&nbsp;&nbsp;&nbsp;  Last Name<span style="font-size:x-small;color:FF0000">*</span>: <input type="text" name="last_name" tabindex="2" value="<?PHP echo($person->get_last_name()) ?>">
        <p>Address<span style="font-size:x-small;color:FF0000">*</span>: <input type="text" name="address" tabindex="3" size=40 value="<?PHP echo($person->get_address()) ?>">
        <p>City<span style="font-size:x-small;color:FF0000">*</span>: <input type="text" name="city" tabindex="4" value="<?PHP echo($person->get_city()) ?>">
        State, Zip<span style="font-size:x-small;color:FF0000">*</span>:
            <select name="state" tabindex="5">
<?PHP
$states = array("AL", "AK", "AZ", "AR", "CA", "CO", "CT", "DE", "DC", "FL", "GA", "HI", "ID", "IL", "IN", "IA",
    "KS", "KY", "LA", "ME", "MD", "MA", "MI", "MN", "MS", "MO", "MT", "NE", "NV", "NH", "NJ", "NM",
    "NY", "NC", "ND", "OH", "OK", "OR", "PA", "RI", "SC", "SD", "TN", "TX", "UT", "VT", "VA", "WA",
    "WV", "WI", "WY");
foreach ($states as $st) {
    echo "<option value='" . $st . "' ";
    if ($person->get_state() == $st)
        echo("SELECTED");
    else if ($id == "new" && $st == "ME")
        echo("SELECTED");
    echo ">" . $st . "</option>";
}
?>
</select>,
<input type="text" name="zip" size="5" tabindex="6" value="<?PHP echo($person->get_zip()) ?>">
<?php     
        $phonetypes = array("home", "cell", "work");
        if ($person->get_first_name()=="new") {
        	echo '<p>Primary Phone<span style="font-size:x-small;color:FF0000">*</span>: ';
        	echo '<input type="text" name="phone1" MAXLENGTH=12 tabindex="7" value="'.phone_edit($person->get_phone1()).'">';
        	foreach ($phonetypes as $pvalue)
        		echo '<input type="radio" name="phone1type" value="'.$pvalue.'"'.($person->get_phone1type()==$pvalue?' checked':'').'>'.$pvalue.' ';
        }
        else echo '<p>Primary Phone: '.phone_edit($person->get_phone1());
        echo '<p>Secondary Phone: ';
        echo '<input type="text" name="phone2" MAXLENGTH=12 tabindex="8" value="'.phone_edit($person->get_phone2()).'">';
        foreach ($phonetypes as $pvalue)
        	echo '<input type="radio" name="phone2type" value="'.$pvalue.'"'.($person->get_phone2type()==$pvalue?" checked":"").'>'.$pvalue.' ';
        
        echo '<p>Birth date: '. '<input name="birthday" type="text" id="birthday" tabindex="9" value="'.$person->get_birthday().'">';
        if ($id=='new')
        	echo ' (Applicants younger than 18 should contact RMH for a separate application)';
        echo '<p>Email address: '. '<input type="text" name="email" tabindex="10" value="'.$person->get_email().'">';

        //added for GG database
        echo '<h2>Added for GG database, needs editing + entered info does not save on the screen when going back to edit person</h2>';
        echo '<p>Shirt size: '. '<input type="text" name="shirt_size" tabindex="11" placeholder="S, M, L, XL, or XXL" '.$person->get_shirt_size().'">';
        echo '<p>Do you own a computer: '. '<input type="text" name="computer" tabindex="12" placeholder="Yes or No" '.$person->get_computer().'">';
        echo '<p>Do you own a camera: '. '<input type="text" name="camera" tabindex="13" placeholder="Yes or No" '.$person->get_camera().'">';
        echo '<p>Do you have reliable transportation: '. '<input type="text" name="transportation" tabindex="14" placeholder="Yes or No" '.$person->get_transportation().'">';
        echo '<p>Emergency contact name: '. '<input type="text" name="contact_name" tabindex="15" placeholder="Name" '.$person->get_contact_name().'">';
        echo '<p>Emergency contact number: '. '<input type="text" name="contact_num" tabindex="16" placeholder="Phone number" '.$person->get_contact_num().'">';
        echo '<p>Relation to emergency contact: '. '<input type="text" name="relation" tabindex="17" placeholder="Relative, Spouse, Friend, etc." '.$person->get_relation().'">';
        //echo '<p>Do you have reliable transportation: '. '<input type="text" name="transportation" tabindex="14" placeholder="Yes or No" '.$person->get_transportation().'">';
?>
<script src="lib/jquery-1.9.1.js"></script>
<script src="lib/jquery-ui.js"></script>
</fieldset>

<?php 		  
if ($_SESSION['access_level']==2) {
	echo('<p>Manager Notes:<br />');
	echo('<textarea name="notes" rows="2" cols="75">');
	echo($person->get_notes().'</textarea>');
}

echo '<fieldset> <legend>Employment:</legend>';
echo '<p>Current Employer: <input type="text" name="employer" tabindex="1" size=30 value="'.$person->get_employer().'"> '.
'Position: <input type="text" name="position" tabindex="2" size=30 value="'.$person->get_position().'">';


echo '</fieldset>';

echo '<fieldset> <legend>Students (18+ only):</legend>';
echo '<p>Are you currently attending school? <input type="radio" name="isstudent" value="yes" '.($person->get_position()=="student"?"checked":"").'>yes'.
 		'&nbsp;&nbsp;<input type="radio" name="isstudent" value="no" '.($person->get_position()!="student"?"checked":"").'>no';
echo '&nbsp;&nbsp;&nbsp;&nbsp;Name of school: '.'<input type="text" name="nameofschool" size=30 value="'.($person->get_position()=="student"?$person->get_employer():"").'"> ';
echo '<p>Will you be receiving academic credit for your volunteer work? ';
echo '<input type="radio" name="academiccredit" value="yes" '.($person->get_credithours()!=""?"checked":"").'>yes'.
 		'&nbsp;&nbsp;<input type="radio" name="academiccredit" value="no" '.($person->get_credithours()==""?"checked":"").'>no';
echo '<br>If yes, number of hours required: ';
echo '<input type="text" name="credithours" size=5 value="'.$person->get_credithours().'">';
echo '</fieldset>';

echo '<fieldset> <legend>Volunteer Information:</legend>';

echo '<p>How did you hear about RMHC volunteer opportunities? ';
echo '<p><input type="radio" name="howdidyouhear" value="internet" '.($person->get_howdidyouhear()=="internet"?"checked":"").'>Internet search or website'.
		'&nbsp;&nbsp;<input type="radio" name="howdidyouhear" value="family" '.($person->get_howdidyouhear()=="family"?"checked":"").'>Family or friend'.
		'&nbsp;&nbsp;<input type="radio" name="howdidyouhear" value="volunteer" '.($person->get_howdidyouhear()=="volunteer"?"checked":"").'>Current volunteer'.
		'&nbsp;&nbsp;<input type="radio" name="howdidyouhear" value="other" '.($person->get_howdidyouhear()=="other"?"checked":"").'>other';
echo '<p>Can you make a commitment to volunteer at RMH for at least one year? <br>(one semester for college students): ';
echo '<input type="radio" name="commitment" value="yes" '.($person->get_commitment()=="yes"?"checked":"").'>yes'.
 		'&nbsp;&nbsp;<input type="radio" name="commitment" value="no" '.($person->get_commitment()!="yes"?"checked":"").'>no';
echo('<p>Why are you interested in volunteering at the Ronald McDonald House?<br />');
echo('<textarea name="motivation" rows="3" cols="75">');
echo($person->get_motivation());
echo('</textarea>');

echo('<p>Please list special skills, hobbies, or training you would like us to know about:<br />');
echo('<textarea name="specialties" rows="3" cols="75">');
echo($person->get_specialties());
echo('</textarea>');

	echo '<p>Have you ever been convicted of a felony? ';
	echo '<input type="radio" name="convictions" value="yes" '.($person->get_convictions()=="yes"?"checked":"").'>yes'.
	 		'&nbsp;&nbsp;<input type="radio" name="convictions" value="no" '.($person->get_position()!="yes"?"checked":"").'>no';
if ($_SESSION['access_level']==0) {
	echo '<p>All volunteer positions require a background check (separate form).'.
		 '<br> Please note: our facility is unable to accommodate court-ordered community service or probation-based hours.';
}
echo '</fieldset>';

echo ('<p>Status:');
echo('<span style="font-size:x-small;color:FF0000">*</span>&nbsp;&nbsp;');
echo('<select name="status">');
if ($_SESSION['access_level'] == 0) {
	echo ('<option value="applicant"');
    echo (' SELECTED'); 
    echo('>applicant</option>');
}
else {
	echo ('<option value="applicant"');
	if ($person->get_status() == 'applicant')
    	echo (' SELECTED'); 
    echo('>applicant</option>'); echo ('<option value="active"');
	if ($person->get_status() == 'active')
	    echo (' SELECTED'); echo('>active</option>');
	echo ('<option value="LOA"');
	if ($person->get_status() == 'LOA')
	    echo (' SELECTED'); echo('>on leave</option>');
	echo ('<option value="former"');
	if ($person->get_status() == 'former')
	    echo (' SELECTED'); echo('>former</option>');
}
echo('</select>');
// $st = implode(',', $person->get_type());
$types = array('volunteer' => 'House Volunteer', 'weekendmgr' => 'Weekend Manager', 'sub' => 'Flex shift', 'mealprep' => 'Guest Chef', 'events' => 'Events/Special projects', 'manager' => 'Manager');
$descriptions = array('volunteer' => ' -- Assists with the day-to-day operations of the House, such as
				answering phones, assisting families, giving tours, cleaning rooms and common areas, and washing linens.<p>', 
		'weekendmgr' => ' -- Serves as main point of contact during day and overnight hours. Shifts are 
						generally Friday 5pm to Saturday 5pm and/or Saturday 5pm to Sunday noon (Bangor) or 2pm (Portland). Duties include
						preparing rooms for guests, assisting families, responding to emergencies, and coordinating shift volunteers.', 
		'sub' => ' -- available on an as-needed basis to fill in (sub) for an open House Volunteer or Weekend Manager shift.',
		'mealprep' => ' -- Individual or group provides ingredients and prepares evening meal for families (approx. 15-20 people Bangor and 
						20-25 people Portland). Groups should be limited to 6-8 people.', 
		'events' => ' -- Helps with special projects and fundraising events that take place occasionally during the year.', 
		'manager' => ' -- This is a restricted level of Homebase access for House staff and experienced volunteers.');
echo('<p>Position type:');
// $ts = $types;
echo('<span style="font-size:x-small;color:FF0000">*</span> (check one or more)<p>');

foreach ($types as $key => $value) {
    echo ('&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="type[]" value=' . $key);
    if (in_array($key,$person->get_type()) !== false)
        echo(' CHECKED');
    echo ('>' . $value );
    if ($_SESSION['access_level']==0)
    	echo $descriptions[$key].'<p>';
}

if ($_SESSION['access_level']==0)
	echo '<p>House volunteer shifts are three hours and regularly-scheduled shifts can occur weekly, bi-weekly, 
        or monthly (for weekend shifts). Volunteers may also work flex shifts, filling in as their schedule allows.';
?>

    <fieldset id='availability'>
        <legend>Availability:<span style="font-size:x-small;color:FF0000">*</span>  </legend>
        <span class="bigTable">
                <?PHP
                $shifts = array('9-12' => '9-12', '12-3' => '12-3', '3-6' => '3-6',
                    '6-9' => '6-9', 'night' => "night");
                $satshiftsportland = array('9-12'=>'10-1', '12-3' => '1-4', '3-6' => '',
                    '6-9' => '', 'night' => "night");
                $sunshiftsportland = array('9-12' => '9-12', '12-3' => '2-5', '3-6' => '',
                    '6-9' => '5-9', 'night' => "");
                $satshiftsbangor = array('9-12'=>'9-5', '12-3' => '', '3-6' => '',
                    '6-9' => '', 'night' => "night");
                $sunshiftsbangor = array('9-12' => '9-5', '12-3' => '', '3-6' => '',
                    '6-9' => '5-9', 'night' => "");
                if ($_SESSION['venue']=="portland") {
                	$satshifts = $satshiftsportland;
                	$sunshifts = $sunshiftsportland;
                }
                else {
                	$satshifts = $satshiftsbangor;
                	$sunshifts = $sunshiftsbangor;
                }
                $days = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
                echo "<table>";
    			echo "<tr><td>Monday&nbsp;&nbsp;</td><td>Tuesday&nbsp;&nbsp;</td><td>Wednesday&nbsp;&nbsp;</td>".
					"<td>Thursday&nbsp;&nbsp;</td><td>Friday&nbsp;&nbsp;</td><td>Saturday&nbsp;&nbsp;</td><td>Sunday</td></tr>";
    			foreach ($shifts as $shift => $shiftvalue) {
       				echo ('<tr>');
       				foreach ($days as $day) {
       			      if ($day=="Sat") 
    	  					$shiftdisplay=$satshifts[$shift];
       			      else if ($day=="Sun")
    	  					$shiftdisplay=$sunshifts[$shift];
    	  			  else $shiftdisplay=$shiftvalue;
    	  			  if (($shift!="night" || $day=="Fri" || $day=="Sat") && $shiftdisplay!="") {
       					$realkey = $day . ":". $shiftdisplay. ":". $person->get_venue();
       	  				echo ('<td><input type="checkbox" name="availability[]" value="' . $realkey . '"');
    	  				if (in_array($realkey, $person->get_availability())) echo(' CHECKED');
    	  				echo ('>');
    	  				echo " ".$shiftdisplay.'</td>';
       			      }
       				  else echo "<td></td>";
       				}
       				echo ('</tr>');
    			}
   		 		echo "</table><p>";
    			?>
        </span>
    </fieldset>
    <p>
        <?PHP
        if ($_SESSION['access_level']==2 && $person->get_status() == "applicant") {
            echo "<fieldset>";
            echo "<legend>Applicants only: </legend>";
			if ($_SESSION['access_level'] == 2) {
            	$screeningType = $person->get_screening_type();
                $screening = retrieve_dbApplicantScreenings($screeningType);
                $screenings = getall_ApplicantScreenings();
                echo('<p> Screening Type:&nbsp; <select name="screening_type">');
                if ($person->get_screening_type() == "")
                    echo('<option value="" SELECTED></option>');
                foreach ($screenings as $s) {
                    if ($s->get_status() == "published") {
                        $t = $s->get_type();
                        if ($screeningType == $t) {
                            echo('<option value ="' . $t . '" SELECTED>' . $t . '</option>');
                        } else {
                            echo('<option value ="' . $t . '"> ' . $t . '</option>');
                        }
                    }
                }
                echo('</select>&nbsp;');

                // submit button that allows manager to associate person with applicant screening
                //echo(' Hit <input type="submit" value="submit" name="Submit Edits"> to associate '.$person->get_first_name().' with this screening.<br><br>');

                if ($screening) {
                    $step_array = $screening->get_steps();
                    $date_array = $person->get_screening_status();
                    $step_count = count($step_array);
                
                echo("<p><table>");
                echo('<tr><td>Completion Date</td> <td>Step</td></tr>');
                for ($i = 0; $i < $step_count; $i++) {
                    $j = $i + 1;
                    echo "<tr><td>";
                    echo('<tr><td><input type="text" id="screening_status" name="screening_status[]" value="'.$date_array[$i]. '" size="8" /></td>');
                    echo('</td><td>' . $j . '. ' . $step_array[$i] . '</td></tr>');
                }
                echo('</table>');
                }
			}    
            echo "</fieldset>";
        }
        
        echo('<input type="hidden" name="schedule" value="' . implode(',', $person->get_schedule()) . '">');
        echo('<input type="hidden" name="hours" value="' . implode(',', $person->get_hours()) . '">');
        echo('<input type="hidden" name="password" value="' . $person->get_password() . ')">');
        echo('<input type="hidden" name="_submit_check" value="1"><p>');
        if ($_SESSION['access_level'] == 0)
            echo('By hitting <input type="submit" value="Submit" name="Submit Edits">, I understand the importance of this volunteer 
            		commitment and have answered the application questions honestly and to the best of my knowledge.<br /><br />');
        else
            echo('Hit <input type="submit" value="Submit" name="Submit Edits"> to submit these edits.<br /><br />');
        if ($id != 'new' && $_SESSION['access_level'] >= 2) {
            echo ('<input type="checkbox" name="deleteMe" value="DELETE"> Check this box and then hit ' .
            '<input type="submit" value="Delete" name="Delete Entry"> to delete this entry. <br />' .
            '<input type="checkbox" name="reset_pass" value="RESET"> Check this box and then hit ' .
            '<input type="submit" value="Reset Password" name="Reset Password"> to reset this person\'s password.</p>');
        }
        ?>
</form>