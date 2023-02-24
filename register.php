<?php
    session_start();
    if (isset($_SESSION['_id'])) {
        header('Location: index.php');
    } else {
        $_SESSION['logged_in'] = 1;
        $_SESSION['access_level'] = 0;
        $_SESSION['venue'] = "";
        $_SESSION['type'] = "";
        $_SESSION['_id'] = "guest";
        header('Location: personEdit.php?id=new');
    }
?>