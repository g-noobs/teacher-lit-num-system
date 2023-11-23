<?php
session_start();
//id modifcation
include_once "../../../Database/ColumnCountClass.php";
//input validation
include_once "../../../CommonPHPClass/InputValidationClass.php";
//insert parameterized sanitization
include_once "../../../Database/SanitizeCrudClass.php";
//Check if there is duplicate of lesson name  in tbl_lesson
include_once "../../../Database/CommonValidationClass.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['lesson_name'])){
        $values = array(
            'lesson_id'=>'',
            'lesson_description' => trim($_POST['lesson_description']), //trim removes the white spaces before and after the string
            'lesson_name' => trim($_POST['lesson_name']),
            'category_id' => $_POST['category_level'],
            'added_byID' => '',
            'module_id' => $_POST['subj_list']
        );
        
        $inputValidation = new InputValidationClass();
        $lesson_name = $inputValidation->test_input($values['lesson_name'], 'description');
        $lesson_description = $inputValidation->test_input($values['lesson_description'], 'description');

        $errors = array();
        if($lesson_name == false){
            $errors[] = "Lesson name is required";
        }
        if($lesson_description == false){
            $errors[] = "Lesson description is required";
        }
        if(!empty($errors)){
            echo json_encode($errors);
            exit();
        }else{
            $table = "tbl_lesson";
            $lesson_count = new ColumnCountClass();
            $values['lesson_id'] = "LSN". $lesson_count->columnCountWhere("lesson_id", $table);
            
            //place id for added_byID
            $values['added_byID']= $_SESSION['id'];

            
            $addLesson = new SanitizeCrudClass();
            $columns = implode(', ', array_keys($values));
            //set number of question marks
            $masks = implode(', ', array_fill(0, count($values), '?'));
            $query = "INSERT INTO $table($columns) VALUES ($masks)";
            $params = array_values($values);
            
            $check = new CommonValidationClass();
            $data = $values['lesson_name'];
            $column = 'lesson_name';
            $isDuplicate = $check -> validateOneColumn($table, $column, $data);
            
            if($isDuplicate){
                try{
                    $addLesson->executePreState($query,$params);
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
    }
    else{
        $response = array('error' => "Please fill up the form");
        echo json_encode($response);
    }
}
else{
    $response = array('error' => "POST PROCESSING ERROR");
    echo json_encode($response);
}
?>