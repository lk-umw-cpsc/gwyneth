<?php
/*
 * Copyright 2013 by Allen Tucker. 
 * This program is part of RMHC-Homebase, which is free software.  It comes with 
 * absolutely no warranty. You can redistribute and/or modify it under the terms 
 * of the GNU General Public License as published by the Free Software Foundation
 * (see <http://www.gnu.org/licenses/ for more information).
 * 
 */

/*
 * Created on Mar 28, 2008
 * @author Oliver Radwan <oradwan@bowdoin.edu>, Sam Roberts, Allen Tucker
 * @version 3/28/2008, revised 7/1/2015
 */
 class Event {
	private $id;         // id (unique key) = event id
	private $start_date; // format: 99-03-12
	private $venue;      // portland or bangor
	private $first_name; // first name as a string
	private $event_name;  // event name as a string
	private $status;     // a person may be an "applicant", "active", "LOA", or "former"
	private $availability; // array of day:hours:venue triples; e.g., Mon:9-12:bangor, Sat:afternoon:portland
	private $schedule;     // array of scheduled shift ids; e.g., 15-01-05:9-12:bangor
	private $hours;        // array of actual hours logged; e.g., 15-01-05:0930-1300:portland:3.5
	private $description;   // description of the event
	private $event_id;		// the unique id that is attached to each event, is then copied into id


	function __construct($f, $en, $v, $st, $av, $sch, $hrs, $sd, $description, $ev) {
		//$this->id = $f . $p1;
		$this->id = $ev;//$f . $p1;
		//$this->id = uniqid();
		$this->start_date = $sd;
		$this->venue = $v;
		$this->first_name = $f;
		$this->event_name = $en;
		$this->status = $st;
		if ($av == "")
			$this->availability = array();
		else
			$this->availability = explode(',', $av);
		if ($sch !== "")
			$this->schedule = explode(',', $sch);
		else
			$this->schedule = array();
		if ($hrs !== "")
			$this->hours = explode(',', $hrs);
		else
			$this->hours = array();
		$this->description = $description;
		$this->event_id = $ev;
		
	}

	function get_id() {
		return $this->id;
	}

	function get_start_date() {
		return $this->start_date;
	}

	function get_venue() {
		return $this->venue;
	}

	function get_first_name() {
		return $this->first_name;
	}

	function get_event_name() {
		return $this->event_name;
	}

	function get_status() {
		return $this->status;
	}

	function get_availability() {   // array of day:hours:venue
		return $this->availability;
	}

	function set_availability($dayscolonhours) { // tack on the venue for each pair
		$this->availability = array();
		foreach($dayscolonhours as $dayhour) {
			$dh = explode(":",$dayscolonhours);
			$this->availability[] = $dh[0].":".$dh[1].":".$this->venue;
		}
	}

	function get_schedule() {
		return $this->schedule;
	}

	function get_hours() {
		return $this->hours;
	}

	function get_description() {
		return $this->description;
	}

	function get_event_id() {
		return $this->event_id;
	}

}
?>