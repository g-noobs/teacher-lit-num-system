<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
// modify quizID
include_once("../../../Database/ColumnCountClass.php");
include_once("../../../Database/SanitizeCrudClass.php");
include_once "../../../CommonPHPClass/InputValidationClass.php";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['assign_question']) && !empty($_POST['assign_question']) && !empty($_POST['max_score'])){
        $values = array(
            'assignment_id' => '',
            'topic_id' => $_POST['topic_id'],
            'assignment_name' => $_POST['assignment_name'],
            'question' => $_POST['assign_question'],
            'max_score' => $_POST['max_score'],
            'created_by' => $_SESSION['id'],
            'date_added' => '',
        );
        $inputValidation = new InputValidationClass();
        $assign_question = $inputValidation->test_input($_POST['assign_question'], 'description');

        $errors = array();
        if($assign_question === false){
            $errors[] = 'Some or all of the characters in the question are not allowed.';
        }
        if(!empty($errors)){
            echo json_encode($errors);
            exit();
        }else{
            $table = 'tbl_assignment';
            //set ID
            $columnCount = new ColumnCountClass();
            $values['assignment_id'] = "ASG". $columnCount->columnCountWhere("assignment_id",$table);
            //set date
            date_default_timezone_set('Asia/Kuala_Lumpur');
            $currentDate = new DateTime();
            $values['date_added'] = $currentDate->format('Y-m-d H:i:s');

            $olumns = implode(", ",array_keys($values));
            $questionMarkString = implode(',', array_fill(0, count($values), '?'));
            $sql = "INSERT INTO $table ($columns)
                    VALUES($questionMarkString);";
            $params = array_values($values);

            $addNewAssign = new SanitizeCrudClass();
            $addNewAssign->executePreState($sql, $params);

            if($addNewAssign->getLastError() === null){
                $response = array('success' => 'Assignment Added Successfully!');
                echo json_encode($response);
                exit();
            }else{
                $response = array('error' => 'Error Adding Assignment! '. $addNewAssign->getLastError());
                echo json_encode($response);
                exit();

            }
        }
    }else{
        $response = array('error' => 'Empty Question or Quiz Description!');
        echo json_encode($response);
        exit();

    }
}else{
    $response = array('error' => 'Possible POST ISSUE!');
    echo json_encode($response);
    exit();

}
?>