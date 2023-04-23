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
<header>

    <?PHP
    //Log-in security
    //If they aren't logged in, display our log-in form.
    $showing_login = false;
    if (!isset($_SESSION['logged_in'])) {
        echo '
        <nav>
            <span id="nav-top">
                <span class="logo">
                    <img src="images/gwynethsgift.png">
                    <span id="vms-logo">VMS</span>
                </span>
                <img id="menu-toggle" src="images/menu.png">
            </span>
            <ul>
                <li><a href="login.php">Log in</a></li>
                <li><a href="register.php">Register</a></li>
            </ul>
        </nav>';
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
        $permission_array['logout.php'] = 0;
        $permission_array['register.php'] = 0;
        //pages volunteers can view
        $permission_array['help.php'] = 1;
        $permission_array['dashboard.php'] = 1;
        $permission_array['calendar.php'] = 1;
        $permission_array['eventsearch.php'] = 1;
        $permission_array['changepassword.php'] = 1;
        $permission_array['editprofile.php'] = 1;
        $permission_array['inbox.php'] = 1;
        $permission_array['date.php'] = 1;
        $permission_array['event.php'] = 1;
        $permission_array['viewprofile.php'] = 1;
        $permission_array['viewnotification.php'] = 1;
        $permission_array['volunteerreport.php'] = 1;
        //pages only managers can view
        $permission_array['personsearch.php'] = 2;
        $permission_array['personedit.php'] = 0; // changed to 0 so that applicants can apply
        $permission_array['viewschedule.php'] = 2;
        $permission_array['addweek.php'] = 2;
        $permission_array['log.php'] = 2;
        $permission_array['reports.php'] = 2;
        $permission_array['eventedit.php'] = 2;
        $permission_array['modifyuserrole.php'] = 2;
        $permission_array['addevent.php'] = 2;
        $permission_array['editevent.php'] = 2;
        $permission_array['roster.php'] = 2;
        $permission_array['report.php'] = 2;
        $permission_array['reportspage.php'] = 2;
        $permission_array['resetpassword.php'] = 2;

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
            echo('<nav>');
            echo('<span id="nav-top"><span class="logo"><a class="navbar-brand" href="' . $path . 'index.php"><img src="images/gwynethsgift.png"></a>');
            echo('<a class="navbar-brand" id="vms-logo">VMS</a></span><img id="menu-toggle" src="images/menu.png"></span>');
            echo('<ul>');
            //echo " <br><b>"."Gwyneth's Gift Homebase"."</b>|"; //changed: 'Homebase' to 'Gwyneth's Gift Homebase'
	        if ($_SESSION['access_level'] >= 1) {
                echo('<li><a class="nav-link active" aria-current="page" href="' . $path . 'index.php">Home</a></li>');
                // echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'about.php">About</a></li>');
                // echo('<li class="nav-item"><a class="nav-link active" aria-current="page" href="' . $path . 'help.php?helpPage=' . $current_page . '" target="_BLANK">Help</a></li>');
                echo('<span class="nav-divider">|</span>');
                echo('<span class="navbar-brand">Events</span>');
                echo('<li class="sub-item"><a class="nav-link active" aria-current="page" href="' . $path . 'calendar.php">Calendar</a></li>');
                echo('<li class="sub-item"><a class="nav-link active" aria-current="page" href="' . $path . 'eventSearch.php">Search</a></li>');
                //echo('<button type="button" class="btn btn-link"><a href="' . $path . 'index.php" class="link-primary">home</a></button>');
	        	//echo(' | <button type="button" class="btn btn-link"><a href="' . $path . 'about.php">about</a></button>');
	            //echo(' | <button type="button" class="btn btn-link"><a href="' . $path . 'help.php?helpPage=' . $current_page . '" target="_BLANK">help</a></button>');
	            //echo(' | calendars: <a href="' . $path . 'calendar.php?venue=bangor'.''.'">Bangor, </a>');
	            //echo(' | <button type="button" class="btn btn-link"><a href="' . $path . 'calendar.php?venue=portland'.''.'">calendar</a></button>'); //added before '<a': |, changed: 'Portland' to 'calendar'
	        }
	        if ($_SESSION['access_level'] >= 2) {
	            //echo('<br>master schedules: <a href="' . $path . 'viewSchedule.php?venue=portland'."".'">Portland, </a>');
	            //echo('<a href="' . $path . 'viewSchedule.php?venue=bangor'."".'">Bangor</a>');
	            echo('<li class="sub-item"><a class="nav-link active" aria-current="page" href="' . $path . 'addEvent.php">Add</a></li>');
	            echo('<span class="nav-divider">|</span>');
	            echo('<span class="navbar-brand">Volunteers</span>');
                echo('<li class="sub-item"><a class="nav-link active" aria-current="page" href="' . $path . 'personSearch.php">Search</a></li>
			        <li class="sub-item"><a class="nav-link active" aria-current="page" href="register.php">Add</a></li>'); 
	            echo('<li class="sub-item"><a class="nav-link active" aria-current="page" href="' . $path . 'report.php">Reports</a></li>');
	        }
	        echo('<li><a class="nav-link active" aria-current="page" href="' . $path . 'logout.php">Log out</a></li>');
            echo '</ul></nav>';
        }
        
    }
    ?>
</header>
