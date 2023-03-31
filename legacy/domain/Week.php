<?php
/*
 * Copyright 2015 by Adrienne Beebe, Connor Hargus, Phuong Le, 
 * Xun Wang, and Allen Tucker. This program is part of RMHP-Homebase, which is free 
 * software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 */
/**
 * Person class for RMHP-Hmebase.
 * @author Connor Hargus, Oliver Radwan, Judy Yang, Maxwell Palmer, and Allen Tucker
 * @version May 1, 2008, modified January 21, 2015
 */
include_once('RMHdate.php');
/*
 * Week is an array of dates
 * Weeks start on Mondays
 * For any date given to either constructor function,
 * the script will find the Monday of that week, and generate dates from there
 */

class Week {

    private $id;    // id of the first day of the week, yy-mm-dd;venue, e.g., "02-06-12:house"
    private $dates;    // array of 7 RMHdates, beginning Monday
    private $venue; // venue "house" or "fam"
    private $name;     // the name of the week (ie March 7, 2008 - March 14, 2008)
    private $status; // status of the week, "unpublished", "published" or "archived"
    private $end_of_week_timestamp; // the mktime timestamp of the end of the week

    /**
     * Creates a new calendar week.
     */

    function __construct($dates, $venue, $status) {
        $this->dates = $dates;
        $this->venue = $venue;
        $this->status = $status;
        $this->id = $this->dates[0]->get_id();
        $this->name = $this->dates[0]->get_name() . " to " . $this->dates[6]->get_name();
        $this->end_of_week_timestamp = $this->dates[6]->get_end_time();
    }

    function get_name() {
        return $this->name;
    }

    function get_id() {
        return $this->id;
    }

    function get_dates() {
        return $this->dates;
    }

    function get_status() {
        return $this->status;
    }

    function get_end() {
        return $this->end_of_week_timestamp;
    }

    function get_venue() {
        return $this->venue;
    }

    function set_status($s) {
        if ($s == "unpublished" || $s == "published" || $s == "archived") {
            $this->status = $s;
        }
        else
            return false;
    }

}

?>
