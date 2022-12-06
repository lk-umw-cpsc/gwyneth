<?php

/*
//Intro
In this iteration of the homepage project we made little to no changes to the MasterScheduleEntry.php RMHdate.php SCL.php Shift.php 
and Week.php classes and their related files. The original homebase code used as a starting point for this iteration can be
found here - https://github.com/megandalster/homebasedemo2017 and a demo of this prior iteration here - https://npfi.org/homebase-demo/

//Access levels - 
There are different access levels for the site which determine who has access to certain links, functions etc.
Information about access levels can be found in header.php (this file handles links at the top of the site too).

//Person files - 
Each time you want to add/remove a person field make sure to update all relevant files, including line 24 of personEdit.php where a 
new person object is created, and also update the constructor parameters and body in Person.php. Additionally be sure to update the sql table.

Use the commands below to search through files on the site:
grep SearchingFor -r
grep 'Searching For' -r

When a user makes an edit to a person, the existing person is deleted and a new one added. First name and primary phone are used to
make a persons id in the persons database table so they cannot be edited. A potential solution to this problem can be found in events.

//Event files - 
The algorithm for adding/removing event fields is the same as persons. The events files are a trimmed down version of the persons files.

Similar to the way persons are edited, the event is deleted and a new one created. However the event id is created via a function, uniqid(),
and this is preserved in the new event being created. This method makes it so that the url and id is never changed in the editing process and
unlike persons, all fields can be set up to be edited if needed. 

//Help page -
The original homepage help page contained information that is not relevant to this iteration of the website. However, rather than removing
this info, it has just been commented out and can be accessed as needed.

//Calendar -
The homebase code used as a starting point for this iteration contained a dual calendar system for two different venues. These two 
venues were Bangor and Portland. This two venue system still remains in much of the backend, however the current iteration has been
set so that persons default to Portland. This two calendar system should either be completely altered to a single one and renamed
or the unused venue can be utilized for some other purpose. 

//Remaining bugs found in the files worked on -
Notifications on the home page being blank will make everything below not load properly.
When manager makes a new account, they must select a position for the new account, otherwise a blank page appears upon submitting.

*/

?>