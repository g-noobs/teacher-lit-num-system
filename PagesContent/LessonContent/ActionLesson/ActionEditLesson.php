<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once "../../../Database/SanitizeCrudClass.php";
include_once "../../../CommonPHPClass/InputValidationClass.php";
include_once "../../../Database/CommonValidationClass.php";

$id = $_POST['id'];
$values = array(
    'lesson_name' => $_POST['lesson_name'],
    'lesson_description' => $_POST['lesson_description'],
    'category_id' => $_POST['category_level'],
    'module_id' => $_POST['subj_list'],
    'lesson_id' => $id
);

$table = 'tbl_lesson';
$inputValidation = new InputValidationClass();

$lesson_name = $inputValidation->test_input($_POST['lesson_name'], 'address');
$lesson_description = $inputValidation->test_input($_POST['lesson_description'], 'address');

$errors = array();
if($lesson_name === false){
    $errors[] = "Invalid Character in Lesson Name";
}
if(!empty($errors)){
    echo json_encode($errors);
    exit();
}else{
    $validate = new CommonValidationClass();
    $isValid = $validate -> updateValidateOne($table, 'lesson_name', $values['lesson_name'], 'lesson_id',$values['lesson_id']);

    if($isValid){
        $sql = "UPDATE $table
        SET lesson_name = ?,
            lesson_description = ?,
            category_id = ?,
            module_id = ?,
        WHERE lesson_id = ?";

        $params = array_values($values);
        $updateLesson = new SanitizeCrudClass();
        $updateLesson->executePreState($sql, $params);

        if($updateLesson->getLastError() === null){
            $response = array('success' => 'Successfullt Update Lesson: '. $values['lesson_id']);
            echo json_encode($response);
            exit();
        }else{
            $response = array('error' => $updateLesson->getLastError());
            echo json_encode($response);
            exit();
        }
    }else{
        $response = array('error' => 'Data Duplicate. Please try again. . ');
        echo json_encode($response);
        exit();
    }
}
?>
