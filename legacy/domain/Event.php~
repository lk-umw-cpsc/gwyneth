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

/* 
 * Created for Gwyneth's Gift in 2022 using original Homebase code as a guide
 */

 class Event {
	private $id;         // id (unique key) = event id
	private $event_date; // format: 99-03-12
	private $venue;      // portland, leftover from the old two calendar system
	private $event_name;  // event name as a string
	private $description;   // description of the event
	private $event_id;		// the unique id that is attached to each event, is then copied into id, used for editing events


	function __construct($en, $v, $sd, $description, $ev) {
		$this->id = $ev;
		$this->event_date = $sd;
		$this->venue = $v;
		$this->event_name = $en;
		$this->description = $description;
		$this->event_id = $ev;
		
	}

	function get_id() {
		return $this->id;
	}

	function get_event_date() {
		return $this->event_date;
	}

	function get_venue() {
		return $this->venue;
	}

	function get_event_name() {
		return $this->event_name;
	}

	function get_description() {
		return $this->description;
	}

	function get_event_id() {
		return $this->event_id;
	}

}
?>