<?php
include_once "../../Database/Connection.php";
$conn = new Connection();
$connection = $conn->getConnection();

$connection = mysqli_connect($host, $username, $password, $database);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$filterClass = isset($_GET['status']) ? $_GET['status'] : 'all';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intervention</title>

    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 25px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 2dp;
            width: 50%;
        }

        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input, select, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 6px;
            margin-bottom: 16px;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<!-- Filter Form -->
<form action="" method="GET" class="filter-form">
    <label for="status">Filter by Status:</label>
    <select name="status" id="status" onchange="this.form.submit()">
        <option value="0" <?php echo ($filterClass == '0') ? 'selected' : ''; ?>>On Going</option>
        <option value="1" <?php echo ($filterClass == '1') ? 'selected' : ''; ?>>Completed</option>
    </select>
</form>

<!-- Add Intervention Button -->
<button type="button" onclick="openModal()">Add Intervention</button>

<!-- Mao ni ang Modal na maglabas pag pindot sa add intervention na button -->
<div id="interventionModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <!-- Intervention Form -->
        <form id="interventionForm" action="" method="POST">
            <!-- mao ni ang dropdown for student -->
            <label for="studentName">Student Name:</label>
            <select name="studentName" id="studentName">
                <?php
                $userQuery = "SELECT * FROM tbl_user_info";
                $userResult = mysqli_query($connection, $userQuery);

                while ($userRow = mysqli_fetch_assoc($userResult)) {
                    $fullName = $userRow['first_name'] . ' ' . $userRow['last_name'];
                    $personalId = $userRow['personal_id'];
                    echo "<option value='$personalId'>$fullName</option>";
                }
                ?>
            </select>

            <label for="startDate">Start Date:</label>
            <input type="date" name="startDate" id="startDate">

            <label for="endDate">End Date:</label>
            <input type="date" name="endDate" id="endDate">

            <label for="comments">Comments:</label>
            <textarea name="comments" id="comments" rows="4"></textarea>

            <button type="button" onclick="submitForm()">Submit</button>
        </form>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById('interventionModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('interventionModal').style.display = 'none';
    }

    function submitForm() {
    var formData = new FormData(document.getElementById('interventionForm'));
    // ang 'pending' diri ang automated value for attachment_link sa tbl_intervention, pwede siya i change into anything na usto mo
    formData.append('attachmentLink', 'Pending');

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>', true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            alert('Intervention added successfully!');
            closeModal();
            location.reload(); // mao ni para pag pindot sa submit button sa modal, mag auto refresh ang page para makita ang newly inserted data
        } else {
            alert('Error: ' + xhr.status);
        }
    };

    xhr.send(formData);
}
</script>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currentDate = date('Y-m-d');
    $status = mysqli_real_escape_string($connection, $_POST['status']);

    // Extract data from the form
    $studentId = mysqli_real_escape_string($connection, $_POST['studentName']);
    $startDate = mysqli_real_escape_string($connection, $_POST['startDate']);
    $endDate = mysqli_real_escape_string($connection, $_POST['endDate']);
    $comments = mysqli_real_escape_string($connection, $_POST['comments']);
    $attachmentLink = mysqli_real_escape_string($connection, $_POST['attachmentLink']);

    // Set the date_created to the current date - mao ni gapa automate sa date_created na value
    $dateCreated = $currentDate;

    // Add your SQL query to insert data into tbl_intervention
    $insertQuery = "INSERT INTO tbl_intervention (student_id, date_created, start_date, end_date, comments, attachments_link, status) 
                    VALUES ('$studentId', '$dateCreated', '$startDate', '$endDate', '$comments', '$attachmentLink', 1)";

    if (mysqli_query($connection, $insertQuery)) {
        echo "Data inserted successfully!";
    } else {
        echo "Error: " . $insertQuery . "<br>" . mysqli_error($connection);
    }
}
?>


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
    xhr.onload = function () {
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
