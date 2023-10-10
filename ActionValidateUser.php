<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Perform your validation logic here

    // Validate username
    if (empty($username)) {
        $response = array('error' => "Username is required");
        echo  json_encode($response);
    }

    // Validate password
    if (empty($password)) {
        $response = array('error' => "Password is required");
        echo  json_encode($response);

    }
    
    // If there are no errors, compare the username and password with the database
    include_once("../ValidateCredsClass.php");
    $validate = new ValidateCredsClass();
    $isCorrect = $validate ->checkTeacherCreds($username, $password);
    
    if($isCorrect){
        $_SESSION['loggedin'] = true;
        $response = array('success' => "Success!");
        echo json_encode($response);
    }
    else{
        $response = array('error' => "Invalid Credentials!");
        echo  json_encode($response);
    }
    
}
else{
    $response = array('error' => "POST ISSUE");
    echo  json_encode($response);
}

?>