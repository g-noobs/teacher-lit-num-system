<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once "../../../Database/Connection.php";

$connection = new Connection();
$conn = $connection->getConnection();
$table = "tbl_quiz";
$quiz_id = $_POST['id'];

if(!empty($class_id)){
    $sql = "SELECT * FROM $table WHERE quiz_id = '$quiz_id';";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $response = array(
                'topic_id' => $row['topic_id'],
                'quiz_type' => $row['quiz_type'],
                'quiz_question' => $row['quiz_question'],
                'quiz_answer' => $row['quiz_selectionA'],
            );
        }
    }else{
        $response = array('error' => 'Table Empty');
    }
    //sent response to populate data for Edit
    echo json_encode($response);
    exit();
}else{}

?>