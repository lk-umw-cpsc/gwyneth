<?php
/*
 * Copyright 2013 by Jerrick Hoang, Ivy Xing, Sam Roberts, James Cook, 
 * Johnny Coster, Judy Yang, Jackson Moniaga, Oliver Radwan, 
 * Maxwell Palmer, Nolan McNair, Taylor Talmage, and Allen Tucker. 
 * This program is part of RMH Homebase, which is free software.  It comes with 
 * absolutely no warranty. You can redistribute and/or modify it under the terms 
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 * 
 */


/**
 * validate_form validates the form data, checking all legality.
 * it returns an array of the errors with the form (string warnings)
 * this array is null (aka false) if there are no errors
 */

 /* 
 * Created for Gwyneth's Gift in 2022 using original Homebase code as a guide
 */

// only check for date and name
function validate_form($event) {
    if (($_POST['event_date'] == "" || strlen($_POST['event_date']) != 10)) 
        $errors[] = 'Please select a valid event date';
    if ($_POST['event_name'] == null)
        $errors[] = 'Please enter an event name';

    return $errors;
}




function show_errors($e) {
    //this function should display all of our errors.
    echo('<div class="warning">');
    echo('<ul>');
    foreach ($e as $error) {
        echo("<li><strong><font color=\"red\">" . $error . "</font></strong></li>\n");
    }
    echo("</ul></div></p>");
}

?>