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

<!--//Searching for an Event//-->

<p>
	<strong>How to Search for an Event</strong>
<p>
	<B>Step 1:</B>
</p>
<p>
	Find <strong>Events</strong> and select <strong>Search</strong> from the navigation bar at the top
	of the page, like this:<BR> <BR> <a
	    href="tutorial/screenshots/searchEventStep1.JPG" class="image"
        title="searchEventStep1.JPG"
        target="tutorial/screenshots/searchEventStep1.JPG">
        &nbsp&nbsp&nbsp&nbsp<img
        src="tutorial/screenshots/searchEventStep1.JPG" width="10%"
        rel="popover" data-img="tutorial/screenshots/searchEventStep1.JPG"
        border="1px" align="middle"> </a>
</p>
<p>
    <B>Step 2:</B>
</p>
<p>
	From this page you will be able to search for an event by typing in any part of the event's name.
	For example, a search for "ann" would return Ann, Anna, Dianne, etc.<BR> <BR> <a
        href="tutorial/screenshots/searchEventStep2.JPG" class="image"
        title="searchEventStep2.JPG"
        target="tutorial/screenshots/searchEventStep2.JPG">
        &nbsp&nbsp&nbsp&nbsp<img
        src="tutorial/screenshots/searchEventStep2.JPG" width="10%"
        rel="popover" data-img="tutorial/screenshots/searchEventStep2.JPG"
        border="1px" align="middle"> </a>
</p>
<p>
    NOTE: If you leave the field blank and still perform a search, you will get a list of every event in
    the database.
</p>
<p>
    <b>Step 3:</b>
</p>
<p>
	Once you have entered the name of the event you wish to search for, click the <strong>Submit</strong>
	button under the name field. A table should appear underneath the button displaying the name and
	date of maching events.<BR> <BR> <a
    href="tutorial/screenshots/searchEventStep3.JPG" class="image"
    title="searchEventStep3.JPG"
    target="tutorial/screenshots/searchEventStep3.JPG">
    &nbsp&nbsp&nbsp&nbsp<img
    src="tutorial/screenshots/searchEventStep3.JPG" width="10%"
    rel="popover" data-img="tutorial/screenshots/searchEventStep3.JPG"
    border="1px" align="middle"> </a>
<p>
<p>
    Clicking on the name of an event will take you to a page where you can edit that event's information.
</p>