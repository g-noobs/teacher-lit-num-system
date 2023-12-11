<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once "../../Database/Connection.php";
$connection = new Connection();
$conn = $connection->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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
    echo json_encode("Invalid request");
}
?>
