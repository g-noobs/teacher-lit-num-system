<?php
session_start();
include_once "../../../Database/Connection.php";
$connection = new Connection();

$table = "user_info_view";
$id  = $_SESSION['id'];
$sql = "SELECT * FROM $table WHERE user_info_id = '$id';";
$result = $connection->getConnection()->query($sql);

if($result->num_rows > 0){
    $response = array(
        'last_name' => $row['last_name'],
        'first_name' => $row['first_name'],
        'middle_initial' =>$row['middle_name'],
        'gender' => $row['gender'],
        'phone' => $row['contact_num'],
        'email' => $row['email'],
        'street' => $row['street'],
        'baranggay' => $row['barangay'],
        'city_municipality' => $row['municipal_city'],
        'province' => $row['province'],
        'zip_code' => $row['postalcode'],
        'username' => $row['uname'],
        'password' => $row['pass']
    );
}else{
    $response = array('error' => 'No Data -- Error');
}
echo json_encode($response);
?>