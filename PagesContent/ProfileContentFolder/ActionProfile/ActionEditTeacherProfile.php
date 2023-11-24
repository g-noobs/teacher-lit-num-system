<?php 
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

//Character Validation Class
include_once "../../../CommonPHPClass/InputValidationClass.php";
// Duplicate validation Class
include_once "../../../Database/CommonValidationClass.php";
//update parameter sanitation
include_once "../../../Database/SanitizeCrudClass.php";

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    //set the input validation
    $inputValidation = new InputValidationClass();
    
    $last_name = $inputValidation->test_input($_POST['last_name'], 'name');
    $first_name = $inputValidation->test_input($_POST['first_name'], 'name');
    $middle_initial = $inputValidation->test_input($_POST['middle_initial'], 'middle_initial');
    $gender = $inputValidation->test_input($_POST['gender'], 'name');

    $phone = $inputValidation->test_input($_POST['phone'], 'phone');
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $street = $inputValidation->test_input($_POST["street"], 'address');
    $baranggay = $inputValidation->test_input($_POST["baranggay"], 'address');
    $city_municipality = $inputValidation->test_input($_POST["city_municipality"], 'address');
    $province = $inputValidation->test_input($_POST["province"], 'address');
    $zip_code = $inputValidation->test_input($_POST["zip_code"], 'number');
    $username = $inputValidation->test_input($_POST['username'], 'description');
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_pass'];

    $errors = array();
    if($last_name === false){
        $errors[] = "Invalid characters in Last Name.";
    }
    if($first_name === false){
        $errors[] = "Invalid characters in First Name.";
    }
    if($middle_initial === false){
        $errors[] = "Invalid characters in Middle Initial.";
    }
    if($gender === false){
        $errors[] = "Invalid characters in Gender.";
    }
    if($phone === false){
        $errors[] = "Invalid characters in Phone.";
    }
    if($email === false){
        $errors[] = "Invalid email format.";
    }
    if($street === false){
        $errors[] = "Invalid street format.";
    }
    if($baranggay === false){
        $errors[] = "Invalid barangay format.";
    }
    if($city_municipality === false){
        $errors[] = "Invalid Municipality or City format.";
    }
    if($province === false){
        $errors[] = "Invalid Province format.";
    }
    if($zip_code === false){
        $errors[] = "Invalid zip code format.";
    }
    //check for empty fields
    if (!empty($errors)) {
        echo json_encode($errors);
        exit();
        //start adding if no error catched
    }elseif($pasword != $confirm_password){
        $response = array('error' => 'Password does not match!');
        echo json_encode($response);
        exit();
    }else{
        $table = "tbl_user_info";
        $id = $_SESSION['id'];
        
        $values = array(
            'last_name' => trim($_POST['last_name']),
            'first_name' => trim($_POST['first_name']),
            'middle_name' => $_POST['middle_initial'],
            'gender' => $_POST['gender'],
        );
        $contact = array(
            'contact_num' => $_POST['phone'],
            'email' => $_POST['email'],
            'street' => $_POST['street'],
            'barangay' => $_POST['baranggay'],
            'municipal_city' => $_POST['city_municipality'],
            'province' => $_POST['province'],
            'postalcode' => $_POST['zip_code'],
        );
        $credential = array(
            'uname' => $_POST['username'],
            'pass' => $_POST['password']
        );

        //set validation
        $validate = new CommonValidationClass();
        $data = array($values['first_name'], $values['last_name']);
        $column = array('first_name', 'last_name');
        $isValid = $validate -> updatevalidateColumns($table, $column, $data);

        if($isValid){
            $sql = "UPDATE $table SET last_name = ?, first_name = ?, middle_name = ?, gender = ? WHERE user_info_id = '$id'";
            $params = array_values($values);
            $updateUser = new SanitizeCrudClass();
            $updateUser->executePreState($sql, $params);

            if($updateUser->getLastError() === null){
                $table_contact = "tbl_contact_info";
                $sql = "UPDATE $table_contact SET contact_num = ?, email = ?, street = ?, barangay = ?, municipal_city = ?, province = ?, postalcode = ?
                WHERE user_info_id = '$id'";
                $params = array_values($contact);
                $updateContact = new SanitizeCrudClass();
                $updateContact->executePreState($sql, $params);

                if($updateContact->getLastError() === null){
                    $table_creds = "tbl_credentials";
                    $sql = "UPDATE $table_creds SET uname = ?, pass = ? WHERE user_info_id = '$id'";
                    $params = array_values($credential);
                    $updateCred = new SanitizeCrudClass();
                    $updateCred->executePreState($sql, $params);

                    if($updateCred->getLastError() === null){
                        $response = array('success' => 'Successfully edited Teacher Data');
                        echo json_encode($response);
                        exit();
                    }else{
                        $response = array('error'=> 'Error on adding user credntials info');
                        echo json_encode($response);
                        exit();
                    }
                }else{
                    $response = array('error'=> 'Error on adding user basic info');
                    echo json_encode($response);
                    exit();
                }
            }else{
                $response = array('error'=> 'Error on adding user contact info');
                echo json_encode($response);
                exit();
        }
        }else{
            $response = array('error'=> 'duplicate for First Name and Last Name');
            echo json_encode($response);
            exit();
        }
    }
}else{
    $response = array('error'=> 'POSSIBLE POST ISSUE');
    echo json_encode($response);
    exit();
}
?>