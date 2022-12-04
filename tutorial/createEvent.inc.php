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

<!--//Creating an Event//-->

<p>
	<strong>How to Create an Event</strong>
<p>
	<B>Step 1:</B>
</p>
<p>
	Find <strong>Events</strong> and select <strong>Add</strong> from the navigation bar at the top
	of the page, like this:<BR> <BR> <a
	    href="tutorial/screenshots/createEventStep1.JPG" class="image"
        title="createEventStep1.JPG"
        target="tutorial/screenshots/createEventStep1.JPG">
        &nbsp&nbsp&nbsp&nbsp<img
        src="tutorial/screenshots/createEventStep1.JPG" width="10%"
        rel="popover" data-img="tutorial/screenshots/createEventStep1.JPG"
        border="1px" align="middle"> </a>
</p>
<p>
	<B>Step 2:</B>
</p>
<p>
	From this page, you will be able to specify the date, name and description of your new event.
	<BR> <BR> <a
    	    href="tutorial/screenshots/createEventStep2-1.JPG" class="image"
            title="createEventStep2-1.JPG"
            target="tutorial/screenshots/createEventStep2-1.JPG">
            &nbsp&nbsp&nbsp&nbsp<img
            src="tutorial/screenshots/createEventStep2-1.JPG" width="10%"
            rel="popover" data-img="tutorial/screenshots/createEventStep2-1.JPG"
            border="1px" align="middle"> </a>
</p>
<p>
    NOTE: For the <strong>Event Date</strong> field, a menu will pop up allowing you to select a date:
    <BR> <BR> <a
        	    href="tutorial/screenshots/createEventStep2-2.JPG" class="image"
                title="createEventStep2-2.JPG"
                target="tutorial/screenshots/createEventStep2-2.JPG">
                &nbsp&nbsp&nbsp&nbsp<img
                src="tutorial/screenshots/createEventStep2-2.JPG" width="10%"
                rel="popover" data-img="tutorial/screenshots/createEventStep2-2.JPG"
                border="1px" align="middle"> </a>
</p>
<p>
    <b>Step 3</b>
</p>
<p>
    After typing your criteria in the appropriate box, click on the Search button, like this:
    <BR> <BR> <a
            	    href="tutorial/screenshots/createEventStep3.JPG" class="image"
                    title="createEventStep3.JPG"
                    target="tutorial/screenshots/createEventStep3.JPG">
                    &nbsp&nbsp&nbsp&nbsp<img
                    src="tutorial/screenshots/createEventStep3.JPG" width="10%"
                    rel="popover" data-img="tutorial/screenshots/createEventStep3.JPG"
                    border="1px" align="middle"> </a>
</p>
<p>
    If successful, you should get a message on screen saying
    <i>"You have successfully added <strong>event_name</strong> to the database"</i>.
    Clicking on the name of the event will take you to a page where you can edit the event's information.
</p>