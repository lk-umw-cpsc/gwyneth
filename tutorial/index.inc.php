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
?>
<html>
<head>
<title>RMH Homebase</title>
</head>
<body>
	<p>
		<strong>Homebase Help Pages</strong>
	</p>
	<ol>
		<li><a href="?helpPage=rmhc-homebase/login.php">Signing in and out of the System</a>
		</li>
		<!--<br>
		<ul>
			<li><a href="?helpPage=rmhc-homebase/index.php">About your Personal Home Page</a></li>
			<li><a href="?helpPage=rmhc-homebase/volunteerLog.php">Logging Your Hours (Volunteers Only)</a></li>
		
		</ul>-->
		<br>
		<li><strong>Working with the Volunteer Database</strong> (Managers
			Only)</li>
		<br>
		<ul>
			<li><a href="?helpPage=rmhc-homebase/personSearch.php">Searching for People (and
					Phone Numbers)</a></li>
			<li><a href="?helpPage=rmhc-homebase/personEdit.php">Editing People</a></li>
			<li><a href="?helpPage=rmhc-homebase/personAdd.php">Adding People </a></li>
		</ul>
		<br>
		<li><a href="?helpPage=rmhc-homebase/calendar.php">Working with the Calendar</a></li>
		<br>
		<ul>
			<li><a href="?helpPage=rmhc-homebase/addWeek.php">Generating and publishing
					new calendar weeks (Managers Only)
					</a></li>
			<li><strong>Editing Events on the Calendar</strong></li>
			<p>
			
			
			<ul>
				<li><a href="?helpPage=rmhc-homebase/cancelShift.php">Creating an Event
						(Managers Only)</a></li>
				<li><a href="help.php?helpPage=rmhc-homebase/addSlotToShift.php">Searching for Events
				</a></li>
				<!--<li><a href="help.php?helpPage=rmhc-homebase/addPersonToShift.php">Adding/removing
						a person from a shift</a></li>
				<li><a href="help.php?helpPage=rmhc-homebase/subCallList.php">Using a Sub Call
						List (Managers Only)</a></li>-->
			</ul>
			<p>
			<!--<li><a href="?helpPage=rmhc-homebase/addNotes.php">Adding notes</a></li>-->

		</ul>
		<!--<li><a href="?helpPage=rmhc-homebase/viewSchedule.php">Working with the Master
				Schedule</a> (Managers Only)</li>
		<br>-->
		<li><a href="?helpPage=rmhc-homebase/reports.php">Generating Reports</a> (Managers
			Only)</li>
		<br>
		<!--<li><a href="?helpPage=rmhc-homebase/dataExport.inc.php">Exporting Reports as CSVs (spreadsheet files)</a> (Managers Only)</li>-->

	</ol>
	<p>
		If these help pages don't answer your questions, please contact a Gwyneth's Gift staff member</a>.
	</p>
</body>
</html>

