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

$accessLevelsByRole = [
	'volunteer' => 1,
	'admin' => 2,
	'superadmin' => 3
];

class Person {
	private $id;         // id (unique key) = first_name . phone1
	private $start_date; // format: 99-03-12
	private $venue;      // portland or bangor
	private $first_name; // first name as a string
	private $last_name;  // last name as a string
	private $address;   // address - string
	private $city;    // city - string
	private $state;   // state - string
	private $zip;    // zip code - integer
  	private $profile_pic; // image link
	private $phone1;   // primary phone -- home, cell, or work
	private $phone1type; // home, cell, or work
	private $phone2;   // secondary phone -- home, cell, or work
	private $phone2type; // home, cell, or work
	private $birthday;     // format: 64-03-12
	private $email;   // email address as a string
	private $shirt_size;   // t-shirt size
	private $computer;   // computer - yes or no
	private $camera;   // camera - yes or no
	private $transportation;   // transportation - yes or no
	private $contact_name;   // emergency contact name
	private $contact_num;   // emergency cont. phone number
	private $relation;   // relation to emergency contact
	private $contact_time; //best time to contact volunteer
	private $cMethod;    // best contact method for volunteer (email, phone, text)
	private $position;    // job title or "student"
	private $credithours; // hours required if volunteering for academic credit; otherwise blank
	private $howdidyouhear;  // about RMH; internet, family, friend, volunteer, other (explain)
	private $commitment;  // App: "year" or "semester" (if student) or N/A (guest chef, events, or projects)
	private $motivation;   // App: why interested in RMH?
	private $specialties;  // special training or skills
	private $convictions;  // App: ever convicted of a felony?  "yes" or blank
	private $type;       // array of "volunteer", "weekendmgr", "sub", "guestchef", "events", "projects", "manager"
	private $access_level;
	private $status;     // a person may be "active" or "inactive"
	private $availability; // array of day:hours:venue triples; e.g., Mon:9-12:bangor, Sat:afternoon:portland
	private $schedule;     // array of scheduled shift ids; e.g., 15-01-05:9-12:bangor
	private $hours;        // array of actual hours logged; e.g., 15-01-05:0930-1300:portland:3.5
	private $notes;        // notes that only the manager can see and edit
	private $password;     // password for calendar and database access: default = $id
	// Volunteer availability start and end for each week day in 24h format, hh:mm
	private $sundaysStart;
	private $sundaysEnd;
	private $mondaysStart;
	private $mondaysEnd;
	private $tuesdaysStart;
	private $tuesdaysEnd;
	private $wednesdaysStart;
	private $wednesdaysEnd;
	private $thursdaysStart;
	private $thursdaysEnd;
	private $fridaysStart;
	private $fridaysEnd;
	private $saturdaysStart;
	private $saturdaysEnd;
	private $mustChangePassword;
	private $gender;

	function __construct($f, $l, $v, $a, $c, $s, $z, $pp, $p1, $p1t, $p2, $p2t, $e, $ts, $comp, $cam, $tran, $cn, $cpn, $rel,
			$ct, $t, $st, $cntm, $pos, $credithours, $comm, $mot, $spe,
			$convictions, $av, $sch, $hrs, $bd, $sd, $hdyh, $notes, $pass,
			$suns, $sune, $mons, $mone, $tues, $tuee, $weds, $wede,
			$thus, $thue, $fris, $frie, $sats, $sate, $mcp, $gender) {
		$this->id = $e;
		$this->start_date = $sd;
		$this->venue = $v;
		$this->first_name = $f;
		$this->last_name = $l;
		$this->address = $a;
		$this->city = $c;
		$this->state = $s;
		$this->zip = $z;
    	$this->profile_pic = $pp;
		$this->phone1 = $p1;
		$this->phone1type = $p1t;
		$this->phone2 = $p2;
		$this->phone2type = $p2t;
		$this->birthday = $bd;
		$this->email = $e;
		$this->shirt_size = $ts;
		$this->computer = $comp;
		$this->camera = $cam;
		$this->transportation = $tran;
		$this->contact_name = $cn;
		$this->contact_num = $cpn;
		$this->relation = $rel;
		$this->contact_time = $ct;
		$this->cMethod = $cntm;
		$this->position = $pos;
		$this->credithours = $credithours;
		$this->howdidyouhear = $hdyh;
		$this->commitment = $comm;
		$this->motivation = $mot;
		$this->specialties = $spe;
		$this->convictions = $convictions;
		$this->mustChangePassword = $mcp;
		if ($t !== "") {
			$this->type = explode(',', $t);
			global $accessLevelsByRole;
			$this->access_level = $accessLevelsByRole[$t];
		} else {
			$this->type = array();
			$this->access_level = 0;
		}
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
		$this->notes = $notes;
		if ($pass == "")
			$this->password = password_hash($this->id, PASSWORD_BCRYPT); // default password
		else
			$this->password = $pass;
		$this->sundaysStart = $suns;
		$this->sundaysEnd = $sune;
		$this->mondaysStart = $mons;
		$this->mondaysEnd = $mone;
		$this->tuesdaysStart = $tues;
		$this->tuesdaysEnd = $tuee;
		$this->wednesdaysStart = $weds;
		$this->wednesdaysEnd = $wede;
		$this->thursdaysStart = $thus;
		$this->thursdaysEnd = $thue;
		$this->fridaysStart = $fris;
		$this->fridaysEnd = $frie;
		$this->saturdaysStart = $sats;
		$this->saturdaysEnd = $sate;
		$this->gender = $gender;
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

	function get_last_name() {
		return $this->last_name;
	}

	function get_address() {
		return $this->address;
	}

	function get_city() {
		return $this->city;
	}

	function get_state() {
		return $this->state;
	}

	function get_zip() {
		return $this->zip;
	}

  function get_profile_pic() {
    return $this->profile_pic;
  }

	function get_phone1() {
		return $this->phone1;
	}

	function get_phone1type() {
		return $this->phone1type;
	}

	function get_phone2() {
		return $this->phone2;
	}

	function get_phone2type() {
		return $this->phone2type;
	}

	function get_birthday() {
		return $this->birthday;
	}

	function get_email() {
		return $this->email;
	}

	function get_shirt_size() {
		return $this->shirt_size;
	}

	function get_computer() {
		return $this->computer;
	}

	function get_camera() {
		return $this->camera;
	}

	function get_transportation() {
		return $this->transportation;
	}

	function get_contact_name() {
		return $this->contact_name;
	}

	function get_contact_num() {
		return $this->contact_num;
	}

	function get_relation() {
		return $this->relation;
	}

	function get_contact_time() {
		return $this->contact_time;
	}

	function get_cMethod() {
		return $this->cMethod;
	}

	function get_position() {
		return $this->position;
	}

	function get_credithours() {
		return $this->credithours;
	}

	function get_howdidyouhear() {
		return $this->howdidyouhear;
	}

	function get_commitment() {
		return $this->commitment;
	}

	function get_motivation() {
		return $this->motivation;
	}

	function get_specialties() {
		return $this->specialties;
	}

	function get_convictions() {
		return $this->convictions;
	}

	function get_type() {
		return $this->type;
	}

	function get_status() {
		return $this->status;
	}

	function get_availability() { // array of day:hours:venue
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

	function get_notes() {
		return $this->notes;
	}

	function get_password() {
		return $this->password;
	}

	function get_sunday_availability_start() {
		return $this->sundaysStart;
	}

	function get_sunday_availability_end() {
		return $this->sundaysEnd;
	}

	function get_monday_availability_start() {
		return $this->mondaysStart;
	}

	function get_monday_availability_end() {
		return $this->mondaysEnd;
	}

	function get_tuesday_availability_start() {
		return $this->tuesdaysStart;
	}

	function get_tuesday_availability_end() {
		return $this->tuesdaysEnd;
	}

	function get_wednesday_availability_start() {
		return $this->wednesdaysStart;
	}

	function get_wednesday_availability_end() {
		return $this->wednesdaysEnd;
	}

	function get_thursday_availability_start() {
		return $this->thursdaysStart;
	}

	function get_thursday_availability_end() {
		return $this->thursdaysEnd;
	}

	function get_friday_availability_start() {
		return $this->fridaysStart;
	}

	function get_friday_availability_end() {
		return $this->fridaysEnd;
	}

	function get_saturday_availability_start() {
		return $this->saturdaysStart;
	}

	function get_saturday_availability_end() {
		return $this->saturdaysEnd;
	}

	function get_access_level() {
		return $this->access_level;
	}

	function is_password_change_required() {
		return $this->mustChangePassword;
	}

	function get_gender() {
		return $this->gender;
	}
}