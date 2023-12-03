<?php 
include_once("Connection.php");

class CommonValidationClass extends Connection{
    function __construct(){
        parent :: __construct();
    }
    function validateColumns($table, $column, $value) {
        // Convert column and value to arrays if they are not already
        if (!is_array($column)) {
            $column = [$column];
        }
    
        if (!is_array($value)) {
            $value = [$value];
        }
    
        // Check if the column and value arrays have the same count
        if (count($column) !== count($value)) {
            echo "<script>console.log('Columns and values must have the same count.')</script>";
            throw new Exception("Columns and values must have the same count.");
        }
    
        $conditions = [];
    
        // Loop through columns and values to build the WHERE clause
        for ($i = 0; $i < count($column); $i++) {
            $conditions[] = "$column[$i] = '" . addslashes($value[$i]) . "'";
        }
    
        $conditionString = implode(" AND ", $conditions);
        $sql = "SELECT COUNT(*) FROM $table WHERE $conditionString";
    
        // Execute the SQL query
        $result = $this->getConnection()->query($sql);
    
        if ($result === false) {
            echo "<script>console.log('Error executing query: " . $this->getConnection()->error . "')</script>";
            throw new Exception("Error executing query: " . $this->getConnection()->error);
        }
    
        $count = $result->fetch_row()[0];
        // Return true if duplicate exists, false otherwise
        if($count > 0){
            return false;
        }
        else{
            return true;
        }
    }
    function validateOneColumn($table, $column, $data){
        $sql = "SELECT COUNT($column) as count FROM $table WHERE $column = '$data'";
        $result = $this->getConnection()->query($sql);
        if($result->num_rows >0){
            $row = $result->fetch_assoc();
            $count = $row["count"];
            if($count > 0){
                return false;
            }
            else{
                return true;
            }
        }
    }

    function updatevalidateColumns($table, $column, $value, $user_info_id) {
        // Convert column and value to arrays if they are not already
        if (!is_array($column)) {
            $column = [$column];
        }
    
        if (!is_array($value)) {
            $value = [$value];
        }
    
        // Check if the column and value arrays have the same count
        if (count($column) !== count($value)) {
            echo "<script>console.log('Columns and values must have the same count.')</script>";
            throw new Exception("Columns and values must have the same count.");
        }
    
        $conditions = [];
    
        // Loop through columns and values to build the WHERE clause
        for ($i = 0; $i < count($column); $i++) {
            $conditions[] = "$column[$i] = '" . addslashes($value[$i]) . "'";
        }
    
        // Add the condition for excluding the current row based on user_info_id
        $conditions[] = "user_info_id != '$user_info_id'";
    
        $conditionString = implode(" AND ", $conditions);
        $sql = "SELECT COUNT(*) FROM $table WHERE $conditionString";
    
        // Execute the SQL query
        $result = $this->getConnection()->query($sql);
    
        if ($result === false) {
            echo "<script>console.log('Error executing query: " . $this->getConnection()->error . "')</script>";
            throw new Exception("Error executing query: " . $this->getConnection()->error);
        }
    
        $count = $result->fetch_row()[0];
        if ($count > 0) {
            return false; // There is at least one duplicate (excluding the current row)
        } else {
            return true; // No duplicates found
        }
    }
    

    function updateValidateOneColumn($table, $column, $data, $user_info_id){
        $sql = "SELECT COUNT($column) as count 
                FROM $table 
                WHERE $column = '$data' AND user_info_id != '$user_info_id';";
        
        $result = $this->getConnection()->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $count = $row["count"];
            
            if ($count > 0) {
                // There is at least one duplicate (excluding the current row)
                return false;
            } else {
                // No duplicates found
                return true;
            }
        }
        
        // Error in the query or no results
        return false;
    }
    function updateValidateOne($table, $column, $data, $column_id_name ,$id_data){
        $sql = "SELECT COUNT($column) as count 
                FROM $table 
                WHERE $column = '$data' AND $column_id_name != '$id_data';";
        
        $result = $this->getConnection()->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $count = $row["count"];
            
            if ($count > 0) {
                // There is at least one duplicate (excluding the current row)
                return false;
            } else {
                // No duplicates found
                return true;
            }
        }
        
        // Error in the query or no results
        return false;
    } 
}
?>