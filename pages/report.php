<?php
session_start();

function establishConnection() {
    include_once "../Database/Connection.php";
    $conn = new Connection();
    $connection = $conn->getConnection(); 

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    return $connection;
}

function displayTable($headers, $data, $actionName, $hiddenFieldName) {
    $conn = establishConnection();

    $result = $conn->query($data);

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

    $conn->close();
}

function displayStudents() {
    $connection= establishConnection();
    $teacher_id = $_SESSION["id"];
    $studlist = "SELECT CONCAT(ui.first_name, ' ', ui.last_name) AS full_name, ui.gender, c.class_name, c.sy_id, ui.personal_id
                FROM tbl_user_info ui
                JOIN tbl_class c ON ui.class_id = c.class_id
                WHERE ui.user_level_id = 2 AND ui.status_id = 1";
    $studlist.= " AND ui.class_id IN (
        SELECT class_id
        FROM tbl_teacher_class_assignment
        WHERE status = 1 AND user_info_id = '$teacher_id') ";           
    $result = $connection->query($studlist);

    if ($result->num_rows > 0) {
        echo '<h2>List of Student Table</h2>';
        echo '<table class="table table-bordered table-hover text-center">';
        echo '<thead><tr><th>Full Name</th><th>Gender</th><th>Class Name</th><th>School Year ID</th><th>Personal ID</th><th>Action</th></tr></thead>';
        echo '<tbody>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row["full_name"] . '</td>';
            echo '<td>' . $row["gender"] . '</td>';
            echo '<td>' . $row["class_name"] . '</td>';
            echo '<td>' . $row["sy_id"] . '</td>';
            echo '<td>' . $row["personal_id"] . '</td>';

            echo '<td><form method="get" action="student_info.php">
                      <input type="hidden" name="personal_id" value="' . $row["personal_id"] . '">
                      <button type="submit" name="view_info" class="btn btn-default">View Information & Gradebook</button>
                  </form></td>';
            
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo "No results found";
    }

    $connection->close();
}

function displayAssignments() {
    $connection= establishConnection();
    $teacher_id = $_SESSION["id"];
    // Query to fetch assignment data
    $assignmentlist = "SELECT assignment_id, assignment_name, question, max_score, date_added
                      FROM tbl_assignment
                      WHERE status = 1 AND created_by = '$teacher_id'";
    $resultAssignments = $connection->query($assignmentlist);

    if ($resultAssignments->num_rows > 0) {

        echo '<h2>Assignment Table</h2>';
        echo '<table class="table table-bordered table-hover text-center">';
        echo '<thead><tr><th>Assignment ID</th><th>Assignment Name</th><th>Question</th><th>Max Score</th><th>Date Added</th></tr></thead>';
        echo '<tbody>';
        while ($rowAssignment = $resultAssignments->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $rowAssignment["assignment_id"] . '</td>';
            echo '<td>' . $rowAssignment["assignment_name"] . '</td>';
            echo '<td>' . $rowAssignment["question"] . '</td>';
            echo '<td>' . $rowAssignment["max_score"] . '</td>';
            echo '<td>' . $rowAssignment["date_added"] . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo "No assignments found";
    }
    $connection->close();
}


function displayQuiz() {
    $connection= establishConnection();

    // Query to fetch assignment data
    $teacher_id = $_SESSION["id"];
    $quizlist = "SELECT quiz_id, quiz_question, quiz_attempts, score, date_created
                      FROM tbl_quiz
                      WHERE quiz_status = 1 AND added_byID = '$teacher_id'";
    $resultQuiz = $connection->query($quizlist);

    if ($resultQuiz->num_rows > 0) {
        echo '<h2>Quiz Table</h2>';
        echo '<table class="table table-bordered table-hover text-center">';
        echo '<thead><tr><th>Quiz ID</th><th>Quiz Name</th><th>Max Attempts</th><th>Max Score</th><th>Date Added</th></tr></thead>';
        echo '<tbody>';
        while ($rowQuiz = $resultQuiz->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $rowQuiz["quiz_id"] . '</td>';
            echo '<td>' . $rowQuiz["quiz_question"] . '</td>';
            echo '<td>' . $rowQuiz["quiz_attempts"] . '</td>';
            echo '<td>' . $rowQuiz["score"] . '</td>';
            echo '<td>' . $rowQuiz["date_created"] . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo "No quiz found";
    }

    $connection->close();
}

function displayStory() {
    $connection= establishConnection();
    // Query to fetch topic data
    $teacher_id = $_SESSION["id"];
    $topiclist = "SELECT topic_id, topic_name, topic_description, date_added
                    FROM tbl_topic
                    WHERE topic_status = 1 AND added_byID = '$teacher_id'";
    $resultTopic = $connection->query($topiclist);

    if ($resultTopic->num_rows > 0) {
        echo '<h2>Story Table</h2>';
        echo '<table class="table table-bordered table-hover text-center">';
        echo '<thead><tr><th>Topic ID</th><th>Topic Name</th><th>Topic Description</th><th>Date Added</th></tr></thead>';
        echo '<tbody>';
        while ($rowTopic = $resultTopic->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $rowTopic["topic_id"] . '</td>';
            echo '<td>' . $rowTopic["topic_name"] . '</td>';
            echo '<td>' . $rowTopic["topic_description"] . '</td>';
            echo '<td>' . $rowTopic["date_added"] . '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo "No topic found";
    }

    $connection->close();
}

function displayIntervention() {
    $connection= establishConnection();
    $teacher_id = $_SESSION["id"];

    // Query to fetch intervention data with learner's full name
    $interventionlist = "SELECT CONCAT(ui.first_name, ' ', ui.last_name) AS learner_name, date_created, start_date, end_date, comments, attachments_link 
                        FROM tbl_intervention i
                        JOIN tbl_user_info ui ON i.student_id = ui.personal_id
                        AND i.added_byID = '$teacher_id'";
    
    $resultIntervention = $connection->query($interventionlist);

    if ($resultIntervention->num_rows > 0) {
        echo '<h2>Intervention Table</h2>';
        echo '<table class="table table-bordered table-hover text-center">';
        echo '<thead><tr><th>Full Name</th><th>Date Created</th><th>Date Started</th><th>Date Ended</th><th>Comments</th><th>Status</th></tr></thead>';
        echo '<tbody>';
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
        echo '</tbody>';
        echo '</table>';
    } else {
        echo "No Intervention Data found";
    }

    $connection->close();
}


?>

<html style="height: auto; min-height: 100%;">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>List of Students and Assignments</title>
    <!-- jQuery 3 -->
    <script src="../design/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../design/bower_components/jquery-ui/jquery-ui.min.js"></script>


    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php include_once("../bootstrap/style.php") ?>

</head>

<body class="skin-blue layout-top-nav fixed" data-new-gr-c-s-check-loaded="14.1131.0" data-gr-ext-installed
    style="height: auto; min-height: 100%;">

    <div class="wrapper" style="height: auto; min-height: 100%;">
        <!-- Header  -->
        <?php include_once("../CommonCode/header.php");?>

        <div class="content-wrapper" style="min-height: 606.2px;">
            <section class="content-header">
                <h1>
                    Reports
                    <small>View Reports</small>
                </h1>
            </section>
            <br>
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-default container">
                            <br>
                            <div class="box-header with-border">
                                <form method="post">
                                    <button class="btn btn-default" type="submit" name="list_students">List of
                                        Students</button>
                                    <button class="btn btn-default" type="submit"
                                        name="list_assignments">Assignments</button>
                                    <button class="btn btn-default" type="submit" name="list_quiz">Quiz</button>
                                    <button class="btn btn-default" type="submit" name="list_story">Story</button>
                                    <button class="btn btn-default" type="submit"
                                        name="list_intervention">Intervention</button>
                                </form>
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
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
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include_once("../CommonCode/footer.php");?>
    </div>
    <?php include_once("../bootstrap/jquery.php");?>
    <?php include_once "../CommonScript/CommonAllScript.php";?>
</body>

</html>