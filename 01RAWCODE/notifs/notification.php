<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification Page</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        #notificationButton {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
        }

        #notificationButton i {
            margin-right: 5px;
        }

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

        #markAllReadButton,
        #exitButton {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        #noNotificationPrompt {
            text-align: center;
            color: #555;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $host = "localhost";
    $user = "u170333284_admin";
    $password = "Capstone1!";
    $database = "u170333284_db_tagakaulo";

    $conn = new mysqli($host, $user, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query 1: Fetch data from the database
    $query1 = "SELECT lap.assign_class_id, CONCAT(tc.class_name, ' ', tc.sy_id) AS class_sy, CONCAT(ui.first_name, ' ', ui.last_name) AS fullname, ta.assignment_name, ui.user_info_id, lap.learner_id, lap.assignment_id FROM tbl_learner_assignment_progress lap
            JOIN tbl_assign_assignment taa ON lap.assign_class_id = taa.assign_class_id
            JOIN tbl_class tc ON taa.class_id = tc.class_id
            JOIN tbl_user_info ui ON lap.learner_id = ui.personal_id
            JOIN tbl_assignment ta ON lap.assignment_id = ta.assignment_id
            WHERE lap.notif_status = 0";


    $result1 = $conn->query($query1);

    if ($result1) {
        $data = $result1->fetch_all(MYSQLI_ASSOC);
        $hasNotifications = !empty($data);
    ?>

        <button id="notificationButton">
            <?php if ($hasNotifications) : ?>
                <i class="fas fa-exclamation-circle"></i> Notifications
            <?php else : ?>
                <i class="fas fa-bell"></i> Notifications
            <?php endif; ?>
        </button>

        <div id="notificationModal">
            <?php if ($hasNotifications) : ?>
                <ul>
                    <?php foreach ($data as $row) : ?>
                        <li><?= $row['fullname'] ?> submitted '<?= $row['assignment_name'] ?>' from section <?= $row['class_sy'] ?> <a href="#" class="view-details" data-userid="<?= $row['user_info_id'] ?>" data-learnerid="<?= $row['learner_id'] ?>" data-assignmentid="<?= $row['assignment_id'] ?>">View Details</a></li>
                    <?php endforeach; ?>
                </ul>
                <button id="markAllReadButton">Mark All Read</button>
                <button id="exitButton">Exit</button>
            <?php else : ?>
                <p id="noNotificationPrompt"></p>
            <?php endif; ?>
        </div>

        <script>
            $(document).ready(function () {
                $("#notificationButton").click(function () {
                    if (!$("#notificationModal ul li").length) {
                        alert("No notifications found");
                    } else {
                        $("#notificationModal").toggle();
                    }
                });

                $("#markAllReadButton").click(function() {
                    $.ajax({
                        url: 'mark_all_read.php',
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

                $("#exitButton").click(function () {
                    $("#notificationModal").hide();
                });

                function redirectToDetails(userId) {
                    window.location.href = "../filtermodule/get_assignment_progress.php?userId=" + userId;
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
                        url: "update_notif_status.php", 
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

                    window.location.href = "../filtermodule/get_assignment_progress.php?userId=" + userId;
                }
            });
        </script>

    <?php
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
    ?>
</body>

</html>
