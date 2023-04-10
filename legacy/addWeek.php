<?php
/*
 * Copyright 2013 by Allen Tucker. 
 * This program is part of RMH Homebase, which is free software.  It comes with 
 * absolutely no warranty. You can redistribute and/or modify it under the terms 
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 * 
 */

session_cache_expire(30);
session_start();
?>
<!--
        addWeek.php
        @author Max Palmer and Allen Tucker
        @version 3/25/08, revised 8/10/15
-->
<html>
    <head>
        <title>
            Add Weeks to Calendar
        </title>
        <link rel="stylesheet" href="styles.css" type="text/css" />
    </head>
    <body>
        <div id="container">
            <?PHP include('header.php'); ?>
            <div id="content">
                <?PHP
                $venue = $_GET['venue'];
                include_once('database/dbWeeks.php');
                include_once('database/dbMasterSchedule.php');
                include_once('database/dbPersons.php');
                include_once('database/dbLog.php');
                include_once('domain/Shift.php');
                include_once('domain/RMHdate.php');
                include_once('domain/Week.php');
                include_once('domain/Person.php');
                // Check to see if there are already weeks in the db
                // connects to the database to see if there are any weeks in the dbWeeks table
                $result = get_all_dbWeeks($venue);
                // If no weeks for either the house or the family room, show first week form
                if (sizeof($result) == 0)
                    $firstweek = true;
                else
                    $firstweek = false;
                // publishes a week if the user is a manager
                if (!$firstweek && $_GET['publish'] && $_SESSION['access_level'] >= 2) {
                    $id = $_GET['publish'];
                    $week = get_dbWeeks($id);
                    if ($week->get_status() == "unpublished")
                        $week->set_status("published");
                    else if ($week->get_status() == "published")
                        $week->set_status("unpublished");
                    update_dbWeeks($week);
                    add_log_entry('<a href=\"personEdit.php?id=' . $_SESSION['_id'] . '\">' . $_SESSION['f_name'] . ' ' . $_SESSION['l_name'] . '</a> ' .
                            $week->get_status() . ' the week of <a href=\"calendar.php?id=' . $week->get_id() . '&edit=true\">' . $week->get_name() . '</a>.');
                    echo "<p>Week \"" . $week->get_name() . "\" " .
                    $week->get_status() . ".<br>";
					include('addWeek_newweek.inc');
                }
                // removes a week if user is a manager
                else if (!$firstweek && $_GET['remove'] && $_SESSION['access_level'] >= 2) {
                    $id = $_GET['remove'];
                    $week = get_dbWeeks($id);
                    if ($week) {
                      if ($week->get_status() == "unpublished" || $week->get_status() == "archived") {
                        delete_dbWeeks($week);
                        add_log_entry('<a href=\"personEdit.php?id=' . $_SESSION['_id'] . '\">' . $_SESSION['f_name'] . ' ' . $_SESSION['l_name'] . '</a> removed the week of <a href=\"calendar.php?id=' . $week->get_id() . '&edit=true\">' . $week->get_name() . '</a>.');
                        echo "<p>Week \"" . $week->get_name() . "\" removed.<br>";
                      }
                      else
                        echo "<p>Week \"" . $week->get_name() . "\" is published, so it cannot be removed.<br>";
                    }
                    //include('addWeek_newweek.inc');
                    //unset($_GET('remove'));
                    echo "<br> (Back to <a href=\"addWeek.php?venue=".$venue."&archive=".$_GET['archive']."\"><b>manage weeks</b></a>)" ;
                         
                }
                else if (!array_key_exists('_submit_check_newweek', $_POST)) {
                    include('addWeek_newweek.inc');
                } else {
                    process_form($firstweek, $venue, $_POST['_new_week_timestamp']);
                    include('addWeek_newweek.inc');
                }
                
                function process_form($firstweek, $venue, $timestamp) {
                    if ($_SESSION['access_level'] < 2)
                        return null;
                    if ($firstweek == true) {
                        //find the beginning of the current week
                        $dow = strtotime("last Monday");
                        $m = date("m",$dow);
                        $d = date("d",$dow);
                        $y = date("y",$dow);
                        generate_populate_and_save_new_week($m, $d, $y, $venue);
                    } 
                    else {                     
                        // populate new weeks from last generated to 4 weeks from now
                        $limit = strtotime("+4 weeks");
                        $timestamp = $timestamp;
                        while ($timestamp < $limit) {
                            $m = date("m", $timestamp);
                            $d = date("d", $timestamp);  
                            $y = date("y", $timestamp);
                            generate_populate_and_save_new_week($m, $d, $y, $venue);
                            $timestamp = strtotime("+1 week", $timestamp); 
                        }
                        // delete all archived weeks prior to 4 weeks ago
                        $result = get_all_dbWeeks($venue);
                        $limit = strtotime("-4 weeks");
                        foreach ($result as $old_week) {
                            if ($old_week->get_end() < $limit)
                                delete_dbWeeks($old_week);
                        }
                    }
                }

                // uses the master schedule to create a new week in dbWeeks and 
                // 7 new dates in dbDates and new shifts in dbShifts
                // 
                function generate_populate_and_save_new_week($m, $d, $y, $venue) {
                    // set the group names the format used by master schedule
                    $weekdays = array("Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun");
                    $weeksofmonth = array(1=>"1st",2=>"2nd",3=>"3rd",4=>"4th",5=>"5th");
                    $day_id = $y . "-" . $m . "-" . $d;
                    $dates = array();
                    $daysinmonth=date("t",mktime(0, 0, 0, $m, $d, $y));
                        
                    foreach ($weekdays as $day) {
                    	$my_date = mktime(0, 0, 0, $m, $d, $y);
                        $week_of_month= $weeksofmonth[floor(($d - 1)/7)+1];
                        // echo "weekofmonth,day,month,year,daysinmonth= ",$week_of_month.",".$d.",".$m.",".$y.",".$daysinmonth;
        				$weekno = date("W",$my_date);
						if ($weekno==53)   // one in 7 years will have a 53rd week, so punt when that happens
 							$weekno==52;
 						$weekno--;         // all years start at week 0 so we can't get 2 odds in a row
 						if ($weekno%2==1)
            				$week_of_year= "odd";
        				else 
        					$week_of_year= "even";	
        				$month_num = date("m", $my_date);
                        $venue_shifts1 = get_master_shifts($venue, $week_of_month, $day);
                        $venue_shifts2 = get_master_shifts($venue, $week_of_year, $day);
                        $venue_shifts = array_merge($venue_shifts1, $venue_shifts2);
                            /* Each row in the array is an associative array
                             *  of (venue, my_group, day, time, start, end, slots, persons, notes)
                             *  and persons is a comma-separated string of ids, like "alex2077291234"
                             */
                        $shifts = array();
                        if (sizeof($venue_shifts)>0) {
                        	foreach ($venue_shifts as $venue_shift) 
                                $shifts[] = generate_and_populate_shift($day_id, $venue, $week_of_month, $week_of_year, $day, $venue_shift->get_hours(), "");
                        }
                    
                        // makes a new date with these shifts
                        $new_date = new RMHdate($day_id, $venue, $shifts, "");
                        $dates[] = $new_date;
                        $d++;
                        if ($d>$daysinmonth) {
                        	$d=1;
                        	if ($m == 12) 
                        	    {$m =1; $y++;}
                        	else $m++;
                        }
                        $day_id = date("y-m-d", mktime(0, 0, 0, $m, $d, $y));
                    }
                     // creates a new week from the dates
                    $newweek = new Week($dates, $venue, "published");
                    insert_dbWeeks($newweek);
                    add_log_entry('<a href=\"personEdit.php?id=' . $_SESSION['_id'] . '\">' . $_SESSION['f_name'] . ' ' . $_SESSION['l_name'] . '</a> generated a new week: <a href=\"calendar.php?id=' . $newweek->get_id() . '&edit=true\">' . $newweek->get_name() . '</a>.');        
                }

                // makes new shifts, fills from master schedule
                //!
                function generate_and_populate_shift($day_id, $venue, $week_of_month, $week_of_year, $day, $time, $note) {
                    // gets the people from the master schedule
                    $people1 = get_person_ids($venue, $week_of_month, $day, $time);
                    if (!$people1[0])
                        array_shift($people1);
                    // echo($week_of_month.":".$day.":".$time.":".$venue);
                    $vacancies1 = get_total_slots($week_of_month.":".$day.":".$time.":".$venue) - count($people1);
                    $people2 = get_person_ids($venue, $week_of_year, $day, $time);
                    if (!$people2[0])
                        array_shift($people2);
                    $vacancies2 = get_total_slots($week_of_year.":".$day.":".$time.":".$venue) - count($people2);
                    $people = array_unique(array_merge($people1, $people2));
                    if (!$people[0])
                        array_shift($people);
                    $vacancies = $vacancies1 + $vacancies2;
                    // changes the people array to the format used by Shift (id, fname lname)
                    for ($i = 0; $i < count($people); ++$i) {
                        $person = retrieve_person($people[$i]);
                        if ($person) {
                        	$people[$i] = $person->get_id() . "+" . $person->get_first_name() . "+" . $person->get_last_name();
                        }
                    }
                    // calculates vacancies
                    // makes a new shift filled with people found above
                    $newShift = new Shift($day_id . ":" . $time, $venue, $vacancies, $people, array(), "", $note);
                    return $newShift;
                    
                }

                // displays form errors (only for first week)
                function show_errors($e) {
                    //this function should display all of our errors.
                    echo("<p><ul>");
                    foreach ($e as $error) {
                        echo("<li><strong><font color=\"red\">" . $error . "</font></strong></li>\n");
                    }
                    echo("</ul></p>");
                }
                ?>
            </div>
            <?PHP include('footer.inc'); ?>
        </div>
    </body>
</html>