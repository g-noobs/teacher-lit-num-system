<?php 
include_once "Connection.php";
class LessonDisplayClass extends Connection{
    function __construct(){
        parent :: __construct();
    }

    // finction for showing category name options
    function displayCategoryList(){
        $sql = "SELECT 	category_id , category_name  FROM tbl_category WHERE category_status = 1";
        $result = $this->conn->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<option value='{$row['category_id']}'>";
                echo $row['category_name'];
                echo "</option>";
            }
        }
        else{
            echo"<option>";
            echo "No category Assigned or Available";
            echo "</option>";
        }
    }
    // Function for showing subject name options
    function displaySubjectlist($teacher_user_id){
        $table = 'view_teacher_module_info';
        $sql = "SELECT 	module_id , module_name  FROM $table  WHERE module_status = 1 AND user_info_id = '$teacher_user_id';";
        $result = $this->conn->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<option value='{$row['module_id']}'>";
                echo $row['module_name'];
                echo "</option>";
            }
        }
        else{
            echo"<option>";
            echo "No Module Available or Assigned";
            echo "</option>";
        }
    }

    function lessonTable($teacher_user_id){
        $table = "lesson_view";
        $sql = "SELECT * FROM $table WHERE module_status = 1 AND lesson_status = 1 AND added_byID = '$teacher_user_id' ";
        $result = $this->getConnection()->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<tr>";
                
                echo "<td><input type='checkbox' class='checkbox' name='selected[]' value='" . $row['lesson_id'] . "'></td>";
                
                echo "<td>" . $row["lesson_id"] . "</td>";
                echo "<td>" . $row["lesson_name"] . "</td>";
                echo "<td>" . $row["lesson_description"] . "</td>";
                echo "<td>" . $row["category_name"] . "</td>";
                echo "<td>" . $row["module_name"] . "</td>";
                
                echo "<td><a href='#' class='viewBtn' type='button' data-toggle='tooltip' title='View Lesson' data-id='" . $row["lesson_id"] . "'> <i class='fa fa-eye'></i> </a></td>";
                echo "<td><a href='#' class='addBtn text-success' type='button' data-toggle='tooltip' title='Add Lesson'  data-id='" . $row["lesson_id"] . "'><i class='fa fa-plus'></i></a></td>";
                
                echo "<td><a href='#' class='edit' data-toggle='tooltip' title='Edit Lesson' data-id='" . $row["lesson_id"] . "'><span class='glyphicon glyphicon-edit'></span></a></td>";
                echo "</tr>";
            }
        }   
    }
    function archivedLessonTable($teacher_user_id){
        $table = "lesson_view"; //archive_lesson_view
        // $teacher_user_id = $_SESSION['id'];
        $sql = "SELECT * FROM $table WHERE module_status = 1 AND lesson_status = 0 AND added_byID = '$teacher_user_id'";
        $result = $this->getConnection()->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<tr>";

                echo "<td><input type='checkbox' class='checkbox' name='selected[]' value='" . $row['lesson_id'] . "'></td>";
                
                echo "<td>" . $row["lesson_id"] . "</td>";
                echo "<td>" . $row["lesson_name"] . "</td>";
                echo "<td>" . $row["lesson_description"] . "</td>";
                echo "<td>" . $row["category_name"] . "</td>";
                echo "<td>" . $row["module_name"] . "</td>";
                
                echo "</tr>";
            }
        }   
    }
    function topicTable($lessonId, $teacher_user_id){
        $sql = "SELECT * FROM tbl_topic WHERE added_byID = '$teacher_user_id' AND lesson_id = '".$lessonId."';";
        $result = $this->getConnection()->query($sql);
        
        if($result-> num_rows >0){
            while($row = $result->fetch_assoc()){
                
                if($row['topic_status'] == 1){
                    $status = "<b class=text-success>Active</b>";

                }
                else{
                    $status = "<b class=text-success>Inactive</b>";
                }
                echo '<tr>';
                echo "<td><a href='#' class='viewBtn' type='button' data-toggle='tooltip' title='View Topic' data-id='" . $row["topic_id"] . "'> <i class='fa fa-eye'></i> </a></td>";
                echo '<td>'. $row['topic_id'] .'</td>';
                echo '<td>'. $row['topic_name'] .'</td>';
                echo '<td>'. $status .'</td>';

                echo "<td><a href='#' type='button' class='edit_topic_btn' data-id='".$row['topic_id']."' style='margin-right:10px; color: blue;'><span class='glyphicon glyphicon-edit' ></span></a></td>";
                
                echo '</tr>';
            }
        }
        
    }
}
?>