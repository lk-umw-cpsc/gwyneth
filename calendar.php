<?php
    session_cache_expire(30);
    session_start();

    date_default_timezone_set("America/New_York");

    // Ensure user is logged in
    if (!isset($_SESSION['access_level']) || $_SESSION['access_level'] < 1) {
        header('Location: login.php');
        die();
    }

    // Redirect to current month
    if (!isset($_GET['month'])) {
        header('Location: calendar.php?month=' . date("Y-m"));
        die();
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
    $calendarEnd = strtotime(date('Y-m-d', $calendarStart) . ' +34 day');
?>
<!DOCTYPE html>
<html>
    <head>
        <?php require('universal.inc'); ?>
        <script src="js/calendar.js"></script>
        <title>Gwyneth's Gift VMS | Events Calendar</title>
    </head>
    <body>
        <?php require('header.php'); ?>
        <main class="calendar-view">
            <h1 class='calendar-header'>
                <img id="previous-month-button" src="images/arrow-back.png" data-month="<?php echo date("Y-m", $previousMonth); ?>">
                <span id="calendar-heading-month">Events - <?php echo date('F Y', $month); ?></span>
                <img id="next-month-button" src="images/arrow-forward.png" data-month="<?php echo date("Y-m", $nextMonth); ?>">
            </h1>
            <!-- <input type="date" id="month-jumper" value="<?php echo date('Y-m-d', $month); ?>" min="2023-01-01"> -->
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
                    $start = date('Y-m-d', $calendarStart);
                    $end = date('Y-m-d', $calendarEnd);
                    require_once('database/dbEvents.php');
                    $events = fetch_events_in_date_range($start, $end);
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
                            $eventsStr = '';
                            $e = date('Y-m-d', $date);
                            if (isset($events[$e])) {
                                $dayEvents = $events[$e];
                                foreach ($dayEvents as $info) {
                                    $eventsStr .= '<a class="calendar-event" href="event.php?id=' . $info['id'] . '">' . $info['abbrevName'] .  '</a>';
                                }
                            }
                            echo '<td class="calendar-day' . $extraClasses . '" ' . $extraAttributes . ' data-date="' . date('Y-m-d', $date) . '">
                                <div class="calendar-day-wrapper">
                                    <p class="calendar-day-number">' . date('j', $date) . '</p>
                                    ' . $eventsStr . '
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
