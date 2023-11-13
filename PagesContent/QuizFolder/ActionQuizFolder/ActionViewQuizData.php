<?php
include_once "../../../Database/Connection.php";

$connection = new Connection();
$conn = $connection->getConnection();
$table = "tbl_quiz";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        $sql = "SELECT * FROM $table WHERE quiz_id = '$id' AND quiz_status = 1;";
        $result = $conn->query($sql);

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                if($row['quiz_selectionB'] == null){
                    $option1 = 'false';
                }else{
                    $option1 = $row['quiz_selectionB'];
                }
                if($row['quiz_status'] == 1){
                    $status = 'Active';
                }else{
                    $status = 'Inactive';
                }

                $response = array(
                    'quiz_id' => $row['quiz_id'],
                    'quiz_question' => $row['quiz_question'],
                    'correct_answer' => $row['quiz_selectionA'],
                    'option1' => $option1,
                    'option2' => $row['quiz_selectionC'],
                    'option3' => $row['quiz_selectionD'],
                    'topic_source' => $row['topic_id'],
                    'date_created' => $row['date_created'],
                    'quiz_status' => $status,
                );
            }
            echo json_encode($response);
        }
    }
}
?>