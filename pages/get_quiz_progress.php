<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../Database/Connection.php';

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

// Query to fetch quiz progress information for the selected student
$query = "SELECT q.quiz_id, q.quiz_question, COALESCE(lqp.score, 'Not Taken') AS quiz_score FROM tbl_quiz q
        LEFT JOIN tbl_learner_quiz_progress lqp ON q.quiz_id = lqp.quiz_id AND lqp.learner_id = '{$userInfo['personal_id']}' WHERE q.quiz_status = 1";

$result = mysqli_query($connection, $query);

?>
<html style="height: auto; min-height: 100%;">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gradebook</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php include_once("../bootstrap/style.php");?>
    <!-- jQuery 3 -->

    <script src="../design/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../design/bower_components/jquery-ui/jquery-ui.min.js"></script>
    <?php include_once "../CommonCode/ModifiedSearchStyle.php";?>
</head>

<body class="skin-blue layout-top-nav fixed" data-new-gr-c-s-check-loaded="14.1131.0" data-gr-ext-installed
    style="height: auto; min-height: 100%;">
    <div class="wrapper" style="height: auto; min-height: 100%;">
        <?php include_once("../CommonCode/header.php");?>
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
                <section class="content" id="main_content">
                    <div class="row" id="quiz_content">
                        <div class="col-xs-12">
                            <div class="box box-default container">
                                <br>
                                <div class="box-header with-">
                                    <div class="form-group col-xs-4">
                                        <select id='quizFilterSelect' onchange='applyQuizFilter()' class='form-control'>
                                            <option value='all'>All</option>
                                            <option value='taken'>Taken</option>
                                            <option value='not_taken'>Not Taken</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="box-body" style="overflow-y: scroll; max-height: 400px;">
                                    <div class="table-responsive">
                                        <table id="quizProgressTable"
                                            class="table table-bordered table-hover text-center">
                                            <tr>
                                                <th>Quiz ID</th>
                                                <th>Quiz Question</th>
                                                <th>Quiz Score</th>
                                            </tr>
                                            <?php
                                            if ($result) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<tr class='quizProgressRow' data-score='{$row['quiz_score']}'>
                                                            <td>{$row['quiz_id']}</td>
                                                            <td>{$row['quiz_question']}</td>
                                                            <td>{$row['quiz_score']}</td>
                                                        </tr>";
                                                }
                                            } else {
                                                echo "Error: " . mysqli_error($connection);
                                            }
                                            
                                            mysqli_close($connection);
                                            ?>

                                        </table>
                                    </div>
                                </div>
                                <p><button onclick="goBack()">Go Back</button></p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <?php include_once("../CommonCode/footer.php");?>
        </div>
        <?php include_once("../bootstrap/jquery.php");?>

        <script>
        function applyQuizFilter() {
            var filter = document.getElementById('quizFilterSelect').value;
            var
                rows = document.getElementsByClassName('quizProgressRow');
            for (var i = 0; i <
                rows.length; i++) {
                var score = rows[i].getAttribute('data-score');
                if (filter === 'all' || (filter === 'taken' && score !== 'Not Taken') ||
                    (filter === 'not_taken' && score === 'Not Taken')) {
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
        

</body>
<html>