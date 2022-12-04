<?php
/*
 * Copyright 2015 by Adrienne Beebe, Connor Hargus, Phuong Le, 
 * Xun Wang, and Allen Tucker. This program is part of RMHP-Homebase, which is free 
 * software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 */
?>
<script src="lib/jquery-1.9.1.js"></script>
<script src="lib/jquery-ui.js"></script>
<script
	src="lib/bootstrap/js/bootstrap.js"></script>

<script>
	$(function () {
		$('img[rel=popover]').popover({
			  html: true,
			  trigger: 'hover',
			  placement: 'right',
			  content: function(){return '<img border="3" src="'+$(this).data('img') + '" width="60%"/>';}
			});
	});
</script>

<p>
	<strong>How to Generate Reports</strong>
<p>
	<B>Step 1:</B> On the navigation bar at the top of the page, find <B>reports</B>
	, like this:<BR> <BR> <a href="tutorial/screenshots/reportsStep1.JPG"
		class="image" title="reportsStep1.JPG" horizontalalign="center"
		target="tutorial/screenshots/reportsStep1.JPG"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/reportsStep1.JPG" width="10%" rel="popover"
		data-img="tutorial/screenshots/reportsStep1.JPG" border="1px"
		align="center"> </a> <BR>
	<BR>Click on it and you should see the following page: <BR>
	<BR> <a href="tutorial/screenshots/reportsStep1-2.JPG" class="image"
		title="reportsStep1-2.JPG" horizontalalign="center"
		target="tutorial/screenshots/reportsStep1-2.JPG"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/reportsStep1-2.JPG" width="10%"
		rel="popover" data-img="tutorial/screenshots/reportsStep1-2.JPG"
		border="1px" align="center"> </a>
<p>
	<B>Step 2:</B> If you wish to view total volunteer hours for a particular date range, select "Total Hours"
	and specify the date rang you wish to view like this: <BR>
	<BR>
	<a href="tutorial/screenshots/reportsStep2.JPG" class="image"
		title="reportsStep2.JPG" horizontalalign="center"
		target="tutorial/screenshots/reportsStep2.JPG"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/reportsStep2.JPG" width="10%" rel="popover"
		data-img="tutorial/screenshots/reportsStep2.JPG" border="1px"
		align="center"> </a> <BR>
	<BR> Now when you hit the <B>Submit</B> button, you will see a report like this: <BR>
	<BR>
	<a href="tutorial/screenshots/reportsStep2-2.JPG" class="image"
		title="reportsStep2-2.JPG" horizontalalign="center"
		target="tutorial/screenshots/reportsStep2-2.JPG"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/reportsStep2-2.JPG" width="10%" rel="popover"
		data-img="tutorial/screenshots/reportsStep2-2.JPG" border="1px"
		align="center"> </a> <BR>
		
	<BR> NOTE: if you wish to view the volunteer hours for all active and archived calendar weeks,
	you don't need to select a date range - just hit the <B>Submit</B> button. <BR>
	
<p>
	<B>Step 3:</B> If you wish to view the total number of volunteer shifts and vacancies, select "Shifts/Vacancies" and  
	pick a specific date range, like this: <BR>
	<BR>
	<a href="tutorial/screenshots/reportsStep3.JPG" class="image"
		title="reportsStep3.JPG" horizontalalign="center"
		target="tutorial/screenshots/reportsStep3.JPG"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/reportsStep3.JPG" width="10%" rel="popover"
		data-img="tutorial/screenshots/reportsStep3.JPG" border="1px"
		align="center"> </a> <BR>
	<BR> Hitting <B>Submit</B> will now give you a report like this: <BR>
	<BR>
	<a href="tutorial/screenshots/reportsStep3-2.JPG" class="image"
		title="reportsStep3-2.JPG" horizontalalign="center"
		target="tutorial/screenshots/reportsStep3-2.JPG"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/reportsStep3-2.JPG" width="10%" rel="popover"
		data-img="tutorial/screenshots/reportsStep3-2.JPG" border="1px"
		align="center"> </a> <BR>
		
<p>
	<B>Step 4:</B> If you wish to view volunteer emails, contact information, and/or general information, then
	select the corresponding report type and click the <b>Submit</b> button to generate a report.
<p>
	<B>Step 5:</B> For the reports described in step 4, if you wish to download them as .csv files
	for processing as an Excel or OpenOffice spreadsheet, then check the box labeled <i>"To save the report,
	check here"</i> and then hit <b>Submit</b> again.
	<!--For more discussion of this option, please look <a href="?helpPage=rmhp-homebase/dataExport.inc.php">here.-->
</p>
<p>
	NOTE: You can only export the reports with a start in their name, such as the ones in step 4.
</p>