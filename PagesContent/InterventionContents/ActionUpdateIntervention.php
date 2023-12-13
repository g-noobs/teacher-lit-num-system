<?php
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
}
?>