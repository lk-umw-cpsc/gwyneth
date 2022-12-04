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
	<strong>How to Use the Sub Call List</strong>
<p>
	Each shift that has a vacancy may have an associated <i>sub call list</i>.
	This list keeps track of all subs who are available and have/have not
	been called to fill that vacancy, along with the status of those calls.
	If nobody has tried to fill that shift yet, a new sub call list can be
	generated. Here's how it works:
<p>
	To begin, you must have already selected <strong>(edit this week)</strong>
	at the top of the calendar.
<p>
	<B>Step 1:</B> Click on an editable calendar shift that has a vacancy,
	like this:<BR> <BR> <a
		href="tutorial/screenshots/SubCallListStep1.png"
		class="image" title="quickStartGuideHelp_step1.png"
		horizontalalign="center"
		target="tutorial/screenshots/SubCallListStep1.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/SubCallListStep1.png" width="20%"
		rel="popover"
		data-img="tutorial/screenshots/SubCallListStep1.png"
		border="1px" align="center"> </a> <br> <br> (Each upcoming calendar
	shift will turn gray whenever the mouse passes over it. Shifts for
	prior days on the calendar cannot be edited in this way.)
<p>
	<B>Step 2:</B> This will give you a shift form that looks like this:<BR>
	<BR> <a href="tutorial/screenshots/quickStartGuideHelp_step2.png"
		class="image" title="quickStartGuideHelp_step2.png"
		horizontalalign="center"
		target="tutorial/screenshots/quickStartGuideHelp_step2.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/quickStartGuideHelp_step2.png" width="10%"
		rel="popover"
		data-img="tutorial/screenshots/quickStartGuideHelp_step2.png"
		border="1px" align="center"> </a>
<p>
	<B>Step 3:</B> If you are the first to try to fill a vacancy for this
	shift, click on the <B>Generate Sub Call List</B> button, like this:<BR>
	<BR> <a href="tutorial/screenshots/quickStartGuideHelp_step3.png"
		class="image" title="quickStartGuideHelp_step3.png"
		horizontalalign="center"
		target="tutorial/screenshots/quickStartGuideHelp_step3.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/quickStartGuideHelp_step3.png" width="10%"
		rel="popover"
		data-img="tutorial/screenshots/quickStartGuideHelp_step3.png"
		border="1px" align="center"> </a> <BR> <br>NOTE: If
	you are not the first, a sub call list will already have been created,
	so you should click on <B>View Sub Call List</B> button instead. (If
	there is no <B>Generate/View Sub Call List</B> button, the shift has no
	vacancies to be filled.)
<p>
	<B>Step 4:</B> You will now see a page that lists everyone available to
	fill that shift, their phone number, a 'Date Called' box, a 'Notes'
	box, and an 'Accepted' box, like this: <br> <br> <a
		href="tutorial/screenshots/quickStartGuideHelp_step4.png"
		class="image" title="quickStartGuideHelp_step4.png"
		target="tutorial/screenshots/quickStartGuideHelp_step4.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/quickStartGuideHelp_step4.png" width="10%"
		rel="popover"
		data-img="tutorial/screenshots/quickStartGuideHelp_step4.png"
		border="1px" align="middle"> </a>
<p>
	<B>Step 5:</B> When you call a person to find out if they can fill in,
	enter both the date you called them, along with any notes that apply to
	the call, in the boxes shown below. <BR> <BR> <a
		href="tutorial/screenshots/quickStartGuideHelp_step5.png"
		class="image" title="quickStartGuideHelp_step5.png"
		target="tutorial/screenshots/quickStartGuideHelp_step5.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/quickStartGuideHelp_step5.png" width="10%"
		rel="popover"
		data-img="tutorial/screenshots/quickStartGuideHelp_step5.png"
		border="1px" align="middle"> </a> <br> <br>If they
	accept or reject your request, select "Yes" or "No" in the 'Accepted'
	box. If you select "Yes," this vacancy will automatically be filled on the
	active calendar. If this is the last vacancy to be filled on this
	shift, this sub call list will be "closed." 
<p>
	<B>Step 6:</B> When you are finished with the sub call list for that
	shift, click on the <B>Assign Subs/Save Changes</B> button, like this.<BR>
	<BR> <a href="tutorial/screenshots/quickStartGuideHelp_step6.png"
		class="image" title="quickStartGuideHelp_step6.png"
		target="tutorial/screenshots/quickStartGuideHelp_step6.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/quickStartGuideHelp_step6.png" width="10%"
		rel="popover"
		data-img="tutorial/screenshots/quickStartGuideHelp_step6.png"
		border="1px" align="middle"> </a> <br> <br>NOTE: If
	you fail to save your changes, any entries that you made on this list
	will be lost. So this is a very important step; you don't want other
	volunteers working with this shift's sub call list at a later time to
	duplicate your efforts and call the same person again.
<p>
	<B>Step 7:</B> Now that the Date Called, Notes, "Yes"s and "No"s are
	saved, you will see a page showing all the open sub call lists on the
	calendar, like this: <br> <br> <a
		href="tutorial/screenshots/subcallliststep7.png" class="image"
		title="subcalllistStep7.png"
		target="tutorial/screenshots/subcallliststep7.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/subcallliststep7.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/subcallliststep7.png"
		border="1px" align="middle"> </a> <br> <br>You can now click on any other "open" sub
	call list on this list to find out its current status and try to fill
	another vacancy.
<p>
	<B>Step 8:</B> You can return to the shift, the calendar, or any other
	function by selecting it on the navigation bar.