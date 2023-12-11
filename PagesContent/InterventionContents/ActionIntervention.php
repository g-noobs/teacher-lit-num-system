<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once "../../../Database/SanitizeCrudClass.php";

$table = "tbl_intervention";

$id = $_GET['id'];
$sql = "UPDATE $table SET status = 1 WHERE intervention_id = ?;";
$params = array($id);
$removeIntervention = new SanitizeCrudClass();
$removeIntervention->executePreState($sql, $params);
if($removeIntervention->getLastError() == null){
    echo json_encode(array('success' => 'Intervention Removed Successfully'));
    exit();
}else{
    echo json_encode(array('error' => 'Intervention Failed to Remove'));
    exit();
}

?>