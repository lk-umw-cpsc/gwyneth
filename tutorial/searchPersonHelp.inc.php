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
	<strong>Searching for People (and Phone Numbers)</strong>
<p>
	<B>Step 1:</B> On the navigation bar at the top of the page, find <B>Volunteers</B>
	and select <B>Search</B>, like this:<BR> <BR> <a
		href="tutorial/screenshots/searchPersonStep1.JPG" class="image"
		title="searchPersonStep1.JPG"
		target="tutorial/screenshots/searchPersonStep1.JPG">
		&nbsp;&nbsp;&nbsp;&nbsp;<img
		src="tutorial/screenshots/searchPersonStep1.JPG" width="10%"
		rel="popover" data-img="tutorial/screenshots/searchPersonStep1.JPG"
		border="1px" align="middle"> </a>
<p>
	<B>Step 2:</B> From this page you can search for a person via their name, whether or
	not they are a volunteer or manager, their status and their availability. When searching for someone
	by name, you can use any part of a their first name or last name as a search criterion. For example,
	a search for "ann" would return <B>Ann</B>, <B>Ann</B>a, Di<B>ann</B>e, etc.
<p>
	You can search for people of a particular type, such as
	"Volunteer" or "Manager".<BR> <BR> <a
		href="tutorial/screenshots/searchPersonStep2-1.png" class="image"
		title="searchPersonStep2-1.png"
		target="tutorial/screenshots/searchPersonStep2-1.png">
		&nbsp;&nbsp;&nbsp;&nbsp;<img
		src="tutorial/screenshots/searchPersonStep2-1.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/searchPersonStep2-1.png"
		border="1px" align="middle"> </a>
<p>
	You can also search for all people of a particular status, like "Applicant"
	or "On Leave".<BR> <BR> <a
		href="tutorial/screenshots/searchPersonStep2-2.png" class="image"
		title="searchPersonStep2-2.png" horizontalalign="center"
		target="tutorial/screenshots/searchPersonStep2-2.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/searchPersonStep2-2.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/searchPersonStep2-2.png"
		border="1px" align="middle"> </a>
</p>
<p>
	Lastly, you can search by availability.
	Remember, you can always search with more than one criterion. <BR> <BR> <a
		href="tutorial/screenshots/searchPersonStep2-3.png" class="image"
		title="searchPersonStep2-3.png" horizontalalign="center"
		target="tutorial/screenshots/searchPersonStep2-3.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/searchPersonStep2-3.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/searchPersonStep2-3.png"
		border="1px" align="middle"> </a>
</p>

<p>
	<B>Step 3:</B> After typing your criteria in the appropriate box,
	click on the <B>Search</B> button, like this:<BR> <BR> <a
		href="tutorial/screenshots/searchPersonStep3.JPG" class="image"
		title="searchPersonStep3.JPG"
		target="tutorial/screenshots/searchPersonStep3.JPG">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/searchPersonStep3.JPG" width="10%"
		rel="popover" data-img="tutorial/screenshots/searchPersonStep3.JPG"
		border="1px" align="middle"> </a>
</p>
<p>
	<B>Step 4:</B> Now you will see a list of the names in the database
	that match your search criteria, along with their primary phone number,
	email and availability.
	like this:<BR> <BR> <a
		href="tutorial/screenshots/searchPersonStep4.JPG" class="image"
		title="searchPersonStep4.JPG"
		target="tutorial/screenshots/searchPersonStep4.JPG">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/searchPersonStep4.JPG" width="10%"
		rel="popover" data-img="tutorial/screenshots/searchPersonStep4.JPG"
		border="1px" align="middle"> </a>
<p>
	If you see the person you want to view or edit, then <B>click on</B>
	that person's name, and you will be directed to his/her Edit Page. <br>
<p>
	<B>Step 5:</B> If you don't see what you were looking for, you can try
	again by repeating <B>Step 2</B>. <BR> <BR>
</p>

<p>
	<B>Step 6:</B> When you finish, you can return to any other function by
	selecting it on the navigation bar.