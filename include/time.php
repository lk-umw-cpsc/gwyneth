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
    return $hours + ($minutes / 60.0);
}

?>