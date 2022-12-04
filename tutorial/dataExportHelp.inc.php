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
	<strong>Exporting Reports as CSVs (spreadsheet files)</strong>
<p>
From the reports page, you can export (download) some of these reports as CSVs for further processing
using Excel or OpenOffice.  
	<B>Step 1:</B> On the navigation bar at the top of the page, find <B>reports</B>
	, like this:<BR> <BR> <a href="tutorial/screenshots/reportsStep1.JPG"
		class="image" title="reportsStep1.JPG" horizontalalign="center"
		target="tutorial/screenshots/reportsStep1.JPG"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/reportsStep1.JPG" width="10%" rel="popover"
		data-img="tutorial/screenshots/reportsStep1.JPG" border="1px"
		align="center"> </a> <BR>
	<BR>Click on it and you should see the following page: <BR>
	<BR> <a href="tutorial/screenshots/reportsStep1-2.JPG" class="image"
		title="reportsStep1-2.JPG" horizontalalign="center"
		target="tutorial/screenshots/reportsStep1-2.JPG"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/reportsStep1-2.JPG" width="10%"
		rel="popover" data-img="tutorial/screenshots/reportsStep1-2.JPG"
		border="1px" align="center"> </a><br><br>
	The three reports that can be downloaded are starred (*) in the menu on the left. 
<p>
	<B>Step 2:</B> If you wish to download the .csv file for Volunteer Birthdays Report, 
	select "Volunteer Birthdays", pick a venue, check the box on the right, and click on <b>Submit</b>
	button, like this: <BR>
	<BR>
	<a href="tutorial/screenshots/dataexport2.png" class="image"
		title="dataexport2.png" horizontalalign="center"
		target="tutorial/screenshots/dataexport2.png"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/dataexport2.png" width="10%" rel="popover"
		data-img="tutorial/screenshots/dataexport2.png" border="1px"
		align="center"> </a> <BR>
	<BR> Now in the URL at the top of your browser, change the phrase "reports.php" to "export.csv" and hit Enter. 
	This will download that file to the Downlaods folder on your computer.  When you open the file in Excel or OpenOffice, 
	it will look like this: <BR>
	<BR>
	<a href="tutorial/screenshots/dataexport2-2.png" class="image"
		title="dataexport2-2.png" horizontalalign="center"
		target="tutorial/screenshots/dataexport2-2.png"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/dataexport2-2.png" width="10%" rel="popover"
		data-img="tutorial/screenshots/dataexport2-2.png" border="1px"
		align="center"> </a> <BR>
<p>
	<B>Step 3:</B> If you wish to download .csv file for the Volunteer History Report or the Volunteer 
	Contact Info report, select "Volunteer History" or "Volunteer Contact Info", check the box on the right,
	and then just click on <B>Submit</B> button, like this: <BR>
	<BR>
	<a href="tutorial/screenshots/dataexport3.png" class="image"
		title="dataexport3.png" horizontalalign="center"
		target="tutorial/screenshots/dataexport3.png"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/dataexport3.png" width="10%" rel="popover"
		data-img="tutorial/screenshots/dataexport3.png" border="1px"
		align="center"> </a> <BR>
	<BR> Now in the URL at the top of your browser, change the phrase "reports.php" to "export.csv" and hit Enter. 
	This will download that file to the Downlaods folder on your computer.  When you open the file in Excel or OpenOffice, 
	it will look like this: <BR>
	<BR>
	<a href="tutorial/screenshots/dataexport3-2.png" class="image"
		title="dataexport3-2.png" horizontalalign="center"
		target="tutorial/screenshots/dataexport3-2.png"> &nbsp&nbsp&nbsp&nbsp<img
		src="tutorial/screenshots/dataexport3-2.png" width="10%" rel="popover"
		data-img="tutorial/screenshots/dataexport3-2.png" border="1px"
		align="center"> </a> <BR>




