<?php 
include_once "Connection.php";
class ColumnCountClass extends Connection{
    function __construct(){
        parent :: __construct();
    }

    function columnCount($col,$table){
        $sql = "SELECT COUNT($col) as count FROM $table";  // Replace with your table name
        $result = $this->conn->query($sql);
    
        if ($result->num_rows > 0) {
            // Fetch the count value
            $row = $result->fetch_assoc();
            $count = $row["count"];
            
            return $count;
        } else {
            return 0;
        }
    }
    function columnCountNum($sql){
        $result = $this->conn->query($sql);
    
        if ($result->num_rows > 0) {
            // Fetch the count value
            $row = $result->fetch_assoc();
            $count = $row["count"];
            
            return $count;
        } else {
            return 0;
        }
    }

    function columnCountWhere($col,$tableName){
        $query = "SELECT COUNT($col) as count FROM $tableName";// Replace with your table name
        $result = $this->getConnection()->query($query);
    
        if ($result) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $count = $row["count"];
            } else {
                $count = 0;
            }
            $value = str_pad(($count+1)+ 100000, 6, '0', STR_PAD_LEFT);
            return $value;
        } else {
            // Handle the query execution error here.
            return "Error";
        }
    }
}
?>