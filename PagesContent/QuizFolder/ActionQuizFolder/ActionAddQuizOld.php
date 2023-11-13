<?php 
session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['quiz_name'])){
        $values = array(
            'quiz_id' => '',
            'quiz_name' => $_POST['quiz_name'],
            'quiz_instruction' => $_POST['quiz_instruction'],
            'quiz_creation_date' => '',
            'quiz_added_by' => '',
            'topic_id' => $_POST['topic_id'],
            'quiz_status' => '1'
        );
        
        include_once "../../../Database/ColumnCountClass.php";
        $quiz_count = new ColumnCountClass();
        $values['quiz_id'] = "QZ". $quiz_count->columnCountWhere("quiz_id","tbl_quiz");
        
        $values['quiz_added_by'] = $_SESSION['id'];
        
        //create an object for current date
        $currentDate = new DateTime();
        $values['quiz_creation_date'] = $currentDate->format('Y-m-d H:i:s');
        
        
        include_once "../../../Database/SanitizeCrudClass.php";
        $table = "tbl_quiz";
        $addQuiz = new SanitizeCrudClass();
        $columns = implode(', ', array_keys($values));
        $query = "INSERT INTO $table($columns) VALUES (?,?,?,?,?,?,?)";
        $params = array_values($values);
        
        //Check if there is duplicate of quiz  in tbl_quiz
        
        include "../../../Database/CommonValidationClass.php";
        $check = new CommonValidationClass();
        $data = $values['quiz_name'];
        $column = 'quiz_name';
        $isDuplicate = $check -> validateOneColumn($table, $column, $data);
        
        if($isDuplicate){
            try{
                $addQuiz->executePreState($query,$params);
                $response = array('success' => $data." has been added");
                echo json_encode($response);
            } catch (mysqli_sql_exception $e) {
                if ($e->getCode() == 1062) {
                    // Duplicate entry
                    $response = array('error' => $data." already exists. Please try again");
                    echo json_encode($response);
                } else {
                    // Some other error
                    $response = array('error' => 'Something went wrong' . $e);
                    echo json_encode($response);
                    throw $e;
                    
                }
            }
            //add a catch for foreign key constraits fails
            catch(Exception $e){
                $response = array('error' => $e->getMessage());
                echo json_encode($response);
            }
        }
        else{
            $response = array('error' => $data." already exists. Please try again");
            echo json_encode($response);
        }

    }
    else{
        $response = array('error' => "Please fill up the form");
        echo json_encode($response);
    }
}
else{
    $response = array('error' => "Possible POST ISSUE");
    echo json_encode($response);
}

?>