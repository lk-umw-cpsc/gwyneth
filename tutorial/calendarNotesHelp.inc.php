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
	<strong>How to Add Notes</strong>
<p>Managers can record notes on any shift that will be read by all
	volunteers viewing the calendar. Managers may also enter a note for an
	entire day at the bottom of that day on the calendar.
<p>
	To begin, you must have already selected <strong>(edit this week)</strong>
	at the top of the calendar.
<p>
	<B>Step 1:</B> At the bottom of each shift there's a place to enter
	notes for that shift. <BR> <BR> <a
		href="tutorial/screenshots/AddingNotesStep1.png"
		class="image" title="AddingNotesStep1.png"
		horizontalalign="center"
		target="tutorial/screenshots/AddingNotesStep1.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/AddingNotesStep1.png"
		rel="popover"
		data-img="tutorial/screenshots/AddingNotesStep1.png"
		width="10%" border="1px" align="center"> </a>
<p>
	<B>Step 2:</B> Below all the shifts, there is an additional row marked
	"manager notes".<BR> <BR> <a
		href="tutorial/screenshots/calendarNotesHelp_manager_notes.png"
		class="image" title="calendarNotesHelp_manager_notes.png"
		horizontalalign="center"
		target="tutorial/screenshots/calendarNotesHelp_manager_notes.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/calendarNotesHelp_manager_notes.png"
		rel="popover"
		data-img="tutorial/screenshots/calendarNotesHelp_manager_notes.png"
		width="10%" border="1px" align="center"> </a>
<p>
	<B>Step 3:</B> Once you have entered the notes, scroll down to the
	bottom of the calendar and click the button <strong>Save changes to all
		notes</strong>, like this:<BR> <BR> <a
		href="tutorial/screenshots/calendarNotesHelp_save_notes.png"
		class="image" title="calendarNotesHelp_save_notes.png"
		target="tutorial/screenshots/calendarNotesHelp_save_notes.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/calendarNotesHelp_save_notes.png"
		rel="popover"
		data-img="tutorial/screenshots/calendarNotesHelp_save_notes.png"
		width="10%" border="1px" align="middle"> </a>
<p>The notes you entered will now appear whenever someone views that
	week on the calendar.
<p>
	<B>Step 4:</B> You can return to any other function by selecting it on
	the navigation bar.