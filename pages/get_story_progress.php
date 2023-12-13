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

// Query to fetch all topic_id values with topic_status = 1 for the selected student
$teacher_id = $_SESSION['id'];
$query = "SELECT tp.topic_id, tp.topic_name, COALESCE(CONCAT('Completed on ', DATE_FORMAT(lsp.date_completed, '%Y-%m-%d')), 'Not Yet Taken') AS progress_status FROM tbl_topic tp
          LEFT JOIN tbl_learner_story_progress lsp ON tp.topic_id = lsp.story_id AND lsp.learner_id = '{$userInfo['personal_id']}' WHERE tp.topic_status = 1 AND tp.added_byID = '$teacher_id'";  

$filterCondition = isset($_GET['filter']) ? $_GET['filter'] : ''; 

// Apply filter condition
if ($filterCondition === 'completed') {
    $query .= " AND lsp.date_completed IS NOT NULL";
} elseif ($filterCondition === 'not_completed') {
    $query .= " AND lsp.date_completed IS NULL";
}

$result = mysqli_query($connection, $query);

?>

<html style="height: auto; min-height: 100%;">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Assignment | LIST</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php 
        include_once("../bootstrap/style.php");
    ?>
</head>

<body class="skin-blue layout-top-nav fixed" data-new-gr-c-s-check-loaded="14.1131.0" data-gr-ext-installed
    style="height: auto; min-height: 100%;">


    <div class="wrapper" style="height: auto; min-height: 100%;">
        <!-- Header  -->
        <?php include_once("../CommonCode/header.php");?>

        <div class="content-wrapper" style="min-height: 606.2px;">
            <div class="container">
                <section class="content-header">
                    <!-- Header name -->
                    <h1>
                        <?php 
                            echo "<h2>Learner Story Progress for {$userInfo['first_name']} {$userInfo['last_name']}</h2>";
                            echo  "<p>Personal ID: {$userInfo['personal_id']}</p> ";
                        ?>
                    </h1>
                </section>
                <br>
                <!-- Main Content-->
                <section class="content" id="main_content">
                    <div class="row" id="learner_content">
                        <div class="col-xs-12">
                            <div class="box box-default container">
                                <br>
                                <div class="box-header with-">
                                    <form class='form-inline'>
                                        <div class="form-group col-xs-4">
                                            <select id='filterSelect' onchange='applyFilter()' class='form-control'>
                                                <option value='all'>All</option>
                                                <option value='completed'>Completed</option>
                                                <option value='not_completed'>Not Completed</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="box-body" style="overflow-y: scroll; max-height: 400px;">
                                    <div class="table-responsive">
                                        <table border='1' id='progressTable'
                                            class="table table-bordered table-hover text-center">
                                            <tr>
                                                <th>Topic ID</th>
                                                <th>Topic Name</th>
                                                <th>Status</th>
                                            </tr>
                                            <?php
                                                if ($result) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo "<tr class='progressRow' data-status='{$row['progress_status']}'>
                                                                <td>{$row['topic_id']}</td>
                                                                <td>{$row['topic_name']}</td>
                                                                <td>{$row['progress_status']}</td>
                                                            </tr>";
                                                    }
                                                }else {
                                                    echo "Error: " . mysqli_error($connection);
                                                }
                                                
                                                mysqli_close($connection);
                                            ?>
                                        </table>
                                    </div>
                                    <button class="btn btn-default" type="button" onclick="goBack()">Go Back</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <?php 
        include_once("../CommonCode/footer.php");
        ?>
    </div>

    <?php include_once("../bootstrap/jquery.php");?>
    <!-- This Script Contain Common Script used on other pages  -->
    <?php include_once "../CommonScript/CommonAllScript.php";?>
    <script>
    function applyFilter() {
        var filter = document.getElementById('filterSelect').value;
        var rows = document.getElementsByClassName('progressRow');

        for (var i = 0; i < rows.length; i++) {
            var status = rows[i].getAttribute('data-status');

            if (filter === 'all' || (filter === 'completed' && status.includes('Completed')) || (filter ===
                    'not_completed' && status.includes('Not Yet Taken'))) {
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

</html>