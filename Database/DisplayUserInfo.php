<?php 
include_once("Connection.php");
class DisplayUserInfo extends Connection{
    private $lastError;
    function __construct(){
        parent :: __construct();
    }

    function displayTeacherName($sql){
        $result = $this->getConnection()->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo $row['first_name']." " .$row['last_name'];
            }
        }
    }

    function displayTeacherEmail($sql){
        $result = $this->getConnection()->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo $row['email'];
            }
        }
    }
}
?>