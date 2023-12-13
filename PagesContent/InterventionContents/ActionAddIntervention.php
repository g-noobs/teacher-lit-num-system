<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once "../../Database/SanitizeCrudClass.php";
include_once "../../Database/ColumnCountClass.php";
include_once "../../CommonPHPClass/InputValidationClass.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $table = "tbl_intervention";
    $values = array(
        'intervention_id' => '',
        'added_byID' => $_SESSION['id'],
        'student_id' => $_POST['student_id'],
        'date_created' => '',
        'start_date' => $_POST['startDate'],
        'end_date' => $_POST['endDate'],
        'comments' => $_POST['comments']
    );

    $inputValidation = new InputValidationClass();
    $comment = $inputValidation->test_input($values['comments'], 'address');

    $errors = array();
    if ($comment === false) {
        $errors[] = 'Invalid Comment';
    }
    if($values['start_date'] === null || $values['end_date'] === null){
        $errors[] = 'One of the dates is empty';
    }
    if (!empty($errors)) {
        echo json_encode($errors);
        exit();
    } else {
        // modified id
        $columnCount = new ColumnCountClass();
        $values['intervention_id'] = "ITVT" . $columnCount->columnCountWhere("intervention_id", "tbl_intervention");

        // adding data for date_added
        $currentDate = new DateTime('now', new DateTimeZone('Asia/Kuala_Lumpur'));
        $values['date_created'] = $currentDate->format('Y-m-d H:i:s');

        //get alll array keys to be used as column name
        $columns = implode(', ', array_keys($values));
        //set number of question marks
        $questionMarkString = implode(',', array_fill(0, count($values), '?'));
        //sql
        $sql = "INSERT INTO $table($columns)VALUES($questionMarkString);";
        //set params - from array's value
        $params = array_values($values);
        //set sanitize class
        $addIntervention = new SanitizeCrudClass();
        //execute
        $addIntervention->executePreState($sql, $params);
        if ($addIntervention->getLastError() == null) {
            echo json_encode(array('success' => 'Intervention Added Successfully'));
            exit();
        } else {
            echo json_encode(array('error' => 'Intervention Failed to Add'));
            exit();
        }
    }
    

}
?>