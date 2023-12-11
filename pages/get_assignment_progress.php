<?php
include_once "../Database/Connection.php";

$conn = new Connection();
$connection = $conn->getConnection();

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$userId = $_GET['userId'];

$queryUserInfo = "SELECT ui.first_name, ui.last_name, ui.personal_id FROM tbl_user_info ui WHERE ui.user_info_id = '$userId'";

$resultUserInfo = mysqli_query($connection, $queryUserInfo);

if (!$resultUserInfo) {
    echo "Error: " . mysqli_error($connection);
}

$userInfo = mysqli_fetch_assoc($resultUserInfo);

mysqli_set_charset($connection, "utf8mb4");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assignmentId']) && isset($_POST['score'])) {
    $assignmentId = mysqli_real_escape_string($connection, $_POST['assignmentId']);
    $score = mysqli_real_escape_string($connection, $_POST['score']);

    // Check if the assignment has been taken
    $queryCheckAssignmentTaken = "SELECT assignment_answer FROM tbl_learner_assignment_progress WHERE learner_id = '{$userInfo['personal_id']}' AND assignment_id = '$assignmentId'";
    $resultCheckAssignmentTaken = mysqli_query($connection, $queryCheckAssignmentTaken);

    if (!$resultCheckAssignmentTaken) {
        echo "Error: " . mysqli_error($connection);
        mysqli_close($connection);
        exit();
    }

    $assignmentTaken = mysqli_fetch_assoc($resultCheckAssignmentTaken);

    if (!$assignmentTaken || empty($assignmentTaken['assignment_answer'])) {
        // mao ni ang mag prompt if gi try tagaan score ni teacher ang assignment na wala pa na take sa student
        echo "Assignment not taken yet!";
        mysqli_close($connection);
        exit();
    }

    // Fetch max_score from tbl_assignment
    $queryMaxScore = "SELECT max_score FROM tbl_assignment WHERE assignment_id = '$assignmentId'";
    $resultMaxScore = mysqli_query($connection, $queryMaxScore);
    $maxScore = mysqli_fetch_assoc($resultMaxScore)['max_score'];

    // mao ni ang mag prompt if gi try mulampas sa max score ang gitry hatag ni teacher sa assignment
    if ($score > $maxScore) {
        echo "Score value exceeds the max score.";
        mysqli_close($connection);
        exit();
    }

    // Check if the record already exists for the user and assignment
    $queryCheckExisting = "SELECT * FROM tbl_learner_assignment_progress WHERE learner_id = '{$userInfo['personal_id']}' AND assignment_id = '$assignmentId'";
    $resultCheckExisting = mysqli_query($connection, $queryCheckExisting);

    if (!$resultCheckExisting) {
        echo "Error: " . mysqli_error($connection);
        mysqli_close($connection);
        exit();
    }

    if (mysqli_num_rows($resultCheckExisting) > 0) {
        // Update the existing record
        $queryUpdateScore = "UPDATE tbl_learner_assignment_progress SET score = '$score', status = 1 WHERE learner_id = '{$userInfo['personal_id']}' AND assignment_id = '$assignmentId'";
    } else {
        // Insert a new record
        $queryUpdateScore = "INSERT INTO tbl_learner_assignment_progress (lap_id, assign_class_id, learner_id, assignment_id, date_taken, assignment_answer, score, attempt, badge_id, status) VALUES
                            (UUID(), '', '{$userInfo['personal_id']}', '$assignmentId', NULL, '', '$score', 0, 0, 1)";
    }

    $resultUpdateScore = mysqli_query($connection, $queryUpdateScore);

    if (!$resultUpdateScore) {
        echo "Error: " . mysqli_error($connection);
    } else {
        echo "Score updated/inserted successfully!";
    }

    mysqli_close($connection);
    exit();
}

// Retrieve assignments
$queryAssignments = "SELECT a.assignment_id, a.assignment_name, a.question, lap.score AS score, COALESCE(lap.assignment_answer, 'Not Taken') AS assignment_answer FROM tbl_assignment a 
                    LEFT JOIN tbl_learner_assignment_progress lap ON a.assignment_id COLLATE utf8mb4_unicode_ci = lap.assignment_id COLLATE utf8mb4_unicode_ci
                    AND lap.learner_id COLLATE utf8mb4_unicode_ci = '{$userInfo['personal_id']}' WHERE a.status = 1";

$resultAssignments = mysqli_query($connection, $queryAssignments);

if (!$resultAssignments) {
    echo "Error: " . mysqli_error($connection);
}

?>
<html style="height: auto; min-height: 100%;">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gradebook</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php 
        include_once("../bootstrap/style.php");
    ?>
    <!-- jQuery 3 -->
    <script src="../design/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../design/bower_components/jquery-ui/jquery-ui.min.js"></script>
    <?php include_once "../CommonCode/ModifiedSearchStyle.php";?>

    <style>
    #scoreModal {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 300px;
        /* Adjust the width as needed */
        padding: 20px;
        border: 2px solid #000;
        background-color: #fff;
        z-index: 999;
    }

    #scoreModal h3 {
        margin-top: 0;
    }

    #scoreModal .exitButton {
        position: absolute;
        top: 5px;
        right: 5px;
        cursor: pointer;
    }
    </style>

</head>

<body class="skin-blue layout-top-nav fixed" data-new-gr-c-s-check-loaded="14.1131.0" data-gr-ext-installed
    style="height: auto; min-height: 100%;">

    <div class="wrapper" style="height: auto; min-height: 100%;">
        <div class="content-wrapper" style="min-height: 606.2px;">
            <?php include_once "../CommonCode/ModifiedAlert.php";?>
            <div class="container">
                <section class="content-header">
                    <h1>
                        <?php
                            echo "<h2>Quiz Progress for {$userInfo['first_name']} {$userInfo['last_name']}</h2>";
                            echo "<p>Personal ID: {$userInfo['personal_id']}</p>"; 
                        ?>
                    </h1>
                </section>

                <!-- Score Modal -->
                <div id='scoreModal'>
                    <span class='exitButton' onclick='closeScoreModal()'>&times;</span>
                    <h3>Enter Score</h3>
                    <input type='number' id='scoreInput' placeholder='Enter score' oninput='validateScore()'>
                    <p id='maxScoreInfo'></p>
                    <button onclick='submitScore()'>Submit</button>
                    <button onclick='closeScoreModal()'>Cancel</button>
                </div>
                <section class="content" id="main_content">

                    <div class="row" id="gradebook_content">
                        <div class="col-xs-12">
                            <div class="box box-default container">
                                <br>
                                <div class="box-header with-">
                                    <h3 class="box-title"></h3>
                                </div>
                                <div class="box-body" style="overflow-y: scroll; max-height: 400px;">
                                    <div class="table-responsive">
                                        <table id="userTable" class="table table-bordered table-hover text-center">
                                            <tr>
                                                <th>Assignment ID</th>
                                                <th>Assignment Name</th>
                                                <th>Question</th>
                                                <th>Answer</th>
                                                <th>Score</th>
                                                <th>Action</th>
                                            </tr>
                                            <?php
                                                while ($assignment = mysqli_fetch_assoc($resultAssignments)) {
                                                    echo "<tr class='assignmentRow'>
                                                            <td>" . $assignment['assignment_id'] . "</td>
                                                            <td>" . $assignment['assignment_name'] . "</td>
                                                            <td>" . $assignment['question'] . "</td>
                                                            <td>" . $assignment['assignment_answer'] . "</td>
                                                            <td>" . $assignment['score'] . "</td>
                                                            <td><button onclick='openScoreModal(\"{$assignment['assignment_id']}\")'>Submit Score</button></td>
                                                        </tr>";
                                                    }
                                            ?>
                                        </table>
                                        <p><button onclick="goBack()">Go Back</button></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </div>
        <?php include_once("../CommonCode/footer.php");?>
    </div>
    <?php include_once("../bootstrap/jquery.php");?>
    <script>
    function goBack() {
        window.history.back();
    }

    // Function to open the score input modal
    function openScoreModal(assignmentId) {
        // Fetch max_score from tbl_assignment
        let xhrMaxScore = new XMLHttpRequest();
        xhrMaxScore.onreadystatechange = function() {
            if (xhrMaxScore.readyState === 4 && xhrMaxScore.status === 200) {
                let maxScore = JSON.parse(xhrMaxScore.responseText).max_score;
                document.getElementById('maxScoreInfo').innerText = 'Max Score: ' + maxScore;
            }
        };
        xhrMaxScore.open("GET", "fetch_max_score.php?assignmentId=" + encodeURIComponent(assignmentId), true);
        xhrMaxScore.send();

        document.getElementById('scoreModal').style.display = 'block';
        document.getElementById('scoreInput').value = '';
        document.getElementById('scoreInput').dataset.assignmentId = assignmentId;
    }

    // Function to validate the entered score
    function validateScore() {
        let scoreInput = document.getElementById('scoreInput');
        let maxScoreInfo = document.getElementById('maxScoreInfo');
        let maxScore = maxScoreInfo.innerText.replace('Max Score: ', '');

        if (isNaN(scoreInput.value)) {
            maxScoreInfo.style.color = 'black';
            return;
        }

        if (parseInt(scoreInput.value) > parseInt(maxScore)) {
            maxScoreInfo.style.color = 'red';
        } else {
            maxScoreInfo.style.color = 'black';
        }
    }

    // Function to submit the score
    function submitScore() {
        let assignmentId = document.getElementById('scoreInput').dataset.assignmentId;
        let score = document.getElementById('scoreInput').value;

        if (isNaN(score)) {
            alert('Please enter a valid score.');
            return;
        }

        // Fetch max_score from tbl_assignment
        let xhrMaxScore = new XMLHttpRequest();
        xhrMaxScore.onreadystatechange = function() {
            if (xhrMaxScore.readyState === 4 && xhrMaxScore.status === 200) {
                let maxScore = JSON.parse(xhrMaxScore.responseText).max_score;

                if (parseInt(score) > parseInt(maxScore)) {
                    alert('Score value exceeds the max score.');
                } else {
                    // ajax gamit naton for submission of score
                    let xhr = new XMLHttpRequest();
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            alert(xhr.responseText);
                            closeScoreModal();
                            location.reload();
                        }
                    };
                    xhr.open("POST", window.location.href, true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.send("assignmentId=" + encodeURIComponent(assignmentId) + "&score=" + encodeURIComponent(
                        score));
                }
            }
        };
        xhrMaxScore.open("GET", "fetch_max_score.php?assignmentId=" + encodeURIComponent(assignmentId), true);
        xhrMaxScore.send();
    }

    function closeScoreModal() {
        document.getElementById('scoreModal').style.display = 'none';
    }
    </script>
</body>

</html>