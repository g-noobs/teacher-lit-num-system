<?php
if($_SERVER['REQUEST_METHOD'] == 'get'){
    session_start();
    $_SESSION['admin'] = false;
    $_SESSION['teacher'] = false;
    session_destroy();
    echo "You have been logged out";
}
?>