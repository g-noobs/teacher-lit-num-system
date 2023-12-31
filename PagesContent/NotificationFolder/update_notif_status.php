<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once "../../Database/Connection.php";
$connection = new Connection();
$conn = $connection->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $learnerId = $_POST['learnerId'];
    $assignmentId = $_POST['assignmentId'];

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
        echo json_encode("Error updating notif status: " . $conn->error);
    }

    $conn->close();
} else {
    echo json_encode("Invalid request");
}
?>
