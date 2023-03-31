<?php
/*
 * Copyright 2015 by Adrienne Beebe, Connor Hargus, Phuong Le, 
 * Xun Wang, and Allen Tucker. This program is part of RMHP-Homebase, which is free 
 * software.  It comes with absolutely no warranty. You can redistribute and/or 
 * modify it under the terms of the GNU General Public License as published by the 
 * Free Software Foundation (see <http://www.gnu.org/licenses/ for more information).
 */
/*
 * A class to manage a sub call list for a particular shift
 * @version May 1, 2008
 * @author Maxwell Palmer
 */

class SCL {

    private $id;   // yy-mm-dd:hours:venue, the same id as the shift it belongs to
    private $persons;  // array of person information arrays
    // person[i]=array(personid, first_name, last_name, phone1, phone2,
    // date_called, result, accepted);
    private $status;  // open, closed
    private $vacancies;     // number of slots to fill
    private $time;      // YYYYMMDD#, # is shift order

    /*
     * makes a scl object.  from either the db or from the generating form in edit shifts
     */

    function __construct($id, $persons, $status, $vacancies, $time) {
        $this->id = $id;
        $this->persons = $persons;
        $this->status = $status;
        $this->vacancies = $vacancies;
        $this->time = $time;
    }

    function get_id() {
        return $this->id;
    }

    function get_persons() {
        return $this->persons;
    }

    function get_status() {
        return $this->status;
    }

    function get_vacancies() {
        return $this->vacancies;
    }

    function get_time() {
        return $this->time;
    }

    function set_persons($persons) {
        $this->persons = $persons;
    }

    function set_status($status) {
        $this->status = $status;
    }

    function set_vacancies($vacancies) {
        $this->vacancies = $vacancies;
    }

    function set_time($time) {
        $this->time = $time;
    }

}

?>