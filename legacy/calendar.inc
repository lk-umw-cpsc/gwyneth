<?php
/*
 * Copyright 2013 by Jerrick Hoang, Ivy Xing, Sam Roberts, James Cook, 
 * Johnny Coster, Judy Yang, Jackson Moniaga, Oliver Radwan, 
 * Maxwell Palmer, Nolan McNair, Taylor Talmage, and Allen Tucker. 
 * This program is part of RMH Homebase, which is free software.  It comes with 
 * absolutely no warranty. You can redistribute and/or modify it under the terms 
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 * 
 */

session_start();
session_cache_expire(30);
?>
<!--
        calendar.inc
        @author Max Palmer, Allen Tucker, Sam Roberts, James Cook
        @version 3/26/08, revised 10/3/2013
-->

<?php

/**
 * shows the "previous week"/"next week" menu, if the weeks exist
 */
function do_week_nav($week, $edit, $venue) {
    $cur_id = $week->get_id();
//		echo ("We are doing a nav for week ".$cur_id."<br>");
    $prev_id = date("y-m-d", mktime(0, 0, 0, substr($cur_id, 3, 2), substr($cur_id, 6, 2) - 7, substr($cur_id, 0, 2))) . ":" .$venue;
    $next_id = date("y-m-d", mktime(0, 0, 0, substr($cur_id, 3, 2), substr($cur_id, 6, 2) + 7, substr($cur_id, 0, 2))). ":" .$venue;
    $s = "<p><table id=\"weeknav\" align=\"left\"><tr><td align=\"left\" >";
    // determines if there is a previous week
    $prev_week = get_dbWeeks($prev_id);
    if ($prev_week instanceof Week) {
        $s = $s . '<a href="calendar.php?id=' . $prev_id . '&venue=' . $venue;
        if ($edit)
            $s = $s . "&edit=true";
        $s = $s . "\" id=\"weeknavlink\"><< Previous Week</a>";
    }
    else $s = $s . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    if ($_SESSION['access_level'] >= 1)
        if ($edit != true)
            $s = $s . '<td align="left"> <a href="calendar.php?id=' . $cur_id . '&venue=' . $venue . '&edit=true">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(edit this week)</a></td>';
        else
            $s = $s . '<td align="left"> <a href="calendar.php?id=' . $cur_id . '&venue=' . $venue . '&edit=false">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(view this week)</a></td>';
    if ($_SESSION['access_level'] >= 2)
        $s = $s . '<td align="right"> <a href="addWeek.php?archive=false&venue='.$venue.'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(manage weeks)</a></td>';
    $s = $s . "</td><td align=\"right\">";
    // determines if there is a next week
    $next_week = get_dbWeeks($next_id);
    if ($next_week instanceof Week) {
        $s = $s . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="calendar.php?id=' . $next_id . '&venue=' . $venue;
        if ($edit)
            $s = $s . "&edit=true";
        $s = $s . "\" id=\"weeknavlink\">Next Week >></a>";
    }
    else $s = $s . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    $s = $s . "</td></tr></table></p><br><br>";
    return $s;
}
function show_week_no ($cur_id) {
	$cur_time = mktime(0, 0, 0, substr($cur_id, 3, 2), substr($cur_id, 6, 2), substr($cur_id, 0, 2));
	$woms = array(1=>"1st",2=>"2nd",3=>"3rd",4=>"4th",5=>"5th");
	$dom = date("d",$cur_time);
	$wom = floor(($dom-1)/7) + 1;
	$weekno = date("W",$cur_time);
	if ($weekno==53)   // one in 7 years will have a 53rd week, so punt when that happens
 		$weekno==52;
 	$weekno--;         // all years start at week 0 so we can't get 2 odds in a row
 	if ($weekno%2==0)
		$oddeven = "even";
	else
		$oddeven = "odd";
	return " (week ". $weekno . ": ".$oddeven.")";
	//	echo $woms[$wom] . " ". date ("l", $cur_time) . " of the month<p>";
}
/**
 * gets a week object, and displays it as a calendar
 */
function show_week($days, $week, $edit, $year, $doy, $venue) {
    // gets all of the dates for this week
    // sets up the table, with title, and then day of month
    $venues = array("portland" => "Portland House", "bangor" => "Bangor House");
	$free_hour = array();
    for ($i = 0; $i < 91; $i++)
        $free_hour[] = true;
//		echo ("Showing week ". $week->get_id(). " for venue " . $venue . " and first day " . $days[0]->get_id() . "<br>");
    $daynames = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
    echo ('<table id="calendar" align="center" ><tr class="weekname"><td colspan="16" ' .
    'align="center" >Calendar: ' . $week->get_name() . '</td></tr>
				<tr><td bgcolor=lightblue></td>');
				//removed: ' .$venues[$venue]. ' between '>' and 'Calendar'
                //removed: show_week_no($week->get_id()). after '$week->get_name() .'
    for ($i = 0; $i < 7; $i++)
        echo ('<td class="dom">' . get_dom($days[$i]) . '</td><td class="dow">&nbsp; ' . $daynames[$i] . '</td>');
    echo('<td bgcolor=lightblue></td></tr>');
    $limit = 22;
    for ($hour = 9; $hour < $limit; $hour++) {
        echo ("<tr><td class=\"hour\">" . show_hours($venue, $hour) . "</td>");
        for ($i = 0; $i < 7; $i++) {
            $shiftid = $days[$i]->get_shift_id($hour);
            if ($shiftid) {
            	$shift_length = get_shift_end($shiftid) - get_shift_start($shiftid);
            	if (substr($shiftid,9,5)=="night")
            	    $t="night";
            	else $t = substr($shiftid,9,strrpos($shiftid,":")-9);
          //  	echo "shift id,length,start,end,t = ".$shiftid.",".$shift_length.",".get_shift_start($shiftid).",".get_shift_end($shiftid).",".$t;
            	echo do_shift($days[$i], $t, $shift_length, $edit, $venue);
                for ($j = $hour; $j < $hour + $shift_length; $j++)
                    $free_hour[7 * ($j - 9) + $i] = false;
            } 
            else 
            if ($free_hour[7 * ($hour - 9) + $i])
                echo "<td colspan='2' bgcolor=\"lightgray\"></td>";
        }
        echo ("<td class=\"hour\">" . show_hours($venue, $hour) . "</td></tr>");
    }


// notes
    echo do_day_notes($days, $edit, $year, $doy);
    echo "<input type=\"hidden\" name=\"_submit_check_edit_notes\" value=\"1\">";
    echo "<input type=\"hidden\" name=\"weekid\" value=\"" . $days[0]->get_id() . "\">";
    echo "</table>";
}

function show_hours($venue, $hour) {
    $d = 1;
    $last_shift = 8;
    if ($hour==21) {
    	return "night";
    }
    else {
    $clock = $hour < 12 ? $hour . "am" : $hour - 12 . "pm";
    $clockend = $hour + $d < 12 ? ($hour + $d) . "am" : ($hour - 12 + $d) . "pm";
    if ($clock == "0pm")
        $clock = "12pm";
    if ($clockend == "0pm")
        $clockend = "12pm";
    if (($clock) % $d == 0){
    	if ($clock % $last_shift == 0)
            return $clock . " - " . $clockend;
        else 
            return $clock;
    }
    else
        return "";
    }
}

// return a string of html that contains a table cell for a shift
function do_shift($day, $shift, $length, $edit, $venue) {
    // chooses size annd style of cell based on length
    $s = "<td colspan=\"2\" ";
    $s = $s . "rowspan='" . $length . "' class = 'shift'";
    // checks that the shift is not in the past
    $year = date("Y", time());
    $doy = date("z", time()) + 1;
    if ($edit) // && ($year < $day->get_year() || $year == $day->get_year() && $doy <= $day->get_day_of_year() ))
        $s = $s . "e";
    $s = $s . "\"><table id=\"shiftbox\"><tr><td class=\"persons\">";
    if ($edit) // && ($year < $day->get_year() || $year == $day->get_year() && $doy <= $day->get_day_of_year() ))
        $s = $s . "<a id=\"shiftlink\" href=\"editShift.php?shift=" . substr($day->get_id(),0,8) . ":" . $shift . "&venue=" . $venue . "\">";
    $s = $s . get_people_for_shift($day, $shift);
    if ($edit) { //&& ($year < $day->get_year() || $year == $day->get_year() && $doy <= $day->get_day_of_year() )) {
        $s = $s . "</a>";
        // if manager, adds shift notes
        if ($_SESSION['access_level'] >= 2 || $_SESSION['access_level'] >= 1.5) {
            $s = $s . "</td></tr><tr><td class=\"notes\" align=\"center\">" .
                    "<textarea id=\"shift_notes\" rows=\"1\" name=\"shift_notes_" . $day->get_shift($shift)->get_id() . "\">"
                    . $day->get_shift($shift)->get_notes() . "</textarea>";
        } else {
            $shiftnote = $day->get_shift($shift)->get_notes();
            $s = $s . "</td></tr><tr><td class=\"notes\"><p id=\"shift\">" . $shiftnote . "</p>";
        }
    } 
    else {
        $shiftnote = $day->get_shift($shift)->get_notes();
        $s = $s . "</td></tr><tr><td class=\"notes\"><p id=\"shift\">" . $shiftnote . "</p>";
    }
    
    $s = $s . "</td></tr></table></td>";
    return $s;
}

function get_dom($day) {
    $dom = $day->get_dom();
    if (substr($dom, 0, 1) == "0")
        return "&nbsp;&nbsp;" . substr($dom, 1);
    return $dom;
}

function get_people_for_shift($day, $key) {
	//echo "we are getting people for shift ".$day->get_shift($key);
    $shift = $day->get_shift($key);
    $people = $shift->get_persons();
    if (!$people[0])
        array_shift($people);
    $p = "<br>";
    $vac = $shift->num_vacancies();
//		echo $shift->get_id()." slots = ".$shift->num_slots()."  vac = ".$shift->num_vacancies()."<br>";
    for ($i = 0; $i < sizeof($people); ++$i) {
        if (!$people[$i] == "") {
            $name_components = explode("+", $people[$i]);
            $p = $p . "&nbsp;" . $name_components[1] . " " . $name_components[2] . "<br>";
        }
    }
    if ($vac > 0)
        $p = $p . "&nbsp;<b>Vacancies (" . $vac . ")</b>";
    return substr($p, 0, strlen($p) - 4);
}

function do_day_notes($days, $edit, $year, $doy) {
    if ($edit == false || $_SESSION['access_level'] < 1.5) {
        $s = "<tr><td class=\"hour\">manager notes&nbsp;</td>";
        for ($i = 0; $i < 7; ++$i) {
            $s = $s . "<td class=\"note\" colspan=\"2\">" . $days[$i]->get_mgr_notes() . "</td>";
        }
        return $s . "<td class=\"hour\">manager notes&nbsp;</td></tr>";
    } else {
        $s = "<tr><td class=\"hour\">manager notes&nbsp;</td>";
        for ($i = 0; $i < 7; ++$i) {
            if ($year < $days[$i]->get_year() || $year == $days[$i]->get_year() && $doy <= $days[$i]->get_day_of_year()) {
                $s = $s . "<td class=\"note_e\" colspan=\"2\"><textarea id=\"mgr_notes\"
					 rows=\"1\" name=\"mgr_notes" . $i . "\">"
                        . $days[$i]->get_mgr_notes() . "</textarea></td>";
            }
            else 
                $s = $s . "<td class=\"note\" colspan=\"2\">" . $days[$i]->get_mgr_notes() . "</td>";
        }
        return $s . "<td class=\"hour\">manager notes&nbsp;</td></tr>";
    }
}

function process_edit_notes($week, $venue, $post) {
    $days = $week->get_dates();
    for ($i = 0; $i < 7; ++$i) {
        $shifts = $days[$i]->get_shifts();
        foreach ($shifts as $key => $shift) {
       //   if ($shift->get_venue()==$venue) {
        	$note = trim(str_replace('\"', '\\\"', str_replace('\'', '\\\'', htmlentities($post['shift_notes_' . $shift->get_id()]))));
            $shift->set_notes($note);
            update_dbShifts($shift);
      //    }
        }
    //    if ($year < $days[$i]->get_year() || $year == $days[$i]->get_year() && $doy <= $days[$i]->get_day_of_year()) {
            $mgr_note = trim(str_replace('\"', '\\\"', str_replace('\'', '\\\'', htmlentities($post['mgr_notes' . $i]))));
            $days[$i] = select_dbDates($days[$i]->get_id());
            $days[$i]->set_mgr_notes($mgr_note);
            update_dbDates($days[$i]);
    //    }
        
    }
}
?>