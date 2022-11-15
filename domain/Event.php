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
	private $phone1;   // primary phone -- home, cell, or work
	private $phone1type; // home, cell, or work
	private $birthday;     // format: 64-03-12
	private $type;       // array of "volunteer", "weekendmgr", "sub", "guestchef", "events", "projects", "manager"
	private $status;     // a person may be an "applicant", "active", "LOA", or "former"
	private $availability; // array of day:hours:venue triples; e.g., Mon:9-12:bangor, Sat:afternoon:portland
	private $schedule;     // array of scheduled shift ids; e.g., 15-01-05:9-12:bangor
	private $hours;        // array of actual hours logged; e.g., 15-01-05:0930-1300:portland:3.5
	private $description;        // description that only the manager can see and edit
	private $event_id;		// the unique id that is attached to each event, is then copied into id
	private $password;     // password for calendar and database access: default = $id


	function __construct($f, $en, $v, $p1, $p1t, $t, $st, $av, $sch, $hrs, $bd, $sd, $description, $ev, $pass) {
		//$this->id = $f . $p1;
		$this->id = $ev;//$f . $p1;
		//$this->id = uniqid();
		$this->start_date = $sd;
		$this->venue = $v;
		$this->first_name = $f;
		$this->event_name = $en;
		//have to remove phone1, password, and first name all at the same time
		$this->phone1 = $p1;
		$this->phone1type = $p1t;
		$this->birthday = $bd;
		if ($t !== "")
			$this->type = explode(',', $t);
		else
			$this->type = array();

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
		if ($pass == "")
			$this->password = md5($this->id);
		else
			$this->password = $pass;  // default password == md5($id)
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


	function get_phone1() {
		return $this->phone1;
	}

	function get_phone1type() {
		return $this->phone1type;
	}


	function get_birthday() {
		return $this->birthday;
	}


	function get_type() {
		return $this->type;
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

	function get_password() {
		return $this->password;
	}
}
?>