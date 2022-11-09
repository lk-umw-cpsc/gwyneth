<?php
/*
 * Copyright 2013 by Allen Tucker. 
 * This program is part of RMHP-Homebase, which is free software.  It comes with 
 * absolutely no warranty. You can redistribute and/or modify it under the terms 
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 * 
 */
?>
<!-- Begin Header -->

<style type="text/css">
        /* Modify the background color */
        .navbar-custom {
            background-color: rgb(250, 249, 246);
        }
        /* Modify brand and text color */
         
        .navbar-custom .navbar-brand,
        .navbar-custom .navbar-text {
            background-color: rgb(250, 249, 246);
        }
</style>

<div id="header">
<!--<br><br><img src="images/rmhHeader.gif" align="center"><br>
<h1><br><br>Homebase <br></h1>-->

</div>

<link rel="stylesheet" href="lib\bootstrap\css\bootstrap.css" type="text/css"/>
<script src="lib\bootstrap\js\bootstrap.js"></script>

<div class="d-flex justify-content-center mt-3" id="navigationLinks">

    <?PHP
    //Log-in security
    //If they aren't logged in, display our log-in form.
    if (!isset($_SESSION['logged_in'])) {
    	
        include('login_form.php');
        die();
    } else if ($_SESSION['logged_in']) {

        /*         * Set our permission array.
         * anything a guest can do, a volunteer and manager can also do
         * anything a volunteer can do, a manager can do.
         *
         * If a page is not specified in the permission array, anyone logged into the system
         * can view it. If someone logged into the system attempts to access a page above their
         * permission level, they will be sent back to the home page.
         */
        //pages guests are allowed to view
        $permission_array['index.php'] = 0;
        $permission_array['about.php'] = 0;
        $permission_array['apply.php'] = 0;
        //pages volunteers can view
        $permission_array['help.php'] = 1;
        $permission_array['calendar.php'] = 1;
        //pages only managers can view
        $permission_array['personsearch.php'] = 2;
        $permission_array['personedit.php'] = 2;
        $permission_array['viewschedule.php'] = 2;
        $permission_array['addweek.php'] = 2;
        $permission_array['log.php'] = 2;
        $permission_array['reports.php'] = 2;

        //Check if they're at a valid page for their access level.
        $current_page = strtolower(substr($_SERVER['PHP_SELF'], strpos($_SERVER['PHP_SELF'],"/")+1));
        $current_page = substr($current_page, strpos($current_page,"/")+1);
        
        if($permission_array[$current_page]>$_SESSION['access_level']){
            //in this case, the user doesn't have permission to view this page.
            //we redirect them to the index page.
            echo "<script type=\"text/javascript\">window.location = \"index.php\";</script>";
            //note: if javascript is disabled for a user's browser, it would still show the page.
            //so we die().
            die();
        }
        //This line gives us the path to the html pages in question, useful if the server isn't installed @ root.
        $path = strrev(substr(strrev($_SERVER['SCRIPT_NAME']), strpos(strrev($_SERVER['SCRIPT_NAME']), '/')));
		$venues = array("portland"=>"RMH Portland");
        
        //they're logged in and session variables are set.
        if ($_SESSION['venue'] =="") { 
        	echo(' <a href="' . $path . 'personEdit.php?id=' . 'new' . '">Apply</a>');
        	echo(' | <a href="' . $path . 'logout.php">Logout</a><br>');
        }
        else {
            echo('<nav class="navbar navbar-custom navbar-expand-lg bg-light">');
            echo('<div class="container-fluid">');
            echo('<a class="navbar-brand">Gwyneth\'s Gift Homebase</a>');
            echo('<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>');
        	echo('<div class="collapse navbar-collapse" id="navbarSupportedContent">');
            echo('<ul class="navbar-nav me-auto mb-2 mb-lg-0">');
            //echo " <br><b>"."Gwyneth's Gift Homebase"."</b>|"; //changed: 'Homebase' to 'Gwyneth's Gift Homebase'
	        if ($_SESSION['access_level'] >= 1) {
                echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'index.php">Home</a></li>');
                echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'about.php">About</a></li>');
                echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'help.php?helpPage=' . $current_page . '" target="_BLANK">Help</a></li>');
                echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'calendar.php?venue=portland'.''.'">Calendar</a></li>');
                echo('<a class="navbar-brand">|</a>');
                //echo('<button type="button" class="btn btn-link"><a href="' . $path . 'index.php" class="link-primary">home</a></button>');
	        	//echo(' | <button type="button" class="btn btn-link"><a href="' . $path . 'about.php">about</a></button>');
	            //echo(' | <button type="button" class="btn btn-link"><a href="' . $path . 'help.php?helpPage=' . $current_page . '" target="_BLANK">help</a></button>');
	            //echo(' | calendars: <a href="' . $path . 'calendar.php?venue=bangor'.''.'">Bangor, </a>');
	            //echo(' | <button type="button" class="btn btn-link"><a href="' . $path . 'calendar.php?venue=portland'.''.'">calendar</a></button>'); //added before '<a': |, changed: 'Portland' to 'calendar'
	        }
	        if ($_SESSION['access_level'] >= 2) {
	            //echo('<br>master schedules: <a href="' . $path . 'viewSchedule.php?venue=portland'."".'">Portland, </a>');
	            //echo('<a href="' . $path . 'viewSchedule.php?venue=bangor'."".'">Bangor</a>');
	            echo('<a class="navbar-brand">Volunteers</a>');
                echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'personSearch.php">Search</a></li>
			        <li class="nav-item"><a class="nav-link active" aria-current="page" href="personEdit.php?id=' . 'new' . '">Add</a></li>'); //remove after 'add,': <a href="viewScreenings.php?type=new">screenings</a>
	            echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'reports.php?venue='.$_SESSION['venue'].'">Reports</a></li>');
	        }
	        echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'logout.php">Logout</a></li><br>');
            echo('</div></div></nav>');
        }
        
    }
    ?>
</div>
<!-- End Header -->