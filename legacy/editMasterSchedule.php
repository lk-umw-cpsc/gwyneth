<?php
/*
 * Copyright 2013 by ... and Allen Tucker. 
 * This program is part of RMH Homebase, which is free software.  It comes with 
 * absolutely no warranty. You can redistribute and/or modify it under the terms 
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 * 
 */

session_cache_expire(30);
session_start();
?>
<html>
    <head>
        <title>
            Edit Master Schedule Shift
        </title>
        <link rel="stylesheet" href="styles.css" type="text/css" />
    </head>
    <body>
        <div id="container">
            <?PHP include('header.php'); ?>
            <div id="content">
                <?php
                include_once('database/dbMasterSchedule.php');
                include_once('domain/MasterScheduleEntry.php');
                include_once('database/dbShifts.php');
                include_once('database/dbLog.php');
                if ($_SESSION['access_level'] < 2) {
                    die("<p>Only managers can edit the master schedule.</p>");
                }
                $group = $_GET['group'];         // 1st
                $venue = $_GET['venue'];         // portland
                $day = $_GET['day'];             // Mon
                $shiftname = $_GET['shift'];     // 9-12
                $id = $group.":".$day.":".$shiftname.":".$venue;
    			$msentry = retrieve_dbMasterSchedule($id);
                if (!$msentry) {
                    $result = process_add_shift($_POST, $group, $day, $shiftname, $venue);
                    if ($result) {
                        $returnpoint = "viewSchedule.php?venue=" . $venue;
                        echo "<table align=\"center\"><tr><td align=\"center\" width=\"442\">
								<br><a href=\"" . $returnpoint . "\">
								Back to Master Schedule</a></td></tr></table>";
                    }
                    // shouldn't get here ever! 
                    else {
                        echo ("Failed to add a master schedule shift");
                    }
                } else { // if a shift is there, see what we can do to update it
                    if (!process_fill_vacancy($_POST, $msentry) && // try to fill a vacancy
                            !process_add_volunteer($_POST, $msentry) &&
                            !process_remove_shift($_POST, $msentry, $group, $day, $shiftname, $venue)) 
                    { 
                        if (process_unfill_shift($_POST, $msentry, $venue)) {  // try to remove a person
                        } else if (process_add_slot($_POST, $msentry, $venue)) { // try to add a new slot
                        } else if (process_ignore_slot($_POST, $msentry, $venue)) {  //try to remove a slot
                        }
                        // we've tried to clear the shift, add a slot, or remove a slot;
                        // so now display the shift again.
                        $msentry = retrieve_dbMasterSchedule($id);
                        $persons = get_persons($msentry->get_id());
                        // $groupdisplay = $venue . " Group ".$group;
                        echo ("<table align=\"center\" width=\"450\"><tr><td align=\"center\" colspan=\"2\"><b>" . 
                                $msentry->get_name() . 
								"</b>
								<form method=\"POST\" style=\"margin-bottom:0;\">
									<input type=\"hidden\" name=\"_submit_remove_shift\" value=\"1\"><br>
									<input type=\"submit\" value=\"Remove Entire Shift\"
									name=\"submit\">
									</form><br>
								</td></tr>" .
                                "<tr><td valign=\"top\"><br>&nbsp;" . do_slot_num($msentry) . "</td><td>
									<form method=\"POST\" style=\"margin-bottom:0;\">
									<input type=\"hidden\" name=\"_submit_add_slot\" value=\"1\"><br>
									<input type=\"submit\" value=\"Add Slot\"
									name=\"submit\" style=\"width: 250px\">
									</form><br></td></tr>");
                        echo (display_filled_slots($persons)
                        . display_vacant_slots($msentry->get_slots() - count($persons))
                        . "</table>");
                        $returnpoint = "viewSchedule.php?venue=" . $venue;
                        echo "<table align=\"center\"><tr><td align=\"center\" width=\"442\">
									       <br><a href=\"" . $returnpoint . "\">
										   Back to Master Schedule</a></td></tr></table>";
                    }
                }
                ?>
                <br>
             </div>
          <?PHP include('footer.inc'); ?>
        </div>
    </body>
</html>

                <?php
                function process_add_shift($post, $group, $day, $time, $venue) {
                	//if (!array_key_exists('_submit_insert_shift', $post))
                    //    return false;
                    $entry = new MasterScheduleEntry($venue, $day, $group, $time, 0, "", "");
                    insert_dbMasterSchedule($entry);
                    if ($error) {
                        echo $error;
                        return false;
                    } else {
                        //$groupdisplay = $venue . " Group ".$group." Time ".$time;
                        echo "Added a master schedule shift <br><br>";
                        add_log_entry('<a href=\"personEdit.php?id=' . $_SESSION['_id'] . '\">' . $_SESSION['f_name'] . ' ' .
                                $_SESSION['l_name'] . '</a> added a new master schedule shift: <a href=\"editMasterSchedule.php?group=' .
                                $group . "&day=" . $day . "&shift=" . $time . "&venue=" . $venue . '\">' . $group . ":" . $day .":" .  $time .":" . $venue .'</a>.');
                        return true;
                    }
                }

                function process_remove_shift($post, $msentry, $group, $day, $time, $venue) {
                    if (!array_key_exists('_submit_remove_shift', $post))
                        return false;
                    if ($msentry->get_id()) {
                    	if (delete_dbMasterSchedule($msentry->get_id())) {
       // the next 3 lines are a 1-time cleanup for the database and should be removed
                    		if (substr($msentry->get_id(),4)=="Sat:9-5:bangor") {
                    			delete_dbMasterSchedule(substr($msentry->get_id(),0,4)."Sat:9-9:bangor");
                    			delete_dbMasterSchedule("1st:Sat:10-1:bangor");
                    		}
                        	echo "<br>Removed a master schedule shift <br><br>";
                        	$returnpoint = "viewSchedule.php?venue=" . $venue;
                        	echo "<table align=\"center\"><tr><td align=\"center\" width=\"442\">
									<a href=\"" . $returnpoint . "\">
									Back to Master Schedule</a></td></tr></table>";
                        	add_log_entry('<a href=\"personEdit.php?id=' . $_SESSION['_id'] . '\">' . $_SESSION['f_name'] . ' ' .
                            		$_SESSION['l_name'] . '</a> deleted a new master schedule shift: <a href=\"editMasterSchedule.php?group=' .
                            		$group . "&day=" . $day . "&shift=" . $time . "&venue=" . $venue . '\">' . $group . ":" . $day .":" .  $time .":" . $venue .'</a>.');
                        	return true;
                    	}
                    }
                    return false;
                }

                function do_slot_num($msentry) {
                    $slots = $msentry->get_slots();
                    if ($slots == 1)
                        return "1 slot for this shift:";
                    return $slots . " slots for this shift:";
                }

                function display_filled_slots($persons) {
                    $s = "";
                    if (!$persons[0])
                        array_shift($persons);
                    for ($i = 0; $i < count($persons); ++$i) {
                        $p = $persons[$i];
                        if (is_array($persons[$i]))
                            $p = $persons[$i]['first_name'] . " " . $persons[$i]['last_name'];
                        $s = $s . "<tr><td width=\"150\" valign=\"top\"><br>&nbsp;" . $p . "</td><td>
				<form method=\"POST\" style=\"margin-bottom:0;\">
				<input type=\"hidden\" name=\"_submit_filled_slot_" . $i . "\" value=\"1\"><br>
				<input type=\"submit\" value=\"Remove Person / Create Vacancy\" name=\"submit\" style=\"width: 250px\">
			</form><br></td></tr>";
                    }
                    return $s;
                }

                function display_vacant_slots($vacancies) {
                    $s = "";
                    for ($i = 0; $i < $vacancies; ++$i) {
                        $s = $s . "<tr><td width=\"150\" valign=\"top\"><br>&nbsp;<b>vacant</b></td><td>
				<form method=\"POST\" style=\"margin-bottom:0;\">
				<input type=\"hidden\" name=\"_submit_fill_vacancy\" value=\"1\"><br>
				<input type=\"submit\" value=\"Assign Volunteer\" name=\"submit\" style=\"width: 250px\"></form>
				<form method=\"POST\" style=\"margin-bottom:0;\">
				<input type=\"hidden\" name=\"_submit_ignore_vacancy\" value=\"1\">
				<input type=\"submit\" value=\"Remove Vacant Slot\" name=\"submit\" style=\"width: 250px\"></form>
				<br></td></tr>";
                    }
                    return $s;
                }

                function process_fill_vacancy($post, $msentry) {
                	$venues = array("portland"=>"RMH Portland", "bangor"=>"RMH Bangor");
                	if (!array_key_exists('_submit_fill_vacancy', $post))
                        return false;
                    echo "<table align=\"center\"><tr><td align=\"center\" width=\"450\"><b>
		Filling a vacancy for " . $msentry->get_name() . "
		</b></td></tr>
		<tr><td><form method=\"POST\" style=\"margin-bottom:0;\">
			<select name=\"scheduled_vol\">
			<option value=\"0\" style=\"width: 371px;\">Select an active volunteer with this availability</option>"
                    . get_available_volunteer_options($msentry, get_persons($msentry->get_id())) .
                    "</select><br><br>
			<select name=\"all_vol\">
			<option value=\"0\" style=\"width: 371px;\">Select from all active volunteers</option>"
                    . get_all_volunteer_options(get_persons($msentry->get_id()), $msentry->get_venue()) .
                    "</select><br><br>
			<input type=\"hidden\" name=\"_submit_add_volunteer\" value=\"1\">
			<input type=\"submit\" value=\"Add Volunteer\" name=\"submit\" style=\"width: 400px\">
			</form></td></tr>";
                    echo "</table>";
                    echo "<table align=\"center\"><tr><td align=\"center\" width=\"450\">
		<a href=\"editMasterSchedule.php?group=" . $msentry->get_week_no() . "&day=" . $msentry->get_day() . "&shift=" . $msentry->get_hours() . "&venue=" . $msentry->get_venue() . "\">Back to Shift</a><br></td></tr></table>";
                    return true;

                    // check that person is not already working that shift
                    // check that person is available
                }

                function process_unfill_shift($post, $msentry) {
                    $persons = get_persons($msentry->get_id());
                    if (!$persons[0])
                        array_shift($persons);
                    for ($i = 0; $i < count($persons); ++$i) {
                    	if (array_key_exists('_submit_filled_slot_' . $i, $post)) {
                    		if (is_array($persons[$i])) {
                                unschedule_person($msentry, $persons[$i]['id']);
                                remove_from_future_shifts($persons[$i]['id']);
                    		}
                            else {
                                unschedule_person($msentry, $persons[$i]);
                            	remove_from_future_shifts($persons[$i]);
                            }
							return true;
                        }
                    }
                    return false;
                }

                function process_add_slot($post, $msentry, $venue) {
                    if (array_key_exists('_submit_add_slot', $post)) {
                        edit_schedule_vacancy($msentry, 1);
                        return true;
                    }
                    return false;
                }

                function process_ignore_slot($post, $msentry, $venue) {
                    if (array_key_exists('_submit_ignore_vacancy', $post)) {
                        edit_schedule_vacancy($msentry, -1);
                        return true;
                    }
                    return false;
                }

                function get_available_volunteer_options($msentry, $persons) {
                    if (!$persons[0])
                        array_shift($persons);
                    $con=connect();
                    $chrtime =  $msentry ->get_day() . ":" . $msentry->get_hours().":".$msentry->get_venue();

                    $query = "SELECT * FROM dbPersons WHERE status = 'active' " .
                            "AND availability LIKE '%" . $chrtime . "%' ORDER BY last_name,first_name";
                    $result = mysqli_query($con,$query);
                    mysqli_close($con);
                    $s = "";
                    for ($i = 0; $i < mysqli_num_rows($result); ++$i) {
                        $row = mysqli_fetch_row($result);
                        $value = $row[0];
                        $label = $row[4] . ", " . $row[3];
                        $match = false;
                        for ($j = 0; $j < count($persons); ++$j) {
                            if ($value == $persons[$j]['id']) {
                                $match = true;
                            }
                        }
                        if (!$match) {
                            $s = $s . "<option value=\"" . $value . "\">" . $label . "</option>";
                            $match = false;
                        }
                    }
                    return $s;
                }

                function get_all_volunteer_options($persons, $venue) {
                    if (!$persons[0])
                        array_shift($persons);
                    $con=connect();
                    $query = "SELECT * FROM dbPersons WHERE status = 'active' " .
                    	"AND availability LIKE '%" . $venue . "%' ORDER BY last_name,first_name";
                    $result = mysqli_query($con,$query);
                    mysqli_close($con);
                    $s = "";
                    for ($i = 0; $i < mysqli_num_rows($result); ++$i) {
                        $row = mysqli_fetch_row($result);
                        $value = $row[0];
                        $label = $row[4] . ", " . $row[3];
                        $match = false;
                        for ($j = 0; $j < count($persons); ++$j) {
                            if ($value == $persons[$j]['id']) {
                                $match = true;
                            }
                        }
                        if (!$match) {
                            $s = $s . "<option value=\"" . $value . "\">" . $label . "</option>";
                            $match = false;
                        }
                    }
                    return $s;
                }

                function process_add_volunteer($post, $msentry) {
                    if (!array_key_exists('_submit_add_volunteer', $post))
                        return false;
                    if ($post['all_vol'] == "0" && $post['scheduled_vol'] == "0")
                        $error = "<table align=\"center\"><tr><td width=\"400\">
				You must select a volunteer.</td></tr></table><br>";
                    else if ($post['all_vol'] == "0")
                        $vol = $post['scheduled_vol'];
                    else
                        $vol = $post['all_vol'];
                    if ($error) {
                        echo $error;
                        return true;
                    } else {
                        schedule_person($msentry, $vol);
                        return false;
                    }
                }
              
 ?>
