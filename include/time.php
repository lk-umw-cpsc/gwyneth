<?php

/* Take two 24-hour times and return the number of hours between them */
function calculateHourDuration($start, $end) {
    $start = explode(':', $start);
    $end = explode(':', $end);
    if (count($start) != 2 || count($end) != 2) {
        return -1;
    }
    $startHours = intval($start[0]);
    $startMinutes = intval($start[1]);
    $endHours = intval($end[0]);
    $endMinutes = intval($end[1]);

    $hours = $endHours - $startHours;
    $minutes = $endMinutes - $startMinutes;
    if ($minutes < 0) {
	$hours--;
	$minutes += 60;
    }
    if ($minutes > 0)
  	return number_format(($hours + ($minutes / 60.0)), 1, '.', '');
    else
  	return $hours + ($minutes / 60.0);
}

?>
