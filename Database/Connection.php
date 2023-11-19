<?php
class Connection{
    protected $host;
    protected $username;
    protected $password;
    protected $database;
    protected $conn;

    public function __construct(){
        //! Online Deployment
        // $this->host = "156.67.222.1"; 
        $this->host = "localhost"; 
        $this->username = "u170333284_admin";  
        $this->password = "Capstone1!";  
        $this->database = "u170333284_db_tagakaulo";  
        $this->connect();

        //! Local Deployment 
        // $this->host = "localhost:3306";  /
        // $this->username = "admin"; 
        // $this->password = "admin";  
        // $this->database = "u170333284_db_tagakaulo"; 
        // $this->connect();
    }
    public function connect(){
        $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->database);
        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }
    //This will close the Connection
    public function close(){
        if($this->conn){
            $this->conn->close();
        }
    }
    //Access the variable $conn outside this class
    public function getConnection(){
        return $this->conn;
    }
}
?>