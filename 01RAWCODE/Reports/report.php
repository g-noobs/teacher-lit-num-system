<?php
session_start();

function establishConnection() {
    include_once "../../Database/Connection.php";
    $conn = new Connection();
    $connection = $conn->getConnection(); 

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    return $connection;
}

function displayTable($headers, $data, $actionName, $hiddenFieldName) {
    $connection= establishConnection();

    $result = $connection->query($data);

    if ($result->num_rows > 0) {
        echo '<table border="1">';
        echo '<tr>';
        foreach ($headers as $header) {
            echo '<th>' . $header . '</th>';
        }
        echo '<th>Action</th>';
        echo '</tr>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            foreach ($row as $key => $value) {
                echo '<td>' . $value . '</td>';
            }
            echo '<td>
                    <form method="get" action="' . $actionName . '">
                        <input type="hidden" name="' . $hiddenFieldName . '" value="' . $row[$hiddenFieldName] . '">
                        <button type="submit" name="view_info">View Information</button>
                    </form>
                </td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo "No results found";
    }

    $connection->close();
}

function displayStudents() {
    $connection= establishConnection();

    $studlist = "SELECT CONCAT(ui.first_name, ' ', ui.last_name) AS full_name, ui.gender, c.class_name, c.sy_id, ui.personal_id
                 FROM tbl_user_info ui
                 JOIN tbl_class c ON ui.class_id = c.class_id
                 WHERE ui.user_level_id = 2 AND ui.status_id = 1";
    $result = $connection->query($studlist);

    if ($result->num_rows > 0) {
        echo '<h2>List of Student Table</h2>';
        echo '<table border="1">';
        echo '<tr><th>Full Name</th><th>Gender</th><th>Class Name</th><th>School Year ID</th><th>Personal ID</th><th>Action</th></tr>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row["full_name"] . '</td>';
            echo '<td>' . $row["gender"] . '</td>';
            echo '<td>' . $row["class_name"] . '</td>';
            echo '<td>' . $row["sy_id"] . '</td>';
            echo '<td>' . $row["personal_id"] . '</td>';

            echo '<td><form method="get" action="student_info.php">
                      <input type="hidden" name="personal_id" value="' . $row["personal_id"] . '">
                      <button type="submit" name="view_info">View Information & Gradebook</button>
                  </form></td>';
            
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo "No results found";
    }

    $connection->close();
}

function displayAssignments() {
    $connection= establishConnection();

    // Query to fetch assignment data
    $assignmentlist = "SELECT assignment_id, assignment_name, question, max_score, date_added
                      FROM tbl_assignment
                      WHERE status = 1";
    $resultAssignments = $connection->query($assignmentlist);

    if ($resultAssignments->num_rows > 0) {

        echo '<h2>Assignment Table</h2>';
        echo '<table border="1">';
        echo '<tr><th>Assignment ID</th><th>Assignment Name</th><th>Question</th><th>Max Score</th><th>Date Added</th></tr>';
        while ($rowAssignment = $resultAssignments->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $rowAssignment["assignment_id"] . '</td>';
            echo '<td>' . $rowAssignment["assignment_name"] . '</td>';
            echo '<td>' . $rowAssignment["question"] . '</td>';
            echo '<td>' . $rowAssignment["max_score"] . '</td>';
            echo '<td>' . $rowAssignment["date_added"] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo "No assignments found";
    }
    $connection->close();
}


function displayQuiz() {
    $connection= establishConnection();

    // Query to fetch assignment data
    $quizlist = "SELECT quiz_id, quiz_question, quiz_attempts, score, date_created
                      FROM tbl_quiz
                      WHERE quiz_status = 1";
    $resultQuiz = $connection->query($quizlist);

    if ($resultQuiz->num_rows > 0) {
        echo '<h2>Quiz Table</h2>';
        echo '<table border="1">';
        echo '<tr><th>Quiz ID</th><th>Quiz Name</th><th>Max Attempts</th><th>Max Score</th><th>Date Added</th></tr>';
        while ($rowQuiz = $resultQuiz->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $rowQuiz["quiz_id"] . '</td>';
            echo '<td>' . $rowQuiz["quiz_question"] . '</td>';
            echo '<td>' . $rowQuiz["quiz_attempts"] . '</td>';
            echo '<td>' . $rowQuiz["score"] . '</td>';
            echo '<td>' . $rowQuiz["date_created"] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo "No quiz found";
    }

    $connection->close();
}

function displayStory() {
    $connection= establishConnection();
    // Query to fetch assignment data
    $topiclist = "SELECT topic_id, topic_name, topic_description, date_added
                      FROM tbl_topic
                      WHERE topic_status = 1";
    $resultTopic = $connection->query($topiclist);

    if ($resultTopic->num_rows > 0) {
        echo '<h2>Story Table</h2>';
        echo '<table border="1">';
        echo '<tr><th>Topic ID</th><th>Topic Name</th><th>Topic Description</th><th>Date Added</th></tr>';
        while ($rowTopic = $resultTopic->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $rowTopic["topic_id"] . '</td>';
            echo '<td>' . $rowTopic["topic_name"] . '</td>';
            echo '<td>' . $rowTopic["topic_description"] . '</td>';
            echo '<td>' . $rowTopic["date_added"] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo "No topic found";
    }

    $connection->close();
}

function displayIntervention() {
    $connection= establishConnection();

    // Query to fetch intervention data with learner's full name
    $interventionlist = "SELECT CONCAT(ui.first_name, ' ', ui.last_name) AS learner_name, date_created, start_date, end_date, comments, attachments_link 
                        FROM tbl_intervention i
                        JOIN tbl_user_info ui ON i.student_id = ui.personal_id";

    $resultIntervention = $connection->query($interventionlist);

    if ($resultIntervention->num_rows > 0) {
        echo '<h2>Intervention Table</h2>';
        echo '<table border="1">';
        echo '<tr><th>Full Name</th><th>Date Created</th><th>Date Started</th><th>Date Ended</th><th>Comments</th><th>Status</th></tr>';
        while ($rowIntervention = $resultIntervention->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $rowIntervention["learner_name"] . '</td>';
            echo '<td>' . $rowIntervention["date_created"] . '</td>';
            echo '<td>' . $rowIntervention["start_date"] . '</td>';
            echo '<td>' . $rowIntervention["end_date"] . '</td>';
            echo '<td>' . $rowIntervention["comments"] . '</td>';
            echo '<td>' . $rowIntervention["attachments_link"] . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo "No topic found";
    }

    $connection->close();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Students and Assignments</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
        }

        form {
            margin-bottom: 10px;
        }

        button {
            padding: 8px;
            cursor: pointer;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Reports</h2>;

<form method="post">
    <button type="submit" name="list_students">List of Students</button>
    <button type="submit" name="list_assignments">Assignments</button>
    <button type="submit" name="list_quiz">Quiz</button>
    <button type="submit" name="list_story">Story</button>
    <button type="submit" name="list_intervention">Intervention</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["list_students"])) {
    $_SESSION["show_results"] = !isset($_SESSION["show_results"]) || $_SESSION["show_results"] == false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["list_assignments"])) {
    $_SESSION["show_assignments"] = !isset($_SESSION["show_assignments"]) || $_SESSION["show_assignments"] == false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["list_quiz"])) {
    $_SESSION["show_quiz"] = !isset($_SESSION["show_quiz"]) || $_SESSION["show_quiz"] == false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["list_story"])) {
    $_SESSION["show_story"] = !isset($_SESSION["show_story"]) || $_SESSION["show_story"] == false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["list_intervention"])) {
    $_SESSION["show_intervention"] = !isset($_SESSION["show_intervention"]) || $_SESSION["show_intervention"] == false;
}

if ($_SESSION["show_results"] ?? false) {
    displayStudents();
}

if ($_SESSION["show_assignments"] ?? false) {
    displayAssignments();
}

if ($_SESSION["show_quiz"] ?? false) {
    displayQuiz();
}

if ($_SESSION["show_story"] ?? false) {
    displayStory();
}

if ($_SESSION["show_intervention"] ?? false) {
    displayIntervention();
}

?>

</body>
</html>