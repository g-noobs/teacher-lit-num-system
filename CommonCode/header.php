<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SESSION['teacher'] !== true || $_SESSION['admin'] !== false) {
    header('Location: ../../index.php');
    exit;
}

?>
<style>
#notificationModal {
    display: none;
    position: fixed;
    top: 16%;
    left: 15%;
    transform: translate(-50%, -50%);
    background-color: #f4f4f4;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

#notificationModal ul {
    list-style: none;
    padding: 0;
}

#notificationModal ul li {
    margin-bottom: 10px;
}

#notificationModal ul li a {
    color: #3498db;
    text-decoration: none;
    font-weight: bold;
    margin-left: 10px;
}

#noNotificationPrompt {
    text-align: center;
    color: #555;
    margin-top: 10px;
}
</style>
<?php
include "../Database/Connection.php";
$connection = new Connection();
$conn = $connection->getConnection();

?>

<header class="main-header">
    <nav class="navbar navbar-static-top">

        <div class="container-fluid">
            <div class="navbar-header">
                <a href="main.php" class="navbar-brand"><b>Teacher</b> Portal</a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar-collapse" aria-expanded="false">
                    <i class="fa fa-bars"></i>
                </button>
            </div>

            <div class="collapse navbar-collapse pull-left" id="navbar-collapse" aria-expanded="false"
                style="height: 0.8px;">
                <ul class="nav navbar-nav">
                    <li><a href="main.php">Dashboard <span class="sr-only">(current)</span></a></li>

                    <li><a href="class_list.php">Class Management</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Workspace<span
                                class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="lesson.php">Lesson</a></li>
                            <li class="divider"></li>
                            <li><a href="quiz.php">Quiz</a></li>
                            <li class="divider"></li>
                            <li><a href="assignment.php">Assignment</a></li>
                            <li class="divider"></li>

                            <li><a href="todolist.php">To do List</a></li>


                        </ul>
                    </li>
                    <li><a href="gradebook.php">Gradebook</a></li>
                    <li><a href="intervention_tickets.php">Intervention</a></li>
                    <li><a href="leaderboard.php">Leader Board</a></li>
                </ul>

                <!-- Search Bar
                <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
                    </div>
                </form>
                -->
            </div>


            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">
                                <?php
                                $countQuery = "SELECT COUNT(*) AS notif_count FROM tbl_learner_assignment_progress WHERE notif_status = 0";
                                $result2 = $conn->query($countQuery);
                                $data2 = $result2->fetch_all(MYSQLI_ASSOC);
                                echo $data2[0]['notif_count'];
                                ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have <?php echo $data2[0]['notif_count']; ?> notifications</li>
                            <li>
                                <?php // Query 1: Fetch data from the database
                                    $query1 = "SELECT lap.assign_class_id, CONCAT(tc.class_name, ' ', tc.sy_id) AS class_sy, CONCAT(ui.first_name, ' ', ui.last_name) AS fullname, ta.assignment_name, ui.user_info_id, lap.learner_id, lap.assignment_id FROM tbl_learner_assignment_progress lap
                                    JOIN tbl_assign_assignment taa ON lap.assign_class_id = taa.assign_class_id
                                    JOIN tbl_class tc ON taa.class_id = tc.class_id
                                    JOIN tbl_user_info ui ON lap.learner_id = ui.personal_id
                                    JOIN tbl_assignment ta ON lap.assignment_id = ta.assignment_id
                                    WHERE lap.notif_status = 0";


                                    $result1 = $conn->query($query1);

                                    if ($result1) {
                                    $data = $result1->fetch_all(MYSQLI_ASSOC);
                                    $hasNotifications = !empty($data);?>
                                <!-- //start of notification -->
                                <?php if ($hasNotifications) : ?>
                                <ul class="menu">
                                    <?php foreach ($data as $row) : ?>
                                    <li class="text-center"><?= $row['fullname'] ?> submitted '<?= $row['assignment_name'] ?>' from section
                                        <?= $row['class_sy'] ?> <a href="#" class="view-details text-center text-yellow'
                                            data-userid="<?= $row['user_info_id'] ?>"
                                            data-learnerid="<?= $row['learner_id'] ?>"
                                            data-assignmentid="<?= $row['assignment_id'] ?>">View Details</a></li>
                                    <?php endforeach; ?>
                                </ul>
                                <?php else : ?>
                                <!-- <p id="noNotificationPrompt"></p> -->
                                <?php endif; ?>
                                <?php
                                        } else {
                                            echo "Error: " . $conn->error;
                                        }
                                    ?>
                            </li>
                            <li class="footer"><a href="#" id="markAllReadButton">Mark All as Read</a></li>
                        </ul>
                    </li>
                    <!-- end of notification  -->
                    <li class="dropdown user user-menu">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                            <img src="../Media/Images/UserAvatar/temp_profpic.png" class="user-image" alt="User Image">

                            <span class="hidden-xs" id="teacher_name_main">
                                <?php include "../Database/DisplayUserInfo.php";
                                $displayUserInfo = new DisplayUserInfo();
                                $displayUserInfo->displayTeacherName();
                                ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <img src="../Media/Images/UserAvatar/temp_profpic.png" class="img-circle"
                                    alt="User Image">
                                <p id=teacher_name>
                                    <?php $displayUserInfo->displayTeacherName();?>
                                </p>
                                <p id=teacher_email>
                                    <?php $displayUserInfo->displayTeacherEmail();?>
                                </p>
                            </li>

                            <li class="user-body">
                                <div class="row">

                                </div>
                            </li>

                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="profile.php" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right" id="logoutTeachBtn">
                                    <a href="#" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<script>
$(document).ready(function() {
    $("#notificationButton").click(function() {
        if (!$("#notificationModal ul li").length) {
            alert("No notifications found");
        } else {
            $("#notificationModal").toggle();
        }
    });

    $("#markAllReadButton").click(function() {
        $.ajax({
            url: '../PagesContent/NotificationFolder/mark_all_read.php',
            type: 'GET',
            success: function(response) {
                alert(response);
                location.reload();
            },
            error: function(error) {
                alert('Error marking all as read');
            }
        });
    });

    $("#exitButton").click(function() {
        $("#notificationModal").hide();
    });

    function redirectToDetails(userId) {
        window.location.href = "../PagesContent/GradeBookContent/ActionGradebook/get_assignment_progress.php?userId=" + userId;
    }

    $("#notificationModal ul li a").on("click", function(e) {
        e.preventDefault();
        var userId = $(this).data("userid");
        redirectToDetails(userId);
    });
});
</script>

<script>
$(document).ready(function() {
    $("#notificationButton").click(function() {
        $("#notificationModal").show();
    });

    $(".view-details").click(function() {
        var userId = $(this).data("userid");
        var learnerId = $(this).data("learnerid");
        var assignmentId = $(this).data("assignmentid");
        redirectToDetails(userId, learnerId, assignmentId);
    });

    function redirectToDetails(userId, learnerId, assignmentId) {
        $.ajax({
            type: "POST",
            url: "./PagesContent/NotificationFolder/update_notif_status.php",
            data: {
                learnerId: learnerId,
                assignmentId: assignmentId
            },
            success: function(response) {
                console.log(response);
            },
            error: function(error) {
                console.error(error);
            }
        });

        window.location.href = "../PagesContent/GradeBookContent/ActionGradebook/get_assignment_progress.php?userId=" + userId;
    }
});
</script>