<?php
    session_start();
    if(isset($_POST['id'])) {
    $lessonId = $_POST['id'];
    $teacher_user_id = $_SESSION['id'];
    include_once "../../../Database/LessonDisplayClass.php";
    $topicDisplay = new LessonDisplayClass();
    $topicDisplay->topicTable($lessonId, $teacher_user_id);
    }
    else{
        $response = array("error"=> "POST ERROR");
        echo json_encode($response);
    }
?>