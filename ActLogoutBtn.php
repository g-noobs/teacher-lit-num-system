<?php
if($_SERVER['REQUEST_METHOD'] == 'get'){
    session_start();
    $_SESSION['loggedin'] = false;
    session_destroy();
    echo "You have been logged out";
}
?>