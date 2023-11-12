<?php 
session_start();
include_once "../../../Database/Connection.php";

$connection = new Connection();
$conn = $connection->getConnection();
$table = "view_teacher_class_info";


$id = $_SESSION['id'];
$sql = "SELECT classs_id, class_name FROM $table WHERE user_info_id = '$id';";
$result = $conn->query($sql);

$response  = array();
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $response[] = array(
            "id" => $row['classs_id'],
            "name" => $row['class_name']
        );
    }
    
}
else{
    $response = array('error' => 'No data Found');
}
echo json_encode($response);
?>