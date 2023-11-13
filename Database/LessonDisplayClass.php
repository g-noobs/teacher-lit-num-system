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
            echo "No category Level Available";
            echo "</option>";
        }
    }
    // Function for showing subject name options
    function displaySubjectlist(){
        $sql = "SELECT 	module_id , module_name  FROM tbl_module WHERE module_status = 1";
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
            echo "No Subject Available";
            echo "</option>";
        }
    }

    function lessonTable(){
        $table = "lesson_view";
        $sql = "SELECT * FROM ".$table;
        $result = $this->getConnection()->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<tr>";
                
                echo "<td><input type='checkbox' class='checkbox' name='selected[]' value='" . $row['user_info_id'] . "'></td>";

                echo "<td>" . $row["lesson_id"] . "</td>";
                echo "<td>" . $row["lesson_name"] . "</td>";
                echo "<td>" . $row["category_name"] . "</td>";
                echo "<td>" . $row["module_name"] . "</td>";
                
                echo "<td><a href='#' class='viewBtn' type='button' data-toggle='tooltip' title='View Lesson' data-id='" . $row["lesson_id"] . "'> <i class='fa fa-eye'></i> </a></td>";
                echo "<td><a href='#' class='addBtn text-success' type='button' data-toggle='tooltip' title='Add Lesson'  data-id='" . $row["lesson_id"] . "'><i class='fa fa-plus'></i></a></td>";
                echo "<td><a href='#' class='edit' data-toggle='modal' data-toggle='tooltip' title='Edit Lesson'  data-target='#edit-user' data-id='" . $row["lesson_id"] . "'><span class='glyphicon glyphicon-edit'></span></a></td>";
                echo "</tr>";
            }
        }   
    }
    function topicTable($lessonId){
        $sql = "SELECT * FROM tbl_topic WHERE lesson_id = '".$lessonId."';";
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

                echo "<td><a href='#' type='button' id='editBtn-".$row['topic_id']."' data-toggle='modal' data-target='#editModal' style='margin-right:10px; color: blue;'><span class='glyphicon glyphicon-edit' ></span></a></td>";
                
                echo "<td><a href='#' type='button' id='archiveBtn-".$row['topic_id']."' data-toggle='modal' data-target='#archiveModal' style='color:red';> <span class='glyphicon glyphicon-trash'></span></a></td>";
                echo '</tr>';
            }
        }
        
    }
}
?>