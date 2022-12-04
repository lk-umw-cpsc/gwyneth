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
	<strong>Adding/Removing a Volunteer from a Shift</strong>
<p>
	To begin, you must have already selected <strong>(edit this week)</strong>
	at the top left of the calendar:
<p>
	<B>Step 1:</B> Click on a calendar shift, like this:<BR> <BR> <a
		href="tutorial/screenshots/addSlotToShiftHelp_choose_shift.png"
		class="image" title="addSlotToShiftHelp_choose_shift.png"
		horizontalalign="center"
		target="tutorial/screenshots/addSlotToShiftHelp_choose_shift.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/addSlotToShiftHelp_choose_shift.png"
		rel="popover"
		data-img="tutorial/screenshots/addSlotToShiftHelp_choose_shift.png"
		width="10%" border="1px" align="center"> </a> <br> <br> (Each upcoming
	calendar shift will turn gray whenever the mouse passes over it.)
<p>
	<B>Step 2:</B> This will give you a shift form that looks like this:<BR>
	<BR> <a
		href="tutorial/screenshots/addPersonToShiftHelp_initial_view.png"
		class="image" title="addPersonToShiftHelp_initial_view.png"
		horizontalalign="center"
		target="tutorial/screenshots/addPersonToShiftHelp_initial_view.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/addPersonToShiftHelp_initial_view.png"
		rel="popover"
		data-img="tutorial/screenshots/addPersonToShiftHelp_initial_view.png"
		width="10%" border="1px" align="center"> </a>
<p>
	<B>Removing a Volunteer from a Shift:</B> If a slot already has a
	volunteer, there will be a <b>Remove Person</b> button that looks like
	this: <BR> <BR> <a
		href="tutorial/screenshots/addPersonToShiftHelp_removing_volunteer.png"
		class="image" title="addPersonToShiftHelp_removing_volunteer.png"
		horizontalalign="center"
		target="tutorial/screenshots/addPersonToShiftHelp_removing_volunteer.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/addPersonToShiftHelp_removing_volunteer.png"
		rel="popover"
		data-img="tutorial/screenshots/addPersonToShiftHelp_removing_volunteer.png"
		width="10%" border="1px" align="center"> </a> <br> <br> Click that <b>Remove
		Person</b> button to remove that volunteer from that shift's slot,
	leaving an empty slot.
<p>
	<B>Adding a Volunteer to a Shift:</B> If a slot doesn't have a
	volunteer yet (or you just removed a volunteer from that slot), there
	will be two buttons: <b>Assign Volunteer</b> and <b>Remove Vacancy</b>.
	<BR> <BR> <a
		href="tutorial/screenshots/addPersonToShiftHelp_assign_volunteer.png"
		class="image" title="addPersonToShiftHelp_assign_volunteer.png"
		horizontalalign="center"
		target="tutorial/screenshots/addPersonToShiftHelp_assign_volunteer.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/addPersonToShiftHelp_assign_volunteer.png"
		rel="popover"
		data-img="tutorial/screenshots/addPersonToShiftHelp_assign_volunteer.png"
		width="10%" border="1px" align="center"> </a> <br> <br> Click the <b>Assign
		Volunteer</b> button to come to a page where you can choose a new
	volunteer: <br> <br> <a
		href="tutorial/screenshots/addPersonToShiftHelp_add_view.png"
		class="image" title="addPersonToShiftHelp_add_view.png"
		horizontalalign="center"
		target="tutorial/screenshots/addPersonToShiftHelp_add_view.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/addPersonToShiftHelp_add_view.png"
		rel="popover"
		data-img="tutorial/screenshots/addPersonToShiftHelp_add_view.png"
		width="10%" border="1px" align="center"> </a> <br> <br> Select a
	Volunteer using the drop down lists. The first list shows volunteers
	who have listed that time as available; the second shows every
	House (or Family Room) volunteer. Once you've chosen a volunteer, click the <b>Add Volunteer</b>
	button: <br> <br> <a
		href="tutorial/screenshots/addPersonToShiftHelp_add_view_volunteer.png"
		class="image" title="addPersonToShiftHelp_add_view_volunteer.png"
		horizontalalign="center"
		target="tutorial/screenshots/addPersonToShiftHelp_add_view_volunteer.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/addPersonToShiftHelp_add_view_volunteer.png"
		rel="popover"
		data-img="tutorial/screenshots/addPersonToShiftHelp_add_view_volunteer.png"
		width="10%" border="1px" align="center"> </a> <br> <br> This brings
	you back to the shift form (Step 2), and the selected volunteer will be
	displayed. <br> <br>You can return to any other function by selecting
	it on the navigation bar.