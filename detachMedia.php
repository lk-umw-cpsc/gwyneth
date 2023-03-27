<?php
    session_cache_expire(30);
    session_start();

    if ($_SESSION['access_level'] < 2) {
        echo 'forbidden';
        die();
    }
    require_once('include/input-validation.php');
    require_once('database/dbEvents.php');
    $args = sanitize($_GET);
    $required = ['eid', 'mid'];
    if (!wereRequiredFieldsSubmitted($args, $required)) {
        echo 'bad args';
        die();
    }
    $eid = $args['eid'];
    $mid = $args['mid'];
    detach_media($mid);
    header('Location: event.php?id=' . $eid . '&removeSuccess');
?>