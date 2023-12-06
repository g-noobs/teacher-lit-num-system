<?php 
include_once "Connection.php";
class DisplayGradebook extends Connection{
    function __construct(){
        parent :: __construct();
    }
    function displayAssign($teacher_id){
        $table = "tbl_assignment";
        $sql = "SELECT a.*, t.topic_name
        FROM $table a
        JOIN tbl_topic t ON a.topic_id = t.topic_id
        WHERE a.created_by = 'teacher_id';";

        $result = $this->getConnection()->query($sql);
        
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td>" .$row['assignment_id'] . "</td>";
                echo "<td>" .$row['assignment_name'] . "</td>";
                echo "<td>" .$row['question'] . "</td>";
                echo "<td>" .$row['max_score'] . "</td>";
                echo "<td>" .$row['date_added'] . "</td>";
                echo "<td>" .$row['status'] . "</td>";
                echo "</tr>";
            }
        }
    }
}
?>