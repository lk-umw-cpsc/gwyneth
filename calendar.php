<?php
    session_start();
    session_cache_expire(30);

    date_default_timezone_set("America/New_York");
    // Redirect to current month
    if (!isset($_GET['month'])) {
        header('Location: calendar.php?month=' . date("Y-m"));
    }

    $today = strtotime(date("Y-m-d"));

    // Fetch month from URL
    $month = $_GET['month'];
    $first = $month . '-01';
    // Convert to date
    $month = strtotime($month);
    // Find first day of the month
    $first = strtotime($first);
    // Find previous and next month
    $previousMonth = strtotime(date('Y-m', $month) . ' -1 month');
    $nextMonth = strtotime(date('Y-m', $month) . ' +1 month');
    // Validate; redirect if bad arg given
    if (!$month) {
        header('Location: calendar.php?month=' . date("Y-m"));
    }
    $calendarStart = $first;
    // Back up until we find the first Sunday that should appear on the calendar
    while (date('w', $calendarStart) > 0) {
        $calendarStart = strtotime(date('Y-m-d', $calendarStart) . ' -1 day');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require('universal.inc'); ?>
    </head>
    <body>
        <?php require('header.php'); ?>
        <main class="calendar-view">
            <h1 class='calendar-header'><a href="calendar.php?month=<?php echo date("Y-m", $previousMonth); ?>">&lt;</a><span>Events - <?php echo date('F Y', $month); ?></span><a href="calendar.php?month=<?php echo date("Y-m", $nextMonth); ?>">&gt;</a></h1>
            <table id="calendar">
                <thead>
                    <tr>
                        <th>Sunday</th>
                        <th>Monday</th>
                        <th>Tuesday</th>
                        <th>Wednesday</th>
                        <th>Thursday</th>
                        <th>Friday</th>
                        <th>Saturday</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $date = $calendarStart;
                    for ($week = 0; $week < 5; $week++) {
                        echo '
                            <tr class="calendar-week">
                        ';
                        for ($day = 0; $day < 7; $day++) {
                            $extraAttributes = '';
                            $extraClasses = '';
                            if ($date == $today) {
                                $extraClasses = ' today';
                            }
                            if (date('m', $date) != date('m', $month)) {
                                $extraClasses .= ' other-month';
                                $extraAttributes .= ' data-month="' . date('Y-m', $date) . '"';
                            }
                            $events = '';
                            if ($day + $week * 7 == 14) {
                                $events .= '<a class="calendar-event" href="#">8a Event 1</a>';
                            }
                            echo '
                            <td class="calendar-day' . $extraClasses . '" ' . $extraAttributes . '>
                                <div class="calendar-day-wrapper">
                                    <p class="calendar-day-number">' . date('j', $date) . '</p>
                                    ' . $events . '
                                </div>
                            </td>';
                            $date = strtotime(date('Y-m-d', $date) . ' +1 day');
                        }
                        echo '
                            </tr>';
                    }
                ?>
                </tbody>
            </table>
            <!-- <table id="calendar">
                <tr class="calendar-week">
                    <td class="calendar-day other-month">
                        <div class="calendar-day-wrapper">
                            <p class="calendar-day-number">26</p>
                        </div>
                    </td>
                    <td class="calendar-day other-month">
                        <div class="calendar-day-wrapper">
                            <p class="calendar-day-number">26</p>
                        </div>
                    </td>
                    <td class="calendar-day other-month">
                        <div class="calendar-day-wrapper">
                            <p class="calendar-day-number">27</p>
                        </div>
                    </td>
                    <td class="calendar-day other-month today">
                        <div class="calendar-day-wrapper">
                            <p class="calendar-day-number">28</p>
                        </div>
                    </td>
                    <td class="calendar-day">
                        <div class="calendar-day-wrapper">
                            <p class="calendar-day-number">1</p>
                            <a class="calendar-event" href="#">8a Event 1</a>
                            <a class="calendar-event" href="#">12:30p Event 2</a>
                            <a class="calendar-event" href="#">5pm Event 3</a>
                        </div>
                    </td>
                    <td class="calendar-day">
                        <div class="calendar-day-wrapper">
                            <p class="calendar-day-number">2</p>
                        </div>
                    </td>
                    <td class="calendar-day">
                        <div class="calendar-day-wrapper">
                            <p class="calendar-day-number">3</p>
                        </div>
                    </td>
                </tr>
                <tr class="calendar-week">
                    <td class="calendar-day"></td>
                    <td class="calendar-day"></td>
                    <td class="calendar-day"></td>
                    <td class="calendar-day"></td>
                    <td class="calendar-day"></td>
                    <td class="calendar-day"></td>
                    <td class="calendar-day"></td>
                </tr>
                <tr class="calendar-week">
                    <td class="calendar-day"></td>
                    <td class="calendar-day"></td>
                    <td class="calendar-day"></td>
                    <td class="calendar-day"></td>
                    <td class="calendar-day"></td>
                    <td class="calendar-day"></td>
                    <td class="calendar-day"></td>
                </tr>
                <tr class="calendar-week">
                    <td class="calendar-day"></td>
                    <td class="calendar-day"></td>
                    <td class="calendar-day"></td>
                    <td class="calendar-day"></td>
                    <td class="calendar-day"></td>
                    <td class="calendar-day"></td>
                    <td class="calendar-day"></td>
                </tr>
                <tr class="calendar-week">
                    <td class="calendar-day"></td>
                    <td class="calendar-day"></td>
                    <td class="calendar-day"></td>
                    <td class="calendar-day"></td>
                    <td class="calendar-day"></td>
                    <td class="calendar-day"></td>
                    <td class="calendar-day"></td>
                </tr>
            </table> -->
        </main>
    </body>
</html>