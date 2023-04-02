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

/*
 * reports page for RMH homebase.
 * @author Jerrick Hoang
 * @version 11/5/2013
 */
session_cache_expire(30);
session_start();

include_once('database/dbinfo.php');
include_once('database/dbPersons.php');
include_once('domain/Person.php');
include_once('database/dbEvents.php');

include_once('database/dbShifts.php');
include_once('domain/Shift.php');
?>

<html>
<head>
<!-- <link rel="stylesheet" href="lib\bootstrap\css\bootstrap.css" type="text/css" /> -->
<!-- <link rel="stylesheet" href="styles.css" type="text/css" /> -->
<!-- <link rel="stylesheet" href="lib/jquery-ui.css" /> -->
<script type="text/javascript" src="lib/jquery-1.9.1.js"></script>
<script src="lib/jquery-ui.js"></script>
<script>
$(function() {
	$( "#from" ).datepicker({dateFormat: 'y-mm-dd',changeMonth:true,changeYear:true});
	$( "#to" ).datepicker({dateFormat: 'y-mm-dd',changeMonth:true,changeYear:true});

	$(document).on("keyup", ".volunteer-name", function() {
		var str = $(this).val();
		var target = $(this);
		$.ajax({
			type: 'get',
			url: 'reportsCompute.php?q='+str,
			success: function (response) {
				var suggestions = $.parseJSON(response);
				console.log(target);
				target.autocomplete({
					source: suggestions
				});
			}
		});
	});

	$("input[name='date']").change(function() {
		if ($("input[name='date']:checked").val() == 'date-range') {
			$("#fromto").show();
		} else {
			$("#fromto").hide();
		}
	});

	$("#report-submit").on('click', function (e) {
		e.preventDefault();
		$.ajax({
			type: 'post',
			url: 'reportsCompute.php',
			data: $('#search-fields').serialize(),
			success: function (response) {
				$("#outputs").html(response);
			}
		});
	} );
	
});
</script>
	<?php require_once('universal.inc') ?>
        <title>Gwyneth's Gift VMS | Reports</title>
        <style>
            .report_select{
                display: flex;
                flex-direction: column;
                gap: .5rem;
                padding: 0 0 4rem 0;
            }
            @media only screen and (min-width: 1024px) {
                .report_select {
                    width: 50%;
                }
                main.reportSelection {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                }
            }
        </style>
</head>
<body>
 	<?php require_once('header.php');
	if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["go_to_reports_page"]) && isset($_POST["report_types"])) {
		$type = $_POST['report_type'];
		header("Location: /gwyneth/reportsPage.php?report_type=$type");
	}
	?>
        <h1>Business and Operational Reports</h1>
        <main class="reportSelection">
            <form class="report_select" method="post">
        <?php
	//<div id="container">

	//<div id = "content">
	//<div>
	//<p id="report-select-container">
	//<form id = "search-fields" method="post">
		//<p class = "search-description" id="today">
		date_default_timezone_set ("America/New_York");
		$venue = $_GET['venue'];
		$venues = array('portland'=>"RMH Portland",'bangor'=>"RMH Bangor");
		echo "Today's Date: " .date("F d, Y");
		echo '<br><br><b>'." Select Report </b>";
		echo '</p>';
		echo '<input type="hidden" name="_form_submit" value="report'.$venue.'" />';?>
	<table>	<tr>
		<td class = "report_select" valign="top"> 
		<p>	<select multiple name="report-types[]" id = "report-type" size="6"> <!-- size should = # of options -->
	  		<option value="all-volunteer-hours">Total Volunteer Hours</option>
	  		<option value="indiv-volunteer-hours">Individual Volunteers</option>
	  		<option value="top-hours-volunteered">Top Performers</option>
			</select>
		</td>
		<td class = "search-description" valign="top">&nbsp;&nbsp; Date Range: 
			<p id="fromto"> from : <input name = "from" type="date" size="10" id="from" placeholder="yyyy-mm-dd"><br>
							&nbsp;&nbsp;&nbsp;&nbsp;to : <input name = "to" type="date" size="10" id="to"placeholder="yyyy-mm-dd"></p>
		</td>
		<td class = "search-description" valign="top">&nbsp;&nbsp; Last Name Range: 
			<p id="name_fromto"> from : <input name = "name_from" type="text" size="10" id="name_from"><br>
							&nbsp;&nbsp;&nbsp;&nbsp;to : <input name = "name_to" type="text" size="10" id="name_to"></p>
		</td>
		
	</tr>
	<tr>
	<td valign="top">
	To view report, click 
	<input class="btn btn-success btn-sm" type="submit" value="Submit" id ="report-submit" class ="btn", name="go_to_reports_page">
	</td></tr>
	<tr>
	<td>* To save the report, check here <input type="checkbox" name="export" value="export">, hit 'Submit', and
	<a href="http://localhost/GwynethsGift/export.csv">Click here</a>.</td></tr>
	<tr><td></td></tr>
	<tr><td>To run another report, please refresh the page.</td></tr>
	</table>
	</form>
	<p id="outputs">

	</p>
</div>
</div>
</div>
        <?PHP include('footer.inc'); ?>

</body>
