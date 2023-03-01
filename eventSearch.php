<?php
/*
 * Copyright 2015 by Allen Tucker. This program is part of RMHP-Homebase, which is free 
 * software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 */
/* 
 * Modified by Xun Wang on Feb 25, 2015
 */

/* 
 * Created for Gwyneth's Gift in 2022 using original Homebase code as a guide
 */

session_cache_expire(30);
session_start();
?>
<html>
    <head>
        <title>
            Search for Events
        </title>
        <!-- <link rel="stylesheet" href="lib\bootstrap\css\bootstrap.css" type="text/css" /> -->
        <link rel="stylesheet" href="styles.css" type="text/css" />
		<link rel="stylesheet" href="lib/jquery-ui.css" />
        <?php require('universal.inc') ?>
		
    </head>
    <body style="background-color: rgb(250, 249, 246);">
        <div class="container-fluid" id="container">
            <?PHP include('header.php'); ?>
            <div class="container-fluid" id="content">
                <?PHP
                // display the search form
                $area = $_GET['area'];
                echo('<form method="post">');
                echo('<p><strong>Search for events:</strong>');
               
                echo '<p>Event name (type a few letters): ';
                echo '<input type="text" name="s_name">';

                echo('<p><input class="btn btn-success" type="submit" name="Search" value="Search">');
                echo('</form></p>');

                // if user hit "Search"  button, query the database and display the results
                if ($_POST['Search']) {
                    $name = trim(str_replace('\'', '&#39;', htmlentities($_POST['s_name'])));
                    // now go after the events that fit the search criteria
                    include_once('database/dbEvents.php');
                    include_once('domain/Event.php');
                    $result = getonlythose_dbEvents($name, $_POST['s_day'], $_SESSION['venue']); 
                    echo '<p><strong>Search Results:</strong> <p>Found ' . sizeof($result) . ' ';   
                        echo "events";
                    if ($name != "")
                        echo ' with name like "' . $name . '"';
				    if (sizeof($result) > 0) {
				       echo ' (select one for more info).';
                       echo '<div class="overflow-auto" id="target" style="width: variable; height: 400px;">';
				       echo '<p><table class="table table-info table-responsive table-striped-columns table-hover table-bordered"> <tr><td>Event Name</td><td>Event Date (YY-MM-DD)</td></tr>';
				       foreach ($result as $vol) {
				          echo "<tr><td><a href=eventEdit.php?id=" . 
				               str_replace(" ","_",$vol->get_id()) . ">" .
				                $vol->get_event_name() . "</td><td>" . $vol->get_event_date();
				          echo "</td></a></tr>";
				       }
				       echo '</table>';
				       echo '</div>';   
				    }
				               
                }
                ?>
                <!-- below is the footer that we're using currently-->
                </div>
        </div>
        <?PHP include('footer.inc'); ?>
    </body>
</html>

