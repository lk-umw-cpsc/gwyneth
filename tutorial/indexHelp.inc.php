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
	<strong>Information about Your Personal Home Page</strong>
<p>Whenever you log into Homebase, some useful personal information will
	appear.
<p>
	<B>If you are a volunteer or a manager</B> and you've never changed
	your password, you will see the following display: <br><br><a
		href="tutorial/screenshots/homeHelp2.png" class="image"
		title="homeHelp2.png" target="tutorial/screenshots/homeHelp2.png">
		&nbsp&nbsp&nbsp&nbsp<img src="tutorial/screenshots/homeHelp2.png"
		width="10%" border="1px" rel="popover"
		data-img="tutorial/screenshots/homeHelp2.png" align="center"> </a> <br>
	<br>You may change your password by entering it and then entering your new
	password twice. After you change your password in this way, it will be
	known only to you. If you forget your password, please contact the
	house manager. Until you change your password, this display continue to
	appear here.
<p>
	<B>If you are a volunteer</B>, you will see a display of your upcoming
	scheduled shifts, which looks like this: &nbsp;&nbsp;&nbsp;&nbsp;<a
		href="tutorial/screenshots/indexHelp_upcoming_shifts.png"
		class="image" title="indexHelp_upcoming_shifts.png"
		target="tutorial/screenshots/indexHelp_upcoming_shifts.png">
		&nbsp;&nbsp;&nbsp;&nbsp;<img
		src="tutorial/screenshots/indexHelp_upcoming_shifts.png" width="10%"
		rel="popover"
		data-img="tutorial/screenshots/indexHelp_upcoming_shifts.png"
		border="1px" align="center"> </a> <br>If you need to cancel a shift,
	you may also call the House.
	<br><br> Your volunteer home page will also contain the following link: 
	&nbsp;&nbsp;&nbsp;&nbsp;<a
		href="tutorial/screenshots/indexHelp_logsheet.png"
		class="image" title="indexHelp_logsheet.png"
		target="tutorial/screenshots/indexHelp_logsheet.png">
		&nbsp;&nbsp;&nbsp;&nbsp;<img
		src="tutorial/screenshots/indexHelp_logsheet.png" width="10%"
		rel="popover"
		data-img="tutorial/screenshots/indexHelp_logsheet.png"
		border="1px" align="center"> </a>  
	
	<br>This takes you to a page where you can log your recent hours.
<p>
	<B>If you are a manager</B>, you will also see the following current
	information displayed:
<p>
	A log of the most recent schedule changes, which looks like this: <a
		href="tutorial/screenshots/indexHelp_recent_changes.png" class="image"
		title="indexHelp_recent_changes.png"
		target="tutorial/screenshots/indexHelp_recent_changes.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/indexHelp_recent_changes.png" width="10%"
		rel="popover"
		data-img="tutorial/screenshots/indexHelp_recent_changes.png"
		border="1px" align="center"> </a> <br> If you select <b>View full log</b>
	you will see a full listing of all schedule changes, like this: <a
		href="tutorial/screenshots/indexHelp_full_log.png" class="image"
		title="indexHelp_full_log.png"
		target="tutorial/screenshots/indexHelp_full_log.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/indexHelp_full_log.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/indexHelp_full_log.png"
		border="1px" align="center"> </a> <br> This full log allows you to
	delete some or all of its entries, once they are no longer useful.

<p>
	A list of upcoming calendar vacancies: <a
		href="tutorial/screenshots/indexHelp_upcoming_vacancies.png"
		class="image" title="indexHelp_upcoming_vacancies.png"
		target="tutorial/screenshots/indexHelp_upcoming_vacancies.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/indexHelp_upcoming_vacancies.png"
		width="10%" rel="popover"
		data-img="tutorial/screenshots/indexHelp_upcoming_vacancies.png"
		border="1px" align="center"> </a> <br> Selecting any of the vacancies
	in this list takes you directly to that shift on the calendar, so that
	you can examine its sub call list or other details.
<p>
	A list of all open applications (most recent first): <a
		href="tutorial/screenshots/indexHelp_open_applications.png"
		class="image" title="indexHelp_open_applications.png"
		target="tutorial/screenshots/indexHelp_open_applications.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/indexHelp_open_applications.png" width="10%"
		rel="popover"
		data-img="tutorial/screenshots/indexHelp_open_applications.png"
		border="1px" align="center"> </a> <br> An "open" application signifies
	an applicant whose status has not yet been changed to "active". Only
	"active" volunteers can be scheduled for a shift.
	
<p>
	A list of all active volunteers who haven't worked in the last two months: <a
		href="tutorial/screenshots/indexHelp_inactivevolunteers.png"
		class="image" title="indexHelp_inactivevolunteers.png"
		target="tutorial/screenshots/indexHelp_inactivevolunteers.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/indexHelp_inactivevolunteers.png" width="10%"
		rel="popover"
		data-img="tutorial/screenshots/indexHelp_inactivevolunteers.png"
		border="1px" align="center"> </a> <br> This list is helpful in identifying
		volunteers whose status may be changed to "inactive" or "former."