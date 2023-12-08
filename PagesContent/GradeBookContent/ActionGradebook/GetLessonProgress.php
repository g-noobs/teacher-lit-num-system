<?php 
include_once("../../../Database/Connection.php");
$conn = new Connection();
$connection = $conn->getConnection();

$user_info_id = $_GET['id'];

// Query to fetch user information
$sql = "SELECT 
        tp.topic_id, 
        tp.topic_name, 
        COALESCE(
            CONCAT('Completed on ', DATE_FORMAT(lsp.date_completed, '%Y-%m-%d')), 
            'Not Yet Taken'
        ) AS progress_status 
    FROM 
        tbl_topic tp 
    LEFT JOIN 
        tbl_learner_story_progress lsp 
    ON 
        tp.topic_id = lsp.story_id 
        AND lsp.learner_id = (
            SELECT 
                personal_id 
            FROM 
                tbl_user_info 
            WHERE 
                user_info_id = '$user_info_id'
        )
    WHERE 
        tp.topic_status = 1;";

$result = $connection->query($sql);
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $response = 
        "<tr class='progressRow' data-status='{$row['progress_status']}'>
            <td>{$row['topic_id']}</td>
            <td>{$row['topic_name']}</td>
            <td>{$row['progress_status']}</td>
        tr>";
    }
    echo json_encode($response);
}
else{
    $response = "No Data Available";
    echo json_encode($response);
}



?>