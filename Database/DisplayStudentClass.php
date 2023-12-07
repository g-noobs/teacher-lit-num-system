
<?php 
include_once "Connection.php";
class DisplayStudentClass extends Connection{
    function __construct(){
        parent :: __construct();
    }

    function ActiveStudentList(){
        $table = "user_info_view";
        $sql = "SELECT * FROM $table WHERE status = 'Active' AND user_level_description = 'Learner';";  
        $result = $this->getConnection()->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td><a href='#'><span class='glyphicon glyphicon-info-sign' style = 'padding-left: 10px;'></span></a>";

                echo "<td>".$row['personal_id']."</td>";
                echo "<td>".$row['first_name']."</td>";
                echo "<td>".$row['last_name']. "</td>";
                echo "<td>".$row['gender']."</td>";
                echo "<td class=text-success><strong>".$row['status']."</strong></td>";

                echo "<td>";
                echo "<a href='#' class='edit' data-id='".$row["user_info_id"]."' style='margin-right:10px; color: text-success;'><span class='glyphicon glyphicon-edit' ></span></a>";
                
                echo " <a href='#' class='actvIconBtn text-danger' data-toggle='modal' data-target='#arcviveStudentModal' data-id='".$row["user_info_id"]."'> <span class='glyphicon glyphicon-trash'></span></a>";
                echo "</td>";

                echo "</tr>";
            }
        }

    }
    function ArchiveStudentList(){
        $table = "user_info_view";
        $sql = "SELECT * FROM $table WHERE status = 'Inactive' AND user_level_description = 'Learner';";  
        $result = $this->getConnection()->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<tr>";
                echo "<td><a href='#'><span class='glyphicon glyphicon-info-sign' style = 'padding-left: 10px;'></span></a>";

                echo "<td>".$row['personal_id']."</td>";
                echo "<td>".$row['first_name']."</td>";
                echo "<td>".$row['last_name']. "</td>";
                echo "<td>".$row['gender']."</td>";
                echo "<td class=text-danger><strong>".$row['status']."</strong></td>";

                echo "<td>";
                echo "<a href='#' class='edit' data-toggle='modal' data-target='#editStudentModal' data-id='".$row["user_info_id"]."' style='margin-right:10px; color: text-success;'><span class='glyphicon glyphicon-edit' ></span></a>";
                
                echo " <a href='#' class='actvIconBtn text-danger' data-toggle='modal' data-target='#activateStudentModal' data-id='".$row["user_info_id"]."'> <span class='glyphicon glyphicon-trash'></span></a>";
                echo "</td>";

                echo "</tr>";
            }
        }

    }
    function assignClass($teacher_id){
        $table = "view_teacher_class_info";
        // $sql = "SELECT class_id, class_name FROM view_teacher_class_info WHERE class_status = 1 AND user_info_id = '$teacher_id';";
        $sql = "SELECT class_id, class_name FROM $table WHERE class_assign_status = 1 AND class_status = 1 AND user_info_id = '$teacher_id'
        AND class_id IN (
            SELECT class_id
            FROM tbl_teacher_class_assignment
            WHERE status = 1
            );";
        $result = $this->getConnection()->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<option value='{$row['class_id']}'>";
                echo $row['class_name'];
                echo "</option>";
            }
        }
        else{
            echo"<option>";
            echo "No Class Available";
            echo "</option>";
        }
    }

    function displayAssignedClassList($teacher_id){
        $table = 'view_teacher_class_info';
        $sql = "SELECT class_name FROM $table
        WHERE user_info_id = '$teacher_id' 
        AND class_assign_status = 1 
        AND class_status = 1 
        AND class_id IN (
            SELECT class_id
            FROM tbl_teacher_class_assignment
            WHERE status = 1
            );";
        $result = $this->getConnection()->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<li>";
                echo $row['class_name'];
                echo "</li>";
            }
        }
        else{
            echo"<li>";
            echo "No Class Available";
            echo "</li>";
        }
    }
    function assignClassDropddown($teacher_id){
        $table = 'view_teacher_class_info';

        $sql = "SELECT class_id,class_name FROM $table
        WHERE user_info_id = '$teacher_id' 
        AND class_assign_status = 1 
        AND class_status = 1 
        AND class_id IN (
            SELECT class_id
            FROM tbl_teacher_class_assignment
            WHERE status = 1
            );";
        //this will check if the class is already assigned to the teacher
        //and if the class is already assigned to the teacher, it will not display in the dropdown
    
        $result = $this->getConnection()->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<option value='{$row['class_id']}'>";
                echo $row['class_name'];
                echo "</option>";
            }
        }
        else{
            echo"<option>";
            echo "No Class Available";
            echo "</option>";
        }
    }
    function displayAssignedModuleList($teacher_id){
        $sql = "SELECT DISTINCT module_name FROM view_teacher_module_info WHERE module_status = 1 AND module_assign_status = 1 AND user_info_id = '$teacher_id';";
        $result = $this->getConnection()->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "<li>";
                echo $row['module_name'];
                echo "</li>";
            }
        }
        else{
            echo"<li>";
            echo "No Module Available";
            echo "</li>";
        }
    }
}
?>