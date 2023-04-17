<?php

require_once('database/dbinfo.php');

function get_user_messages($userID) {
    $query = "select * from dbMessages
              where recipientID='$userID'
              order by time desc";
    $connection = connect();
    $result = mysqli_query($connection, $query);
    if (!$result) {
        return null;
    }
    $messages = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_close($connection);
    return $messages;
}

function get_user_unread_count($userID) {
    $query = "select count(*) from dbMessages 
        where recipientID='$userID' and wasRead=0";
    $connection = connect();
    $result = mysqli_query($connection, $query);
    if (!$result) {
        return null;
    }

    $row = mysqli_fetch_row($result);
    mysqli_close($connection);
    return intval($row[0]);
}