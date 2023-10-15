<?php 
include_once("Connection.php");
class SanitizeCrudClass extends Connection{
    private $lastError;
    function __construct(){
        parent :: __construct();
    }
    public function executePreparedStatement($query, $params, $header){
        $stmt = $this->getConnection()->prepare($query);

        if(!$stmt){
            die("Error in prepared statement: ". $this->conn->error);
        }

        //Generate the data type string for bind_param dynamically
        $dataTypes = '';
        foreach ($params as $param) {
            if (is_int($param)) {
                $dataTypes .= 'i'; // integer
            } elseif (is_float($param)) {
                $dataTypes .= 'd'; // double
            }
            elseif (is_string($param) && strtotime($param)) { 
                $dataTypes .= 's'; // Bind dates as strings
            }  
            else {
                $dataTypes .= 's'; // string
            }
        }
        // Bind parameters dynamically
        $stmt->bind_param($dataTypes, ...$params);

        // Execute the statement
        $stmt->execute();

        // Check for errors during execution
        if ($stmt->error) {
            die("Error during execution of prepared statement: " . $stmt->error);
        }
         $stmt->close();

        header("Location: ". $header);
        exit();
    }
    public function executePreState($query, $params){
        $stmt = $this->getConnection()->prepare($query);

        if(!$stmt){
            $this->lastError = $this->getConnection()->error;
            die("Error in prepared statement: ". $this->getConnection()->error);
        }

        //Generate the data type string for bind_param dynamically
        $dataTypes = '';
        foreach ($params as $param) {
            if (is_int($param)) {
                $dataTypes .= 'i'; // integer
            } elseif (is_float($param)) {
                $dataTypes .= 'd'; // double
            } else {
                $dataTypes .= 's'; // string
            }
        }
        // Bind parameters dynamically
        $stmt->bind_param($dataTypes, ...$params);

        // Execute the statement
        $stmt->execute();

        // Check for errors during execution
        if ($stmt->error) {
            die("Error during execution of prepared statement: " . $stmt->error);
            
        }
        
         $stmt->close();
    }
    public function getLastError() {
        return $this->lastError;
    }
}

?>
