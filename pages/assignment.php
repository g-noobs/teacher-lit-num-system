<html style="height: auto; min-height: 100%;">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Assignment | LIST</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php 
        include_once("../bootstrap/style.php");
    ?>
    <!-- jQuery 3 -->
    <script src="../design/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../design/bower_components/jquery-ui/jquery-ui.min.js"></script>
    
    <?php include_once "../CommonCode/ModifiedSearchStyle.php";?>
</head>

<body class="skin-blue layout-top-nav fixed" data-new-gr-c-s-check-loaded="14.1131.0" data-gr-ext-installed
    style="height: auto; min-height: 100%;">


    <div class="wrapper" style="height: auto; min-height: 100%;">
        <?php 
            include_once("../CommonCode/header.php");
        ?>

        <div class="content-wrapper" style="min-height: 606.2px;">

            <?php include_once "../CommonCode/ModifiedAlert.php";?>

            <!-- View quiz Data Modal -->
            <div class="container">

                <section class="content-header">
                    <h1>
                        Assignment List
                        <small>Add and Modify Assignment</small>
                    </h1>
                </section>
                <br>


                <section>
                    <div class="align-items-start">
                        <div class="col-sm-2">
                            <div class="custom-dropdown">

                                <button class="custom-dropdown-toggle btn" type="button" data-toggle="dropdown"
                                    style="width:150px; border: 2px solid #3C8DBC; border-radius:10px; color: #3C8DBC;">
                                    <b>Active Assignment</b> <!-- Updated the button text -->
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu custom-dropdown-menu">
                                    <li><a href="#" data-quiz-type="active-quiz"><b>Active Assignment</b></a></li>
                                    <li><a href="#" data-quiz-type="archive-quiz"><b>Archived Assignment</b></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-10">
                            <button class="btn btn-primary pull-right" id="assigned_assgn_btn">Assigned Quiz</button>
                        </div>
                    </div>
                </section>
                <br>
                <br>

                <!-- activate and archive confirmation modal -->

                <!-- edit modal -->
                <?php include_once "../PagesContent/AssignmentFolder/ModalAssignment/AddNewAssignModal.php"?>
                <?php include_once "../PagesContent/AssignmentFolder/ModalAssignment/AssingClassModal.php"?>

                <!-- Main Content-->
                <section class="content" id="assign_content">
                    <?php include_once "../PagesContent/AssignmentFolder/MainAssignment/AssignMainTable.php";?>
                </section>

            </div>

        </div>

        <?php 
        include_once("../CommonCode/footer.php");
        ?>
    </div>

    <?php include_once("../bootstrap/jquery.php");?>

    <!-- add new assignment -->
    <?php include_once "../PagesContent/AssignmentFolder/ScriptAssignment/AddNewAssignScript.php";?>

    <!-- assign to class -->
    <?php include_once "../PagesContent/AssignmentFolder/ScriptAssignment/AssignClasScript.php";?>

    <!-- view assigned class -->
    <?php include_once "../PagesContent/AssignmentFolder/ScriptAssignment/AssignedTableScript.php"?>

    <!-- This Script Contain Common Script used on other pages  -->
    <?php include_once "../CommonScript/CommonAllScript.php";?>
</body>

</html>