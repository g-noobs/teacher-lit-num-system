<?php 
include_once("Connection.php");
class LessonDisplayClass extends Connection{
    private $lastError;
    function __construct(){
        parent :: __construct();
    }

    function lessonTable(){
        $table = "lesson_view";
        $sql = "SELECT * FROM ".$table;
        $result = $this->getConnection()->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td><a href='#' class='edit' data-toggle='modal' data-toggle='tooltip' title='Edit Lesson'  data-target='#edit-user' data-id='" . $row["lesson_id"] . "'><span class='glyphicon glyphicon-edit'></span></a></td>";
                

                echo "<td>" . $row["lesson_id"] . "</td>";
                echo "<td>" . $row["lesson_name"] . "</td>";
                echo "<td>" . $row["subj_name"] . "</td>";
                
                echo "<td><a href='#' class='viewBtn' type='button' data-toggle='tooltip' title='View Lesson' data-id='" . $row["lesson_id"] . "'> <i class='fa fa-eye'></i> </a></td>";
                echo "<td><a href='#' class='addBtn text-success' type='button' data-toggle='tooltip' title='Add Lesson'  data-id='" . $row["lesson_id"] . "'><i class='fa fa-plus'></i></a></td>";
                echo "<td><a href='#' class='text-danger' type='button' data-toggle='tooltip' title='Archive Lesson' class='archive'  data-id='" . $row["lesson_id"] . "'><i class='fa fa-trash-o'></i></a></td>";
                
                echo "</tr>";
            }
        }   
    }
    
}
?>
