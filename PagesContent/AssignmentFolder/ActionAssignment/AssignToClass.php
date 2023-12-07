<?php 
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once("../../../Database/ColumnCountClass.php");
include_once("../../../Database/SanitizeCrudClass.php");
include_once "../../../CommonPHPClass/InputValidationClass.php";

include_once("../../../Database/Connection.php");
$conn = new Connection();

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $values = array(
        'assign_class_id' => '',
        'assignment_id' => $_POST['assignment_id'],
        'class_id' => $_POST['class_id'],
        'assign_by_id' => $_SESSION['id'],
        'assign_date' => '',
    );
    $table = 'tbl_assign_assignment';
    $assignment_id = $values['assignment_id'];
    $class_id = $values['class_id'];
    $sql ="SELECT COUNT(*) FROM $table WHERE assignment_id = '$assignment_id' AND class_id = '$class_id'";

    $result = $conn->getConnection()->query($sql);
    //set count variable
    $count = $result->fetch_row()[0];
    if ($result === false) {
        $response = array('error' =>"Error executing query: " . $conn->getConnection()->error);
        exit();
    }else{
        if ($result === false) {
            $response = array('error' =>"The combination of user and module already exists.");
            echo json_encode($response);
            exit();
        }else{
            if($count > 0){
                $response = array('error' =>"The combination of user and module already exists.");
                echo json_encode($response);
                exit();
            }else{
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

                    $table = "tbl_learner_assignment_progress";
                    $sql = "INSERT INTO tbl_learner_assignment_progress (assign_class_id, learner_id, assignment_id)
                    SELECT aa.assign_class_id, ui.personal_id AS learner_id, aa.assignment_id
                    FROM tbl_assign_assignment AS aa
                    JOIN tbl_user_info AS ui ON aa.class_id = ui.class_id
                    WHERE aa.assign_class_id = ?;";

                    $params = array($values['assign_class_id']);
                    $assignProgress = new SanitizeCrudClass();
                    $assignProgress->executePreState($sql, $params);
                    
                    if($assignProgress->getLastError() === null){
                        $response = array('success' => 'Class Assigned Successfully!');
                        echo json_encode($response);
                        exit();
                    }else{
                        $response = array('error' => 'Error Assigning Class! '. $assignProgress->getLastError());
                        echo json_encode($response);
                        exit();
                    }
                }else{
                    $response = array('error' => 'Error Assigning Class! '. $assignClass->getLastError());
                    echo json_encode($response);
                    exit();
                }
            }
        }
    }
}else{
    $response = array('error' => 'Error Assigning Class! '. $assignClass->getLastError());
    echo json_encode($response);
    exit();
}

?>