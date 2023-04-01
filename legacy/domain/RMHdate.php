<?php
/*
 * Copyright 2015 by Allen Tucker. This program is part of RMHC-Homebase, which is free 
 * software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information). new RMHdate
 */
include_once(dirname(__FILE__).'/Shift.php');
include_once(dirname(__FILE__).'/../database/dbMasterSchedule.php');
/* A class to manage an RMHDate
 * @version May 1, 2008, revised February 10, 2015
 * @author Yonah Biers-Ariel, Phuong Le and Maxwell Palmer
 */

class RMHdate {

    private $id;    // "yy-mm-dd:venue" form of this date: used as a key
    private $month;       // Textual month of the year  (e.g., Jan)
    private $day;         // Textual day of the week (Mon - Sun)
    private $dom;         // Numerical day of month
    private $month_num;   // Numerical month
    private $day_of_week; // Numerical day of the week (1-7, Mon = 1)
    private $day_of_year; // Numerical day of the year (1-366)
    private $week_of_month; // String "1st", "2nd", "3rd", "4th", or "5th"
    private $week_of_year; // String "odd" or "even" (as week of year = 1, 3, 5 ... or 2, 4, 6 ...)
    private $year;        // Numerical year (e.g., 2008)
    private $venue; 		// venue "house" or "fam"
    private $shifts;      // array of Shifts
    private $mgr_notes;   // notes on night/weekend manager

    /*
     * Construct an RMHdate and initialize its vacant shifts
     * Test that arguments $mm, $dd, $yy are valid, using the
     * function checkdate
     */

    function __construct($yy_mm_dd, $venue, $shifts, $mgr_notes) {
        $mm = substr($yy_mm_dd, 3, 2);
        $dd = substr($yy_mm_dd, 6, 2);
        $yy = substr($yy_mm_dd, 0, 2);
        if (!checkdate($mm, $dd, $yy)) {
            $this->id = null;
            echo "Error: invalid date for RMHdate constructor " . $mm . $dd . $yy;
            return;
        }
    
        $my_date = mktime(0, 0, 0, $mm, $dd, $yy);
        $this->id = $yy_mm_dd . ":" . $venue;
        $this->month = date("M", $my_date);
        $this->day = date("D", $my_date);
        $this->year = date("Y", $my_date);
        $this->day_of_week = date("N", $my_date);
        $this->day_of_year = date("z", $my_date) + 1;
        $this->dom = date("d", $my_date);
        
 		$this->week_of_month= floor(($this->dom -1)/7)+1;
        if (date("W", $my_date)%2==1)
            $this->week_of_year= "odd";
        else 
        	$this->week_of_year= "even";	
        $this->venue = $venue;
        $this->month_num = date("m", $my_date);
        if (sizeof($shifts) !== 0)
            $this->shifts = $shifts;
        else
            $this->generate_shifts($this->day_of_week,$this->venue);
        $this->mgr_notes = $mgr_notes;
    }

    /*
     * Generate all shifts for the given venue on a given date, 
     * using the master schedule as a template
     */

    function generate_shifts($day,$venue) {
        $days = array(1 => "Mon", 2 => "Tue", 3 => "Wed", 4 => "Thu", 5 => "Fri", 6 => "Sat", 7 => "Sun");
        $this->shifts = array();
        echo "day, venue, wom, woy = ".$day." ".$venue. " " . $this->week_of_month . " " . $this->week_of_year;
        $master1 = get_master_shifts($venue, $this->week_of_month, $days[$day]);
        $master2 = get_master_shifts($venue, $this->week_of_year, $days[$day]);
        $master = array_merge($master1,$master2);
        for ($i = 0; $i < sizeof($master); $i++) {     // $master[$i] is a MasterScheduleEntry
            $t = $master[$i]->get_hours();
            $this->shifts[$t] = new Shift(
                substr($this->id,0,8).":".$t, $venue, $master[$i]->get_slots(), null, null, "", "");
        }
    }

    /*
     * @return "yy-mm-dd:venue"
     */

    function get_id() {
        return $this->id;
    }

    function get_dom() {
        return $this->dom;
    }

    /*
     * @return the textual day of the week
     */

    function get_day() {
        return $this->day;
    }

    // @return the numerical day of the week, Monday = 1
    function get_day_of_week() {
        return $this->day_of_week;
    }

    // @return the numerical day of the year (starting at 1)
    function get_day_of_year() {
        return $this->day_of_year;
    }
	function get_week_of_month () {
		return $this->week_of_month;
	}
	function get_week_of_year () {  
		return $this->week_of_year;
	}
    function get_year() {
        return $this->year;
    }
    function get_shifts() {
        return $this->shifts;
    }
    
    // @return the number of shifts for this day
    function get_num_shifts() {
        return count($this->shifts);
    }

    /*
     * @return a shift
     * @param the shift's key
     */

    function get_shift($key) {
        return $this->shifts[$key];
    }

    /**
     * if there's a shift starting at $shift_start for the given venue, return its id.
     * Otherwise, return false
     */
    function get_shift_id($shift_start) {
    	if ($shift_start==21) {
        	foreach ($this->shifts as $shift) 
                if ($shift->get_hours() == "night")
                    return $shift->get_id();
    	}
        else {
        	$candidate = $this->get_id() . "-" . $shift_start . "-" . $i;
            foreach ($this->shifts as $shift) 
                if ($shift->get_start_time() == $shift_start)
                    return $shift->get_id();
        }
        return false;
    }

    /*
     * replace a shift by a new shift in a date's associative array of shifts
     * @param the shift, the new shift
     */

    function replace_shift($shift, $newshift) {
        $newshifts = array();
        foreach ($this->shifts as $key => $value)
            if ($this->get_shift($key)->get_id() === $shift->get_id())
                $newshifts[$newshift->get_id()] = $newshift;
            else
                $newshifts[$key] = $value;
        $this->shifts = $newshifts;
        return $this;
    }

    /**
     * @return string name of the date
     */
    function get_name() {
        return date("F j, Y", mktime(0, 0, 0, $this->month_num, $this->dom, $this->year));
    }

    function get_end_time() {
        return mktime(23, 59, 59, $this->month_num, $this->dom, $this->year);
    }

    function get_mgr_notes() {
        return $this->mgr_notes;
    }

    function set_mgr_notes($s) {
        $this->mgr_notes = $s;
    }

}
?>