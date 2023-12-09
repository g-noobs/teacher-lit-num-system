<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "u170333284_db_tagakaulo";

$connection = mysqli_connect($host, $user, $password, $database);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$assignmentId = $_GET['assignmentId'];

$queryMaxScore = "SELECT max_score FROM tbl_assignment WHERE assignment_id = '$assignmentId'";
$resultMaxScore = mysqli_query($connection, $queryMaxScore);

if (!$resultMaxScore) {
    echo json_encode(['max_score' => 'Error: ' . mysqli_error($connection)]);
} else {
    $row = mysqli_fetch_assoc($resultMaxScore);
    echo json_encode(['max_score' => $row['max_score']]);
}

mysqli_close($connection);
?>
