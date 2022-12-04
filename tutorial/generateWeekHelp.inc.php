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
	<strong>How to Generate and Publish Future Weeks on the Calendar
		(Managers Only)</strong>
</p>
<p>
	To begin this activity, select <B>(manage weeks)</B> at the top of any
	calendar page, like this:<BR> <BR> <a
		href="tutorial/screenshots/generateWeekHelp_manage_weeks.png"
		class="image" title="generateWeekHelp_manage_weeks.png"
		target="tutorial/screenshots/generateWeekHelp_manage_weeks.png"> <img
		src="tutorial/screenshots/generateWeekHelp_manage_weeks.png"
		rel="popover"
		data-img="tutorial/screenshots/generateWeekHelp_manage_weeks.png"
		width="10%" border="1px"> </a>
</p>
<p>
	You should then see this page: <a
		href="tutorial/screenshots/generateWeekHelp_week_manager_view.png"
		class="image" title="generateWeekHelp_week_manager_view.png"
		target="tutorial/screenshots/generateWeekHelp_week_manager_view.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/generateWeekHelp_week_manager_view.png"
		rel="popover"
		data-img="tutorial/screenshots/generateWeekHelp_week_manager_view.png"
		width="10%" border="1px" align="center"> </a>
<p>
	Each calendar week in this list has the status <i>archived</i>, <i>published</i>,
	or <i>unpublished</i>.
<ul>
	An
	<i>archived</i> week is any week that is fully in the past (as of the
	current date) -- its calendar cannot be changed.
	<br>A
	<i>published</i> week is is an active calendar week, visible and
	changeable by either managers or volunteers as schedule changes occur.
	<br>An
	<i>unpublished</i> week is a calendar week that is not visible to
	volunteers, and can only be changed or published by a manager.
</ul>
<p>
	The <strong> View Archive/Hide Archive</strong> button in the lower
	right corner of this page allows you to either see or not see the
	archived weeks from the table. (Most of the time you will not need to
	see them, so this button will simplify your view
	by showing only current and future weeks.)
<p>From here, you can do any of the following:
<ul>
	<li>Add a new week to the calendar from the master schedule</li>
	<li>Publish an unpublished week</li>
	<li>Unpublish a published week</li>
	<li>Remove the newest unpublished calendar week from the database</li>
	<li>Remove the oldest archived calendar week from the database
</ul>
<p>
	Adding a new week to the calendar will populate each day
	and shift with volunteers from the master schedule. Before you do this 
	it is important to be sure the master schedule is up
	to date.
<p>
	<B>Step 1:</B> (<i>You will do this step only if there are no current or
	future calendar weeks in the system.</i>) When this happens and you select <B>(manage weeks)</B> on the
	at the top of the calendar, you will see the following form:
<p>
	<a href="tutorial/screenshots/generateWeekHelp_initialize_calendar.png"
		class="image" title="generateWeekHelp_initialize_calendar.png"
		horizontalalign="center"
		target="tutorial/screenshots/generateWeekHelp_week_initialize_calendar.png">
		&nbsp&nbsp&nbsp&nbsp <img
		src="tutorial/screenshots/generateWeekHelp_initialize_calendar.png"
		rel="popover"
		data-img="tutorial/screenshots/generateWeekHelp_initialize_calendar.png"
		width="10%" border="1px" align="middle"> </a>
<p>
	When you hit <b>Add new week</b>, a new calendar week for today
	will be generated and populated from the master schedule, and the following 1-row
	table will appear:
<p>
	<a href="tutorial/screenshots/generateWeekHelp_newly_added.png"
		class="image" title="generateWeekHelp_newly_added.png"
		target="tutorial/screenshots/generateWeekHelp_week_newly_added.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/generateWeekHelp_newly_added.png"
		rel="popover"
		data-img="tutorial/screenshots/generateWeekHelp_newly_added.png"
		width="10%" border="1px" align="middle"> </a>
<p>
	<B>Step 2:</B> At any time in the future, you can use the same <strong>Add
		new week</strong> button to generate and populate the next successive
	    week on the calendar from the master schedule.  Here is the result of
	    hitting this button once:
<p>
	<a href="tutorial/screenshots/generateWeekHelp_add_new_week.png"
		class="image" title="generateWeekHelp_add_new_week.png"
		target="tutorial/screenshots/generateWeekHelp_add_new_week.png">
		&nbsp&nbsp&nbsp&nbsp <img
		src="tutorial/screenshots/generateWeekHelp_add_new_week.png"
		rel="popover"
		data-img="tutorial/screenshots/generateWeekHelp_add_new_week.png"
		width="10%" border="1px" align="bottom"> </a>
<p>
	This new week will be populated with a different
	group of volunteers from the Master Schedule.  That is, the system takes
	into account whether the week being generated is an odd or even week of the year,
	or whether it is the 1st, 2nd, ..., or 5th week of the month and selects 
	volutneers from the master schedule accordingly.
<p>
	The <strong> View Archive/Hide Archive</strong> button
	allows you to either see or remove archived weeks from the table. 
	Here is the table with the archived weeks showing:
	<br>
	<br> <a href="tutorial/screenshots/generateWeekHelp_archived_view.png"
		class="image" title="generateWeekHelp_archived_view.png"
		horizontalalign="center"
		target="tutorial/screenshots/generateWeekHelp_archived_view.png">
		&nbsp&nbsp&nbsp&nbsp <img
		src="tutorial/screenshots/generateWeekHelp_archived_view.png"
		rel="popover"
		data-img="tutorial/screenshots/generateWeekHelp_archived_view.png"
		width="10%" border="1px" align="middle"> </a>
<p>
	<B>Step 3:</B> You can now choose to <b>view</b>, <b>edit</b>, <b>publish</b>,
	or <b>remove</b> any of these weeks from the calendar using the buttons on the
	right.<ul><li>The <b>view</b> button takes you to the
	calendar so you can view the shift assignments for that week. <li>
	The <b>edit</b> button takes you to the calendar where you can edit
	individual shifts for that week. <li> The <b>publish/unpublish</b>
	button controls whether or not the week is visible to volunteers. <li> The <b>remove</b>
	button removes the most recent unpublished week from the calendar.
	(This is handy when you want to
	repopulate a future week after making changes to the Master Schedule.)
	This also allows you to remove the oldest archived weeks from the calendar, one by one.
	</ul>

