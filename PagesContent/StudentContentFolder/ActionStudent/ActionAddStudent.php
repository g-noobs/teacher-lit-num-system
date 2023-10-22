<?php 
session_start();
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(isset($_POST['student_personal_id']) && isset($_POST['student_first_name']) && isset($_POST['student_last_name'])){
        $values = array(
            'user_info_id' => '',
            'personal_id' => $_POST['student_personal_id'],
            'first_name' => $_POST['student_first_name'],
            'last_name' => $_POST['student_last_name'],
            'gender' => $_POST['student_gender'],
            'email' => $_POST['student_email'],
            'student_date' => $_POST['student_birth_date'],
            'status_id' => '1',
            'user_level_id' => '2',
            'added_byID' => '',
            'date_added' => ''

        );

        //set user_info_id
        include_once "../../../Database/ColumnCountClass.php";
        $columnCount = new ColumnCountClass();
        $values['user_info_id'] = "USR". $columnCount->columnCountWhere('user_info_id','tbl_user_info');

        //set added by ID
        $values['added_byID'] = $_SESSION['id'];

        // set date added Date
        $currentDate = new DateTime();
        $values['date_added'] = $currentDate->format('Y-m-d H:i:s');

        //set Credentials ID
        $credential_id = "CRED".$columnCount->columnCountWhere("credentials_id","tbl_credentials");

        //generate credentials password
        include_once "../../../CommonPHPClass/EssentialPHPClass.php";
        $essentialPhpClass = new EssentialPHPClass();
        $password = $essentialPhpClass->generatePassword(10);

        //username
        $username = $values['personal_id'];

        //Userinfo ID
        $user_info_id = $values['user_info_id'];

        include_once "../../../Database/CommonValidationClass.php";
        $validate = new CommonValidationClass();
        $data = array($values['personal_id'],$values['first_name'], $values['last_name']);
        $column = array('personal_id','first_name','last_name');
        $table = "tbl_user_info";

        $isValid = $validate->validateColumns($table, $column, $data);

        if($isValid){
            $columns = implode (',', array_keys($values));
            $sql = "INSERT INTO $table($columns)
                    VALUES(?,?,?,?,?,?,?,?,?,?,?);";

            $params = array($values);
            include_once "../../../Database/SanitizeCrudClass.php";
            $addNewUser = new SanitizeCrudClass();

            try{
                $addNewUser->executePreState($query, $params);
                
                if($addNewUser->getLastError() === null){
                    //if adding is succesfull. Proceed on adding Credentials
                    $table = "tbl_credentials";
                    $query = "INSERT INTO $table(credentials_id,uname,pass,user_info_id) 
                    VALUES(?,?,?,?);";
                    $params = array($credential_id, $username, $password, $user_info_id);
                    $addUserCreds->executePreState($query, $params);

                    // Response to ajax
                    $response = array('success' => 'Successfully added new User!');
                    echo json_encode($response);
                }
                else{
                    $response = array('error' => 'No user added!');
                    echo json_encode($response);
                }
            }catch(mysqli_sql_exception  $e){
                $response = array('error'=> 'Error adding to mysql Database');
                echo json_encode($response);

            }catch(Exception $e){
                $response = array('error'=> "Exception Error'.$e.'");
                echo json_encode($response);
            }
        }else{
            $response = array('error'=> 'Data has Duplicate from ');
            echo json_encode($response);
        }
    }else{
        $response = array('error' => 'MISSING DATA');
        echo json_encode($response);
    }
}else{
    $response = array('error' => 'POST ISSUE');
    echo json_encode($response);
}
?>