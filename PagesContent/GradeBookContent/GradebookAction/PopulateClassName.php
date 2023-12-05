<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once "../../../Database/Connection.php";
$connection = new Connection();
$conn = $connection->getConnection();
$table = "view_teacher_class_info";

$id = $_SESSION['id'];
//can only if class status equals to 1 and class is assigned to teacher's status equals to 1
$sql = "SELECT class_id, class_name FROM $table WHERE class_assign_status = 1 AND class_status = 1 AND user_info_id = '$id'
AND class_id IN (
    SELECT class_id
    FROM tbl_teacher_class_assignment
    WHERE status = 1
    );";

$result = $conn->query($sql);

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $response[] = array(
            "id" => $row['class_id'],
            "name" => $row['class_name']
        );
    }
    
}
else{
    $response = array('error' => 'Class or student was probably archived - No data Found');
}
echo json_encode($response);
?>