<?php 
session_start();
// This will be used to get the column count of the table for naming id
include_once("../../../Database/ColumnCountClass.php");
//Password generation
include_once("../../../CommonPHPClass/PHPClass.php");
//insert validation
include_once "../../../Database/CommonValidationClass.php";
// Sanitize insert
include_once "../../../Database/SanitizeCrudClass.php";

//INPUT VALIDATION cLASS
include_once "../../../CommonPHPClass/InputValidationClass.php";



if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (
        isset($_POST['personal_id']) && !empty($_POST['personal_id']) &&
        isset($_POST['last_name']) && !empty($_POST['last_name']) &&
        isset($_POST['first_name']) && !empty($_POST['first_name']) &&
        isset($_POST['phone_num']) && !empty($_POST['phone_num']) &&
        isset($_POST['gender']) && !empty($_POST['gender']) &&
        isset($_POST['email']) && !empty($_POST['email']) &&
        isset($_POST['street_address']) && !empty($_POST['street_address']) &&
        isset($_POST['barangay_address']) && !empty($_POST['barangay_address']) &&
        isset($_POST['city_address']) && !empty($_POST['city_address']) &&
        isset($_POST['province_address']) && !empty($_POST['province_address']) &&
        isset($_POST['zip_code']) && !empty($_POST['zip_code']) &&
        isset($_POST['guardian_last_name']) && !empty($_POST['guardian_last_name']) &&
        isset($_POST['guardian_first_name']) && !empty($_POST['guardian_first_name']) &&
        isset($_POST['guardian_phone_num']) && !empty($_POST['guardian_phone_num'])
    ) {   
        //set input validation class
        $inputValidation = new InputValidationClass();
        $student_id = $inputValidation->test_input($_POST['personal_id'], 'address');
        $last_name = $inputValidation->test_input($_POST['last_name'], 'name');
        $first_name = $inputValidation->test_input($_POST['first_name'], 'name');
        $middle_name = $inputValidation->test_input($_POST['user_middle_initial'], 'middle_initial');
        $gender = $inputValidation->test_input($_POST["gender"], 'name'); //possible No validation for select
        $phone_num = $inputValidation->test_input($_POST["phone_num"], 'phone');
        $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

        $street_address = $inputValidation->test_input($_POST["street_address"], 'address');
        $barangay_address = $inputValidation->test_input($_POST["barangay_address"], 'address');
        $city_address = $inputValidation->test_input($_POST["city_address"], 'address');
        $province_address = $inputValidation->test_input($_POST["province_address"], 'address');
        $zip_code = $inputValidation->test_input($_POST["zip_code"], 'number');
        
        $guardian_last_name = $inputValidation->test_input($_POST["guardian_last_name"], 'name');
        $guardian_first_name = $inputValidation->test_input($_POST["guardian_first_name"], 'name');
        $guardian_middle_name = $inputValidation->test_input($_POST["guardian_middle_name"], 'middle_initial');
        $guardian_phone_num = $inputValidation->test_input($_POST["guardian_phone_num"], 'phone');

        $class_assign = $inputValidation->test_input($_POST["class_assign"], 'address'); //possible No validation for select
        
        //check if there are errors
        $errors = array();
        if($student_id === false){
            $errors[] = "Invalid characters in Teacher ID.";
        }
        if($last_name === false){
            $errors[] = "Invalid characters in Last Name.";
        }
        if($first_name === false){
            $errors[] = "Invalid characters in First Name.";
        }
        if($middle_name === false){
            $errors[] = "Invalid characters in Middle Initial.";
        }
        if($gender === false){
            $errors[] = "Invalid characters in Guardian Last Name.";
        }
        if($phone_num === false){
            $errors[] = "Invalid phone number";

        }
        if($email === false){
            $errors[] = "Invalid email address";
        }
        if($street_address === false){
            $errors[] = "Invalid characters in Street Address.";
        }
        if($barangay_address === false){
            $errors[] = "Invalid characters in Barangay Address.";
        }
        if($city_address === false){
            $errors[] = "Invalid characters in City Address.";
        }
        if($province_address === false){
            $errors[] = "Invalid characters in Province Address.";
        }
        if($zip_code === false){
            $errors[] = "Invalid characters in Zip Code.";
        }
        if($guardian_last_name === false){
            $errors[] = "Invalid characters in Guardian Last Name.";
        }
        if($guardian_first_name === false){
            $errors[] = "Invalid characters in Guardian First Name.";
        }
        if($guardian_middle_name === false){
            $errors[] = "Invalid characters in Guardian Middle Initial.";
        }
        if($guardian_phone_num === false){
            $errors[] = "Invalid Guardian phone number";
        }
        if($class_assign === false){
            $errors[] = "Invalid characters in Class Assign.";
        }
        //check for empty fields
        if (!empty($errors)) {
            echo json_encode($errors);

            //start adding if no error catched
        } else {
            $values = array(
                'user_info_id'=>'',
                'personal_id' => trim($_POST['personal_id']),
                'first_name' => trim($_POST['first_name']),
                'last_name' =>trim($_POST['last_name']),
                'middle_name' => trim($_POST['user_middle_initial']),
                'gender' => $_POST['gender'],
                'user_level_id' => '2',
                'added_byID'=>'',
                'date_added' => '',
                'class_id' => $_POST['class_assign']
            );
            $table = "tbl_user_info";
                    //adding data for user_info_id
                    $columnCountClass = new ColumnCountClass();
                    $values['user_info_id'] = "USR". $columnCountClass->columnCountWhere("user_info_id",$table);
    
                    //adding data for added_byID
                    $values['added_byID']= $_SESSION['id'];
    
                    //adding data for date_added
                    $currentDate = new DateTime();
                    $values['date_added'] = $currentDate->format('Y-m-d H:i:s');
    
                     //setting validation class
                    $validate = new CommonValidationClass();
                    $data = array($values['first_name'], $values['last_name']);
                    $column = array('first_name', 'last_name');
                    $isValid = $validate -> validateColumns($table, $column, $data);
                    $isIdvalid = $validate -> validateOneColumn($table, 'personal_id', $values['personal_id']);
    
                    if($isIdvalid && $isValid){
                        //set columns
                        $columns = implode(', ', array_keys($values));
                        //set number of question marks
                        $questionMarkString = implode(',', array_fill(0, count($values), '?'));
                        //set sql
                        $sql = "INSERT INTO $table($columns)VALUES($questionMarkString);";
                        // set parameters
                        $params = array_values($values);
                        //set sanitize class
                        $addNewStudent = new SanitizeCrudClass();
                        try{
                            $addNewStudent -> executePreState($sql, $params);
                            //!if adding user is correct then procced with creating credentials
                            if($addNewStudent->getLastError()=== null){
                                $table = "tbl_credentials";
                                //set credential id
                                $credentials_id = "CRED".$columnCountClass->columnCountWhere("credentials_id",$table);
                                //set username
                                $username = $values['personal_id'];
                                //set password
                                $phpClass = new PHPClass();
                                $password = $phpClass->generatePassword();
                                //set user_info_id
                                $user_info_id = $values['user_info_id'];
                                //set query
                                $query = "INSERT INTO $table(credentials_id,uname,pass,user_info_id) VALUES(?,?,?,?);";
                                //set parameters
                                $params = array($credentials_id,$username,$password,$user_info_id);
                                //set the sanitize class
                                $addNewCreds = new SanitizeCrudClass();
                                $addNewCreds->executePreState($query, $params);
                                
                                //!if adding credentials is correct then procced with creating student
                                if($addNewCreds->getLastError()=== null){
                                    $table = 'tbl_contact_info';
                                    $contact = array(
                                        'contact_id' => '',
                                        'contact_num'=> $_POST['phone_num'],
                                        'email'=> $_POST['email'],
                                        'street'=> $_POST['street_address'],
                                        'barangay'=> $_POST['barangay_address'],
                                        'municipal_city'=> $_POST['city_address'],
                                        'province'=> $_POST['province_address'],
                                        'postalcode'=>$_POST['zip_code'],
                                        'user_info_id'=> $values['user_info_id']
                                    );
                                    //set contact id
                                    $contact['contact_id'] = "CNT". $columnCountClass->columnCountWhere("contact_id", $table);
                                    $columns = implode(', ', array_keys($contact));
                                    //set number of question marks
                                    $questionMarkString = implode(',', array_fill(0, count($contact), '?'));
                                    //set sql
                                    $sql = "INSERT INTO $table($columns)VALUES($questionMarkString);";
                                    // set parameters
                                    $params = array_values($contact);
                                    //set sanitize class
                                    $addNewContact = new SanitizeCrudClass();
                                    $addNewContact->executePreState($sql, $params);
                                    //!if adding contact is correct then procced with creating student
                                    if($addNewContact->getLastError()=== null){
                                        $table = 'tbl_guardian';
                                        $guardian = array(
                                            'guardian_id'=> '',
                                            'guardian_fname'=> $_POST['guardian_first_name'],
                                            'guardian_lname'=> $_POST['guardian_last_name'],
                                            'guardian_mname'=> $_POST['guardian_middle_name'],
                                            'guardian_number'=> $_POST['guardian_phone_num'],
                                            'user_info_id'=> $values['user_info_id']
                                        );
                                        //set guardian id
                                        $guardian['guardian_id'] = "GDN". $columnCountClass->columnCountWhere("guardian_id", $table);
                                        //set columns
                                        $columns = implode(', ', array_keys($guardian));
                                        //set number of question marks
                                        $questionMarkString = implode(',', array_fill(0, count($guardian), '?'));
                                        //set sql
                                        $sql = "INSERT INTO $table($columns)VALUES($questionMarkString);";
                                        // set parameters
                                        $params = array_values($guardian);
                                        //set sanitize class
                                        $addNewGuardian = new SanitizeCrudClass();
                                        $addNewGuardian->executePreState($sql, $params);
                                        //!if adding guardian is correct then procced with creating entry for student table
                                        if($addNewGuardian->getLastError()=== null){
                                            $table = 'tbl_student';
                                            $learner = array(
                                                'student_id'=> '',
                                                'user_info_id' => $values['user_info_id'],
                                                'class_id'=> $_POST['class_assign']
                                            );
                                            //set learner id
                                            $learner['student_id'] = "STDNT". $columnCountClass->columnCountWhere("student_id", $table);
                                            //set columns
                                            $columns = implode(', ', array_keys($learner));
                                            //set number of question marks
                                            $questionMarkString = implode(',', array_fill(0, count($learner), '?'));
                                            //set sql
                                            $sql = "INSERT INTO $table($columns)VALUES($questionMarkString);";
                                            // set parameters
                                            $params = array_values($learner);
                                            //set sanitize class
                                            $addNewLearner = new SanitizeCrudClass();
                                            $addNewLearner->executePreState($sql, $params);
                                            //!if adding learner is correct then procced with creating entry for student table
                                            if($addNewLearner->getLastError()=== null){
                                                $response = array('success' => 'Successfully added new student');
                                                echo json_encode($response);
    
                                            }else{
                                                $response = array('error' => "Error adding a new Learner");
                                                echo json_encode($response);
                                            }
                                        }else{
                                            $response = array('error' => "Error adding on guardian");
                                            echo json_encode($response);
                                        }
                                    }else{
                                        $response = array('error' => "Error adding on contact");
                                        echo json_encode($response);
                                    }
                                    
                                }else{
                                    $response = array('error' => "Error adding on credentials");
                                    echo json_encode($response);
                                }
                                
                            }else{
                                $response = array('error' => "Erro adding on user_info_table");
                                echo json_encode($response);
                            }
    
                        }catch(mysqli_sql_exception $e){
                            $response = array('error' => $e->getMessage());
                            echo json_encode($response);
                        
                        }catch(Exception $e){
                            $response =array('error' => $e->getMessage());
                            echo json_encode($response);
                        }
                    }else{
                        $response = array('error' => 'Stduent or name has Duplicate or invalid.. isIdvalid: ='.$isIdvalid.', isValid: ='.$isValid);
                        echo json_encode($response);
                    }
        }
        
    }else{
        $response = array('error' => 'One or more fields are empty');
        echo json_encode($response);
    }
}else{
    $response = array('error' => 'POSSIBLE POST ISSUE');
    echo json_encode($response);
}

?>