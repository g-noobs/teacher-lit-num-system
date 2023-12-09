<?php 
include_once("../../../Database/Connection.php");
$conn = new Connection();
$connection = $conn->getConnection();

$user_info_id = $_GET['id'];

// Query to fetch quiz progress information for the selected student
$query = "SELECT 
        q.quiz_id,
        q.quiz_question,
        COALESCE(lqp.score, 'Not Taken') AS quiz_score  -- Use COALESCE to handle cases where quiz has not been taken
    FROM 
        tbl_quiz q
    LEFT JOIN tbl_learner_quiz_progress lqp ON q.quiz_id = lqp.quiz_id AND lqp.learner_id = (
        SELECT 
            personal_id 
        FROM 
            tbl_user_info 
        WHERE 
            user_info_id = '$user_info_id'
    )
    WHERE 
        q.quiz_status = 1";
    $result = $connection->query($query);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $response[] = array(
                'quiz_id' => $row['quiz_id'],
                'quiz_question' => $row['quiz_question'],
                'quiz_score' => $row['quiz_score']
            );
        }
        echo json_encode($response);
    }
    else{
        $response = "No Data Available";
        echo json_encode($response);
    }
?>