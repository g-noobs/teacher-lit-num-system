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

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Check each value and replace empty ones with null or none
                $quiz_id = !empty($row['quiz_id']) ? $row['quiz_id'] : 'none';
                $quiz_type = !empty($row['quiz_type']) ? $row['quiz_type'] : '0';
                $quiz_question = !empty($row['quiz_question']) ? $row['quiz_question'] : 'none';
                $correct_answer = !empty($row['quiz_selectionA']) ? $row['quiz_selectionA'] : 'none';
                $option1 = !empty($row['quiz_selectionB']) ? $row['quiz_selectionB'] : 'none';
                $option2 = !empty($row['quiz_selectionC']) ? $row['quiz_selectionC'] : 'none';
                $option3 = !empty($row['quiz_selectionD']) ? $row['quiz_selectionD'] : 'none';
                $topic_source = !empty($row['topic_id']) ? $row['topic_id'] : 'none';
                $date_created = !empty($row['date_created']) ? $row['date_created'] : 'none';
                $quiz_status = ($row['quiz_status'] == 1) ? 'Active' : 'Inactive';

                // Create the response array
                $response = array(
                    'quiz_id' => $quiz_id,
                    'quiz_type' => $quiz_type,
                    'quiz_question' => $quiz_question,
                    'correct_answer' => $correct_answer,
                    'option1' => $option1,
                    'option2' => $option2,
                    'option3' => $option3,
                    'topic_source' => $topic_source,
                    'date_created' => $date_created,
                    'quiz_status' => $quiz_status,
                );
            }
            echo json_encode($response);
        }
    }
}
?>
