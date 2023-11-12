<?php 
include_once("Database/Connection.php");

class ValidateCredsClass extends Connection{


    function checkCreds($username,$password){
        $table = "view_userinfo_creds";
        $sql = "SELECT * FROM $table  WHERE uname = '$username' AND pass = '$password' AND user_level_id = 0 AND status_id = 1;";

        $result = $this->getConnection()->query($sql);
        if ($result && mysqli_num_rows($result) > 0){

            while($row = $result->fetch_assoc()){
                $_SESSION['name'] =  $row['first_name']. " ". $row['last_name'];
                $_SESSION['id'] = $row['user_info_id'];
                
            }
            return true;
        }
        else{
            return false;
        }
    }
    
    function checkTeacherCreds($username,$password){
        $table = "view_userinfo_creds";
        $sql = "SELECT * FROM $table  WHERE uname = '$username' AND pass = '$password' AND user_level_id = 1 AND status_id = 1;";
        //will use this while view_userinfo_creds is not available
    
        $result = $this->getConnection()->query($sql);
        if ($result && mysqli_num_rows($result) > 0){

            while($row = $result->fetch_assoc()){
                $_SESSION['name'] =  $row['first_name']. " ". $row['last_name'];
                $_SESSION['id'] = $row['user_info_id'];
            }
            return true;
        }
        else{
            return false;
        }
    }
}
?>