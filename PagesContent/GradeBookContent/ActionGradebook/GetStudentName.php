<?php 
include_once("../../../Database/Connection.php");
$conn = new Connection();
$connection = $conn->getConnection();

$user_info_id = $_GET['id'];

$sql = "SELECT personal_id, first_name, last_name 
    FROM tbl_user_info 
    WHERE user_info_id = '$user_info_id'";
$result = $connection->query($sql);
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $response[] = array(
            'personal_id' => $row['personal_id'],
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name']
        );
    }
    echo json_encode($response);
}
else{
    $response = "No Data Available";
    echo json_encode($response);
}
?>