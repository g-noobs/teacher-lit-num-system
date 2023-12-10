<?php
include "../Database/Connection.php";
$conn = new Connection();
$connection = $conn->getConnection();
// Initialize $filterClass
$filterClass = isset($_GET['status']) ? $_GET['status'] : 'all';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intervention</title>
    <style>
    .sub-leadership-board-container {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
    }

    .sub-leadership-board-container,
    .sub-leadership-board-container th,
    .sub-leadership-board-container td {
        border: 1px solid black;
    }

    .sub-leadership-board-container th,
    .sub-leadership-board-container td {
        padding: 10px;
        text-align: left;
        cursor: pointer;
    }

    .filter-form {
        margin-bottom: 20px;
    }
    </style>
</head>

<body>

    <!-- Filter Form -->
    <form action="" method="GET" class="filter-form">
        <label for="classFilter">Filter by Class:</label>
        <select name="status" id="status" onchange="this.form.submit()">
            <option value="0" <?php echo ($filterClass == '0') ? 'selected' : ''; ?>>On Going</option>
            <option value="1" <?php echo ($filterClass == '1') ? 'selected' : '1'; ?>>Completed</option>
        </select>
    </form>

    <table class="sub-leadership-board-container">
        <tr>
            <th onclick="sortTable(0)">Student Name</th>
            <th onclick="sortTable(1)">Comments</th>
            <th onclick="sortTable(2)">Start Date</th>
            <th onclick="sortTable(3)">End Date</th>
            <th onclick="sortTable(4)">Attachments</th>
            <th>Actions</th>
        </tr>

        <?php
    $userInfoQuery = "SELECT * FROM view_intervention";

    if ($filterClass !== '') {
        $userInfoQuery .= " WHERE status = '$filterClass'";
    }

    $userInfoQuery .= " ORDER BY view_intervention.date_created AND view_intervention.start_date";

    $userInfoResult = mysqli_query($connection, $userInfoQuery);

    while ($row = mysqli_fetch_assoc($userInfoResult)) {
        $fullName = $row['student_name'];
        $comment = $row['comment'];
        $start_date = $row['start_date'];
        $end_date = $row['end_date'];
        $attachment = $row['attachment'];
    
        // ... (your other code)
    
        if ($filterClass == 0 || $filterClass !== '') {
            echo "<tr>
                <td>$fullName</td>
                <td>$comment</td>
                <td>$start_date</td>
                <td>$end_date</td>
                <td>$attachment</td>
                <td>";
    
            // Check if $filterClass is not '1' (Completed) to display the "Finished" button
            if ($filterClass != '1') {
                echo "<form action='intervention_tickets.php' method='POST'>
                        <input type='hidden' name='status' value='1'>
                        <button type='button' onclick='insertDate()'>Finished</button>
                      </form>";
            }
    
            echo "</td>
            </tr>";
        } else {
            echo "<tr>
                <td>$fullName</td>
                <td>$comment</td>
                <td>$start_date</td>
                <td>$end_date</td>
                <td>$attachment</td>
            </tr>";
        }
    }
    ?>


    </table>

    <script>
    function insertDate() {
        // Get form data
        var status = document.getElementById('status').value;

        // Create a new FormData object
        var formData = new FormData();
        formData.append('status', status);

        // Send data to the server using AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert("Successfully udpated data"); // Display the response from the server
                location.reload();
            } else {
                alert('Error: ' + xhr.status);
            }
        };
        xhr.send(formData);
    }

    function sortTable(columnIndex) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.querySelector(".sub-leadership-board-container");
        switching = true;
        dir = "asc"; // start with ascending order

        while (switching) {
            switching = false;
            rows = table.rows;

            for (i = 1; i < rows.length - 1; i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName("td")[columnIndex];
                y = rows[i + 1].getElementsByTagName("td")[columnIndex];

                if (dir === "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir === "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }

            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchcount++;
            } else {
                if (switchcount === 0 && dir === "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }
    </script>

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

</body>

</html>