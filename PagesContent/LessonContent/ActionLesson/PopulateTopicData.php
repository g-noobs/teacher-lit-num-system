<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once "../../../Database/Connection.php";

$connection = new Connection();
$conn = $connection->getConnection();
$table = "tbl_topic";
$topic_id = $_POST['id'];

if(!empty($topic_id)){
    $sql = "SELECT * FROM $table WHERE topic_id = '$topic_id';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $response = array(
                'topic_name' => $row['topic_name'],
                'topic_description' =>$row['topic_description']
            );
        }
    }else{
        $response = array('error' => 'Table Empty');
    }
    //sent response to populate data for Edit
    echo json_encode($response);
    exit();
}else{
    $response = array('error' => 'No id received');
    echo json_encode($response);
    exit();
}
?>