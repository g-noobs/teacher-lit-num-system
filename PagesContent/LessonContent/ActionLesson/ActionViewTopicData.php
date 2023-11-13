<?php
include "../../../Database/Connection.php";
$connection = new Connection;
$conn = $connection->getConnection();
$table = "media_view";

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $sql = "SELECT * FROM $table WHERE topic_id = '$id'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                //code that push all media_path into an array
               // code that push all media_id intp an array
            }
            // set echo for # media
            echo json_encode($response);
        }else{
          $response = array('error' => 'Empty!!');
          echo json_encode($response);
        }
    }else{
      $response = array('error' => 'no id found ??');
      echo json_encode($reponse);
    }
}else{
  $response = array('error' => 'POSSIBLE POST ISSUE');
  echo json_encode($response);
}
?>
