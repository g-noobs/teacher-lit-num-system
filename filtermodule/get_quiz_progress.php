<?php
// XAMPP localhost database connection
$host = "localhost";
$user = "u170333284_admin"; // default XAMPP username
$password = "Capstone1!"; // default XAMPP password is empty
$database = "u170333284_db_tagakaulo"; // your database name

// Create connection
$connection = mysqli_connect($host, $user, $password, $database);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get the user ID from the AJAX request
$userId = $_GET['userId'];

// Query to fetch user information including personal_id
$queryUserInfo = "
    SELECT 
        ui.first_name,
        ui.last_name,
        ui.personal_id
    FROM 
        tbl_user_info ui
    WHERE 
        ui.user_info_id = '$userId'
";

$resultUserInfo = mysqli_query($connection, $queryUserInfo);

if (!$resultUserInfo) {
    echo "Error: " . mysqli_error($connection);
}

// Fetch user information
$userInfo = mysqli_fetch_assoc($resultUserInfo);

// Query to fetch quiz progress information for the selected student
$query = "
    SELECT 
        q.quiz_id,
        q.quiz_question,
        COALESCE(lqp.score, 'Not Taken') AS quiz_score  -- Use COALESCE to handle cases where quiz has not been taken
    FROM 
        tbl_quiz q
    LEFT JOIN tbl_learner_quiz_progress lqp ON q.quiz_id = lqp.quiz_id AND lqp.learner_id = '{$userInfo['personal_id']}'
    WHERE 
        q.quiz_status = 1
";

$result = mysqli_query($connection, $query);

if ($result) {
    // Output HTML table with quiz_id, quiz_question, and quiz_score values
    echo "<div>
            <h2>Quiz Progress for {$userInfo['first_name']} {$userInfo['last_name']}</h2>
            <p>Personal ID: {$userInfo['personal_id']}</p>
            <select id='quizFilterSelect' onchange='applyQuizFilter()'>
                <option value='all'>All</option>
                <option value='taken'>Taken</option>
                <option value='not_taken'>Not Taken</option>
            </select>
            <table border='1' id='quizProgressTable'>
                <tr>
                    <th>Quiz ID</th>
                    <th>Quiz Question</th>
                    <th>Quiz Score</th>
                </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr class='quizProgressRow' data-score='{$row['quiz_score']}'>
                <td>{$row['quiz_id']}</td>
                <td>{$row['quiz_question']}</td>
                <td>{$row['quiz_score']}</td>
            </tr>";
    }

    echo "</table>
        <p><button onclick=\"goBack()\">Go Back</button></p>
    </div>";
} else {
    echo "Error: " . mysqli_error($connection);
}

// Close the database connection
mysqli_close($connection);
?>

<script>
    function applyQuizFilter() {
        var filter = document.getElementById('quizFilterSelect').value;
        var rows = document.getElementsByClassName('quizProgressRow');

        for (var i = 0; i < rows.length; i++) {
            var score = rows[i].getAttribute('data-score');

            if (filter === 'all' || (filter === 'taken' && score !== 'Not Taken') || (filter === 'not_taken' && score === 'Not Taken')) {
                rows[i].style.display = 'table-row';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }

    function goBack() {
        window.history.back();
    }
</script>
