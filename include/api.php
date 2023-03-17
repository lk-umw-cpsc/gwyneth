<?php 

function redirect($destination) {
    if (headers_sent()) {
        echo "ERROR: Unable to redirect to $destination. Headers already sent!";
        echo "You must call this function prior to any characters being printed.";
        die();
    }
    header("Location: $destination");
    exit();
}

?>