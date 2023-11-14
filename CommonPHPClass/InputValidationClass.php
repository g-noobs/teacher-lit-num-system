<?php 

class InputValidationClass{
    function test_input($data, $type) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
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
            if (!preg_match("/^[0-9+-]*$/", $data)) {
                return false;
            }
        }elseif ($type == 'middle_initial') {
            // Allow only one character
            if (strlen($data) !== 1 || !preg_match("/^[a-zA-Z ]*$/", $data)) {
                return false; // Validation failed
            }
        }
        elseif ($type == 'number') {
            // Allow only numbers
            if (!preg_match("/^[0-9]*$/", $data)) {
                return false;
            }
        }
        return true;
    }
}
?>