<?php
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
        $response = array('name' => $row['first_name'], 'email' => $row['email']);
        echo json_encode($response);
    } else {
        $response = array('error' => "No data Found");
        echo json_encode($response);
    }
}
else{
    $response = array('error' => "Teacher ID is required");
    echo json_encode($response);
}
?>