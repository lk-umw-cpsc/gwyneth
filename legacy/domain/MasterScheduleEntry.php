<?php
/*
 * Copyright 2015 by Allen Tucker. This program is part of RMHP-Homebase, which is free 
 * software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 */
/**
 * MasterScheduleEntry class for RMHC-Homebase.
 * @author Allen Tucker
 * @version January 2, 2015
 */

class MasterScheduleEntry {
	private $venue; 		// "portland" or "bangor" for House or Family Room
	private $day;           // "Mon", "Tue", ... "Sun"
	private $week_no;       // week of month 1st-5th, or week of year 'odd' or 'even'
	private $hours;    		// "9-12", "12-3", "3-6", "6-9", or "night"
	private $slots;         // the number of slots to be filled for this shift
	private $persons;       // array of ids, first and last names, eg ["alex2071234567+Jane+doe"]
	private $notes;         // notes to be displayed for this entry
	private $id;	        // unique string for each entry = week_no:day:hours:venue
	  
	/**
	* constructor for all MasterScheduleEntries
	*/
	function __construct($venue, $day, $week_no, $hours, $slots, $persons, $notes){
		$this->venue = $venue;
		$this->day = $day;
		$this->week_no = $week_no;
		$this->hours = $hours;
		$this->slots = $slots;
		if ($persons !== "")
			$this->persons = explode(',',$persons);
		else
			$this->persons = array();
		$this->notes = $notes;
		$this->id = $week_no.":".$day.":".$hours.":".$venue;
	}
	
	/**
	*  getter functions
	*/
	
	function get_venue(){
		return $this->venue;
	}
	function get_day(){
		return $this->day;
	}
	function get_week_no(){
		return $this->week_no;
	}
	function get_hours(){ 
		return $this->hours;
	}
	function get_slots(){
		return $this->slots;
	}
	function get_persons(){
		return $this->persons;
	}
	function get_notes(){
		return $this->notes; 
	}
	function get_id(){
		return $this->id;
	}
	
	function set_notes($notes){
		$this->notes = $notes; 
	}
	function get_name() {
		$daynames = array("Mon"=>"Monday","Tue"=>"Tuesday","Wed"=>"Wednesday","Thu"=>"Thursday",
					"Fri"=>"Friday", "Sat"=>"Saturday", "Sun"=>"Sunday");
		$venues = array("portland"=>"Portland House", "bangor"=>"Bangor House");
		$hours = array("9-12"=>"9am to 12pm", "10-1"=>"10am to 1pm", "12-3"=>"12pm to 3pm", "1-4"=>"1pm to 4pm", 
				"2-5"=>"2pm to 5pm", "3-6"=>"3pm to 6pm", "5-9"=>"5pm to 9pm", "6-9"=>"6pm to 9pm", 
				"9-5"=> "9am to 5pm", "night"=>"night");
		return $venues[$this->venue]." Master Schedule, ".$this->week_no." ".$daynames[$this->day].
					"s, ".$hours[$this->hours];
		
		
	}	
}

?>