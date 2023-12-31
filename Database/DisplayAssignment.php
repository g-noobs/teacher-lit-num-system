<?php 
include_once "Connection.php";
class DisplayAssignment extends Connection{
    function __construct(){
        parent :: __construct();
    }
    function displayAssign($teacher_id){
        $table = "tbl_assignment";
        $sql = "SELECT a.*, t.topic_name
        FROM $table a
        JOIN tbl_topic t ON a.topic_id = t.topic_id
        WHERE a.created_by = '$teacher_id';";

        $result = $this->getConnection()->query($sql);
        
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<tr>";

                echo "<td><input type='checkbox' class='checkbox' name='selected[]' value='" . $row['assignment_id'] . "'></td>";

                echo "<td>" .$row['assignment_id'] . "</td>";
                echo "<td>" .$row['assignment_name'] . "</td>";
                echo "<td>" .$row['question'] . "</td>";
                echo "<td>" .$row['max_score'] . "</td>";
                echo "<td>" .$row['date_added'] . "</td>";
                echo "<td>" .$row['topic_name'] . "</td>";

                echo "<td><a href='#' class='assign_class_btn text-primary' type='button' data-toggle='tooltip' title='Assign a Class' data-id='".$row["assignment_id"]."'><i class='fa fa-plus'></i></a></td>";

                echo "<td><a href='#' class='view_assigned text-warning' type='button' data-toggle='tooltip' title='View Assignment' data-id='".$row["assignment_id"]."'><i class='fa fa-info'></i></a></td>";
                echo "</tr>";
            }
        }
    }
}
?>