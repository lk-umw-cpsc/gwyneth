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
?>

<p>
	<?php 
	$venues = array("portland" => "", "bangor" => "RMH Bangor");
	echo("<strong>" . $venues[$venue] . " </strong>"); 
	
	?>
    <strong>Calendar Week Management</strong><br />
    Here you can add new weeks to the calendar and edit weeks that already exist. <br>Click the "Add new week" button to add a new week, or select an option at the right of an existing week.</p>
<span class="nextWeekTable">
    <form method="POST">
        <table border="1">
            <tr><td>Weeks</td><td>Status (options)</td></tr>
            <?php
            $result = get_all_dbWeeks($venue);
            $week = false;
            for ($i = 0; $i < sizeof($result); ++$i) {
                $week = $result[$i];
                if ($i == sizeof($result)-1 || $i == 0)
                    $remove = true;
                else
                    $remove = false;
                if(($week->get_status()=="archived" && $_GET['archive']=="true") || $week->get_status()=="published" || 
                    ($week->get_status()=="unpublished" && $_SESSION['access_level']>=2))
                echo ("<tr><td>" . $week->get_name() . "</td>" .
                "<td>" . show_week_options($week, $remove, $venue) . "</td></tr>");
            }
            // finds the parameters for "generate next week" button
            if ($_SESSION['access_level'] >= 2) { 
                if ($week) 
                    $last = $week -> get_id();
                else 
                    $last = date('y-m-d',strtotime("last Monday"));   
                $new_week_timestamp = mktime(0, 0, 0, substr($last, 3, 2), substr($last, 6, 2) + 7, substr($last, 0, 2));
                echo ('<tr><td>');
            	echo "<input type=\"hidden\" name=\"_new_week_timestamp\" value=\"" . $new_week_timestamp . "\">
								<input type=\"hidden\" name=\"_submit_check_newweek\" value=\"1\">
								<input type=\"submit\" value=\"Add new week\" name=\"Add new week\">";
                echo "</td>";
                
                echo('<td align="center"><a href="addWeek.php?venue='.$venue.'&archive=');
            	if ($_GET['archive'] == "true")
                	echo 'false">Hide Archive</a></td></tr><tr>';
            	else
                	echo 'true">View Archive</a></td></tr><tr>';
                echo "</td><td colspan = '2'>";    
            }
            echo "</td></tr></table>";    

            // determines what options apply to each week
            function show_week_options($week, $remove, $venue) {
                $id = $week->get_id();
                $status = $week->get_status();
                $end = $week->get_end();
                $options = "";
                $rightnow = time();
                $oneweek = 60 * 60 * 24 * 7;
                if ($status == "archived") {
                    $options = "archived (<a href=\"calendar.php?id=" . $id . "&venue=".$venue."\">view</a>)";
                }
                // see if right now is part of a new week.  If so, archive the previous week.
                // here was a BIG BUG -- today might not have an immediate predecessor week in the database,
                // in which case "week2" below will be null!  So this now accommodates gaps (missing weeks) in the dbWeeks table.
                else if ($rightnow > $end) {
                    $options = "archived (<a href=\"calendar.php?id=" . $id . "&venue=".$venue."\">view</a>)";
                    $week2 = get_dbWeeks($id);
                    if ($week2 != null) {
                        $week2->set_status("archived");
                        update_dbWeeks($week2);
                    }
                } else if ($status == "unpublished") {
                    $options = "unpublished 
							(<a href=\"calendar.php?id=" . $id. "&venue=".$venue."&edit=true\">edit</a>)
							(<a href=\"addWeek.php?venue=".$venue."&publish=" . $id . "\">publish</a>)
							(<a href=\"calendar.php?id=" . $id . "&venue=".$venue."\">view</a>)";
                } else { // status must be "published"
                    $options = "published (<a href=\"calendar.php?id=" . $id . "&venue=".$venue."&edit=true\">edit</a>)
							(<a href=\"addWeek.php?venue=".$venue."&publish=" . $id . "\">unpublish</a>)
							(<a href=\"calendar.php?id=" . $id . "&venue=".$venue."\">view</a>)";
                }
                if ($remove)
                    $options = $options . " (<a href=\"addWeek.php?venue=".$venue."&remove=" . $id . "&archive=".$_GET['archive']."\">remove</a>)";
                return $options;
            }
            ?>
    </form></span>
