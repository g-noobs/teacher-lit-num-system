<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once "../../../Database/CommonValidationClass.php";
include_once "../../../Database/SanitizeCrudClass.php";
include_once "../../../CommonPHPClass/InputValidationClass.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $inputValidation = new InputValidationClass();
    // Validate and sanitize form data
    $student_id = $inputValidation->test_input($_POST["personal_id"], 'address');
    $last_name = $inputValidation->test_input($_POST["last_name"], 'name');
    $first_name = $inputValidation->test_input($_POST["first_name"], 'name');
    $user_middle_initial = $inputValidation->test_input($_POST["user_middle_initial"], 'middle_initial');//possible No validation for select
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

    $class_id = $inputValidation->test_input($_POST["class_id"], 'address');

    $errors = array();
    if($student_id === false){
        $errors[] = "Invalid characters in Student ID.";
    }
    if ($last_name === false) {
        $errors[] = "Invalid characters in Last Name.";
    }
    if ($first_name === false) {
        $errors[] = "Invalid characters in First Name.";
    }
    if($user_middle_initial === false){
        $errors[] = "Invalid characters in Middle Initial.";
    }
    if($gender === false){
        $errors[] = "Invalid characters in Gender.";
    }
    if ($phone_num === false) {
        $errors[] = "Invalid characters in Phone.";
    }
    if ($email === false) {
        $errors[] = "Invalid email format.";
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
        $errors[] = "Invalid characters in Guardian Phone Number.";
    }
    if($class_id === false){
        $errors[] = "Invalid characters in Class ID.";
    }
    //check for empty fields
    if (!empty($errors)) {
        echo json_encode($errors);
        exit();
        //start Editing if no error catched
    }else{
        $values = array(
            'personal_id' => trim($_POST['personal_id']),
            'first_name' => trim($_POST['first_name']),
            'last_name' =>trim($_POST['last_name']),
            'middle_name' => strtoupper($_POST['user_middle_initial']),
            'gender' => $_POST['gender'],
            'user_info_id' => $_POST['id']
        );
        $table = "tbl_user_info";
        //setting validation class
        $validate = new CommonValidationClass();
        $data = array($values['first_name'], $values['last_name']);
        $column = array('first_name', 'last_name');
        $isValid = $validate -> updatevalidateColumns($table, $column, $data, $values['user_info_id']);
        $isIdvalid = $validate -> updateValidateOneColumn($table, 'personal_id', $values['personal_id'], $values['user_info_id']);
        
        if($isIdvalid && $isValid){
            $sql = "UPDATE tbl_user_info 
            SET personal_id = ?,
                first_name = ?,
                last_name = ?,
                middle_name = ?,
                gender = ?
            WHERE user_info_id = ?";
            $params = array_values($values);
            $updateStdntData = new SanitizeCrudClass();
            try{
                $updateStdntData->executePreState($sql, $params);

                if($updateStdntData->getLastError() === null){
                    $table = "tbl_contact_info";
                    $contact = array(
                        'contact_num'=> $_POST['phone_num'],
                        'email'=> $_POST['email'],
                        'street'=> $_POST['street_address'],
                        'barangay'=> $_POST['barangay_address'],
                        'municipal_city'=> $_POST['city_address'],
                        'province'=> $_POST['province_address'],
                        'postalcode'=>$_POST['zip_code'],
                        'user_info_id' => $_POST['id']
                    );
                    $sql = "UPDATE $table 
                    SET 
                        contact_num = ?,
                        email = ?,
                        street = ?,
                        barangay = ?,
                        municipal_city = ?,
                        province = ?,
                        postalcode = ?
                    WHERE user_info_id = ?";
                    $params = array_values($contact);
                    $updateContact = new SanitizeCrudClass();
                    $updateContact->executePreState($sql, $params);

                    if($updateContact->getLastError()=== null){
                        $table = 'tbl_student';
                        $student = array(
                            'class_id' => $_POST['class_assign'],
                            'user_info_id' => $_POST['id']
                        );
                        $sql = "UPDATE $table
                        SET class_id = ?
                        WHERE user_info_id = ?";
                        $params = array_values($student);
                        $updateStudentDataTable = new SanitizeCrudClass();
                        $updateStudentDataTable->executePreState($sql, $params);
                        if($updateStudentDataTable->getLastError() === null){
                            $table = 'tbl_credentials';
                            $credential = array(
                                'uname' => trim($_POST['personal_id']),
                                'user_info_id' => $values['user_info_id']
                            );
                            $sql = "UPDATE $table
                            SET uname = ?
                            WHERE user_info_id = ?";
                            $params = array_values($credential);
                            $updateCredential = new SanitizeCrudClass();
                            $updateCredential->executePreState($sql, $params);
                            if($updateCredential->getLastError() === null){
                                $table = 'tbl_guardian';
                                $guardian = array(
                                    'last_name' => $_POST['guardian_last_name'],
                                    'first_name' => $_POST['guardian_first_name'],
                                    'middle_name' => $_POST['guardian_middle_name'],
                                    'contact_num' => $_POST['guardian_phone_num'],
                                    'user_info_id' => $_POST['id']
                                );
                                $sql = "UPDATE $table
                                SET guardian_lname = ?,
                                    guardian_fname = ?,
                                    guardian_mname = ?,
                                    guardian_number	 = ?
                                WHERE user_info_id = ?";
                                $params = array_values($guardian);
                                $updateGuardian = new SanitizeCrudClass();
                                $updateGuardian->executePreState($sql, $params);
                                if($updateGuardian->getLastError() === null){
                                    $response = array('success' => 'Student Data Updated Successfully');
                                    echo json_encode($response);
                                    exit();
                                }else{
                                    $response = array('error' => $updateGuardian->getLastError());
                                    echo json_encode($response);
                                    exit();
                                }
                            }else{
                                $response = array('error' => $updateCredential->getLastError());
                                echo json_encode($response);
                                exit();
                            }
                        }else{
                            $response = array('error' => $updateStudentDataTable->getLastError());
                            echo json_encode($response);
                            exit();
                        }
                    }else{
                        $response = array('error' => $updateContact->getLastError());
                        echo json_encode($response);
                        exit();
                    }
                }else{
                    $response = array('error' => $updateTeacherData->getLastError());
                    echo json_encode($response);
                    exit();
                }
            }
            catch(Exception $e){
                echo $e->getMessage();
                exit();
            }
        }else{
            //invalid error
            exit();
        }
    }

}
?>