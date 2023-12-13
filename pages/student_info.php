<?php
include_once '../Database/Connection.php';
$conn = new Connection();
$connection = $conn->getConnection();

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

?>

<html style="height: auto; min-height: 100%;">

<head>
    <meta charset="UTF-8">
    <title>Leadership Board & Badges</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?php include_once("../bootstrap/style.php") ?>

    <style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }

    .back-button {
        background-color: #4CAF50;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 20px;
    }

    h2 {
        color: #333;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }

    th {
        background-color: #4CAF50;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    hr {
        border: 1px solid #ddd;
        margin-top: 20px;
    }
    </style>
</head>

<body class="skin-blue layout-top-nav fixed" data-new-gr-c-s-check-loaded="14.1131.0" data-gr-ext-installed
    style="height: auto; min-height: 100%;">

    <div class="wrapper" style="height: auto; min-height: 100%;">

        <?php include_once("../CommonCode/header.php");?>

        <div class="content-wrapper" style="min-height: 606.2px;">
            <div class="container">
                <section class="content-header">
                    <!-- Header name -->
                    <?php
                        $personalId = $_GET['personal_id'];

                        // Fetch full name using personal_id as a reference
                        $fullNameQuery = "SELECT CONCAT(first_name, ' ', middle_name, ' ', last_name) AS full_name FROM tbl_user_info WHERE personal_id = '$personalId'";
                        $fullNameResult = mysqli_query($connection, $fullNameQuery);
                        $fullNameRow = mysqli_fetch_assoc($fullNameResult);
                        $fullName = $fullNameRow['full_name'];

                    ?>

                    <button class="back-button" onclick="window.history.back()">Back</button>

                    <button class="print-button btn btn-default" onclick="printContent()">Print</button>
                    <h2><?php echo $fullName; ?>'s Progress</h2>
                    <h2>Summary</h2>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <br>
                            <table class="summary-table">
                                <tr>
                                    <th>Quiz Score</th>
                                    <th>Story Point</th>
                                    <th>Assignment Score</th>
                                    <th>Overall Total Score</th>
                                    <th>Attendance</th>
                                    <th>Overall Grade</th>
                                </tr>

                                <?php
                                    $totalQuizScoreQuery = "SELECT COALESCE(SUM(CAST(score AS DECIMAL(5, 2))), 0.00) AS total_quiz_score FROM tbl_learner_quiz_progress WHERE learner_id = '$personalId'";
                                    $totalQuizScoreResult = mysqli_query($connection, $totalQuizScoreQuery);
                                    $quiz_progress = mysqli_fetch_assoc($totalQuizScoreResult);
                                    $quiz_progress = $quiz_progress['total_quiz_score'];

                                    // Fetch the total count of story points
                                    $totalStoryPointsQuery = "SELECT COUNT(DISTINCT story_id) AS total_story_points FROM tbl_learner_story_progress WHERE learner_id = '$personalId'";
                                    $totalStoryPointsResult = mysqli_query($connection, $totalStoryPointsQuery);
                                    $story_progress = mysqli_fetch_assoc($totalStoryPointsResult);
                                    $story_progress = $story_progress['total_story_points'];

                                    // Fetch the sum of all assignment scores
                                    $totalAssignmentScoreQuery = "SELECT COALESCE(SUM(CAST(score AS DECIMAL(5, 2))), 0.00) AS total_assignment_score FROM tbl_learner_assignment_progress WHERE learner_id = '$personalId'";
                                    $totalAssignmentScoreResult = mysqli_query($connection, $totalAssignmentScoreQuery);
                                    $assignment_progress = mysqli_fetch_assoc($totalAssignmentScoreResult);
                                    $assignment_progress = $assignment_progress['total_assignment_score'];

                                    $totalScore = $assignment_progress + $story_progress + $quiz_progress;

                                    // Query para makuha ang total score sa quiz / story points / assignment scores then idivide nalang nato para makuha ang result
                                    $storytotalQuery = "SELECT COUNT(topic_id) AS total_topics FROM tbl_topic WHERE topic_status = 1;";
                                    $storytotalResult = mysqli_query($connection, $storytotalQuery);
                                    $storytotalRow = mysqli_fetch_assoc($storytotalResult);
                                    $totalStoryTopics = $storytotalRow['total_topics'];

                                    $quizTotalQuery = "SELECT SUM(score) AS total_quiz_score FROM tbl_quiz WHERE quiz_status = 1;";
                                    $quizTotalResult = mysqli_query($connection, $quizTotalQuery);
                                    $quizTotalRow = mysqli_fetch_assoc($quizTotalResult);
                                    $totalQuizSum = $quizTotalRow['total_quiz_score'];

                                    $assignmentTotalQuery = "SELECT SUM(max_score) AS total_assignment_score FROM tbl_assignment WHERE status = 1;";
                                    $assignmentTotalResult = mysqli_query($connection, $assignmentTotalQuery);
                                    $assignmentTotalRow = mysqli_fetch_assoc($assignmentTotalResult);
                                    $totalAssignmentSum = $assignmentTotalRow['total_assignment_score'];

                                    $totalSum = $totalStoryTopics + $totalQuizSum + $totalQuizSum;

                                    $totalResult = ($totalScore / $totalSum) * 100;

                                    $fontColor = ($totalResult < 75) ? 'color: red;' : 'color: green;';
                                    $backgroundColor = ($totalResult < 75) ? 'background-color: red;' : 'background-color: green;';
                                    
                                    // condition para double decimal ra ang result mag gawas
                                    $totalResulFinal= number_format($totalResult, 2);


                                    echo "<tr>
                                            <td>$quiz_progress</td>
                                            <td>$story_progress</td>
                                            <td>$assignment_progress</td>
                                            <td>$totalScore</td>
                                            <td>$story_progress</td>
                                            <td style='$backgroundColor'>$totalResulFinal%</td>
                                        </tr>";
                                ?>

                            </table>
                            <h2>Quiz</h2>
                            <table class="summary-table">
                                <tr>
                                    <th>Quiz Name</th>
                                    <th>Date Taken</th>
                                    <th>Attempts</th>
                                    <th>Score</th>
                                </tr>

                                <?php
                                    $totalQuizScoreQuery = "SELECT quiz_name, quiz_score, attempts, date_taken
                                                            FROM (
                                                                SELECT q.quiz_title AS quiz_name, SUM(lqp.score) AS quiz_score, lqp.attempt AS attempts, lqp.date_taken AS date_taken
                                                                FROM tbl_quiz q
                                                                INNER JOIN tbl_learner_quiz_progress lqp ON q.quiz_id = lqp.quiz_id
                                                                WHERE lqp.learner_id = '$personalId'
                                                                GROUP BY q.quiz_title, lqp.attempt, lqp.date_taken
                                                            ) AS subquery;";
                                    $totalQuizScoreResult = mysqli_query($connection, $totalQuizScoreQuery);
                                    
                                    while ($row = mysqli_fetch_assoc($totalQuizScoreResult)) {
                                        $quiz_name = $row['quiz_name'];
                                        $date_taken = $row['date_taken'];
                                        $attempts = $row['attempts'];
                                        $quiz_score = $row['quiz_score'];
                                    
                                        echo "<tr>
                                                <td>$quiz_name</td>
                                                <td>$date_taken</td>
                                                <td>$attempts</td>
                                                <td>$quiz_score</td>
                                            </tr>";
                                    }

                                    $totalQuizScoreQuery = "SELECT SUM(score) AS total_quiz_score FROM tbl_learner_quiz_progress WHERE learner_id = '$personalId'";
                                    $totalQuizScoreResult = mysqli_query($connection, $totalQuizScoreQuery);
                                    $totalQuizScore = mysqli_fetch_assoc($totalQuizScoreResult)['total_quiz_score'];

                                    // Separate query to fetch total score for the specific learner for assignments
                                    $totalAssignmentScoreQuery = "SELECT SUM(score) AS total_assignment_score FROM tbl_learner_assignment_progress WHERE learner_id = '$personalId'";
                                    $totalAssignmentScoreResult = mysqli_query($connection, $totalAssignmentScoreQuery);
                                    $totalAssignmentScore = mysqli_fetch_assoc($totalAssignmentScoreResult)['total_assignment_score'];

                                    $quizlearnergrade = ($totalAssignmentScore != 0) ? ($totalQuizScore / $totalAssignmentScore) * 100 : 0;
                                    
                                    // condition para double decimal ra ang result mag gawas
                                    $quizlearnergradeFinal= number_format($quizlearnergrade, 2);

                                    // Change ang value kung unsa prefer, red font or fill background to red
                                    $fontColor = ($quizlearnergrade < 75) ? 'color: red;' : 'color: green;';
                                    $backgroundColor = ($quizlearnergrade < 75) ? 'background-color: red;' : 'background-color: green;';
                                    
                                    echo "<tr>
                                            <td style='background-color: #ffd700; font-weight: bold;'>Total Quiz Grade</td>
                                            <td colspan='2'></td>
                                            <td style='$backgroundColor'>$quizlearnergradeFinal%</td>
                                        </tr>";
                                ?>


                            </table>

                            <h2>Assignment</h2>
                            <table class="summary-table">
                                <tr>
                                    <th>Assignment</th>
                                    <th>Date Submitted</th>
                                    <th>Attempts</th>
                                    <th>Score</th>
                                </tr>

                                <?php
                                        $totalAssignmentScoreQuery = "SELECT lap.score, lap.date_taken, lap.attempt, 
                                        (SELECT assignment_name FROM tbl_assignment a WHERE a.assignment_id = lap.assignment_id COLLATE utf8mb4_unicode_ci) AS assignment_name
                                        FROM tbl_learner_assignment_progress lap
                                        WHERE lap.learner_id = '$personalId'";

                                        $totalAssignmentScoreResult = mysqli_query($connection, $totalAssignmentScoreQuery);
                                        
                                        while ($row = mysqli_fetch_assoc($totalAssignmentScoreResult)) {
                                            $assignment_name = $row['assignment_name'];
                                            $date_taken = $row['date_taken'];
                                            $attempt = $row['attempt'];
                                            $score = $row['score'];
                                        
                                            echo "<tr>
                                                    <td>$assignment_name</td>
                                                    <td>$date_taken</td>
                                                    <td>$attempt</td>
                                                    <td>$score</td>
                                                </tr>";
                                        }

                                        $totalMaxScoreQuery = "SELECT SUM(max_score) AS total_max_score FROM tbl_assignment";
                                        $totalMaxScoreResult = mysqli_query($connection, $totalMaxScoreQuery);
                                        $totalMaxScore = mysqli_fetch_assoc($totalMaxScoreResult)['total_max_score'];
                                        
                                        $totalScoreQuery = "SELECT SUM(score) AS total_score FROM tbl_learner_assignment_progress WHERE learner_id = '$personalId'";
                                        $totalScoreResult = mysqli_query($connection, $totalScoreQuery);
                                        $totalScore = mysqli_fetch_assoc($totalScoreResult)['total_score'];
                                        
                                        $assignmentlearnergrade = ($totalScore / $totalMaxScore) * 100;

                                        // condition para double decimal ra ang result mag gawas
                                        $assignmentlearnergradeFinal= number_format($assignmentlearnergrade, 2);
                                        
                                        // Change ang value kung unsa prefer, red font or fill background to red
                                        $fontColor = ($assignmentlearnergrade < 75) ? 'color: red;' : 'color: green;';
                                        $backgroundColor = ($assignmentlearnergrade < 75) ? 'background-color: red;' : 'background-color: green;';

                                        
                                        
                                        
                                        echo "<tr>
                                                <td style='background-color: #ffd700; font-weight: bold;'>Total Assignment Grade</td>
                                                <td colspan='2'></td>
                                                <td style='$backgroundColor'>$assignmentlearnergradeFinal%</td>
                                            </tr>";
                                    ?>

                            </table>
                            <h2>Attendance</h2>
                            <table class="summary-table">
                                <tr>
                                    <th>Quiz Score</th>
                                    <th>Story Point</th>
                                    <th>Assignment Score</th>
                                    <th>Overall Total Score</th>
                                    <th>Attendance</th>
                                </tr>

                                <?php
                                        // Fetch the sum of all quiz scores
                                        $totalQuizScoreQuery = "SELECT COALESCE(SUM(CAST(score AS DECIMAL(5, 2))), 0.00) AS total_quiz_score FROM (SELECT DISTINCT(quiz_id) AS quiz_id, score AS score FROM tbl_learner_quiz_progress WHERE learner_id = '$personalId') AS new_query";
                                        $totalQuizScoreResult = mysqli_query($connection, $totalQuizScoreQuery);
                                        $quiz_progress = mysqli_fetch_assoc($totalQuizScoreResult);
                                        $quiz_progress = $quiz_progress['total_quiz_score'];

                                        // Fetch the total count of story points
                                        $totalStoryPointsQuery = "SELECT COUNT(DISTINCT story_id) AS total_story_points FROM tbl_learner_story_progress WHERE learner_id = '$personalId' AND date_completed != '0000-00-00'";
                                        $totalStoryPointsResult = mysqli_query($connection, $totalStoryPointsQuery);
                                        $story_progress = mysqli_fetch_assoc($totalStoryPointsResult);
                                        $story_progress = $story_progress['total_story_points'];

                                        // Fetch the sum of all assignment scores
                                        $totalAssignmentScoreQuery = "SELECT COALESCE(SUM(CAST(score AS DECIMAL(5, 2))), 0.00) AS total_assignment_score FROM tbl_learner_assignment_progress WHERE learner_id = '$personalId'";
                                        $totalAssignmentScoreResult = mysqli_query($connection, $totalAssignmentScoreQuery);
                                        $assignment_progress = mysqli_fetch_assoc($totalAssignmentScoreResult);
                                        $assignment_progress = $assignment_progress['total_assignment_score'];

                                        $totalScore = $assignment_progress + $story_progress + $quiz_progress;

                                        // Query para makuha ang total score sa quiz / story points / assignment scores then idivide nalang nato para makuha ang result
                                        $storytotalQuery = "SELECT COUNT(DISTINCT(topic_id)) AS total_topics FROM tbl_topic WHERE topic_status != 0;";
                                        $storytotalResult = mysqli_query($connection, $storytotalQuery);
                                        $storytotalRow = mysqli_fetch_assoc($storytotalResult);
                                        $totalStoryTopics = $storytotalRow['total_topics'];

                                        $quizTotalQuery = "SELECT COALESCE(SUM(CAST(score AS DECIMAL(5, 2))), 0.00) AS total_quiz_score, quiz_id FROM (SELECT quiz_title AS quiz_id, SUM(score) AS score FROM tbl_quiz GROUP BY quiz_title) AS new_query;";
                                        $quizTotalResult = mysqli_query($connection, $quizTotalQuery);
                                        $quizTotalRow = mysqli_fetch_assoc($quizTotalResult);
                                        $totalQuizSum = $quizTotalRow['total_quiz_score'];

                                        $assignmentTotalQuery = "SELECT COALESCE(SUM(CAST(score AS DECIMAL(5, 2))), 0.00) AS total_assignment_score, assignment_id FROM (SELECT assignment_id AS assignment_id, SUM(max_score) AS score FROM tbl_assignment WHERE status != 0) AS new_query;";
                                        $assignmentTotalResult = mysqli_query($connection, $assignmentTotalQuery);
                                        $assignmentTotalRow = mysqli_fetch_assoc($assignmentTotalResult);
                                        $totalAssignmentSum = $assignmentTotalRow['total_assignment_score'];
                                        
                                        $totalSum = $totalStoryTopics + $totalQuizSum + $totalAssignmentSum;

                                        $totalResult = ($totalScore / $totalSum) * 100;
                                        
                                        // condition para double decimal ra ang result mag gawas
                                        $totalResultFinal= number_format($totalResult, 2);

                                        $fontColor = ($totalResult < 75) ? 'color: red;' : 'color: green;';
                                        $backgroundColor = ($totalResult < 75) ? 'background-color: red;' : 'background-color: green;';

                                        echo "<tr>
                                            <td>$quiz_progress</td>
                                            <td>$story_progress</td>
                                            <td>$assignment_progress</td>
                                            <td>$totalScore</td>
                                            <td>$story_progress</td>
                                        </tr>";

                                        echo "<tr>
                                                <td style='background-color: #ffd700; font-weight: bold;'>Total Assignment Grade</td>
                                                <td colspan='3'></td>
                                                <td style='$backgroundColor'>$totalResultFinal%</td>
                                            </tr>";
                                    ?>

                            </table>
                            <h2>Story</h2>
                            <table class="summary-table">
                                <tr>
                                    <th>Topic</th>
                                    <th>Date Started</th>
                                    <th>Date Completed</th>
                                </tr>

                                <?php
                                        $totalTopicScoreQuery = "SELECT t.topic_name AS topic_name, lsp.date_started AS date_started, lsp.date_completed AS date_completed
                                                                FROM tbl_topic t
                                                                INNER JOIN tbl_learner_story_progress lsp ON t.topic_id = lsp.story_id
                                                                WHERE lsp.learner_id = '$personalId'
                                                                GROUP BY t.topic_name, lsp.date_started, lsp.date_completed
                                                                ";
                                        $totalTopicScoreResult = mysqli_query($connection, $totalTopicScoreQuery);
                                        
                                        while ($row = mysqli_fetch_assoc($totalTopicScoreResult)) {
                                            $topic_name = $row['topic_name'];
                                            $date_taken = $row['date_started'];
                                            $attempts = $row['date_completed'];
                                        
                                            echo "<tr>
                                                    <td>$topic_name</td>
                                                    <td>$date_taken</td>
                                                    <td>$attempts</td>
                                                </tr>";
                                        }
                                    ?>

                            </table>
                            <!-- END -->
                        </div>
                </section>
            </div>
        </div>
        <?php //include_once("../CommonCode/footer.php");?>
    </div>
    <?php include_once("../bootstrap/jquery.php");?>
    <?php include_once "../CommonScript/CommonAllScript.php";?>

    <script>
    function goBack() {
        window.history.back();
    }
    </script>

    <script>
    function printWithCtrlP() {
        // Create a new keyboard event with the Ctrl key pressed
        const ctrlPEvent = new KeyboardEvent('keydown', {
            key: 'p',
            ctrlKey: true
        });

        // Dispatch the event to simulate Ctrl+P
        document.dispatchEvent(ctrlPEvent);

        // You can also call your existing printContent() function if needed
        printContent();
    }
    </script>
</body>

</html>

<?php
mysqli_close($connection);
?>