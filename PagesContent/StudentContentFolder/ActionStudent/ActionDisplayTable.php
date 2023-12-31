<?php 
include_once "../../../Database/Connection.php";
$connection = new Connection();
$conn = $connection->getConnection();

$table = "student_full_view";

if($_GET['id']){
    $id = $_GET['id'];
    // this query will only pull up if the class is assigned to teacher and assignment status is active
    $sql = "SELECT * 
    FROM student_full_view 
    WHERE user_level_description = 'Learner'
        AND class_id = '$id'
        AND class_id IN (
            SELECT class_id
            FROM tbl_teacher_class_assignment
            WHERE status = 1
        )
    ORDER BY last_name;";

    $result = $conn->query($sql);

    $htmlContent = '';
    $response = array();
    
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            if($row['status'] == 'Active'){
                $color = 'text-success';
            }else{
                $color = 'text-danger';
            }

            $htmlContent .= "<tr>";
            
            $htmlContent .= "<td><a href='#' data-id='".$row["user_info_id"]."'<span class='glyphicon glyphicon-info-sign'></span></a>";
            $htmlContent .= "<td><a href='#' class='edit' data-id='".$row["user_info_id"]."' data-class-id='".$row["class_id"]."'><span class='glyphicon glyphicon-edit'></span></a></td>";

            $htmlContent .= "<td>".$row['personal_id']."</td>";
            $htmlContent .= "<td>".$row['last_name']. "</td>";
            $htmlContent .= "<td>".$row['first_name']."</td>";
            
            $htmlContent .= "<td>".$row['gender']."</td>";
            $htmlContent .= "<td class='".$color."'><strong>".$row['status']."</strong></td>";
            $htmlContent .= "</tr>";
        }
        $response = array('success' => $htmlContent);
    }else{
        $response = array('error' => "<tr><td colspan='7'>No data Found</td></tr>");
    }
}else{
    $response = array('error' => "<tr><td colspan='7'>No data Found</td></tr>");
}
echo json_encode($response);
?>