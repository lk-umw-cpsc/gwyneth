<?php
/*
 * Copyright 2015 by Adrienne Beebe, Connor Hargus, Phuong Le, 
 * Xun Wang, and Allen Tucker. This program is part of RMHP-Homebase, which is frem
 * software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 */

include_once('dbinfo.php');
include_once('database/dbPersons.php');
include_once('domain/Person.php');
include_once('dbEvents.php');

include_once('database/dbShifts.php');
include_once('domain/Shift.php');

if (isset($_POST['_form_submit'])) {
	if  ($_POST['_form_submit'] == 'reportportland')
		show_report('portland');
	else show_report('bangor');
}

function show_report($venue) {

	$from = $_POST["from"];
	$to   = $_POST["to"];
	$name_from = $_POST["name_from"];
	$name_to = $_POST["name_to"];
	if ($_POST['export'])	
		$export = "yes";
	else $export = "no";
	
	if (isset($_POST['report-types'])) {
		if (in_array('volunteer-hours', $_POST['report-types'])) {
			report_volunteer_hours_by_day($from, $to, $venue);
		}
	    else if (in_array('shifts-staffed-vacant', $_POST['report-types'])) {
			report_shifts_staffed_vacant_by_day($from, $to, $venue);
		}
		else if (in_array('volunteers', $_POST['report-types'])) {
				report_all_volunteers($name_from, $name_to, $venue, $export);	
		}
		else if (in_array('emails', $_POST['report-types'])) {
        		report_all_emails($name_from, $name_to, $venue, $export);
		}
		else if (in_array('information', $_POST['report-types'])) {
			report_all_volunteers_info($name_from, $name_to, $venue, $export);	
	}

	}
}

function report_volunteer_hours_by_day($from, $to, $venue) { 
	if($from == ""){$from ="00-00-00";}
	if($to == ""){$to = date("y-m-d");}
		
	echo "<br><b>".pretty_venue($venue)." Total Volunteer Hours Report</b><br>"; 
	if ($from!="00-00-00")
		echo " from " .pretty_date($from);
	if ($to!="")
		echo " through ".pretty_date($to);

	$report = get_volunteer_hours($from, $to, $venue);
	display_totals_table($report, $venue);	
}

function report_shifts_staffed_vacant_by_day($from, $to, $venue) {
	if($from == ""){$from ="00-00-00";}
	if($to == ""){$to = date("y-m-d");}
		
	echo "<br><b>".pretty_venue($venue)." Shifts/Vacancies Report</b><br>"; 
	if ($from!="00-00-00")
		echo " from " .pretty_date($from);
	if ($to!="")
		echo " through ".pretty_date($to);

	$report = get_shifts_staffed($from, $to, $venue);
	display_vacancies_table($report, $venue);
}

// used for email info
function report_all_emails($name_from, $name_to, $venue, $export) {
	echo ("<br><b>".pretty_venue($venue)." Volunteer Contact Info</b><br> Report date: ");
	echo date("F d, Y")."<br><br>";
	if($name_from == ""){$name_from="A";}
	if($name_to == ""){$name_to = "Z";}

	$report = getall_dbPersons($name_from, $name_to, $venue);
	display_volunteers_emails($report, $export, $venue);
}

//used for contact info
function report_all_volunteers($name_from, $name_to, $venue, $export) {
	echo ("<br><b>".pretty_venue($venue)." Volunteer Contact Info</b><br> Report date: ");
	echo date("F d, Y")."<br><br>";
	if($name_from == ""){$name_from="A";}
	if($name_to == ""){$name_to = "Z";}
	
	$report = getall_dbPersons($name_from, $name_to, $venue);
	display_volunteers($report, $export, $venue);
}

//used for all important, general info
function report_all_volunteers_info($name_from, $name_to, $venue, $export) {
	echo ("<br><b>".pretty_venue($venue)." General Volunteer Info</b><br> Report date: ");
	echo date("F d, Y")."<br><br>";
	if($name_from == ""){$name_from="A";}
	if($name_to == ""){$name_to = "Z";}
	
	$report = getall_dbPersons($name_from, $name_to, $venue);
	display_volunteers_full($report, $export, $venue);
}

function pretty_date($date){
	//eg. date is 78-03-30, this function can convert it into "March 30, 1978"
  	//explode the date to get month, day and year
	$dob=explode("-",$date); 
	//if the year is less than 30, we can assume the person was born after 2000; if the year is greater than 30, we can 
	//assume the person was born before 2000. 
	if ($dob[0]=="XX")
	    $dob[0] = "19XX";
	elseif ( ((int) $dob[0] ) <= date("y")){
		$year = "20".$dob[0];  	
	} else{
		$year = "19".$dob[0];
	}
    if ( ((int) $dob[2] ) < 10)
		$dob[2] = substr($dob[2],1);  		
	//$dateObj   = DateTime::createFromFormat('!m', $dob[1]);
	//$dob[1] = $dateObj->format('M'); 
	return date("F j", mktime(0,0,0,$dob[1],$dob[2],$dob[0])).", ".$year;
}

function display_totals_table($report, $venue){  //Creates a table for the Total Hours report
	$row_lab = array("9-12"=>"Morning","12-3"=>"Early PM","3-6"=>"Late PM","6-9"=>"Evening","night"=>"Night","Total"=>"Total");
	$sat_labels = array("9-12"=>"10-1","12-3"=>"1-4","3-6"=>"","6-9"=>"","night"=>"night","Total"=>"Total");
	$sun_labels = array("9-12"=>"9-12","12-3"=>"2-5","3-6"=>"","6-9"=>"5-9","night"=>"","Total"=>"Total");
	$col_lab = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun","Total");
	$res = "
		<table id = 'areport'> 
			<thead>
			<tr>
				<td></td>";
	$row = "<tr>
				<td><b>Shift</b></td>";
	foreach($col_lab as $col_name){
		$row .= "<td><b>".$col_name."</b></td>";
	}
	$row .="</tr>";
	$res .= $row;
	$res .= "
			</thead>
			<tbody>";
	foreach($row_lab as $row_name=>$row_tag){
		$row_total = 0;
		$row = "<tr>";
		$row .= "<td><b>".$row_tag."</b></td>";
		if($row_name == "Total"){
			$grand_total = 0;
			foreach($col_lab as $col_name){
				$count = 0;
				if($col_name =="Total"){
					$row .= "<td>".$grand_total."</td>";
				}else {
					foreach($report as $entry){
						$elements = explode(":",$entry); 
						if ($col_name==$elements[0]){
							$num = (int)$elements[2];
							$count = $count + $num;
							$row_total = $row_total + $num;
						}
					}
					$row .= "<td>".$count."</td>";
					$grand_total += $count;
				}
			}
		}else{
			foreach($col_lab as $col_name){
				if ($col_name=="Sat")
					$rn=$sat_labels[$row_name];
				else if ($col_name=="Sun")
					$rn=$sun_labels[$row_name];
				else $rn=$row_name;
				$count = 0;
				if($col_name =="Total"){
					$row .= "<td>".$row_total."</td>";
				}else {
					foreach($report as $entry){
						$elements = explode(":",$entry); 
						if ($col_name==$elements[0] && $rn==$elements[1]){
							$num = (int)$elements[2];
							$count += $num;
							$row_total += $num;
						}
					}
					$row .= "<td>".$count."</td>";
				}
			}
		}
		$row .= "</tr>";
		$res .= $row;
	}
	$res .= "</tbody></table>";
	echo $res;
}

function display_vacancies_table($report, $venue){
	$row_lab = array("9-12"=>"Morning","12-3"=>"Early PM","3-6"=>"Late PM","6-9"=>"Evening","night"=>"Night","Total"=>"Total");
	$sat_labels = array("9-12"=>"10-1","12-3"=>"1-4","3-6"=>"","6-9"=>"","night"=>"night","Total"=>"Total");
	$sun_labels = array("9-12"=>"9-12","12-3"=>"2-5","3-6"=>"","6-9"=>"5-9","night"=>"","Total"=>"Total");
	$col_lab = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun","Total");
	$res = "
		<table id = 'areport'> 
			<thead>
			<tr>
				<td></td>";
	//row 1
	$row = "<tr>
				<td></td>";
	foreach($col_lab as $col_name){
		$row .= "<td><b>".$col_name."</b></td>";
	}
	$row .="</tr>";
	$res .= $row;
	$res .= "
			</thead>
			<tbody>";
	foreach($row_lab as $row_name=>$row_tag){
		$row_total_vacs = 0;
		$row_total_slots = 0;
		$row = "<tr>";
		$row .= "<td><b>".$row_tag."</b></td>";
		if($row_name == "Total"){
			$grand_total_vacs = 0;
			$grand_total_slots = 0;
			foreach($col_lab as $col_name){
				$col_total_slots = 0;
				$col_total_vacs = 0;
				if($col_name =="Total"){
					$row .= "<td>".$grand_total_slots."/".$grand_total_vacs."</td>";
				}else{
					foreach($report as $entry){
						$elements = explode(":",$entry); //turn each entry into an arry, hrs is final item in array
						if ($col_name==$elements[0] && $elements[1]!='9-5'){
							$slots = $elements[3];
							$vacs = $elements[2];
							$slotsint = (int)$slots;
							$vacsint = (int)$vacs;
							$col_total_slots += $slotsint;
							$col_total_vacs += $vacsint;
						}
					}
					$row .= "<td>".$col_total_slots."/".$col_total_vacs."</td>";
					$grand_total_slots += $col_total_slots;
					$grand_total_vacs += $col_total_vacs;
				}
			}
		}else{
			foreach($col_lab as $col_name){
				if ($col_name=="Sat")
					$rn=$sat_labels[$row_name];
				else if ($col_name=="Sun")
					$rn=$sun_labels[$row_name];
				else $rn=$row_name;
				$slots_count = 0;
				$vacs_count = 0;
				if($col_name =="Total"){
					$row .= "<td>".$row_total_slots."/".$row_total_vacs."</td>";
				}else {
					foreach($report as $entry){
						$elements = explode(":",$entry); //turn each entry into an arry, hrs is final item in array
						if ($col_name==$elements[0] && $rn==$elements[1]){
							$slots = $elements[3];
							$vacs = $elements[2];
							$slots_count += $slots;
							$vacs_count += $vacs;
							$slotsint = (int)$slots;
							$vacsint = (int)$vacs;
							$row_total_slots += $slotsint;
							$row_total_vacs += $vacsint;
						}
					}
					$row .= "<td>".$slots_count."/".$vacs_count."</td>";
				}
			}
		}
		$row .= "</tr>";
		$res .= $row;
	}
	$res .= "</tbody></table>";
	echo $res;
}

function calculate_age($date){
  	//eg. date is 03-30-78
  	//explode the date to get month, day and year
	$dob=explode("-",$date); 
	
	//if the year is less than 30, we can assume the person was born after 2000; if the year is greater than 30, we can 
	//assume the person was born before 2000. 
	if ( ((int) $dob[0] ) <= date("y")){
		$dob[2] = "20".$dob[0];  	
	} else{
		$dob[2] = "19".$dob[0];
	}	
	$curMonth = date("m");
	$curDay = date("j");
	$curYear = date("Y");
	$age = $curYear - $dob[2]; 
	if($curMonth<$dob[1] || ($curMonth==$dob[1] && $curDay<$dob[2])){ 
		$age--; 
	}
    return $age; 
}
// 24-hour time to 12-hour time 
//eg. time is 0900, this function can convert it into "1:00 pm"
function civil_time($army_time){
		$time_in_12_hour_format = date("g:i a", strtotime($army_time)); 
	return $time_in_12_hour_format;
}

// Improve venue display by using associative array, i.e, turning fam --> "Family Room" 
function pretty_venue($v){
	$venue = array('portland' => "Gwyneth's Gift", 'bangor' => "Gwyneth's Gift");
		return $venue[$v];
}

//Create a table to display volunteer emails
function display_volunteers_emails($report, $export, $venue) {
	$col_labels = array("Name","Email");
	$res = "
		<table id = 'report'>
			<thead>
			<tr>";
	$row = "<tr>";

	foreach($col_labels as $col_name){
		$row .= "<td><b>".$col_name."</b></td>";
	}
	$row .="</tr>";
	$res .= $row;
	$res .= "
			</thead>
			<tbody>";

	echo '<div id="target" style="overflow: scroll; width: variable; height: 400px;">';
	$export_data = array();
	foreach($report as $person){
		$p = array($person->get_last_name() . ", ". $person->get_first_name(), $person->get_email());
		$export_data[] = $p;
		$res .= "<tr>";
		foreach ($p as $info)
			$res .= "<td>". $info . "</td>";
	    $res .= "</tr>";
	}
	$res .= "</tbody></table>";
	echo $res;
	echo "</div>";
	if ($export=="yes")
		export_report ("Volunteer Email Info", $col_labels, $export_data, $venue);
}



//Create a table to display volunteer contact info
function display_volunteers ($report, $export, $venue) { 
	$col_labels = array("Name","Address","City","State","Zip","Phone Number", "Email","Start Date", "Notes");
	$res = "
		<table id = 'report'> 
			<thead>
			<tr>";
	$row = "<tr>";
	
	foreach($col_labels as $col_name){
		$row .= "<td><b>".$col_name."</b></td>";
	}
	$row .="</tr>";
	$res .= $row;
	$res .= "
			</thead>
			<tbody>";
	
	echo '<div id="target" style="overflow: scroll; width: variable; height: 400px;">';
	$export_data = array();			       
	foreach($report as $person){
		$p = array($person->get_last_name() . ", ". $person->get_first_name(), 
				$person->get_address(), $person->get_city(), $person->get_state(), $person->get_zip(),
			    $person->get_phone1(), $person->get_email(),
			    $person->get_start_date(), $person->get_notes());
		$export_data[] = $p;
		$res .= "<tr>";
		foreach ($p as $info)
			$res .= "<td>". $info . "</td>";
	    $res .= "</tr>";
	}
	$res .= "</tbody></table>";
	echo $res;
	echo "</div>";
	if ($export=="yes") 
		export_report ("Volunteer Contact Info", $col_labels, $export_data, $venue);
}


//function to display all important volunteer info
function display_volunteers_full ($report, $export, $venue) { 
	$col_labels = array("Name","Address","City","State","Zip","Phone Number", "Email", "Start Date", "Phone Type", "Birthday",
	"Shirt Size", "Computer", "Camera", "Transportation", "Contact Name","Contact Number", "Contact Relation", "Notes");
	$res = "
		<table id = 'report'> 
			<thead>
			<tr>";
	$row = "<tr>";
	
	foreach($col_labels as $col_name){
		$row .= "<td><b>".$col_name."</b></td>";
	}
	$row .="</tr>";
	$res .= $row;
	$res .= "
			</thead>
			<tbody>";
	
	echo '<div id="target" style="overflow: scroll; width: variable; height: 400px;">';
	$export_data = array();			       
	foreach($report as $person){
		$p = array($person->get_last_name() . ", ". $person->get_first_name(), 
				$person->get_address(), $person->get_city(), $person->get_state(), $person->get_zip(),
			    $person->get_phone1(), $person->get_email(),
			    $person->get_start_date(), $person->get_phone1type(), $person->get_birthday(),$person->get_shirt_size(),
				$person->get_computer(), $person->get_camera(), $person->get_transportation(), 
				$person->get_contact_name(),$person->get_contact_num(),$person->get_relation(), $person->get_notes());
		$export_data[] = $p;
		$res .= "<tr>";
		foreach ($p as $info)
			$res .= "<td>". $info . "</td>";
	    $res .= "</tr>";
	}
	$res .= "</tbody></table>";
	echo $res;
	echo "</div>";
	if ($export=="yes") 
		export_report ("General Volunteer Info", $col_labels, $export_data, $venue);
}

function export_report($heading, $col_labels, $data, $venue) {
	$filename = "export.csv";
	$handle = fopen($filename, "w");
	fputcsv($handle, array(pretty_venue($venue)." ".$heading,"Report date: ".date("F d, Y")));
	fputcsv($handle, array());
	fputcsv($handle, $col_labels);
	foreach ($data as $aline) {
		fputcsv($handle, $aline);
	}
	fclose($handle);
}

?>
