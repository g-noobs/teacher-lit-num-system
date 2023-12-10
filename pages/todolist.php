<?php
$host = "localhost";
$user = "u170333284_admin";
$password = "Capstone1!";
$database = "u170333284_db_tagakaulo";

$connection = mysqli_connect($host, $user, $password, $database);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT ui.user_info_id, CONCAT(ui.first_name, ' ', ui.last_name) COLLATE utf8mb4_unicode_ci AS fullname, c.class_name COLLATE utf8mb4_unicode_ci AS class_name, c.class_id,
          a.assignment_name COLLATE utf8mb4_unicode_ci AS assignment_name FROM tbl_user_info ui JOIN tbl_learner_assignment_progress lap ON ui.personal_id COLLATE utf8mb4_unicode_ci = lap.learner_id COLLATE utf8mb4_unicode_ci
          LEFT JOIN tbl_class c ON ui.class_id COLLATE utf8mb4_unicode_ci = c.class_id COLLATE utf8mb4_unicode_ci
          LEFT JOIN tbl_assignment a ON lap.assignment_id COLLATE utf8mb4_unicode_ci = a.assignment_id COLLATE utf8mb4_unicode_ci
          WHERE lap.status = 0";

$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leadership Board & Badges</title>
    <style>
    .to-do-list-board-container {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
    }

    .to-do-list-board-container,
    .to-do-list-board-container th,
    .to-do-list-board-container td {
        border: 1px solid black;
    }

    .to-do-list-board-container th,
    .to-do-list-board-container td {
        padding: 10px;
        text-align: left;
    }
    </style>
</head>

<body>

    <h2>To do list</h2>

    <table class="to-do-list-board-container">
        <tr>
            <th>Student Name</th>
            <th>Class Section</th>
            <th>Assignment Name</th>
            <th class="assignmentProgress">Action</th>
        </tr>

        <?php
    // table result para sa name class name ug assignment name
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['fullname'] . "</td>";
        echo "<td>" . $row['class_name'] . "</td>";
        echo "<td>" . $row['assignment_name'] . "</td>"; 
        echo "<td class='assignmentProgress'><button onclick=\"showAssignmentProgress('{$row['user_info_id']}')\">show assignment</button></td>";
        echo "</tr>";
    }
    ?>

    </table>

    <script>
    function showAssignmentProgress(userId) {
        window.location.href = "get_assignment_progress.php?userId=" + userId;
    }
    </script>

    <form class="back-button-form" action="lbab.php" method="get">
        <button class="back-button" type="submit">Back</button>
    </form>

</body>

</html>

<?php
mysqli_close($connection);
?>