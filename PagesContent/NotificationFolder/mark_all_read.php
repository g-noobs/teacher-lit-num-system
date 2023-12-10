<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$host = "localhost";
$user = "u170333284_admin";
$password = "Capstone1!";
$database = "u170333284_db_tagakaulo";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update notif_status to 1 for all records
$queryUpdate = "UPDATE tbl_learner_assignment_progress SET notif_status = 1 WHERE notif_status = 0";

if ($conn->query($queryUpdate) === TRUE) {
    echo "All notifications marked as read successfully";
} else {
    echo "Error updating notifications: " . $conn->error;
}

$conn->close();
?>
