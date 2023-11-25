<?php 

class InputValidationClass{
    function test_input($data, $type) {
        if(!empty($data)){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
        }
        if ($type == 'name') {
            // Allow only letters and whitespace
            if (!preg_match("/^[a-zA-Z ]*$/", $data)) {
                return false;
            }
        } elseif ($type == 'address') {
            // Allow alphanumeric and whitespace
            if (!preg_match("/^[a-zA-Z0-9 ]*$/", $data)) {
                return false;
            }
        } elseif ($type == 'phone') {
            // Allow only numbers
            if(empty($data)){
                return true;
            }elseif (!preg_match("/^[0-9+-]*$/", $data)) {
                return false;
            }
        }elseif ($type == 'middle_initial') {
            // Allow one character or an empty string
            if(empty($data)){
                return true;
            }elseif (strlen($data) > 1 || !preg_match("/^[a-zA-Z ]*$/", $data)) {
                return false; // Validation failed
            }
        }
        elseif ($type == 'number') {
            // Allow only numbers
            if (!preg_match("/^[0-9]*$/", $data)) {
                return false;
            }
        }elseif ($type == 'alphanum'){
            // Allow alphanumeric without whitespace
            if (!preg_match("/^[a-zA-Z0-9]*$/", $data)) {
                return false;
            }
        }elseif($type == 'description'){
            //allow alplhanumeric and some symbols for basic description input
            if (!preg_match("/^[a-zA-Z0-9_\-\s?!]*$/", $data)) {
                return false;
            }
        }
        return true;
    }
}
?>