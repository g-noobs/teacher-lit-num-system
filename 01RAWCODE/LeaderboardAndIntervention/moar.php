<?php
$host = "156.67.222.1";
$username = "u170333284_admin";
$password = "Capstone1!";
$database = "u170333284_db_tagakaulo";

$connection = mysqli_connect($host, $username, $password, $database);

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
    }
    </style>
</head>

<body>

    <?php
// Get the personal_id from the URL parameter
$personalId = $_GET['personal_id'];

// Fetch full name using personal_id as a reference
$fullNameQuery = "SELECT CONCAT(first_name, ' ', middle_name, ' ', last_name) AS full_name FROM tbl_user_info WHERE personal_id = '$personalId'";
$fullNameResult = mysqli_query($connection, $fullNameQuery);
$fullNameRow = mysqli_fetch_assoc($fullNameResult);
$fullName = $fullNameRow['full_name'];

?>

    <form class="back-button-form" action="lbab.php" method="get">
        <button class="back-button" type="submit">Back to Leadership Board & Badges</button>
    </form>

    <h2><?php echo $fullName; ?>'s Details</h2>
    <h2>Summary</h2>
    <table class="sub-leadership-board-container">
        <tr>
            <th>Quiz Score</th>
            <th>Story Point</th>
            <th>Assignment Score</th>
            <th>Overall Total Score</th>
            <th>Attendance</th>
            <th>Grade</th>
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
    $totalAssignmentScoreQuery = "SELECT COALESCE(SUM(CAST(score AS DECIMAL(5, 2))), 0.00) AS total_assignment_score FROM tbl_learner_assignment_progress WHERE learner_id = '$personalId' AND date_taken != NULL AND attempt != 0";
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

    echo "<tr>
            <td>$quiz_progress</td>
            <td>$story_progress</td>
            <td>$assignment_progress</td>
            <td>$totalScore</td>
            <td>$story_progress</td>
            <td>$totalResult</td>
          </tr>";
    ?>

    </table>
    <br>
    <hr>
    <br>
    <h2>Quiz</h2>
    <table class="sub-leadership-board-container">
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
    ?>


    </table>
    <br>
    <hr>
    <br>
    <h2>Story</h2>
    <table class="sub-leadership-board-container">
        <tr>
            <th>Topic</th>
            <th>Date Started</th>
            <th>Date Completed</th>
        </tr>

        <?php
        $totalQuizScoreQuery = "SELECT t.topic_name AS topic_name, lsp.date_started AS date_started, lsp.date_completed AS date_completed
                                FROM tbl_topic t
                                INNER JOIN tbl_learner_story_progress lsp ON t.topic_id = lsp.story_id
                                WHERE lsp.learner_id = '$personalId'
                                GROUP BY t.topic_name, lsp.date_started, lsp.date_completed
                                ";
        $totalQuizScoreResult = mysqli_query($connection, $totalQuizScoreQuery);
        
        while ($row = mysqli_fetch_assoc($totalQuizScoreResult)) {
            $quiz_name = $row['topic_name'];
            $date_taken = $row['date_started'];
            $attempts = $row['date_completed'];
        
            echo "<tr>
                    <td>$quiz_name</td>
                    <td>$date_taken</td>
                    <td>$attempts</td>
                  </tr>";
        }
    ?>

    </table>
    <br>
    <hr>
    <br>
    <h2>Assignment</h2>
    <table class="sub-leadership-board-container">
        <tr>
            <th>Assignment</th>
            <th>Date Submitted</th>
            <th>Score</th>
        </tr>

        <?php
        $totalQuizScoreQuery = "SELECT a.assignment_name AS assignment_name, SUM(lap.score) AS total_score, MAX(lap.date_taken) AS date_taken
                                FROM tbl_assignment a
                                INNER JOIN tbl_learner_assignment_progress lap ON a.assignment_id = lap.assignment_id
                                WHERE lap.learner_id = '$personalId'
                                GROUP BY a.assignment_name
                                ";
        $totalQuizScoreResult = mysqli_query($connection, $totalQuizScoreQuery);
        
        while ($row = mysqli_fetch_assoc($totalQuizScoreResult)) {
            $quiz_name = $row['assignment_name'];
            $date_taken = $row['date_taken'];
            $attempts = $row['total_score'];
        
            echo "<tr>
                    <td>$quiz_name</td>
                    <td>$date_taken</td>
                    <td>$attempts</td>
                  </tr>";
        }
    ?>

    </table>
    <br>
    <hr>
    <br>
    <h2>Attendance</h2>
    <table class="sub-leadership-board-container">
        <tr>
            <th>Quiz Score</th>
            <th>Story Point</th>
            <th>Assignment Score</th>
            <th>Overall Total Score</th>
            <th>Attendance</th>
            <th>Grade</th>
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
    $totalAssignmentScoreQuery = "SELECT COALESCE(SUM(CAST(score AS DECIMAL(5, 2))), 0.00) AS total_assignment_score FROM tbl_learner_assignment_progress WHERE learner_id = '$personalId' AND date_taken != NULL AND attempt != 0";
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

    echo "<tr>
            <td>$quiz_progress</td>
            <td>$story_progress</td>
            <td>$assignment_progress</td>
            <td>$totalScore</td>
            <td>$story_progress</td>
            <td>$totalResult</td>
          </tr>";
    ?>

    </table>
    <br>
    <hr>
</body>

</html>

<?php
mysqli_close($connection);
?>