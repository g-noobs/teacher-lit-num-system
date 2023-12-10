<?php
include "../../Database/Connection.php";
$conn = new Connection();
$connection = $conn->getConnection();

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leadership Board & Badges</title>
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
        <select name="classFilter" id="classFilter" onchange="this.form.submit()">
            <option value="all" <?php echo ($_GET['classFilter'] == 'all') ? 'selected' : ''; ?>>All</option>
            <?php
        // Fetch class names with class_status = 1
        $classQuery = "SELECT class_name FROM tbl_class WHERE class_status = 1";
        $classResult = mysqli_query($connection, $classQuery);
        while ($classRow = mysqli_fetch_assoc($classResult)) {
            $className = $classRow['class_name'];
            $selected = ($_GET['classFilter'] == $className) ? 'selected' : '';
            echo "<option value='$className' $selected>$className</option>";
        }
        ?>
        </select>
    </form>

    <table class="sub-leadership-board-container">
        <tr>
            <th onclick="sortTable(0)">Name</th>
            <th onclick="sortTable(1)">Class Section</th>
            <th onclick="sortTable(2)">Quizzes</th>
            <th onclick="sortTable(3)">Subjects</th>
            <th onclick="sortTable(4)">Assignments</th>
            <th onclick="sortTable(5)">Overall</th>
            <th>Actions</th>
        </tr>

        <?php
    // Fetch user information along with the total story count
    $filterClass = isset($_GET['classFilter']) ? $_GET['classFilter'] : 'all';
    $userInfoQuery = "SELECT CONCAT(UPPER(last_name), ', ' , first_name, ' ', middle_name) AS full_name, CONCAT(UPPER(SUBSTRING(class_name, 1, 1)), LOWER(SUBSTRING(class_name, 2))) AS class_name, personal_id
                      FROM tbl_user_info 
                      JOIN tbl_class ON tbl_user_info.class_id = tbl_class.class_id
                      WHERE tbl_user_info.status_id = 1 AND tbl_user_info.user_level_id = 2";
    
    if ($filterClass !== 'all') {
        $userInfoQuery .= " AND tbl_class.class_name = '$filterClass'";
    }
    
    $userInfoQuery .= " GROUP BY tbl_user_info.user_info_id ORDER BY tbl_class.class_name, tbl_user_info.last_name";
    
    $userInfoResult = mysqli_query($connection, $userInfoQuery);
    
    while ($row = mysqli_fetch_assoc($userInfoResult)) {
        $fullName = $row['full_name'];
        $className = $row['class_name'];
        $personalId = $row['personal_id'];
    
        $totalStoryPointsQuery = "SELECT COUNT(DISTINCT story_id) AS total_story_points FROM tbl_learner_story_progress WHERE learner_id = '$personalId' AND date_completed != 0000-00-00";
        $totalStoryPointsResult = mysqli_query($connection, $totalStoryPointsQuery);
        $story_progress = mysqli_fetch_assoc($totalStoryPointsResult);
        $storyCount = $story_progress['total_story_points'];
        
        // Fetch count of unique quiz_id from tbl_learner_quiz_progress
        $quizCountQuery = "SELECT COUNT(DISTINCT lqp.quiz_id) AS quiz_count FROM tbl_learner_quiz_progress lqp WHERE lqp.learner_id = '$personalId'";
        $quizCountResult = mysqli_query($connection, $quizCountQuery);
        $quizCountRow = mysqli_fetch_assoc($quizCountResult);
        $quizCount = $quizCountRow['quiz_count'];

        // Fetch count of unique assignment_id from tbl_learner_assignment_progress
        $assignmentCountQuery = "SELECT COUNT(DISTINCT lap.assignment_id) AS assignment_count FROM tbl_learner_assignment_progress lap WHERE lap.learner_id = '$personalId' AND date_taken != NULL";
        $assignmentCountResult = mysqli_query($connection, $assignmentCountQuery);
        $assignmentCountRow = mysqli_fetch_assoc($assignmentCountResult);
        $assignmentCount = $assignmentCountRow['assignment_count'];

        $totalCount = $storyCount + $quizCount + $assignmentCount;
        
        echo "<tr>
                <td>$fullName</td>
                <td>$className</td>
                <td>$quizCount</td>
                <td>$storyCount</td>
                <td>$assignmentCount</td>
                <td>$totalCount</td>
                <td><form action='student_record.php' method='GET'>
                      <input type='hidden' name='personal_id' value='$personalId'>
                      <button type='submit'>Show more</button>
                    </form>
                </td>
              </tr>";
    }
  ?>

    </table>

    <script>
    function resetFilter() {
        document.getElementById('classFilter').value = 'all';
        document.querySelector('.filter-form').submit();
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

</body>

</html>

<?php
mysqli_close($connection);
?>