<?php 
session_start();
include_once "../../../Database/Connection.php";

$connection = new Connection();
$conn = $connection->getConnection();
$table = "view_teacher_class_info";


$id = $_SESSION['id'];
$sql = "SELECT class_id, class_name, class_status FROM $table WHERE user_info_id = '$id';";

$result = $conn->query($sql);

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        if($row['class_status'] == 0){
            $response[] = array(
                "id" => $row['class_id'],
                "name" => 'Class was archived'
            );
        }else{
            $response[] = array(
                "id" => $row['class_id'],
                "name" => $row['class_name']
            );
        }
    }
    
}
else{
    $response = array('error' => 'Class or student was probably archived - No data Found');
}
echo json_encode($response);
?>