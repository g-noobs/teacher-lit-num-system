<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = "localhost";
    $user = "u170333284_admin";
    $password = "Capstone1!";
    $database = "u170333284_db_tagakaulo";

    $learnerId = $_POST['learnerId'];
    $assignmentId = $_POST['assignmentId'];

    $conn = new mysqli($host, $user, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update notif_status
    $updateQuery = "UPDATE tbl_learner_assignment_progress
                    SET notif_status = 1
                    WHERE learner_id = '$learnerId' AND assignment_id = '$assignmentId'";

    if ($conn->query($updateQuery) === TRUE) {
        echo "Notif status updated successfully";
    } else {
        echo "Error updating notif status: " . $conn->error;
    }

    $conn->close();
} else {
    http_response_code(400);
    echo "Invalid request";
}
?>
