<?php
/*
 * Copyright 2015 by Adrienne Beebe, Connor Hargus, Phuong Le, 
 * Xun Wang, and Allen Tucker. This program is part of RMHP-Homebase, which is free 
 * software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 */
session_start();
session_cache_expire(30);
include_once('database/dbPersons.php');
include_once('domain/Person.php');
?>
<html>
<head>
<title>
	<?PHP echo('Volunteer Hours Log');?>
</title>
<link rel="stylesheet" href="lib\bootstrap\css\bootstrap.css" type="text/css" />
<link rel="stylesheet" href="lib/jquery-ui.css" />
<link rel="stylesheet" href="styles.css" type="text/css" />
<link rel="stylesheet" href="lib/jquery.timepicker.css" />
<script src="lib/jquery-1.9.1.js"></script>
<script src="lib/jquery-ui.js"></script>
<script src="lib/jquery.timepicker.js"></script>
<script>
$(function() {
	$( "#from" ).datepicker({dateFormat: 'y-mm-dd',changeMonth:true,changeYear:true});
	$( "#start_time" ).timepicker({'minTime': '12:00am', 'maxTime': '11:30pm'});
	$( "#end_time" ).timepicker({'minTime': '12:00am', 'maxTime': '11:30pm'});
});
</script>
</head>
<body style="background-color: rgb(250, 249, 246);">
<div class="container-fluid" id="container" style="background-color: rgb(250, 249, 246);">
    <?PHP include('header.php'); ?>
    <div id="content">
    <form method="POST">
	<?php 
	    $person = retrieve_person($_GET['id']);
		$venues = array('portland' => 'RMH Portland', 'bangor' => 'RMH Bangor');
		if ($_POST['Submit']) {
			$hours = gather_hours($_POST['from'], $_POST['start_time'], $_POST['end_time'], $_SESSION['venue'], $_POST['hours_worked']);
			update_hours($person->get_id(), $hours);
	    	echo "Volunteer Log Updated; please remember to log out when finished.<p>";
	    }
	//    else {
		
	    	$person = retrieve_person($_GET['id']);
		    $hours = $person->get_hours();
		    echo '<p><b> Gwyneth\'s Gift Volunteer Log Sheet </b> for '.$person->get_first_name()." ".$person->get_last_name();
			echo "<br> Today is ".date('l F j, Y')."</p>"; 
			$total = 0;
			echo '<p><table name="log_entries" id="spacedRowTable" style="width:40%">';
			echo '<th align="left">Date</th><th align="left">Start time</th><th align="left">End time</th><th align="left">Hours worked</th><th align="left">Total</th><p></p>';
			
			/*foreach ($hours as $log_entry) {
				$log_details = explode(":",$log_entry);	
				echo '<tr><td>'.$log_details[0].'</td><td>'.substr($log_details[1],0,4).'</td><td>'.substr($log_details[1],5,4).'</td><td>'.$log_details[3].'</td><td>'.$log_details[2].'</td></tr>';
			}
			*/
			
			foreach ($hours as $log_entry) {
				$log_details = explode(":",$log_entry);	
				echo '<tr><td><input type="text" name="from[]" class="date" value='.$log_details[0].'></td>
					<td><input type="text" name="start_time[]" class="start_time" size=10 value='.substr($log_details[1],0,4).'></td>
					<td><input type="text" name="end_time[]" class="end_time" size=10 value='.substr($log_details[1],5,4).'></td>
					<td><input type="text" name="hours_worked[]" class="hours_worked" size=10 align=right value='.$log_details[2].'></td>';
				$total += $log_details[2];
				echo '<td>'.$total.'</td></tr>';
					
			}
			echo '<tr><td><input type="text" id = "from" name="from[]" class="date" ></td>
				<td><input type="text" id="start_time" name="start_time[]" class="start_time" size=10></td>
				<td><input type="text" id="end_time" name="end_time[]" class="end_time"  size=10></td>
				<td><input type="text" name="hours-worked[]" class="hours-worked" size=10></td>';
			echo '</tr></table></p>';
	        
		    echo('<p>Hit <input class="btn btn-success" type="submit" value="Submit" name="Submit" tabindex=5> to save these changes.<br /><br />');

	    // rebuilds the hours array from the form, taking in edits to previous entries and a new entry 
	    function gather_hours($dates, $start_times, $end_times, $venues, $hours_worked) {
			for ($i=0;$i<count($dates);$i++) {
				$start_times[$i] = fix_time($start_times[$i]);
				$end_times[$i] = fix_time($end_times[$i]);
				
	    		if (valid_entry($dates[$i],$start_times[$i],$end_times[$i],$hours_worked[$i])) 
	    			$hours .= ",".$dates[$i].":".$start_times[$i]."-".$end_times[$i].":".$hours_worked[$i];
	    		}
			return substr($hours,1);
		}
		// minimal validation function -- assumes 30-minute intervals
		function valid_entry($date,$start,$end,&$hours) {
			if ($date=="") return false;
			if ($start=="" || $end=="") return false;
			if ($hours=='') {
				if ($end < $start){
				    $end+=2400;
				}
				$hours = (int)(($end-$start)/100);
				if (($end-$start)%100!=0) $hours += 0.5;
			}
			if ($hours > 0) return true;
			return false;
		}
		// convert time to 4-digit value -- "9:00am" to "0900" 
		function fix_time($time) { 	
			$parts = explode(":",$time);
			if (count($parts) < 2)
			    return $time;			// no need to convert
			if (strpos($parts[1],"am")>0) {
				if (strlen($parts[0])==1)
					$parts[0] = "0".$parts[0];
			}
			else if ($parts[0]<12)
			    $parts[0] = intval($parts[0]) + 12;
			return $parts[0].substr($parts[1],0,2);
		}
	    ?>
    </form>
    </div>
    <?PHP include('footer.inc'); ?>
</div>
</body>
</html>


