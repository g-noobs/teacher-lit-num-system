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

</head>

<body class="skin-blue layout-top-nav fixed" data-new-gr-c-s-check-loaded="14.1131.0" data-gr-ext-installed
    style="height: auto; min-height: 100%;">


    <div class="wrapper" style="height: auto; min-height: 100%;">
        <?php include_once("../CommonCode/header.php");?>

        <div class="content-wrapper" style="min-height: 606.2px;">

            <?php include_once "../CommonCode/ModifiedAlert.php";?>

            <section class="content-header">
                <h1>
                    Enrolled Subjects
                    <small>Teacher Portal</small>
                </h1>
            </section>
            <br>
            <br>

            <!-- Intervention Confirmation Modal -->
            <?php include_once "../PagesContent/GradeBookContent/AllModal/ModalIntervention.php"?>

            <!-- Main Content-->
            <section class="content" id="main_content">
                <?php include_once "../PagesContent/GradeBookContent/MainTableContent/GradebookData.php"?>

            </section>
        </div>
        <?php 
        include_once("../CommonCode/footer.php");
        ?>
    </div>

    <?php include_once("../bootstrap/jquery.php");?>

    <!-- This Script Contain Common Script used on other pages  -->
    <?php include_once "../CommonScript/CommonAllScript.php";?>

    <!-- add to intervention script -->
    <?php include_once "../PagesContent/GradeBookContent/GradebookScripts/AddToInterventionScript.php"?>


    <script>
    $(document).ready(function() {
        $("#gradebook_content").show();
        $("#lesson_progress_content").hide();
        $("#quiz_progress_content").hide();
    });
    </script>


</body>

</html>