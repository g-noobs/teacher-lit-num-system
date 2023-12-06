<?php 
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
// modify quizID
include_once("../../../Database/ColumnCountClass.php");
include_once("../../../Database/SanitizeCrudClass.php");
include_once "../../../CommonPHPClass/InputValidationClass.php";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['quiz_question'])){
        $values = array(
            'quiz_id' => '',
            'quiz_type' => $_POST['quiz_type_option'],
            'quiz_question' => $_POST['quiz_question'],
            'quiz_selectionA' => '', //Correct Answer
            'quiz_selectionB' => '',
            'quiz_selectionC' => '',
            'quiz_selectionD' => '',
            'date_created' => '',
            'added_byID' => $_SESSION['id'], //Teacher ID
            'topic_id' => $_POST['topic_id']
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

            
            $table = "tbl_quiz";
            $columnCountClass = new ColumnCountClass();
            $values['quiz_id'] = "QZ". $columnCountClass->columnCountWhere("quiz_id",$table);
            
            // Set the date values
            $currentDate = new DateTime();
            $values['date_created'] = $currentDate->format('Y-m-d H:i:s');

            $columns = implode(', ', array_keys($values));
            $questionMarkString = implode(',', array_fill(0, count($values), '?'));

            $sql = "INSERT INTO $table ($columns)
                    VALUES($questionMarkString);";
            $params = array_values($values);

            
            $addNewQuiz = new SanitizeCrudClass();
            $addNewQuiz->executePreState($sql, $params);
            if($addNewQuiz->getLastError() === null){
                $response = array('success' => 'Quiz Added Successfully!');
                echo json_encode($response);
            }
            else{
                $response = array('error' => 'Error Adding Quiz!');
                echo json_encode($response);
            }
        }
    }
    //end of isset
    else{
        $response = array('error' => 'Empty Question or Quiz Description!');
        echo json_encode($response);
    }
}
else{
    $response = array('error' => 'Possible POST ISSUE!');
    echo json_encode($response);
}
?>