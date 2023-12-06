<?php 
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once("../../../Database/ColumnCountClass.php");
include_once("../../../Database/SanitizeCrudClass.php");
include_once "../../../CommonPHPClass/InputValidationClass.php";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $values = array(
        'assign_class_id' => '',
        'assignment_id' => $_POST['assignment_id'],
        'class_id' => $_POST['class_id'],
        'assign_by_id' => $_SESSION['id'],
        'assign_date' => '',
    );
    $table = 'tbl_assign_assignment';
    //set ID
    $columnCount = new ColumnCountClass();
    $values['assign_class_id'] = "ASGCLS". $columnCount->columnCountWhere("assign_class_id",$table);
    //set date
    date_default_timezone_set('Asia/Kuala_Lumpur');
    $currentDate = new DateTime();
    $values['assign_date'] = $currentDate->format('Y-m-d H:i:s');

    $columns = implode(", ",array_keys($values));
    $questionMarkString = implode(',', array_fill(0, count($values), '?'));
    $sql = "INSERT INTO $table ($columns)
            VALUES($questionMarkString);";
    $params = array_values($values);
    $assignClass = new SanitizeCrudClass();
    $assignClass->executePreState($sql, $params);

    if($assignClass->getLastError() === null){
        $response = array('success' => 'Class Assigned Successfully!');
        echo json_encode($response);
        exit();
    }else{
        $response = array('error' => 'Error Assigning Class! '. $assignClass->getLastError());
        echo json_encode($response);
        exit();
    }

}else{
    $response = array('error' => 'Error Assigning Class! '. $assignClass->getLastError());
    echo json_encode($response);
    exit();
}

?>