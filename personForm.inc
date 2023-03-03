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

/*
 * Modified for Gwyneth's Gift website, 2022
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
				// $( "#birthday" ).datepicker({dateFormat: 'y-mm-dd',changeMonth:true,changeYear:true,yearRange: "1920:+nn"});
				// $( "#start_date" ).datepicker({dateFormat: 'y-mm-dd',changeMonth:true,changeYear:true,yearRange: "1920:+nn"});
			})
	</script>
    <?PHP 
    	$venues = array('portland'=>"Portland House");       
        echo '<table class="table"><tr><td>Start Date: '. 
	             '</td><td colspan=2>
                 <input type="date" name="start_date" id="start_date" value="' . date('Y-m-d') . '" min="' . date('Y-m-d') . '">
                 <!--<input class="form-control-sm" name="start_date" type="text" id="start_date" value="'.$person->get_start_date().'">-->';
	   	foreach ($venues as $venue=>$venuename) {
	   		echo ('<td><input type="hidden" name="location" value="' .$venue.'"'. ($person->get_venue()==$venue?' checked':'').'>');
	   	}
	   	echo "</tr></table><br>"; 
    ?>
    <fieldset class="row mb-3">
        <legend class="col-sm-2 col-form-label col-form-label-lg">Personal Information:</legend>
    <?php
        if ($newUser)
        	echo '<p>First Name<span style="font-size:x-small;color:FF0000">*</span>: <input class="form-control-sm" type="text" name="first_name" tabindex="1" value="'.$person->get_first_name().'">';
        else 
        	echo '<p>First Name: ' . $person->get_first_name();
    ?>Last Name<span style="font-size:x-small;color:FF0000">*</span>: <input class="form-control-sm" type="text" name="last_name" tabindex="2" value="<?PHP echo($person->get_last_name()) ?>">
        <p>Address<span style="font-size:x-small;color:FF0000">*</span>: <input class="form-control-sm" type="text" name="address" tabindex="3" size=40 value="<?PHP echo($person->get_address()) ?>">
        <p>City<span style="font-size:x-small;color:FF0000">*</span>: <input class="form-control-sm" type="text" name="city" tabindex="4" value="<?PHP echo($person->get_city()) ?>">
        State:<span style="font-size:x-small;color:FF0000">*</span>
            <select class="form-select-sm" name="state" tabindex="5">
<?PHP
$states = array("AL", "AK", "AZ", "AR", "CA", "CO", "CT", "DE", "DC", "FL", "GA", "HI", "ID", "IL", "IN", "IA",
    "KS", "KY", "LA", "ME", "MD", "MA", "MI", "MN", "MS", "MO", "MT", "NE", "NV", "NH", "NJ", "NM",
    "NY", "NC", "ND", "OH", "OK", "OR", "PA", "RI", "SC", "SD", "TN", "TX", "UT", "VT", "VA", "WA",
    "WV", "WI", "WY");
foreach ($states as $st) {
    echo "<option value='" . $st . "' ";
    if ($person->get_state() == $st)
        echo("SELECTED");
    else if ($id == "new" && $st == "VA")
        echo("SELECTED");
    echo ">" . $st . "</option>";
}
?>
</select>

<label for="">Zipcode:</label><input class="form-control-sm" type="text" name="zip" size="5" tabindex="6" value="<?PHP echo($person->get_zip()) ?>">
<?php     
        $phonetypes = array("Home", "Cell", "Work");
        if ($newUser) {
        	echo '<p>Primary Phone<span style="font-size:x-small;color:FF0000">*</span>: ';
        	echo '<input class="form-control-sm" type="text" name="phone1" MAXLENGTH=12 tabindex="7" value="'.phone_edit($person->get_phone1()).'">';
        	foreach ($phonetypes as $pvalue)
        		echo '<input class="form-check-input" type="radio" name="phone1type" value="'.$pvalue.'"'.($person->get_phone1type()==$pvalue?' checked':'').'>'.$pvalue.' ';
        }
        else echo '<p>Primary Phone: '.phone_edit($person->get_phone1()) . '</p>';

        // Nice to have if a secondary phone is added back in
        //echo '<p>Secondary Phone: ';
        //echo '<input type="text" name="phone2" MAXLENGTH=12 tabindex="8" value="'.phone_edit($person->get_phone2()).'">';
        //foreach ($phonetypes as $pvalue)
        //	echo '<input type="radio" name="phone2type" value="'.$pvalue.'"'.($person->get_phone2type()==$pvalue?" checked":"").'>'.$pvalue.' ';
        
        echo '<p>Birth date: <input type="date" id="birthday" name="birthday" value="' .$person->get_birthday() .'">';
        echo '<p>Email address<span style="font-size:x-small;color:FF0000">*</span>: '. '<input class="form-control-sm" type="email" name="email" tabindex="9" value="'.$person->get_email().'">';
        echo '<p>What is the best time to contact you: '. '<input class="form-control-sm" type="text" name="contact_time" tabindex="10" value="'.$person->get_contact_time().'">';
        echo "<p>What is the best way to contact you? ";
        echo '<p><input class="form-check-input" type="radio" name="cMethod" value="Phone" '.($person->get_cMethod()=="Phone"?"checked":"").'>Phone'.
		    '&nbsp;&nbsp;<input class="form-check-input" type="radio" name="cMethod" value="Email" '.($person->get_cMethod()=="Email"?"checked":"").'>Email'.
            '&nbsp;&nbsp;<input class="form-check-input" type="radio" name="cMethod" value="Text" '.($person->get_cMethod()=="Text"?"checked":"").'>Text';
?>
<script src="lib/jquery-1.9.1.js"></script>
<script src="lib/jquery-ui.js"></script>
</fieldset>

<?php 		  
if ($_SESSION['access_level']==2) {
	echo('<p>Manager Notes:<br />');
	echo('<textarea class="form-control-sm" name="notes" rows="2" cols="75">');
	echo($person->get_notes().'</textarea>');
}


echo '</fieldset>';


echo '<fieldset class="row mb-3"> <legend class="col-sm-2 col-form-label col-form-label-lg">Volunteer Information:</legend>';

// dropdown for t shirt size
echo ('<p>Shirt Size:');
echo('<span style="font-size:x-small;color:FF0000">*</span>&nbsp;&nbsp;');
echo('<select class="form-select-sm" name="shirt size">');

	echo ('<option value="S"');
	if ($person->get_shirt_size() == 'S')
    	echo (' SELECTED'); 
    echo('>S</option>'); // default
    echo ('<option value="M"');
	if ($person->get_shirt_size() == 'M')
	    echo (' SELECTED'); echo('>M</option>');
	echo ('<option value="L"');
	if ($person->get_shirt_size()== 'L')
	    echo (' SELECTED'); echo('>L</option>');
	echo ('<option value="XL"');
	if ($person->get_shirt_size() == 'XL')
	    echo (' SELECTED'); echo('>XL</option>');
    echo ('<option value="XXL"');
    if ($person->get_shirt_size() == 'XXL')
	    echo (' SELECTED'); echo('>XXL</option>');

echo('</select>');

// radio for computer
echo "<p>Do you own a computer? ";
echo('<span style="font-size:x-small;color:FF0000">*</span>&nbsp;&nbsp;');
echo '<p><input class="form-check-input" type="radio" name="computer" value="Yes" '.($person->get_computer()=="Yes"?"checked":"").'>Yes'.
		'&nbsp;&nbsp;<input class="form-check-input" type="radio" name="computer" value="No" '.($person->get_computer()=="No"?"checked":"").'>No';

// radio for camera
echo "<p>Do you own a camera? ";
echo('<span style="font-size:x-small;color:FF0000">*</span>&nbsp;&nbsp;');
echo '<p><input class="form-check-input" type="radio" name="camera" value="Yes" '.($person->get_camera()=="Yes"?"checked":"").'>Yes'.
		'&nbsp;&nbsp;<input class="form-check-input" type="radio" name="camera" value="No" '.($person->get_camera()=="No"?"checked":"").'>No';

// radio for transportation
echo "<p>Do you have reliable transportation? ";
echo('<span style="font-size:x-small;color:FF0000">*</span>&nbsp;&nbsp;');
echo '<p><input class="form-check-input" type="radio" name="transportation" value="Yes" '.($person->get_transportation()=="Yes"?"checked":"").'>Yes'.
		'&nbsp;&nbsp;<input class="form-check-input" type="radio" name="transportation" value="No" '.($person->get_transportation()=="No"?"checked":"").'>No';


echo('<p><b>Emergency contact information: </b>');

echo '<p>Emergency contact name<span style="font-size:x-small;color:FF0000">*</span>: '. '<input class="form-control-sm" type="text" name="contact_name" tabindex="1" value="'.$person->get_contact_name().'">';
echo '<p>Emergency contact number<span style="font-size:x-small;color:FF0000">*</span>: '. '<input class="form-control-sm" type="text" name="contact_num" tabindex="2" value=" '.$person->get_contact_num().'">';

// dropdown for emergency contact relation
echo ('<p>What is your relationship to the emergency contact<span style="font-size:x-small;color:FF0000">*</span>: ');
echo('<select class="form-select-sm" name="relation">');

echo ('<option value="Relative"');
if ($person->get_relation() == 'Relative')
    echo (' SELECTED'); 
echo('>Relative</option>'); // default
echo ('<option value="Parent"');
if ($person->get_relation() == 'Parent')
    echo (' SELECTED'); echo('>Parent</option>');
echo ('<option value="Spouse"');
if ($person->get_relation()== 'Spouse')
    echo (' SELECTED'); echo('>Spouse</option>');
echo ('<option value="Friend"');
if ($person->get_relation() == 'Friend')
    echo (' SELECTED'); echo('>Friend</option>');
echo ('<option value="Other"');
if ($person->get_relation() == 'Other')
    echo (' SELECTED'); echo('>Other</option>');

echo('</select>');


echo "<p><b>How did you hear about Gwyneth's Gift? </b>";
echo '<p><input class="form-check-input" type="radio" name="howdidyouhear" value="internet" '.($person->get_howdidyouhear()=="internet"?"checked":"").'>Internet search or website'.
		'&nbsp;&nbsp;<input class="form-check-input" type="radio" name="howdidyouhear" value="family" '.($person->get_howdidyouhear()=="family"?"checked":"").'>Family or friend'.
		'&nbsp;&nbsp;<input class="form-check-input" type="radio" name="howdidyouhear" value="volunteer" '.($person->get_howdidyouhear()=="volunteer"?"checked":"").'>Current volunteer'.
		'&nbsp;&nbsp;<input class="form-check-input" type="radio" name="howdidyouhear" value="other" '.($person->get_howdidyouhear()=="other"?"checked":"").'>other';


echo('<p>Please list special skills or training you would like us to know about:<br />');
echo('<textarea class="form-control-sm" name="specialties" rows="3" cols="75">');
echo($person->get_specialties());
echo('</textarea>');

echo '</fieldset>';

echo ('<p>Status:');
echo('<span style="font-size:x-small;color:FF0000">*</span>&nbsp;&nbsp;');
echo('<select class="form-select-sm" name="status">');
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


// only managers can see the manager position type option
if ($_SESSION['access_level'] == 2) {
    // $st = implode(',', $person->get_type());
    $types = array('volunteer' => 'Volunteer', 'manager' => 'Manager');
    echo('<p>Position type:');
    // $ts = $types;
    echo('<span style="font-size:x-small;color:FF0000">*</span><p>');
    
    foreach ($types as $key => $value) {
        echo ('&nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="type[]" value=' . $key);
        if (in_array($key,$person->get_type()) !== false)
            echo(' CHECKED');
        echo ('>' . $value );

    }
}
    
// volunteers can only see the volunteer option
if ($_SESSION['access_level'] <= 1) {
        $types = array('volunteer' => 'Volunteer');
        // keeping this here, can be used to add descriptions to the jobs, related lines commented out below
        //$descriptions = array('volunteer' => ' *insert job description here <p>',  
                //'manager' => ' *insert job description here');
        echo('<p>Position type:');
        // $ts = $types;
        echo('<span style="font-size:x-small;color:FF0000">*</span><p>');
        
        foreach ($types as $key => $value) {
            // set volunteer position to be checked automatically, will need to be changed if adding new position types
            echo ('&nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" checked name="type[]" value=' . $key);
            if (in_array($key,$person->get_type()) !== false)
                echo(' CHECKED');
            echo ('>' . $value );
            //if ($_SESSION['access_level']==0)
               // echo $descriptions[$key].'<p>';
        }
}

?>

    <fieldset class="row mb-3" id='availability'>
        <legend class="col-sm-2 col-form-label col-form-label-lg">Availability:<span style="font-size:x-small;color:FF0000">*</span>  </legend>
        <span class="bigTable">
                <?PHP
            $shifts = array('9-12' => '9-12', '12-3' => '12-3', '3-6' => '3-6',
                '6-9' => '6-9');
            $days = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
                echo "<table class='table'>";
                echo "<tr><td>Monday&nbsp;&nbsp;</td><td>Tuesday&nbsp;&nbsp;</td><td>Wednesday&nbsp;&nbsp;</td>".
                "<td>Thursday&nbsp;&nbsp;</td><td>Friday&nbsp;&nbsp;</td><td>Saturday&nbsp;&nbsp;</td><td>Sunday</td></tr>";
            foreach ($shifts as $shift => $shiftvalue) {
                   echo ('<tr>');
                   foreach ($days as $day) {
                     $shiftdisplay=$shiftvalue;
                    //some stuff here is redundant, left over from old version w/ weekends having different hours
                    if (($shift!="night" || $day=="Fri" || $day=="Sat") && $shiftdisplay!="") {
                       $realkey = $day . ":". $shiftdisplay. ":". $person->get_venue();
                         echo ('<td><input class="form-check-input" type="checkbox" name="availability[]" value="' . $realkey . '"');
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

        //change password - only volunteers here       
        if ($_SESSION['access_level'] == 1) {
            if ($id != 'new' ) { 

                echo "<fieldset>";
                echo "<legend>Change Password: </legend>";
                echo('<p>Click <strong><a href="changePassword.php">here</a></strong> to change your password</p>');
                echo '</fieldset>';
            }

        }

        //if you would like to add the ability for managers to change their own password but not other's on profile page
        /*
        if ($_SESSION['access_level'] == 2 && $_SESSION['_id'] == $person->get_id()) {
            if ($id != 'new' ) { 

                echo "<fieldset>";
                echo "<legend>Change Password: </legend>";
                echo('<p>Click <strong><a href="changePassword.php">here</a></strong> to change your password</p>');
                echo '</fieldset>';
            }

        }//end change password
        */

        echo('<br>');

        echo('<input type="hidden" name="schedule" value="' . implode(',', $person->get_schedule()) . '">');
        echo('<input type="hidden" name="hours" value="' . implode(',', $person->get_hours()) . '">');
        echo('<input type="hidden" name="password" value="' . $person->get_password() . ')">');
        echo('<input type="hidden" name="_submit_check" value="1"><p>');
        if ($_SESSION['access_level'] == 0)
            echo('By hitting <input type="submit" value="Submit" name="Submit Edits">, I understand the importance of this volunteer 
            		commitment and have answered the application questions honestly and to the best of my knowledge.<br /><br />');
        else
            echo('<input class="btn btn-success" type="submit" value="Submit" name="Submit Edits"><br /><br />');
        if ($id != 'new' && $_SESSION['access_level'] >= 2) {
            echo ('<input type="checkbox" name="deleteMe" value="DELETE"> Check this box and then hit ' .
            '<input type="submit" value="Delete" name="Delete Entry"> to delete this entry. <br />' .
            '<input type="checkbox" name="reset_pass" value="RESET"> Check this box and then hit ' .
            '<input type="submit" value="Reset Password" name="Reset Password"> to reset this person\'s password.</p>');
            
        }
        ?>
</form>