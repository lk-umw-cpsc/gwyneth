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
	<strong>How to Edit a Person's Information in the Database</strong>
<p>Editing information in the volunteer database is usually done by the
	Volunteer Coordinator or Family Room Coordinator. 
<p>
	<strong>Step 1:</strong> First you need to <strong>search</strong> for
	the person whose information you want to edit. <BR> <BR> <a
		href="tutorial/screenshots/editpersonstep1.png" class="image"
		title="editpersonstep1.png"
		target="tutorial/screenshots/editpersonstep1.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/editpersonstep1.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/editpersonstep1.png"
		border="1px" align="middle"> </a>
</p>
<p>
	To see more information on searching, <a
		href="?helpPage=rmhp-homebase/personSearch.php">click here</a>.
</p>

<p>
	<strong>Step 2:</strong> After finding that person, <strong> click on </strong>
	his/her name. You will now see a page with all of the person's
	information, like this:<BR> <BR> <a
		href="tutorial/screenshots/editpersonstep2.png" class="image"
		title="editpersonstep2.png"
		target="tutorial/screenshots/editpersonstep2.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/editpersonstep2.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/editpersonstep2.png"
		border="1px" align="middle"> </a>
		<BR><BR> If you'd like only to delete a volunteer or change their password, skip to step <b>4(b)</b>: 
</p>
<p>
	<strong>Step 3:</strong> To change any of the person's information,
	just retype or reselect it. For instance, to change Availability,
	select one of the unchecked (checked) boxes and it will become checked
	(unchecked). <BR>&nbsp&nbsp REMEMBER: No fields marked by <font
		color="#FF0000">*</font> can be left blank.
</p>

<p>
	<strong>Step 4(a):</strong> When you finish making changes, select <strong>Submit</strong>
	at the bottom of the page:<BR> <BR> <a
		href="tutorial/screenshots/editpersonstep4.png" class="image"
		title="editpersonstep4.png"
		target="tutorial/screenshots/editpersonstep4.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/editpersonstep4.png" rel="popover"
		data-img="tutorial/screenshots/editpersonstep4.png" width="10%"
		border="1px" align="middle"> </a>
</p>

<p>
	<strong>Step 4(b):</strong> If you'd like to delete a volunteer or reset their password, check the corresponding box press <b>Delete</b> or <b>Reset Password</b>.
	at the bottom of the page:<BR> <BR> <a
		href="tutorial/screenshots/editpersonstep4b.png" class="image"
		title="editpersonstep4b.png"
		target="tutorial/screenshots/editpersonstep4b.png">
		&nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/editpersonstep4b.png" rel="popover"
		data-img="tutorial/screenshots/editpersonstep4b.png" width="10%"
		border="1px" align="middle"> </a>
</p>

<p>
	<B>Step 5:</B> If errors occur, <font color=#FF0000>red</font> warnings
	will tell you what you need to correct, like this:<BR> <BR> <a
		href="tutorial/screenshots/editpersonstep5.png" class="image"
		title="editpersonstep5.png"
		target="tutorial/screenshots/editpersonstep5.png"
		horizontalalign="center"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/editpersonstep5.png" width="10%"
		border="1px" rel="popover"
		data-img="tutorial/screenshots/editpersonstep5.png" align="middle"> </a>
	<BR><BR>&nbsp&nbsp&nbsp *After you have made these corrections, repeat <B>Step
		4(a)</B>.
<p>
	<B>Step 6:</B> If you have no errors or omissions, you will see a page
	telling you the edit was successful, like this:<BR> <BR> <a
		href="tutorial/screenshots/editpersonstep6.png" class="image"
		title="editpersonstep6.png"
		target="tutorial/screenshots/editpersonstep6.png"
		horizontalalign="center"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/editpersonstep6.png" width="10%"
		rel="popover" data-img="tutorial/screenshots/editpersonstep6.png"
		border="1px" align="middle"> </a>
<p>
	<B>Step 7:</B> When you finish, you can return to any other function by
	selecting it on the navigation bar.