<!DOCTYPE html>
<html style="height: auto; min-height: 100%;">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <title>Leadership Board & Badges</title>

    <?php include_once("../bootstrap/style.php");?>

    <style>
    .filter-form {
        margin-bottom: 20px;
    }
    </style>
</head>

<body class="skin-blue layout-top-nav fixed" data-new-gr-c-s-check-loaded="14.1131.0" data-gr-ext-installed
    style="height: auto; min-height: 100%;">

    <div class="wrapper" style="height: auto; min-height: 100%;">
        <!-- Header  -->
        <?php include_once("../CommonCode/header.php");?>

        <div class="content-wrapper" style="min-height: 606.2px;">
            <!-- View quiz Data Modal -->
            <div class="container">
                <section class="content-header">
                    <!-- Header name -->
                    <h1>
                        Leaderboard
                        <small>Students Ranking</small>
                    </h1>
                </section>
                <br>

                <!-- Main Content-->
                <section class="content">
                    <div class="row">
                        <div class="box container">
                            <div class="box-header">
                                <!-- Filter Form -->
                                <form action="" method="GET" class="filter-form form-inline">
                                    <div class="form-group col-xs-4">
                                        <label for="classFilter">Filter by Class:</label>
                                        <select name="classFilter" id="classFilter" onchange="this.form.submit()"
                                            class="form-control">
                                            <option value="all"
                                                <?php echo ($_GET['classFilter'] == 'all') ? 'selected' : ''; ?>>All
                                            </option>
                                            <?php
                                                include_once "../Database/Connection.php";
                                                $conn = new Connection();
                                                $connection = $conn->getConnection();

                                                if (!$connection) {
                                                    die("Connection failed: " . mysqli_connect_error());
                                                }
                                                // Fetch class names with class_status = 1
                                                $classQuery = "SELECT class_name FROM tbl_class WHERE class_status = 1";
                                                $classResult = mysqli_query($connection, $classQuery);
                                                while ($classRow = mysqli_fetch_assoc($classResult)) {
                                                    $className = $classRow['class_name'];
                                                    $selected = ($_GET['classFilter'] == $className) ? 'selected' : '';
                                                    echo "<option value='all'>All</option>";
                                                    echo "<option value='$className' $selected>$className</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body" style="overflow-y: scroll; max-height: 400px;">
                                <div class="table-responsive">
                                    <table class="sub-leadership-board-container table table-bordered table-hover text-center">
                                        <tr>
                                            <th onclick="sortTable(0)">Name</th>
                                            <th onclick="sortTable(1)">Class Section</th>
                                            <th onclick="sortTable(2)">Quizzes</th>
                                            <th onclick="sortTable(3)">Subjects</th>
                                            <th onclick="sortTable(4)">Assignments</th>
                                            <th onclick="sortTable(5)">Overall</th>
                                            <th>Actions</th>
                                        </tr>

                                        <?php
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
                                                
                                                echo "<tr>
                                                        <td>$fullName</td>
                                                        <td>$className</td>
                                                        <td>$quizCount</td>
                                                        <td>$storyCount</td>
                                                        <td>$assignmentCount</td>
                                                        <td>$totalCount</td>
                                                        <td><form action='student_record.php' method='GET'>
                                                            <input type='hidden' name='personal_id' value='$personalId'>
                                                            <button type='submit'>Show more</button>
                                                            </form>
                                                        </td>
                                                    </tr>";
                                            }
                                            mysqli_close($connection);
                                        ?>
                                    </table>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                </section>
            </div>
        </div>

        <?php 
        include_once("../CommonCode/footer.php");?>
    </div>



    <?php include_once("../bootstrap/jquery.php");?>
    <script>
    function resetFilter() {
        document.getElementById('classFilter').value = 'all';
        document.querySelector('.filter-form').submit();
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

</body>

</html>