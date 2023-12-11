<?php


include_once "../Database/Connection.php";
$conn = new Connection();
$connection = $conn->getConnection();


if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT ui.user_info_id, CONCAT(ui.first_name, ' ', ui.last_name) COLLATE utf8mb4_unicode_ci AS fullname, c.class_name COLLATE utf8mb4_unicode_ci AS class_name, c.class_id,
          a.assignment_name COLLATE utf8mb4_unicode_ci AS assignment_name FROM tbl_user_info ui JOIN tbl_learner_assignment_progress lap ON ui.personal_id COLLATE utf8mb4_unicode_ci = lap.learner_id COLLATE utf8mb4_unicode_ci
          LEFT JOIN tbl_class c ON ui.class_id COLLATE utf8mb4_unicode_ci = c.class_id COLLATE utf8mb4_unicode_ci
          LEFT JOIN tbl_assignment a ON lap.assignment_id COLLATE utf8mb4_unicode_ci = a.assignment_id COLLATE utf8mb4_unicode_ci
          WHERE lap.status = 0";

$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leadership Board & Badges</title>
    <style>
    .to-do-list-board-container {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
    }

    .to-do-list-board-container,
    .to-do-list-board-container th,
    .to-do-list-board-container td {
        border: 1px solid black;
    }

    .to-do-list-board-container th,
    .to-do-list-board-container td {
        padding: 10px;
        text-align: left;
    }
    </style>
    <?php include_once("../bootstrap/style.php");?>
    <script src="../design/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../design/bower_components/jquery-ui/jquery-ui.min.js"></script>
    <?php include_once "../CommonCode/ModifiedSearchStyle.php";?>
</head>

<body class="skin-blue layout-top-nav fixed" data-new-gr-c-s-check-loaded="14.1131.0" data-gr-ext-installed
    style="height: auto; min-height: 100%;">

    <div class="wrapper" style="height: auto; min-height: 100%;">
        <div class="content-wrapper" style="min-height: 606.2px;">
            <?php include_once "../CommonCode/ModifiedAlert.php";?>
            <div class="container">
                <section class="content-header">
                    <h1>
                        Gradebook
                        <small>Teacher Portal</small>
                    </h1>
                </section>
                <section class="content" id="main_content">

                    <div class="row" id="gradebook_content">
                        <div class="col-xs-12">
                            <div class="box box-default container">
                                <br>
                                <div class="box-header with-">
                                    <h3 class="box-title">To do list</h3>
                                </div>
                                <div class="box-body" style="overflow-y: scroll; max-height: 400px;">
                                    <div class="table-responsive">
                                        <table id="userTable"
                                            class="table table-bordered table-hover text-center to-do-list-board-container">
                                            <tr>
                                                <th>Student Name</th>
                                                <th>Class Section</th>
                                                <th>Assignment Name</th>
                                                <th class="assignmentProgress">Action</th>
                                            </tr>

                                            <?php
                                                // table result para sa name class name ug assignment name
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<tr>";
                                                    echo "<td>" . $row['fullname'] . "</td>";
                                                    echo "<td>" . $row['class_name'] . "</td>";
                                                    echo "<td>" . $row['assignment_name'] . "</td>"; 
                                                    echo "<td class='assignmentProgress'><button onclick=\"showAssignmentProgress('{$row['user_info_id']}')\">show assignment</button></td>";
                                                    echo "</tr>";
                                                }
                                            ?>
                                        </table>
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
    function showAssignmentProgress(userId) {
        window.location.href = "get_assignment_progress.php?userId=" + userId;
    }
    </script>

</body>

</html>

<?php
mysqli_close($connection);
?>