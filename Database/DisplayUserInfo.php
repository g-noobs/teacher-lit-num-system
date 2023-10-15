<?php 
session_start();
include_once("Connection.php");
class DisplayUserInfo extends Connection{
    private $lastError;
    function __construct(){
        parent :: __construct();
    }

    function displayTeacherName(){
        $sql = "SELECT * FROM user_info_view WHERE user_info_id = '{$_SESSION['id']}'";
        $result = $this->getConnection()->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo $row['first_name']." " .$row['last_name'];
            }
        }
    }

    function displayTeacherEmail(){
        $sql = "SELECT * FROM user_info_view WHERE user_info_id = '{$_SESSION['id']}'";
        $result = $this->getConnection()->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo $row['email'];
            }
        }
    }
}
?>