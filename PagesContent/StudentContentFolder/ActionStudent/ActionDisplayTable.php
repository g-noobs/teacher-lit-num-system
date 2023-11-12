<?php 
include_once "../../../Database/Connection.php";
$connection = new Connection();
$conn = $connection->getConnection();

$table = "user_info_view";

if($_GET['id']){
    $id = $_GET['id'];
    $sql = "SELECT * FROM $table WHERE status = 'Active' AND user_level_description = 'Learner';";
    $result = $conn->query($sql);

    $htmlContent = '';
    $response = array();
    
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $htmlContent .= "<tr>";
            $htmlContent .= "<td><a href='#'><span class='glyphicon glyphicon-info-sign' style = 'padding-left: 10px;'></span></a>";

            $htmlContent .= "<td>".$row['personal_id']."</td>";
            $htmlContent .= "<td>".$row['first_name']."</td>";
            $htmlContent .= "<td>".$row['last_name']. "</td>";
            $htmlContent .= "<td>".$row['gender']."</td>";
            $htmlContent .= "<td class=text-success><strong>".$row['status']."</strong></td>";

            $htmlContent .= "<td>";
            $htmlContent .= "<a href='#' class='edit' data-toggle='modal' data-target='#editStudentModal' data-id='".$row["user_info_id"]."' style='margin-right:10px; color: text-success;'><span class='glyphicon glyphicon-edit' ></span></a>";

            $htmlContent .= " <a href='#' class='actvIconBtn text-danger' data-toggle='modal' data-target='#arcviveStudentModal' data-id='".$row["user_info_id"]."'> <span class='glyphicon glyphicon-trash'></span></a>";
            $htmlContent .= "</td>";

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