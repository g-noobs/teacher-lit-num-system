<?php
class EssentialPHPClass{
    function generatePassword($length = 8) {
        // Define a set of characters to choose from for the password
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+';
    
        // Get the total number of characters
        $characterCount = strlen($characters);
    
        // Initialize an empty password string
        $password = '';
    
        // Generate a random password by selecting characters randomly from the set
        for ($i = 0; $i < $length; $i++) {
            $randomIndex = random_int(0, $characterCount - 1);
            $password .= $characters[$randomIndex];
        }
    
        return $password;
    }
    function getFormattedCurrentDate() {
        $formattedDate = date("Y-m-d H:i:s"); // Get the current date and time in the format: YYYY-MM-DD HH:MM:SS
        return $formattedDate;
    }
}
?>