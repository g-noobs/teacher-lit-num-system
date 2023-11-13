<?php 
include_once("Connection.php");

class QuizDisplayClass extends Connection{
    function __construct(){
        parent :: __construct();
    }
    function quizTable(){
        $sql = "SELECT * FROM view_answer_question_quiz";
        $result = $this->conn->query($sql);

        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<tr>";

                echo "<td>"."". "</td>";
                echo "<td>".$row['question_id']. "</td>";
                echo "<td>".$row['quiz_id']. "</td>";
                echo "<td>".$row['question_text']. "</td>";
                echo "<td>".$row['answer_id']. "</td>";
                echo "<td>".$row['answer_text']. "</td>";

                if ($row['is_correct'] == 1){
                    echo "<td>"."Correct Answer". "</td>";
                }
                else{
                    echo "<td>"."Wrong Answer". "</td>";
                }

                echo "<td>".$row['topic_id']. "</td>";
                echo "<td>"."". "</td>";
                

                echo "</tr>";

            }
        }
    }

    function displayTopicOption(){
        $table = "tbl_topic";
        $sql = "SELECT * FROM ".$table;
        $result = $this->conn->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<option value='{$row['topic_id']}'>";
                echo $row['topic_name'];
                echo "</option>";
            }
        }
        else{
            echo"<option>";
            echo "No Topic Available";
            echo "</option>";
        }
    }
    function displayQuestions(){
        $sql = "SELECT * FROM tbl_quiz;";
        $result = $this->getConnection()->query($sql);
        if($result->num_rows > 0){
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td><input type='checkbox' class='checkbox' name='selected[]' value='" . $row['user_info_id'] . "'></td>";

                echo "<td><a href='#' class='quiz_info_btn' data-id='".$row["quiz_id"]."' data-toggle='modal' data-target='#quiz_data_modal'><span class='glyphicon glyphicon-info-sign' style = 'padding-left: 10px;'></span></a>";

                echo "<td>".$row['quiz_id']."</td>";
                echo "<td>".$row['quiz_question']."</td>";
                echo "<td>".$row['date_created']."</td>";
                echo "<td>".$row['topic_id']."</td>";

                echo "<td>";
                echo "<a href='#' class='edit_quiz_btn' data-toggle='modal' data-target='#edit_quiz_modal' data-id='".$row["quiz_id"]."' style='margin-right:10px; color:blue;'><span class='glyphicon glyphicon-edit' ></span></a>";
                
                echo "</td>";
                echo "</tr>";
            }
        }
    }
}
?>
