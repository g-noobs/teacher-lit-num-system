<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $currentDate = date('Y-m-d');
        $status = mysqli_real_escape_string($connection, $_POST['status']);

        $updateQuery = "UPDATE tbl_intervention SET status = '1', end_date = '$currentDate' WHERE status = '0'";

        if (mysqli_query($connection, $updateQuery)) {
            echo "Data updated successfully!";
        } else {
            echo "Error: " . $updateQuery . "<br>" . mysqli_error($connection);
        }
    }

    mysqli_close($connection);
    ?>