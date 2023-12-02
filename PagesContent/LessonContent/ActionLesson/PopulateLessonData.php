<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once "../../../Database/Connection.php";

$connection = new Connection();
$conn = $connection->getConnection();
$table = "lesson_view";
$lesson_id = $_POST['id'];

if(!empty($lesson_id)){
    $sql = "SELECT * FROM $table WHERE lesson_id = '$lesson_id';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $response = array(
                'lesson_name' => $row['lesson_name'],
                'lesson_description' =>$row['lesson_description'],
                'category_id' => $row['category_id'],
                'module_id' => $row['module_id']
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