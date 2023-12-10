<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include_once "../Database/ColumnCountClass.php";
    include_once "../Database/SanitizeCrudClass.php";

    $table = "tbl_intervention";
    $values = array(
        'intervention_id' => '',
        'added_byID' => $_SESSION['id'],
        'student_id' => $_POST['student_id'],
        'date_created' => '',
    );
    // modified id
    $columnCount = new ColumnCountClass();
    $values['intervention_id'] = "IVT". $columnCount->columnCountWhere("intervention_id", "tbl_intervention");

    // adding data for date_added
    $currentDate = new DateTime('now', new DateTimeZone('Asia/Kuala_Lumpur'));
    $values['date_created'] = $currentDate->format('Y-m-d H:i:s');
    
    //get alll array keys to be used as column name
    $columns = implode(', ', array_keys($values));
    //set number of question marks
    $questionMarkString = implode(',', array_fill(0, count($values), '?'));
    //sql
    $sql = "INSERT INTO $table($columns)VALUES($questionMarkString);";
    //set params - from array's value
    $params = array_values($values);
    //set sanitize class
    $addIntervention = new SanitizeCrudClass();
    //execute
    $addIntervention->executePreState($sql, $params);
    if($addIntervention->getLastError() == null){
        echo json_encode(array('success' => 'Intervention Added Successfully'));
        exit();

    }else{
        echo json_encode(array('error' => 'Intervention Failed to Add'));
        exit();

    }
}

mysqli_close($connection);
?>