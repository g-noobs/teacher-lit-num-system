<?php 
include_once("Connection.php");
class QuizDisplayClass extends Connection{
    private $lastError;
    function __construct(){
        parent :: __construct();
    }
    function quizTable(){
        $sql = "SELECT * FROM tbl_quiz;";
        $result = $this->getConnection()->query($sql);
        if($result->num_rows > 0){
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td><a href='#' class='quiz_info_btn' data-id='".$row["quiz_id"]."' data-toggle='modal' data-target='#quiz_data_modal'><span class='glyphicon glyphicon-info-sign' style = 'padding-left: 10px;'></span></a>";

                echo "<td>".$row['quiz_id']."</td>";
                echo "<td>".$row['quiz_question']."</td>";
                echo "<td>".$row['date_created']."</td>";
                echo "<td>".$row['topic_id']."</td>";

                echo "<td>";
                echo "<a href='#' class='edit_quiz_btn' data-toggle='modal' data-target='#edit_quiz_modal' data-id='".$row["quiz_id"]."' style='margin-right:10px; color:blue;'><span class='glyphicon glyphicon-edit' ></span></a>";
                
                echo " <a href='#' class='archive_quiz_btn text-danger' data-toggle='modal' data-target='#archive_quiz_modal' data-id='".$row["quiz_id"]."'><span class='glyphicon glyphicon-trash'></span></a>";
                echo "</td>";
                echo "</tr>";
            }
        }
    }
}
?>