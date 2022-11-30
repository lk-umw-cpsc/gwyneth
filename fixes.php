<?php




// delete managers -
// replace around lines 197 - 225 with this in file personEdit.php

if ($_POST['deleteMe'] == "DELETE") {
                        $result = retrieve_person($id);
                        if (!$result)
                            echo('<p>Unable to delete. ' . $first_name . ' ' . $last_name . ' is not in the database. <br>Please report this error to the House Manager.');
                        else {
                            /*//What if they're the last remaining manager account?
                            if (strpos($type, 'manager') !== false) {
                                //They're a manager, we need to check that they can be deleted
                                $managers = getall_type('manager');
                                //if (!$managers || mysqli_num_rows($managers) <= 1 || $id=="Allen7037298111" || $id==$_SESSION['id'])
                                if ($id=="Allen7037298111")
                                    echo('<p class="error">You cannot remove this manager from the database.</p>');*/
                            //We don't want to be able to delete all managers
                            if($id == "Admin7037806282" || $id == "GwynethsGiftAdmin5403160356")
                                echo('<p class="error">You cannot remove this manager from the database.</p>');
                             else {
                                $result = remove_person($id);
                                echo("<p>You have successfully removed " . $first_name . " " . $last_name . " from the database.</p>");
                                if ($id == $_SESSION['_id']) {
                                    session_unset();
                                    session_destroy();
                                }
                            }
                        }
                    }



// applicants availability saves bug fix
// add these two lines at 24 - 25 in personEdit.php
    
    // for new applicants set the venue to portland so all their info saves, leftover from 2 calendar system, Gwyneth's Gift is working off of Portland
    $_SESSION['venue']="portland";





//better availability options
// replace around lines 387 - 428 in personForm.inc
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



// blank position type fix 
// replace around lines 360 - 376 in personForm.inc

                    if ($_SESSION['access_level'] == 2) {
                        // $st = implode(',', $person->get_type());
                        $types = array('volunteer' => 'Volunteer', 'manager' => 'Manager');
                        $descriptions = array('volunteer' => ' *insert job description here <p>', 
                                
                                'manager' => ' *insert job description here');
                        echo('<p>Position type:');
                        // $ts = $types;
                        echo('<span style="font-size:x-small;color:FF0000">*</span><p>');
                        
                        foreach ($types as $key => $value) {
                            echo ('&nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" name="type[]" value=' . $key);
                            if (in_array($key,$person->get_type()) !== false)
                                echo(' CHECKED');
                            echo ('>' . $value );
                            if ($_SESSION['access_level']==0)
                                echo $descriptions[$key].'<p>';
                        }
                        }
                        
                        if ($_SESSION['access_level'] <= 1) {
                            $types = array('volunteer' => 'Volunteer');
                            // keeping this here, can be used to add descriptions to the jobs, related lines commented out below
                            //$descriptions = array('volunteer' => ' *insert job description here <p>', 
                                    
                                    //'manager' => ' *insert job description here');
                            echo('<p>Position type:');
                            // $ts = $types;
                            echo('<span style="font-size:x-small;color:FF0000">*</span><p>');
                            
                            foreach ($types as $key => $value) {
                                echo ('&nbsp;&nbsp;&nbsp;&nbsp;<input class="form-check-input" type="radio" checked name="type[]" value=' . $key);
                                if (in_array($key,$person->get_type()) !== false)
                                    echo(' CHECKED');
                                echo ('>' . $value );
                                //if ($_SESSION['access_level']==0)
                                   // echo $descriptions[$key].'<p>';
                            }
                            }