<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database table for user information
// Include necessary libraries and set up the database configuration
include_once("../../../Database/ColumnCountClass.php");
include_once("../../../Database/CommonValidationClass.php");
include_once("../../../Database/SanitizeCrudClass.php");
include_once("../../../CommonPHPClass/PHPClass.php");
include_once("../../../CommonPHPClass/InputValidationClass.php");

require '../../../vendor/autoload.php'; // Include PhpSpreadsheet library autoloader
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

    $excelMimes = array('text/xls', 'text/xlsx', 'application/excel', 'application/vnd.msexcel', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

    $errors = array();
    // Validate whether a selected file is an Excel file
    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $excelMimes)) {
        // If the file is uploaded
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            $reader = new Xlsx();
            $spreadsheet = $reader->load($_FILES['file']['tmp_name']);
            $worksheet = $spreadsheet->getActiveSheet();
            $worksheet_arr = $worksheet->toArray();

            // Remove header row
            unset($worksheet_arr[0]);

            //remove empty rows
            $worksheet_arr = array_filter($worksheet_arr, function ($row) {
                return !empty(array_filter($row));
            });


            // Loop through each row in the spreadsheet
            foreach ($worksheet_arr as $row) {
                $values = array(
                    'user_info_id' => '',
                    'personal_id' => trim($row[0]), 
                    'last_name' => trim($row[1]),
                    'first_name' => trim($row[2]),
                    'middle_name' => $row[3],
                    'gender' => trim($row[4]),
                    'user_level_id' => '2',
                    'added_byID' => '',
                    'date_added' => '',
                    'class_id' => $_POST['class_id']
                );

                //set variable fro input validation
                $inputValidation = new InputValidationClass();
                $student_id = $inputValidation->test_input($row[0], 'alphanum');
                $last_name = $inputValidation->test_input($row[1], 'name');
                $first_name = $inputValidation->test_input($row[2], 'name');
                $middle_name = $inputValidation->test_input($row[3], 'middle_initial');
                $gender = $inputValidation->test_input($row[4], 'name');
                $phone_num = $inputValidation->test_input($row[5], 'phone');
                $email = filter_var(trim($row[6]), FILTER_SANITIZE_EMAIL);
                $street = $inputValidation->test_input($row[7], 'address');
                $baranggay = $inputValidation->test_input($row[8], 'address');
                $municipal_city = $inputValidation->test_input($row[9], 'address');
                $province = $inputValidation->test_input($row[10], 'address');
                $postal_code = $inputValidation->test_input($row[11], 'number');
                $guardian_last_name = $inputValidation->test_input($row[12], 'name');
                $guardian_first_name = $inputValidation->test_input($row[13], 'name');
                $guardian_middle_initial = $inputValidation->test_input($row[14], 'middle_initial');
                $guardian_number = $inputValidation->test_input($row[15], 'phone');
                
                $errors = array();
                if($student_id === false){
                    $errors[] = "Invalid characters in Student ID. on " . $values['personal_id'];
                }
                if($last_name === false){
                    $errors[] = "Invalid characters for Last Name: " . $values['personal_id'];
                }
                if($first_name === false){
                    $errors[] = "Invalid characters for First Name: " . $values['personal_id'];
                    
                }
                if($middle_name === false){
                    $errors[] = "Invalid characters for First Name: " . $values['personal_id'];
                }
                if($gender === false){
                    $errors[] = "Invalid characters for gender " . $values['personal_id'];
                }
                if($phone_num === false){
                    $errors[] = "Invalid characters for contact number: " . $values['personal_id'];
                }
                if($email === false){
                    $errors[] = "Invalid characters for email: " . $values['personal_id'];
                }
                if($street === false){
                    $errors[] = "Invalid characters for Street Address: " . $values['personal_id'];
                }
                if($baranggay === false){
                    $errors[] = "Invalid characters for Barangay: " . $values['personal_id'];
                }
                if($municipal_city === false){
                    $errors[] = "Invalid characters for Municipal or City: " . $values['personal_id'];
                }
                if($province === false){
                    $errors[] = "Invalid characters for Province: " . $values['personal_id'];
                }
                if($postal_code === false){
                    $errors[] = "Invalid characters for Postal Code: " . $values['personal_id'];
                }
                if($guardian_last_name === false){
                    $errors[] = "Invalid characters for Guardian's Last Name: " . $values['personal_id'];
                }
                if($guardian_first_name === false){
                    $errors[] = "Invalid characters for Guardian's First Name: " . $values['personal_id'];
                }
                if($guardian_middle_initial === false){
                    $errors[] = "Invalid characters for Guardian's Middle Initial: " . $values['personal_id'];
                }
                if($guardian_number === false){
                    $errors[] = "Invalid characters for Guardian's Contact number: " . $values['personal_id'];

                }
                if(!empty($errors)){
                    echo json_encode($errors);
                    exit();

                }else{
                    $table = "tbl_user_info";   
                    // Set user_info_id
                    $columnCountClass = new ColumnCountClass();
                    $values['user_info_id'] = "USR" . $columnCountClass->columnCountWhere("user_info_id", $table);

                    // Set added_byID from the session
                    $values['added_byID'] = $_SESSION['id'];

                    // Set the current date
                    date_default_timezone_set('Asia/Kuala_Lumpur');
                    $currentDate = new DateTime();
                    $values['date_added'] = $currentDate->format('Y-m-d H:i:s');

                    // Insert validation
                    $data = array($values['first_name'], $values['last_name']);
                    $column = array('first_name', 'last_name');
                    $validate = new CommonValidationClass();
                    $isValid = $validate->validateColumns($table, $column, $data);
                    $isIdvalid = $validate->validateOneColumn($table, 'personal_id', $values['personal_id']);

                    if ($isIdvalid && $isValid) {
                        $columns = implode(', ', array_keys($values));
                        $questionMarkString = implode(',', array_fill(0, count($values), '?'));
                        $sql = "INSERT INTO $table ($columns) VALUES($questionMarkString);";
                        $params = array_values($values);
                        $addNewUser = new SanitizeCrudClass();

                        try {
                            $addNewUser->executePreState($sql, $params);

                            if ($addNewUser->getLastError() === null) {
                                // if no eror create a credentials
                                // Modify user_info_id based on your logic
                                $credentials_id = "CRED" . $columnCountClass->columnCountWhere("credentials_id", "tbl_credentials");
                                $username = $values['personal_id'];

                                $phpClass = new PHPClass();
                                $password = $phpClass->generatePassword(10);
                                $table = "tbl_credentials";
                                $query = "INSERT INTO $table(credentials_id,uname,pass,user_info_id) VALUES(?,?,?,?);";
                                $params = array($credentials_id, $username, $password, $values['user_info_id']);
                                $addNewCreds = new SanitizeCrudClass();
                                
                                try {
                                    $addNewCreds->executePreState($query, $params);

                                    // !if no error create a contact info
                                    if($addNewCreds->getLastError()=== null){
                                        $table = 'tbl_contact_info';
                                        $contact = array(
                                            'contact_id' => '',
                                            'contact_num'=> $row[5],
                                            'email'=> trim($row[6]),
                                            'street'=> trim($row[7]),
                                            'barangay'=> trim($row[8]),
                                            'municipal_city'=> trim($row[9]),
                                            'province'=> trim($row[10]),
                                            'postalcode'=>trim($row[11]),
                                            'user_info_id'=> $values['user_info_id']
                                        );
                                        
                                        $contact['contact_id'] = "CNT".$columnCountClass->columnCountWhere("contact_id",$table);
                                        $columns = implode(', ', array_keys($contact));
                                        $questionMarkString = implode(',', array_fill(0, count($contact), '?'));
                                        $sql = "INSERT INTO $table ($columns) VALUES($questionMarkString);";
                                        $params = array_values($contact);
                                        //set the sanitize class
                                        $addNewContact = new SanitizeCrudClass();
                                        $addNewContact->executePreState($sql, $params);
                                        
                                        // !if contact adding is successfull
                                        if($addNewContact->getLastError()=== null){
                                            $table = "tbl_student";
                                            $student = array(
                                                'student_id' => '',
                                                'user_info_id' => $values['user_info_id'],
                                                'class_id' => $_POST['class_id']
                                            );
                                            //set student id
                                            $student['student_id'] = "TCH". $columnCountClass->columnCountWhere("student_id", $table);
                                            //set columns
                                            $columns = implode(', ', array_keys($student));
                                            //set number of question marks
                                            $questionMarkString = implode(',', array_fill(0, count($student), '?'));
                                            //set sql
                                            $sql = "INSERT INTO $table($columns)VALUES($questionMarkString);";
                                            // set parameters
                                            $params = array_values($student);
                                            //set sanitize class
                                            $addNewStudent = new SanitizeCrudClass();
                                            $addNewStudent->executePreState($sql, $params);

                                            if($addNewStudent->getLastError()=== null){
                                                $guardian = array(
                                                    'guardian_id' => '',
                                                    'guardian_fname' => trim($row[13]),
                                                    'guardian_lname' => trim($row[12]),                                          
                                                    'guardian_mname' => $row[14],
                                                    'guardian_number' => $row[15],
                                                    'user_info_id' => $values['user_info_id'],
                                                );
                                                //set guardian id
                                                $guardian['guardian_id'] = "GDN".$columnCountClass->columnCountWhere("guardian_id", "tbl_guardian");
                                                //set columns
                                                $columns = implode(', ', array_keys($guardian));
                                                //set number of question marks
                                                $questionMarkString = implode(',', array_fill(0, count($guardian), '?'));
                                                //set sql
                                                $sql = "INSERT INTO tbl_guardian($columns)VALUES($questionMarkString);";
                                                // set parameters
                                                $params = array_values($guardian);
                                                //set sanitize class
                                                $addNewGuardian = new SanitizeCrudClass();
                                                $addNewGuardian->executePreState($sql, $params);

                                                if($addNewGuardian->getLastError()=== null){
                                                    $response = array('success' => 'Successfully added '.$values['first_name'].' '.$values['last_name'].'!');
                                                }

                                            }else{
                                                $response = array('error' => 'Error Adding on student table for '.$values['first_name'].' '.$values['last_name'].'!');
                                                exit();
                                            }
                                        }else{
                                            $response = array('error' => 'Error Adding Contact Info for'.$values['first_name'].' '.$values['last_name'].'!');
                                            exit();
                                        }
                                    }else{
                                        $response = array('error' => 'Error Adding Credentials for'.$values['first_name'].' '.$values['last_name'].'!');
                                        exit();
                                    }
                                    
                                } catch (mysqli_sql_exception $e) {
                                    // Handle any errors during insertion
                                    $response = array('error' => $e->getMessage());
                                    exit();
                                }
                            }else{
                                $response = array('error' => 'Error adding '.$values['first_name'].' '.$values['last_name'].'! Possible Duplicate or Invalid Data!');
                                echo json_encode($response);
                                exit();
                            }
                        } catch (mysqli_sql_exception $e) {
                            // Handle any errors during insertion
                            $response = array('error' => $e->getMessage());
                            exit();
                        }
                    }
                    else{
                        $response = array('error' => 'Error adding '.$values['first_name'].' '.$values['last_name'].'! Possible Duplicate or Invalid Data!');
                        echo json_encode($response);
                        exit();
                    }
                }
                
            //End of loops
            }
            //!end spreadsheet loop
            $response = array('success' => 'Successfully added new teachers');
            echo json_encode($response);
            exit();
            
        } else {
            $resposne = array('error' => 'Error uploading file!');
            echo json_encode($response);
            exit();
        }
    } else {
        $response = array('error' => 'Please upload a valid Excel file!');
        echo json_encode($response);
        exit();
    }
?>