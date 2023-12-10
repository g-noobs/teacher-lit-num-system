<?php
session_start();
include '../Database/Connection.php';
$conn = new Connection();
$connection = $conn->getConnection();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intervention</title>
    <?php 
        include_once("../bootstrap/style.php");
    ?>
</head>

<body class="skin-blue layout-top-nav fixed" data-new-gr-c-s-check-loaded="14.1131.0" data-gr-ext-installed
    style="height: auto; min-height: 100%;">
    <div class="wrapper" style="height: auto; min-height: 100%;">
        <!-- Header  -->
        <?php 
            include_once("../CommonCode/header.php");
        ?>
        <div class="content-wrapper" style="min-height: 606.2px;">
            <?php include_once "../CommonCode/ModifiedAlert.php";?>

            <div class="container">
                <section class="content-header">
                    <!-- Header name -->
                    <h1>
                        Student Score
                        <small>Scoreboard</small>
                    </h1>
                </section>
                <!-- /.content-header -->
                <br>
                <!-- add modal confirmation -->
                <?php include_once "../PagesContent/InterventionContents/ModalIntervention.php"?>
                <section class="content">
                    <div class="row">
                        <div class="box container">
                            <div class="box-header">
                                <!-- /// header here -->
                                <!-- Filter Form -->
                                <form action="" method="GET" class="filter-form">
                                    <div class="form-group col-xs-2">
                                        <label for="classFilter">Filter by Class:</label>
                                        <select name="classFilter" id="classFilter" onchange="this.form.submit()"
                                            class="form-control">
                                            <?php
                                                echo "<option value='all' " . ($_GET['classFilter'] == 'all' ? 'selected' : '') . ">Overall</option>";

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
                                    </div>
                                </form>
                            </div>
                            <div class="box-body" style="overflow-y: scroll; max-height: 400px;">
                                <div class="table-responsive">
                                    <table
                                        class="sub-leadership-board-container table table-bordered table-hover text-center">
                                        <tr>
                                            <th onclick="sortTable(0)">Name</th>
                                            <th onclick="sortTable(1)">Class Section</th>
                                            <th onclick="sortTable(2)">Quizzes</th>
                                            <th onclick="sortTable(3)">Lesson</th>
                                            <th onclick="sortTable(4)">Assignments</th>
                                            <th onclick="sortTable(5)">Overall</th>
                                            <th>Actions</th>
                                        </tr>

                                        <?php
                                            //$values['lesson_id'] = "LSN". $lesson_count->columnCountWhere("lesson_id","tbl_lesson"); inserting to tbl_intervention
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
                                                
                                                if ($totalCount <= 74) {
                                                    echo "<tr>
                                                        <td>$fullName</td>
                                                        <td>$className</td>
                                                        <td>$quizCount</td>
                                                        <td>$storyCount</td>
                                                        <td>$assignmentCount</td>
                                                        <td>$totalCount</td>
                                                        <td>
                                                        <button class='btn btn-primary intervention_btn' data-id -'$personalId'>Need for intervention</button>

                                                        </td>";
                                                }
                                                
                                                echo "</tr>";
                                            }
                                        ?>

                                    </table>
                                    <!-- end of table -->
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box  -->
                    </div>
                    <!-- /.row -->
                </section>
                <!-- /.end of content -->
            </div>
            <!-- /.container -->
        </div>
        <!-- /.content-wrapper -->
    </div>
    <!-- ./wrapper -->






    <script>
    function createIntervention() {
        // Get form data
        var status = document.getElementById('status').value;

        // Create a new FormData object
        var formData = new FormData();
        formData.append('student_id', student_id);
        formData.append('student_id', student_id);
        formData.append('student_id', student_id);
        formData.append('student_id', student_id);
        formData.append('student_id', student_id);

        // Send data to the server using AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                $('#successAlert').text("Successfully udpated data");
                $('#successBanner').show();
                setTimeout(function() {
                    $("#successBanner").fadeOut("slow");
                    location.reload();
                }, 1500);
                location.reload();
            } else {
                alert('Error: ' + xhr.status);
            }
        };
        xhr.send(formData);
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
    <!-- add intervention script  -->
    <?php include_once "../PagesContent/InterventionContents/InterventionScript.php"?>

</body>
<!-- end of body -->

</html>