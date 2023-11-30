<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once "../../../Database/Connection.php";

$connection = new Connection();
$conn = $connection->getConnection();
$table = "student_full_view";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $sql = "SELECT * FROM $table WHERE user_info_id = '$id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $response = array(
                    'personal_id' => $row['personal_id'],
                    'last_name' => $row['last_name'],
                    'first_name' => $row['first_name'],
                    'middle_initial' => $row['middle_name'],
                    'gender' => $row['gender'],
                    'phone_num' => $row['contact_num'],
                    'email' => $row['email'],
                    'street' => $row['street'],
                    'barangay' => $row['barangay'],
                    'municipal_city' => $row['municipal_city'],
                    'province' => $row['province'],
                    'postal_code' => $row['postalcode'],
                    'guardian_last_name' => $row['guardian_lname'],
                    'guardian_first_name' => $row['guardian_fname'],
                    'guardian_middle_name' => $row['guardian_mname'],
                    'guardian_phone_num' => $row['guardian_number']
                );
            }
        }
        echo json_encode($response);
    }
}
?>