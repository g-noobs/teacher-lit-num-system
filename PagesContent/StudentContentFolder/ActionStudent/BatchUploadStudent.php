<?php
session_start();


require '../../../vendor/autoload.php'; // Include PhpSpreadsheet library autoloader
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

// if (isset($_POST['upload_excel'])) {
    // Allowed mime types for Excel files
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
                    'middle_name' => trim($row[3]),
                    'gender' => trim($row[4]),
                    'user_level_id' => '2',
                    'added_byID' => '',
                    'date_added' => '',
                    'class_id' => $_POST['class_id']
                );
                
                // Database table for user information
                // Include necessary libraries and set up the database configuration
                include_once("../../../Database/ColumnCountClass.php");
                include_once("../../../Database/CommonValidationClass.php");
                include_once("../../../Database/SanitizeCrudClass.php");
                include_once("../../../CommonPHPClass/PHPClass.php");

                $table = "tbl_user_info";   
                // Set user_info_id
                $columnCountClass = new ColumnCountClass();
                $values['user_info_id'] = "USR" . $columnCountClass->columnCountWhere("user_info_id", $table);

                // Set added_byID from the session
                $values['added_byID'] = $_SESSION['id'];

                // Set the current date
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
                                        'contact_num'=> trim($row[5]),
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
                                                
                                                'guardian_lname' => trim($row[12]),
                                                'guardian_fname' => trim($row[13]),
                                                'guardian_mname' => trim($row[14]),
                                                'guardian_number' => trim($row[15]),
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
                                                // $response = array('success' => 'Successfully added '.$values['first_name'].' '.$values['last_name'].'!');
                                            }

                                        }else{
                                            $errors[] = 'Error Adding on student table for '.$values['first_name'].' '.$values['last_name'].'!';
                                            break;
                                        }
                                    }else{
                                        $errors[] = 'Error Adding Contact Info for'.$values['first_name'].' '.$values['last_name'].'!';
                                        break;
                                    }
                                }else{
                                    $errors[] = 'Error Adding Credentials for'.$values['first_name'].' '.$values['last_name'].'!';
                                    break;
                                }
                                
                            } catch (mysqli_sql_exception $e) {
                                // Handle any errors during insertion
                                $errors[] = $e->getMessage();
                                break;
                            }
                        }else{
                            $errors[] = 'Error adding '.$values['first_name'].' '.$values['last_name'].'! Possible Duplicate or Invalid Data!';
                            break;
                        }
                    } catch (mysqli_sql_exception $e) {
                        // Handle any errors during insertion
                        $errors[] = $e->getMessage();
                        break;
                    }
                }
                else{
                    $errors[] = 'Error adding '.$values['first_name'].' '.$values['last_name'].'! Possible Duplicate or Invalid Data!';
                    break;
                }
            }
        } else {
            $errors[] = 'Error uploading file!';
            
        }
    } else {
        $errors[] = "Please upload a valid Excel file!";
    }
// }else{
//     $response = array('error' => 'Possible POST ISSUE');
//     echo json_encode($response);
// }

if (!empty($errors)) {
    echo json_encode($errors);
    //start adding if no error catched
}else{
    $response = array('success' => 'Successfully added all students from excel!');
    echo json_encode($response);
}
?>