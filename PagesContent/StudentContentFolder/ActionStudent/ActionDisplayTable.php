<?php 
include_once "../../../Database/Connection.php";
$connection = new Connection();
$conn = $connection->getConnection();

$table = "student_full_view";

if($_GET['id']){
    $id = $_GET['id'];
    $sql = "SELECT * FROM $table WHERE status = 'Active' AND user_level_description = 'Learner' AND class_id = '$id';";
    $result = $conn->query($sql);

    $htmlContent = '';
    $response = array();
    
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $htmlContent .= "<tr>";
            $htmlContent .= "<td><input type='checkbox' class='checkbox' name='selected[]' value='" . $row['user_info_id'] . "'></td>";
            
            $htmlContent .= "<td><a href='#'><span class='glyphicon glyphicon-info-sign'></span></a>";
            $htmlContent .= "<td><a href='#' class='edit' data-toggle='modal' data-target='#editStudentModal' data-id='".$row["user_info_id"]."' style='macolor: text-success;'><span class='glyphicon glyphicon-edit'></span></a></td>";

            $htmlContent .= "<td>".$row['personal_id']."</td>";
            $htmlContent .= "<td>".$row['first_name']."</td>";
            $htmlContent .= "<td>".$row['last_name']. "</td>";
            $htmlContent .= "<td>".$row['gender']."</td>";
            $htmlContent .= "<td class=text-success><strong>".$row['status']."</strong></td>";
            $htmlContent .= "</tr>";
        }
        $response = array('success' => $htmlContent);
    }else{
        $response = array('error' => "<tr><td colspan='7'>No data Found</td></tr>");
    }
}else{
    $response = array('error' => 'NO ID FOUND FROM GET');
}
echo json_encode($response);
?>