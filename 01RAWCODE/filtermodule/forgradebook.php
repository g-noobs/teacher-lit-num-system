<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Progress</title>
    <style>
    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
    }

    table,
    th,
    td {
        border: 1px solid black;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
    }

    #progressTableContainer,
    #quizTableContainer {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1;
        background-color: white;
        display: none;
    }

    #backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
    }
    </style>
</head>

<body>

    <div id="progressTableContainer"></div>

    <?php
$host = "localhost";
$user = "u170333284_admin";
$password = "Capstone1!";
$database = "u170333284_db_tagakaulo";

$connection = mysqli_connect($host, $user, $password, $database);

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Update tbl_learner_story_progress with topic IDs for each student
$topicsQuery = "
    UPDATE tbl_learner_story_progress lsp
    JOIN tbl_user_info ui ON lsp.learner_id = ui.user_info_id
    SET lsp.story_id = ui.class_id
    WHERE ui.user_level_id = 2
";

mysqli_query($connection, $topicsQuery);

// Update tbl_learner_story_progress with 'Not Taken Yet' for Date Completed
$notTakenYetQuery = "
    UPDATE tbl_learner_story_progress
    SET date_completed = 'Not Taken Yet'
    WHERE date_completed IS NULL OR date_completed = '0000-00-00'
";

mysqli_query($connection, $notTakenYetQuery);

// Query to fetch user information including class_id and class_name
$query = "SELECT ui.user_info_id, ui.personal_id, ui.first_name, ui.last_name, ui.gender, ui.class_id, cls.class_name FROM  tbl_user_info ui
          LEFT JOIN tbl_class cls ON ui.class_id = cls.class_id WHERE ui.user_level_id = 2";

$result = mysqli_query($connection, $query);
?>

    <!-- Mao ni siya ang dropdown selection for gender-->
    <label for="genderFilter">Filter by Gender:</label>
    <select id="genderFilter" onchange="filterTable()">
        <option value="all">All</option>
        <option value="MALE">Male</option>
        <option value="FEMALE">Female</option>
    </select>


    <!-- Mao ni siya ang dropdown selection for class section-->
    <label for="classFilter">Filter by Class:</label>
    <select id="classFilter" onchange="filterTable()">
        <option value="all">All</option>
        <?php
    $classQuery = "SELECT class_name FROM tbl_class WHERE class_status = 1";
    $classResult = mysqli_query($connection, $classQuery);
    while ($classRow = mysqli_fetch_assoc($classResult)) { 
        $className = $classRow['class_name'];
        echo "<option value='$className'>$className</option>";
    }
    ?>
    </select>

    <h2>To Do List</h2>

    <table border='1' id="userTable">
        <tr>
            <th class="firstName" onclick="sortTableByFirstName()">First Name</th>
            <th class="lastName" onclick="sortTableByLastName()">Last Name</th>
            <th class="gender" onclick="sortTableByGender()">Gender</th>
            <th class="classSection" onclick="sortTableByClass()">Class Section</th>
            <th class="topicsTaken" onclick="sortTableByClass()"> Topics Taken</th>
            <th class="quizTaken" onclick="sortTableByClass()">Quiz Taken</th>
            <th class="assignmentTaken" onclick="sortTableByClass()">Assignment Taken</th>
            <th class="learnerProgress">Learner Story Progress</th>
            <th class="quizProgress">Quiz Progress</th>
            <th class="assignmentProgress">Assignment Progress</th>
        </tr>

        <?php
    while ($row = mysqli_fetch_assoc($result)) {
        // mao ni ang query for the result of total story taken by student
        $learnerId = $row['personal_id'];
        $topicsTakenQuery = "SELECT COUNT(DISTINCT story_id) AS total_topics FROM tbl_learner_story_progress WHERE learner_id = '$learnerId'";
        $topicsTakenResult = mysqli_query($connection, $topicsTakenQuery);
        $topicsTakenRow = mysqli_fetch_assoc($topicsTakenResult);
        $totalTopicsTaken = $topicsTakenRow['total_topics'];
        // mao ni ang query for the overall total result sa stories sa database
        $totalTopicsQuery = "SELECT COUNT(DISTINCT topic_id) AS total_topics FROM tbl_topic";
        $totalTopicsResult = mysqli_query($connection, $totalTopicsQuery);
        $totalTopicsRow = mysqli_fetch_assoc($totalTopicsResult);
        $totalTopics = $totalTopicsRow['total_topics'];
        // mao ni ang query for the result of total quiz taken by student
        $quizTakenQuery = "SELECT learner_id, COUNT(DISTINCT quiz_id) AS total_quizzes FROM tbl_learner_quiz_progress WHERE learner_id = '$learnerId' AND quiz_id IN (SELECT quiz_id FROM tbl_quiz WHERE quiz_status = 1)";
        $quizTakenResult = mysqli_query($connection, $quizTakenQuery);
        $quizTakenRow = mysqli_fetch_assoc($quizTakenResult);
        $totalQuizTaken = $quizTakenRow['total_quizzes'];
        // mao ni ang query for the overall total result sa quizzes sa database
        $totalQuizQuery = "SELECT COUNT(DISTINCT quiz_id) AS total_quizzes FROM tbl_quiz WHERE quiz_status = 1";
        $totalQuizResult = mysqli_query($connection, $totalQuizQuery);
        $totalQuizRow = mysqli_fetch_assoc($totalQuizResult);
        $totalQuiz = $totalQuizRow['total_quizzes'];
        // mao ni ang query for the result of total assignment taken by student
        $assignmentTakenQuery = "SELECT COUNT(DISTINCT assignment_id) AS total_assignment FROM tbl_learner_assignment_progress WHERE learner_id = '$learnerId'";
        $assignmentTakenResult = mysqli_query($connection, $assignmentTakenQuery);
        $assignmentTakenRow = mysqli_fetch_assoc($assignmentTakenResult);
        $totalAssignmentTaken = $assignmentTakenRow['total_assignment'];
        // mao ni ang query for the overall total result sa assignments sa database
        $totalAssignmentQuery = "SELECT COUNT(DISTINCT assignment_id) AS total_assignment FROM tbl_assignment";
        $totalAssignmentResult = mysqli_query($connection, $totalAssignmentQuery);
        $totalAssignmentRow = mysqli_fetch_assoc($totalAssignmentResult);
        $totalAssignment = $totalAssignmentRow['total_assignment'];

        echo "<tr>
            <td class='firstName'>{$row['first_name']}</td>
            <td class='lastName'>{$row['last_name']}</td>
            <td class='gender'>{$row['gender']}</td>
            <td class='classSection'>{$row['class_name']}</td>
            <td class='topicsTaken'>$totalTopicsTaken out of $totalTopics</td>
            <td class='quizTaken'>$totalQuizTaken out of $totalQuiz</td>
            <td class='assignmentTaken'>$totalAssignmentTaken out of $totalAssignment</td>
            <td class='learnerProgress'><button default' onclick=\"showProgress('{$row['user_info_id']}')\">Show Progress</button></td>
            <td class='quizProgress'><button default' onclick=\"showQuizProgress('{$row['user_info_id']}')\">Show Quiz Progress</button></td>
            <td class='assignmentProgress'><button default' onclick=\"showAssignmentProgress('{$row['user_info_id']}')\">Show Assignment Progress</button></td>

        </tr>";
    }
    ?>

    </table>

    <?php
mysqli_close($connection);
?>


    <script>
    var sortDirections = {};

    function sortTableByColumn(columnIndex) {
        var table = document.getElementById("userTable");
        var rows = Array.from(table.rows).slice(1);

        rows.sort(function(a, b) {
            var cellA = a.cells[columnIndex].innerText.toLowerCase();
            var cellB = b.cells[columnIndex].innerText.toLowerCase();

            if (cellA < cellB) {
                return -1;
            } else if (cellA > cellB) {
                return 1;
            } else {
                return 0;
            }
        });

        if (!sortDirections[columnIndex] || sortDirections[columnIndex] === 1) {
            rows.reverse();
            sortDirections[columnIndex] = -1;
        } else {
            sortDirections[columnIndex] = 1;
        }

        table.innerHTML = table.rows[0].outerHTML;

        rows.forEach(function(row) {
            table.appendChild(row);
        });
    }

    function sortTableByFirstName() {
        sortTableByColumn(0);
    }

    function sortTableByLastName() {
        sortTableByColumn(1);
    }

    function sortTableByGender() {
        sortTableByColumn(2);
    }

    function sortTableByClass() {
        sortTableByColumn(3);
    }

    function sortTableByClass() {
        sortTableByColumn(4);
    }

    function sortTableByClass() {
        sortTableByColumn(5);
    }

    function showQuizProgress(userId) {
        window.location.href = "get_quiz_progress.php?userId=" + userId;
    }

    function showProgress(userId) {
        window.location.href = "get_story_progress.php?userId=" + userId;
    }

    function showAssignmentProgress(userId) {
        window.location.href = "get_assignment_progress.php?userId=" + userId;
    }

    // filter sa gender ni siya na function    
    function filterTable() {
        var table = document.getElementById("userTable");
        var filter = document.getElementById("genderFilter").value;
        var rows = Array.from(table.rows).slice(1);

        rows.forEach(function(row) {
            var genderCell = row.cells[2].innerText;

            if (filter === 'all' || genderCell === filter) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }


    // filter sa Class Section ni siya na function    
    function filterTable() {
        var table = document.getElementById("userTable");
        var genderFilter = document.getElementById("genderFilter").value;
        var classFilter = document.getElementById("classFilter").value;
        var rows = Array.from(table.rows).slice(1);

        rows.forEach(function(row) {
            var genderCell = row.cells[2].innerText;
            var classCell = row.cells[3].innerText;

            var genderMatch = (genderFilter === 'all' || genderCell === genderFilter);
            var classMatch = (classFilter === 'all' || classCell === classFilter);

            if (genderMatch && classMatch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
    </script>
</body>

</html>