<?php

    function hsc($input) {
        if (is_array($input)) {
            $arr = [];
            foreach ($input as $key => $value) {
                $arr[$key] = htmlspecialchars($value);
            }
            return $arr;
        }
        return htmlspecialchars($input);
    }

    function time24hTo12h($time) {
        if (!$time) {
            return '';
        }
        $hour = substr($time, 0, 2);
        $minute = substr($time, 3, 2);
        $hour = intval($hour);
        if ($hour < 12) {
            if ($hour == 0) {
                $hour = 12;
            }
            return hsc($hour . ':' . $minute . 'AM');
        } else if ($hour > 12) {
            $hour -= 12;
        }
        return hsc($hour . ':' . $minute . 'PM');
    }

    function formatPhoneNumber($number) {
        $str = '(' . substr($number, 0, 3) . ') ' . substr($number, 3, 3) . '-' . substr($number, 6, 4);
        return hsc($str);
    }

?>