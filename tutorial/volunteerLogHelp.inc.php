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
	<strong>Logging Your Hours </strong> </p>
	<p>
	 The Volunteer Hours Log is where volunteers can keep a record of their volunteer history.<br>
	Each entry icludes the date, start and end times, hours volunteered, and location of their shift, as well as total hours to date.
	<br><br>Managers are also able to view and edit volunteers' hours.
	<B>Managers:</B> For instructions on navigating to the Log Sheet, see <B>Step 5</B>.<br><br>
	</p>
<p>
	<B>Step 1:</B>  After you have logged in, select "here" in View/Update your Log Sheet to go to your log sheet.<BR> <BR> <a
		href="tutorial/screenshots/LogHoursStep1.png" class="image"
		title="LogHoursStep1.png" horizontalalign="center"
		target="tutorial/screenshots/LogHoursStep1.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/LogHoursStep1.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/LogHoursStep1.png"
		border="1px" align="middle"> </a>
 
</p>
<p>
	<B>Step 2:</B>  If this is your first time logging hours, only a blank row will appear.  Otherwise, the blank row will be below your previously submitted entries..
<p>
	<a
		href="tutorial/screenshots/LogHoursStep2.png" class="image"
		title="LogHoursStep2.png" horizontalalign="center"
		target="tutorial/screenshots/LogHoursStep2.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/LogHoursStep2.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/LogHoursStep2.png"
		border="1px" align="middle"> </a>
</p>
<p>
	<B>Step 3:</B>  Logging Your Shift: In the blank row, select the date, start time, and end time of your shift.
	If you are entering an overnight shift, select the date on which the shift began.
<p>
	<a
		href="tutorial/screenshots/LogHoursStep3_date.png" class="image"
		title="LogHoursStep3_date.png" horizontalalign="center"
		target="tutorial/screenshots/LogHoursStep3_date.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/LogHoursStep3_date.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/LogHoursStep3_date.png"
		border="1px" align="middle"> </a>
</p>



<p> To enter times, you may either use the drop-down menu or enter them manually.<br><br>
	 <a
		href="tutorial/screenshots/LogHoursStep3_time.png" class="image"
		title="LogHoursStep3_time.png" horizontalalign="center"
		target="tutorial/screenshots/LogHoursStep3_time.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/LogHoursStep3_time.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/LogHoursStep3_time.png"
		border="1px" align="middle"> </a>
</p>
<p>
	 Optionally enter the number of hours you volunteered (this will be automatically calculated 
	 if you leave it blank).  Also, make sure that the correct venue is selected.  <BR> <BR> 
</p>

<p>
	<B>Step 4:</B>  Select "Submit" to save your new entry.  The page will refresh with 
	this entry saved and a new blank row available.<BR> <BR> <a
		href="tutorial/screenshots/LogHoursStep4.png" class="image"
		title="LogHoursStep4.png"
		target="tutorial/screenshots/LogHoursStep4.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/LogHoursStep4.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/LogHoursStep4.png"
		border="1px" align="middle"> </a>
</p>


<p>
	<B>Step 5:</B>  <B>Managers:</B>  To find the Log Sheet for a volunteer, use the volunteer search page, select the person,
	then select "View Log Sheet."  Then see Steps 2-4 to edit the volunteer's history.<br><br>
	<a
		href="tutorial/screenshots/LogHoursStep5.png" class="image"
		title="LogHoursStep5.png"
		target="tutorial/screenshots/LogHoursStep5.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/LogHoursStep5.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/LogHoursStep5.png"
		border="1px" align="middle"> </a>
	</p>
	
<p>
<B>Step 6:</B>  For further assistance, go to "Help Home" for additional help pages. <br><br>
</p>
	
<p>
<B>Step 7:</B>  When you finish, you can return to any other task by selecting it on the navigation bar.
</p>