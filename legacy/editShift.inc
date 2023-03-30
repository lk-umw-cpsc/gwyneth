<?php
/*
 * Copyright 2013 by Jerrick Hoang, Ivy Xing, Sam Roberts, James Cook,old_s_id
 * Johnny Coster, Judy Yang, Jackson Moniaga, Oliver Radwan, 
 * Maxwell Palmer, Nolan McNair, Taylor Talmage, and Allen Tucker. 
 * This program is part of RMH Homebase, which is free software.  It comes with 
 * absolutely no warranty. You can redistribute and/or modify it under the terms 
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 * 
 */

/*
 * Created on Oct 24, 2009
 * @author allen
 */
include_once('database/dbShifts.php');
include_once('database/dbPersons.php');
include_once('database/dbSCL.php');
include_once('database/dbLog.php');

	function do_slot_num($persons, $vacancies) {
		if(!$persons[0])
			array_shift($persons);
		if ($vacancies < 0) $vacancies = 0;  // this is a kluge
		$slots=count($persons)+$vacancies;
		if($slots==1)
			return "1 slot for this shift:";
		return $slots." slots for this shift:";
	}

	function display_filled_slots($persons) {
		$s="";
		if(!$persons[0])
			array_shift($persons);
		for($i=0;$i<count($persons);++$i) {
			$p=explode("+",$persons[$i]);
			$s=$s."<tr><td width=\"150\" valign=\"top\"><br>&nbsp;".$p[1]." ".$p[2]."</td><td>
				<form method=\"POST\" style=\"margin-bottom:0;\">
				<input type=\"hidden\" name=\"_submit_filled_slot_".$i."\" value=\"1\"><br>
				<input type=\"submit\" value=\"Remove Person\" name=\"submit\" style=\"width: 150px\">
			</form><br></td></tr>";
		}
		return $s;
	}

	function display_vacant_slots($vacancies) {
		$s="";
		for($i=0;$i<$vacancies;++$i) {
			$s=$s."<tr><td width=\"150\" valign=\"top\"><br>&nbsp;<b>vacancy</b></td><td>
				<form method=\"POST\" style=\"margin-bottom:0;\">
				<input type=\"hidden\" name=\"_submit_fill_vacancy\" value=\"1\"><br>
				<input type=\"submit\" value=\"Assign Volunteer\" name=\"submit\" style=\"width: 150px\"></form>";
			if($_SESSION['access_level']>=2) {
 				$s=$s."<form method=\"POST\" style=\"margin-bottom:0;\">
				<input type=\"hidden\" name=\"_submit_ignore_vacancy\" value=\"1\">
				<input type=\"submit\" value=\"Remove Vacancy\" name=\"submit\" style=\"width: 150px\"></form>";
			}
			$s=$s."<br></td></tr>";
		}
		return $s;
	}
	function process_fill_vacancy($post,$shift,$venue) {
		if(!array_key_exists('_submit_fill_vacancy',$post))
			return false;
		$shiftid=$shift->get_id();
		$shifttime = $shift->get_time_of_day();
		echo "<br><br><table align=\"center\"><tr><td align=\"center\" width=\"400\"><b>"
			.get_shift_name_from_id($shiftid)."</b></td></tr>
		<tr><td><form method=\"POST\" style=\"margin-bottom:0;\">
			<select name=\"scheduled_vol\">
			<option value=\"0\" style=\"width: 371px;\">Select an active volunteer with this availability</option>"
			.get_available_volunteer_options($shifttime,$shift->get_day(),$shift->get_persons(),$venue).
			"</select><br>
			<br>or<br><br>
			<select name=\"all_vol\">
			<option value=\"0\" style=\"width: 371px;\">Select from all active volunteers for this venue</option>"
			.get_all_volunteer_options("","",$shift->get_persons(),$venue).
			"</select><br><br>
			<input type=\"hidden\" name=\"_submit_add_volunteer\" value=\"1\">
			<input type=\"submit\" value=\"Add Volunteer\" name=\"submit\" style=\"width: 400px\">
			</form></td></tr>";
		echo "</table>";
		echo "<table align=\"center\"><tr><td align=\"center\" width=\"400\">
		&nbsp;<a href=\"editShift.php?shift=".$shift->get_yy_mm_dd().":".$shift->get_hours().
		              "&venue=".$venue."\">Back to Shift</a><br></td></tr></table>";
		return true;

		// check that person is not already working that shift
		// check that person is available
	}

	function process_add_volunteer($post,$shift,$venue) {
		update_dbShifts($shift);
		if(!array_key_exists('_submit_add_volunteer',$post))
			return false;
		if($post['all_vol']=="0" && $post['scheduled_vol']=="0")
			$error="<table align=\"center\"><tr><td width=\"400\">
				You must select a volunteer from one of the menus.</td></tr></table><br>";
		else if($post['all_vol']!="0" && $post['scheduled_vol']!="0")
			$error="<table align=\"center\"><tr><td width=\"400\">
				You have selected a volunteer from both menus.  Please choose only one.</td></tr></table><br>";
		else {
			$vol=$post['scheduled_vol'];
			if($vol=="0")
				$vol=$post['all_vol'];
			$persons=$shift->get_persons();
		}
		if($error) {
			echo $error;
			return true;
		}
		else {
			$persons[]=$vol;
			$shift->assign_persons($persons);
			$shift->ignore_vacancy();
			fix_SCL($shift);
			update_dbShifts($shift);
			$name=explode("+",$vol);
			add_log_entry('<a href=\"personEdit.php?id='.$_SESSION['_id'].'\">'.$_SESSION['f_name'].' '.
			    $_SESSION['l_name'].'</a> assigned <a href=\"personEdit.php?id='.$name[0].'\">'.$name[1].' '.$name[2].'</a> to the shift: <a href=\"editShift.php?shift='.
			    $shift->get_id().'\">'.get_shift_name_from_id($shift->get_id()).'</a>.');
			return false;
		}
	}

	function process_unfill_shift($post,$shift,$venue) {
		update_dbShifts($shift);
		$persons=$shift->get_persons();
		if(!$persons[0])
			array_shift($persons);
		for($i=0;$i<count($persons);++$i) {
			$p2 = array();
			if(array_key_exists('_submit_filled_slot_'.$i, $post)) {
				for($j=0;$j<count($persons);++$j) {
					if($i!=$j)
						$p2[]=$persons[$j];
					else
						$name=$persons[$j];
				}
				if(count($p2)==0)
					$p2=array();
				error_log("removing ". $name);
				$shift->assign_persons($p2);
				$shift->add_vacancy();
				fix_SCL($shift);
				if($name)
					$name=explode("+",$name);
				update_dbShifts($shift);
				add_log_entry('<a href=\"personEdit.php?id='.$_SESSION['_id'].'\">'.$_SESSION['f_name'].' '.
				    $_SESSION['l_name'].'</a> removed <a href=\"personEdit.php?id='.$name[0].'\">'.$name[1].' '.$name[2].'</a> from the shift: <a href=\"editShift.php?shift='.
				    $shift->get_id().'\">'.get_shift_name_from_id($shift->get_id()).'</a>.');
				return true;
			}
		}
		return false;
	}
	function process_add_slot($post,$shift,$venue) {
		if(array_key_exists('_submit_add_slot',$post)) {
			$shift->add_vacancy();
			update_dbShifts($shift);
			fix_SCL($shift);
			add_log_entry('<a href=\"personEdit.php?id='.$_SESSION['_id'].'\">'.$_SESSION['f_name'].' '.
			    $_SESSION['l_name'].'</a> added a slot to the shift: <a href=\"editShift.php?shift='.$shift->get_id().'\">'.
			    get_shift_name_from_id($shift->get_id()).'</a>.');
			return true;
		}
		return false;
	}
	function process_clear_shift($post,$shift,$venue) {
		if(array_key_exists('_submit_clear_shift',$post)) {
			if ($shift->has_sub_call_list()) {
				$scl=select_dbSCL($shift->get_id());
				if ($scl instanceof SCL) {
			   		delete_dbSCL($scl);
			   		add_log_entry('<a href=\"personEdit.php?id='.$_SESSION['_id'].'\">'.$_SESSION['f_name'].' '.
			   		    $_SESSION['l_name'].'</a> deleted a <a href=\"subCallList.php?shift='.$shift->get_id().'\">sub call list</a> for the shift: <a href=\"editShift.php?shift='.
			   		    $shift->get_id().'\">'.get_shift_name_from_id($shift->get_id()).'</a>.');
				}
			}
			$shift = new Shift($shift->get_yy_mm_dd().":".$shift->get_hours(), $shift->get_venue(), 
								0, array(),array(), "", "");
			update_dbShifts($shift);
			add_log_entry('<a href=\"personEdit.php?id='.$_SESSION['_id'].'\">'.$_SESSION['f_name'].' '.
			    $_SESSION['l_name'].'</a> cleared the shift: <a href=\"editShift.php?shift='.$shift->get_id().'\">'.
			    get_shift_name_from_id($shift->get_id()).'</a>.');
			return true;
		}
		return false;
	}
    function process_move_shift($post,$shift,$venue) {
        if(!array_key_exists('_submit_move_shift',$post))
    	    return false;
    	echo "<br><br><table align=\"center\" border=\"1px\" style=\"width: 330px\"><tr><td align=\"center\"><b>"
			.get_shift_name_from_id($shift->get_id())."</b></td></tr>
		<tr><td align=\"center\"><form method=\"POST\" style=\"margin-bottom:0;\">
			<select name=\"new_start\">
			<option value=\"0\" >Select a new starting time</option>"
			.get_all_times().
			"</select><br>
			<br>and/or<br><br>
			<select name=\"new_end\">
			<option value=\"0\" >Select a new ending time</option>"
			.get_all_times().
			"</select><br><br>
			<input type=\"hidden\" name=\"_submit_change_times\" value=\"1\">
			<input type=\"submit\" value=\"Change Times\" name=\"submit\"><br><br>
			</form></td></tr>";
		echo "</table>";
		echo "<table align=\"center\"><tr><td align=\"center\" width=\"400\">
		<br><a href=\"editShift.php?shift=".$shift->get_yy_mm_dd().":".$shift->get_hours().
		          "&venue=".$venue.
		           "\">Back to Shift</a><br></td></tr></table>";
		return true;
    }
    
    function get_all_times(){
    	$s="";
		for ($hour=9; $hour < 22; $hour++) {
			$clock = $hour < 12 ? $hour . "am" : $hour -12 . "pm";
			if ($clock == "0pm") $clock = "12pm";
			$s=$s."<option value=\"".$hour."\">".$clock."</option>";
		}
		return $s;
    }

	function process_change_times($post,$shift){
        if(!array_key_exists('_submit_change_times',$post))
			return false;
		if($post['new_start']=="0" && $post['new_end']=="0")
			$error="<table align=\"center\"><tr><td width=\"400\">
				Can't move shift: you must select a new start or end time.</td></tr></table><br>";
		else {
			$error = false;
			$new_start = $post['new_start'];
			$new_end = $post['new_end'];
			if ($new_start=="0")
			   $new_start = $shift->get_start_time();
			if ($new_end=="0")
			   $new_end = $shift->get_end_time();
			if (!move_shift($shift, $new_start, $new_end))
			   $error = "Can't move the shift to an overlapping time.";
		}
		if($error) {
			echo $error;
			return true;
		}
		else {
			add_log_entry('<a href=\"personEdit.php?id='.$_SESSION['_id'].'\">'.$_SESSION['f_name'].' '.
			    $_SESSION['l_name'].'</a> moved the shift: <a href=\"editShift.php?shift='.
			    $shift->get_id().'\">'.get_shift_name_from_id($shift->get_id()).'</a>.');
			return false;
		}
	}

	function process_ignore_slot($post,$shift,$venue) {
		if(array_key_exists('_submit_ignore_vacancy',$post)) {
			$shift->ignore_vacancy();
			update_dbShifts($shift);
			fix_SCL($shift);
			add_log_entry('<a href=\"personEdit.php?id='.$_SESSION['_id'].'\">'.$_SESSION['f_name'].' '.
			    $_SESSION['l_name'].'</a> ignored a vacant slot for the shift: <a href=\"editShift.php?shift='.$shift->get_id().'\">'.
			    get_shift_name_from_id($shift->get_id()).'</a>.');
			return true;
		}
		return false;
	}

	function get_available_volunteer_options($time,$day,$persons,$venue){
		if(!$persons[0])
			array_shift($persons);
		$result = getall_available("volunteer", $day, $time, $venue);
		$s="";
		for($i=0;$i<mysqli_num_rows($result);++$i) {
			$row=mysqli_fetch_row($result);
			$value=$row[0]."+".$row[3]."+".$row[4];
			$label=$row[4].", ".$row[3];
			$match=false;
			for($j=0;$j<count($persons);++$j) {
				if($value==$persons[$j]) {
					$match=true;
				}
			}
			if(!$match) {
				$s=$s."<option value=\"".$value."\">".$label."</option>";
				$match=false;
			}
		}
		return $s;
	}

	function get_all_volunteer_options($time,$day,$persons,$venue) {
		if(!$persons[0])
			array_shift($persons);
		$result = getall_available("volunteer", $day, $time, $venue);
		$s="";
		for($i=0;$i<mysqli_num_rows($result);$i++) {
		  $row=mysqli_fetch_row($result);
		//  if (!strpos($row[15],"manager")) {
			$value=$row[0]."+".$row[3]."+".$row[4];
			$label=$row[4].", ".$row[3];
			$match=false;
			for($j=0;$j<count($persons);++$j) {
				if($value==$persons[$j]) {
					$match=true;
				}
			}
			if(!$match) {
				$s=$s."<option value=\"".$value."\">".$label."</option>";
				$match=false;
			}
		//  }
		}
		return $s;
	}


/*
 * Bring a shift's SCL into agreement with the shift.
 *    close the SCL if the last vacancy is filled, and
 *    reopen the SCL if a new vacancy is created.
 */
	function fix_SCL($shift) {
		if($shift->has_sub_call_list()) {
			$scl=select_dbSCL($shift->get_id());
			if ($scl instanceof SCL) {
			   $scl->set_vacancies($shift->num_vacancies());
			   if ($scl->get_vacancies()==0) {
				  $scl->set_status("closed");
			   }
			   else if($scl->get_status()=="closed") {
				  $scl->set_status("open");
			   }
			   update_dbSCL($scl);
			}
			else $shift->close_sub_call_list();
		}
	}
?>
