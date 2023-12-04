<?php 
include_once "Connection.php";
class DisplayGradebook extends Connection{
    function __construct(){
        parent :: __construct();
    }

    function gradebookData(){
        $sql = "SELECT
            ui.personal_id,
            ui.first_name,
            ui.last_name,
            COUNT(DISTINCT lqp.quiz_id) AS number_of_quizzes,
            SUM(lqp.score) AS total_score
        FROM
            tbl_learner_quiz_progress lqp
        JOIN
            tbl_user_info ui ON lqp.learner_id = ui.personal_id
        GROUP BY
            ui.personal_id, ui.first_name, ui.last_name;";

        $result = $this->conn->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<tr>";

                echo "<td>" . $row["personal_id"] . "</td>";
                echo "<td>" . $row['last_name'].", ".$row["first_name"]."</td>";
                echo "<td>" . $row["number_of_quizzes"] . "</td>";
                echo "<td>" . $row["total_score"] . "</td>";                
                echo "</tr>";
            }
        }
        else{
            echo "<tr>";
            echo "<td colspan='9'> No Gradebook Available </td>";
            echo "</tr>";
        }
    } 
}
?>