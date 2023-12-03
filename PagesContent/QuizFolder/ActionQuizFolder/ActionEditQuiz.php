<?php 
session_start();
// modify quizID
include_once("../../../Database/ColumnCountClass.php");
include_once("../../../Database/SanitizeCrudClass.php");
include_once "../../../CommonPHPClass/InputValidationClass.php";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['quiz_question'])){
        $values = array(
            'quiz_type' => $_POST['quiz_type_option'],
            'quiz_question' => $_POST['quiz_question'],
            'quiz_selectionA' => '', //Correct Answer
            'quiz_selectionB' => '',
            'quiz_selectionC' => '',
            'quiz_selectionD' => '',
            'topic_id' => $_POST['topic_id'],
            'quiz_id' => $_POST['id']
        );
        $inputValidation = new InputValidationClass();
        $quiz_question = $inputValidation->test_input($_POST['quiz_question'], 'description');

        $errors = array();
        if($quiz_question === false){
            $errors[] = 'Some or all of the characters in the question are not allowed.';
        }
        if(!empty($errors)){
            echo json_encode($errors);
            exit();
        }else{
             // Cache Correct Answer Value
            $correctAnswer = $_POST['quiz_answer'];
            //Place Correct Answer in quiz_selectionA
            $values['quiz_selectionA'] = $correctAnswer;

            // Cache the quiz type
            $quizType = $_POST['quiz_type_option'];
            
            // set the following if quiz type is multiple choice
            if($quizType === '0'){
                // Check if $correctAnswer matches any of the options and place it in quiz_selectionA
                if ($correctAnswer == $_POST['option1']) {
                    $values['quiz_selectionB'] = $_POST['option2'];
                    $values['quiz_selectionC'] = $_POST['option3'];
                    $values['quiz_selectionD'] = $_POST['option4'];
                } elseif ($correctAnswer == $_POST['option2']) {
                    $values['quiz_selectionB'] = $_POST['option1'];
                    $values['quiz_selectionC'] = $_POST['option3'];
                    $values['quiz_selectionD'] = $_POST['option4'];
                } elseif ($correctAnswer == $_POST['option3']) {
                    $values['quiz_selectionB'] = $_POST['option1'];
                    $values['quiz_selectionC'] = $_POST['option2'];
                    $values['quiz_selectionD'] = $_POST['option4'];
                } elseif ($correctAnswer == $_POST['option4']) {
                    $values['quiz_selectionB'] = $_POST['option1'];
                    $values['quiz_selectionC'] = $_POST['option2'];
                    $values['quiz_selectionD'] = $_POST['option3'];
                }
            }
            if($quizType === '1'){
                // Check if $correctAnswer matches any of the options and place it in quiz_selectionA
                if ($correctAnswer === 'true') {
                    $values['quiz_selectionB'] = 'false';
                } elseif ($correctAnswer === 'false') {
                    $values['quiz_selectionB'] = 'true';
                }
            }
            $table = "tbl_quiz";
            $sql = "UPDATE $table 
                SET quiz_type = ?, 
                    quiz_question = ?, 
                    quiz_selectionA = ?, 
                    quiz_selectionB = ?, 
                    quiz_selectionC = ?, 
                    quiz_selectionD = ?, 
                    topic_id = ?
                WHERE quiz_id = ?;";
        }
    }
}
?>