<?php
session_start();
$teacher_id = $_SESSION['id'];
$response = [];

// create a code that will validate if $teacher id is empty or null
if (!empty($teacher_id)) {
    include_once("../../Database/Connection.php");
    $connection = new Connection();
    $conn = $connection->getConnection();

    $sql = "SELECT * FROM teacher WHERE id = '$teacher_id'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result -> fetch_assoc();
        $response = array('name' => $row['name'], 'email' => $row['email']);
        echo json_encode($response);
    } else {
        $response = array('error' => "Teacher ID is not found");
        echo json_encode($response);
    }
}
else{
    $response = array('error' => "Teacher ID is required");
    echo json_encode($response);
}
?>