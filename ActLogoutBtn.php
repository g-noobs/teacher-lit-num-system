<?php
if($_SERVER['REQUEST_METHOD'] == 'get'){
    session_start();
    session_destroy();
    echo "You have been logged out";
}
?>