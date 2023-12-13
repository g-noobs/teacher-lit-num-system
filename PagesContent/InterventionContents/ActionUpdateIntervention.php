<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once "../../Database/SanitizeCrudClass.php";

$id = $_POST['id'];
$status = $_POST['status'];
$link = '';

if($status === 1){
    $link = 'Pending';
}elseif($status === 2){
    $link = 'Completed';
}else{
    $link = 'Removed';
}

if(!empty($id) || !empty($status)){
    $table = 'tbl_intervention';
    $sql = "UPDATE $table SET attachments_link = ?, status = ? WHERE intervention_id = ?";
    $params = array($link, $status, $id);
    $updateIntervention = new SanitizeCrudClass();
    $updateIntervention->executePreState($sql, $params);
    if($updateIntervention->getLastError() === null){
        $response = array('success' => 'Successfully set to ' .$link);
        echo json_encode($response);
        exit();
    }else{
        $response = array('error' => 'Error updating to ' .$link);
        echo json_encode($response);
        exit();
    }
}else{
    $response = array('error' => 'Error updating to ' .$link. ' .One of the Data is empty!');
    echo json_encode($response);
    exit();
}
?>