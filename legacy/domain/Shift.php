<?php
/*
 * Copyright 2015 by Adrienne Beebe, Connor Hargus, Phuong Le, 
 * Xun Wang, and Allen Tucker. This program is part of RMHP-Homebase, which is free 
 * software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).mm_dd_yy
 */
/*
 * class Shift characterizes a time interval in a day new Shift
 * for scheduling volunteers
 * @version May 1, 2008, modified 9/15/08, 2/14/10, 2/5/15
 * @author Allen Tucker and Xun Wang
 */

include_once(dirname(__FILE__).'/../database/dbShifts.php');
include_once(dirname(__FILE__).'/../database/dbPersons.php');

class Shift {

    private $yy_mm_dd;      // String: "yy-mm-dd".
    private $hours;          // String: '9-1', '1-5', '5-9' or 'night'
    private $start_time;    // Integer: e.g. 10 (meaning 10:00am)     
    private $end_time;      // Integer: e.g. 13 (meaning 1:00pm)	  
    private $venue;         // "house", "fam", or "mealprep"
    private $vacancies;     // number of vacancies in this shift
    private $persons;       // array of person ids filling slots, followed by their name, ie "malcom1234567890+Malcom+Jones"
    private $removed_persons; // array of persons who have previously been removed from this shift.
    private $sub_call_list; // SCL if sub call list exists, otherwise null
    private $day;           // string name of day "Monday"...
    private $id;            // "yy-mm-dd:hours:venue is a unique key for this shift
    private $notes;         // notes written by the manager

    /*
     * construct an empty shift with a certain number of vacancies
     */

    function __construct($yy_mm_ddhours, $venue, $vacancies, $persons, $removed_persons, $sub_call_list, $notes) {
    	$this->yy_mm_dd = substr($yy_mm_ddhours, 0, 8);
        $this->hours = substr($yy_mm_ddhours, 9);
        $i = strpos($this->hours, "-");
        if ($i>0) {
        	$this->start_time = substr($this->hours, 0, $i);   
        	$this->end_time = substr($this->hours, $i + 1);
        	if ($this->end_time!=12)
        		$this->end_time += 12;
        	if ($this->start_time < 9) {
        		$this->start_time += 12;
        	}
        }
        else {  // assuming an overnight shift
        	$this->start_time = 0;
        	$this->end_time = 1;
        }
        $this->venue = $venue;
        $this->vacancies = $vacancies;
        $this->persons = $persons;
        $this->removed_persons = $removed_persons;
        $this->sub_call_list = $sub_call_list;
        $this->day = date("D", mktime(0, 0, 0, substr($this->yy_mm_dd, 3, 2), substr($this->yy_mm_dd, 6, 2), "20" . substr($this->yy_mm_dd, 0, 2)));
        $this->id = $yy_mm_ddhours.":".$venue;
        $this->notes = $notes;	
    }

    /**
     * This function (re)sets the start and end times for a shift
     * and corrects its $id accordingly
     * Precondition:  0 <= $st && $st < $et && $et < 24
     *          && the shift is not "chef" or "night"
     * Postcondition: $this->start_time == $st && $this->end_time == $et
     *          && $this->id == $this->yy_mm_dd .  "-"
     *          . $this->start_time . "-" . $this->end_time . $this->venue
     *          && $this->hours == substr($this->id, 9)
     */
    function set_start_end_time($st, $et) {
        if (0 <= $st && $st < $et && $et < 24 &&
                strpos(substr($this->id, 9), "-") !== false) {
            $this->start_time = $st;
            $this->end_time = $et;
            if ($st>12)
            	$st -= 12;
            if ($et>12)
            	$et -=12;
            $this->id = $this->yy_mm_dd . ":" . $st
                    . "-" . $et.":".$this->venue;
            $this->hours = substr($this->id, 9);
            return $this;
        }
        else
            return false;
    }

    /*
     * @return the number of vacancies in this shift.
     */

    function num_vacancies() {
        return $this->vacancies;
    }

    function ignore_vacancy() {
        if ($this->vacancies > 0)
            --$this->vacancies;
    }

    function add_vacancy() {
        ++$this->vacancies;
    }

    function num_slots() {
        if (!$this->persons[0])
            array_shift($this->persons);  
        return $this->vacancies + count($this->persons);
    }

    function has_sub_call_list() {
        if ($this->sub_call_list == "yes")
            return true;
        return false;
    }

    function open_sub_call_list() {
        $this->sub_call_list = "yes";
    }

    function close_sub_call_list() {
        $this->sub_call_list = "no";
    }

    /*
     * getters and setters
     */
    function get_yy_mm_dd() {
    	return $this->yy_mm_dd;
    }

    function get_hours() {
        return $this->hours;
    }

    function get_start_time() {
        return $this->start_time;
    }

    function get_end_time() {
        return $this->end_time;
    }
    function get_time_of_day() { //Redundant function, same as get_hours()
        return $this->hours;
    }
    
    function get_date() {
        return $this->yy_mm_dd;
    }

    function get_venue() {
        return $this->venue;
    }

    function get_persons() {
        return $this->persons;
    }
    
    function get_removed_persons() {
    	return $this->removed_persons;
    }

    function get_sub_call_list() {
        return $this->sub_call_list;
    }

    function get_id() {
        return $this->id;
    }

    function get_day() {
        return $this->day;
    }

    function get_notes() {
        return $this->notes;
    }

	function get_vacancies() {
    	return $this->vacancies;
    }
    
    
    function set_notes($notes) {
        $this->notes = $notes;
    }
    
    function assign_persons($p) {
    	foreach ($this->persons as $person) {
    		if (!in_array($person, $p)) {
    			error_log("adding ".$person." to removed persons");
    			$this->removed_persons[] = $person;
    		}
    	}
        $this->persons = $p;
    }
    
    function duration () {
    	if ($this->end_time == 1 && $this->start_time == 0) {
    		// overnight shift
    		return 12;
    	} else return $this->end_time - $this->start_time;
    }
    
}

?>
