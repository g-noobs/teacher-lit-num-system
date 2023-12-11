<?php 
include "../Database/Connection.php";
$conn = new Connection();
$connection = $conn->getConnection();

$filterClass = isset($_GET['status']) ? $_GET['status'] : 'all';
?>

<html style="height: auto; min-height: 100%;">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Intervention | Tickets</title>
    <!-- jQuery 3 -->
    <script src="../design/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../design/bower_components/jquery-ui/jquery-ui.min.js"></script>


    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

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


            <!-- View quiz Data Modal -->
            <div class="container">
                <section class="content-header">
                    <!-- Header name -->
                    <h1>
                        Intervention
                        <small>List of Student for Intervention</small>
                    </h1>
                </section>
                <br>
                <!-- confirmation modal -->
                <?php include_once "../PagesContent/InterventionContents/ConfirmatioModal.php"?>
                <!-- Main Content-->
                <section class="content">
                    <div class="row">
                        <div class="box container">
                            <div class="box-header">
                                <form action="" method="GET" class="filter-form">
                                    <div class="form-group col-xs-2">
                                        <label for="classFilter">Filter by Class:</label>
                                        <select name="status" id="status" onchange="this.form.submit()"
                                            class="form-control">
                                            <option value="0" <?php echo ($filterClass == '0') ? 'selected' : ''; ?>>On
                                                Going</option>
                                            <option value="1" <?php echo ($filterClass == '1') ? 'selected' : '1'; ?>>
                                                Completed</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body" style="overflow-y: scroll; max-height: 400px;">
                                <div class="table-responsive">
                                    <table
                                        class="sub-leadership-board-container table table-bordered table-hover text-center">
                                        <tr>
                                            <th onclick="sortTable(0)">Student Name</th>
                                            <th onclick="sortTable(1)">Comments</th>
                                            <th onclick="sortTable(2)">Start Date</th>
                                            <th onclick="sortTable(3)">End Date</th>
                                            <th onclick="sortTable(4)">Attachments</th>
                                            <th>Actions</th>
                                        </tr>

                                        <?php
                                            $userInfoQuery = "SELECT * FROM view_intervention";

                                            if ($filterClass !== '') {
                                                $userInfoQuery .= " WHERE status = '$filterClass'";
                                            }

                                            $userInfoQuery .= " ORDER BY view_intervention.date_created AND view_intervention.start_date";

                                            $userInfoResult = mysqli_query($connection, $userInfoQuery);

                                            while ($row = mysqli_fetch_assoc($userInfoResult)) {
                                                $fullName = $row['student_name'];
                                                $comment = $row['comment'];
                                                $start_date = $row['start_date'];
                                                $end_date = $row['end_date'];
                                                $attachment = $row['attachment'];
                                            
                                                // ... (your other code)
                                            
                                                if ($filterClass == 0 || $filterClass !== '') {
                                                    echo "<tr>
                                                        <td>$fullName</td>
                                                        <td>$comment</td>
                                                        <td>$start_date</td>
                                                        <td>$end_date</td>
                                                        <td>$attachment</td>
                                                        <td>";
                                            
                                                    // Check if $filterClass is not '1' (Completed) to display the "Finished" button
                                                    if ($filterClass != '1') {
                                                        echo "<button class='btn btn-default remove_inter_btn' data-id='{$row['intervention_id']}'Finished</button>";
                                                    }
                                            
                                                    echo "</td>
                                                    </tr>";
                                                } else {
                                                    echo "<tr>
                                                        <td>$fullName</td>
                                                        <td>$comment</td>
                                                        <td>$start_date</td>
                                                        <td>$end_date</td>
                                                        <td>$attachment</td>
                                                    </tr>";
                                                }
                                            }
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
        include_once("../CommonCode/footer.php");
        ?>
    </div>
    <script>
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

                +rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
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
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $currentDate = date('Y-m-d');
        $status = mysqli_real_escape_string($connection, $_POST['status']);

        $updateQuery = "UPDATE tbl_intervention SET status = '1', end_date = '$currentDate' WHERE status = '0'";

        if (mysqli_query($connection, $updateQuery)) {
            echo "Data updated successfully!";
        } else {
            echo "Error: " . $updateQuery . "<br>" . mysqli_error($connection);
        }
    }

    mysqli_close($connection);
    ?>

    <?php include_once("../bootstrap/jquery.php");?>
    <!-- This Script Contain Common Script used on other pages  -->
    <?php include_once "../CommonScript/CommonAllScript.php";?>

    <!-- removing from intervention script -->
    <?php include_once "../PagesContent/InterventionContents/InterventionScript.php"?>

</body>

</html>