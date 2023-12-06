<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once "../../../Database/SanitizeCrudClass.php";
include_once "../../../CommonPHPClass/InputValidationClass.php";
include_once "../../../Database/CommonValidationClass.php";

$id = $_POST['id'];
$values = array(
    'topic_name' => $_POST['edit_topic_name'],
    'topic_description' => $_POST['edit_topic_description'],
    'topic_id' => $id
);
$table = "tbl_topic";
$inputValidation = new InputValidationClass();

$topic_name = $inputValidation->test_input($_POST['edit_topic_name'], 'address');
$topic_description = $inputValidation->test_input($_POST['edit_topic_description'], 'address');

$errors = array();
if($topic_name === false){
    $errors[] = "Invalid Character in Topic Name";
}
if($topic_description === false){
    $errors[] = "Invalid Character in Topic Description";
}
if(!empty($errors)){
    echo json_encode($errors);
    exit();
}else{
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $validate = new CommonValidationClass();
        $isValid = $validate -> updateValidateOne($table, 'topic_name', $values['topic_name'], 'topic_id',$values['topic_id']);

        if($isValid){
            $sql = "UPDATE $table
            SET topic_name = ?,
                topic_description = ?,
                topic_status = 1,
            WHERE topic_id = ?";

            $params = array_values($values);
            $updateTopic = new SanitizeCrudClass();
            $updateTopic->executePreState($sql, $params);

            if($updateTopic->getLastError() === null){
                $response = array('success' => 'Successfully Update Topic: '. $values['topic_id']);
                echo json_encode($response);
                exit();
            }else{
                $response = array('error' => $updateTopic->getLastError());
                echo json_encode($response);
                exit();
            }
        }else{
            $response = array('error' => 'Data Duplicate. Please try again. . ');
            echo json_encode($response);
            exit();
        }
    }else{  
        $response = array('error' => 'Invalid Request (POST)');
        echo json_encode($response);
        exit();
    }
    
}
?>