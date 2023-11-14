<html style="height: auto; min-height: 100%;">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Lesson | LIST</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php include_once("../bootstrap/style.php");?>
    <?php include_once "../CommonCode/ModifiedSearchStyle.php";?>

    <!-- jQuery 3 -->
    <script src="../design/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../design/bower_components/jquery-ui/jquery-ui.min.js"></script>
</head>

<body class="skin-blue layout-top-nav" data-new-gr-c-s-check-loaded="14.1131.0" data-gr-ext-installed
    style="height: auto; min-height: 100%;">


    <div class="wrapper" style="height: auto; min-height: 100%;">
        <?php 
            include_once("../CommonCode/header.php");
        ?>

        <div class="content-wrapper" style="min-height: 606.2px;">

            <?php include_once "../CommonCode/ModifiedAlert.php";?>

            <div class="container">

                <section class="content-header">
                    <h1>
                        Lesson List
                        <small>Detailed list of lessons</small>
                    </h1>
                    <!-- Breadcrumb   
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Layout</a></li>
                        <li class="active">Top Navigation</li>
                    </ol> -->
                </section>
                <br>

                <section id=lesson_status_dropdown>
                    <div class="align-items-start">
                        <div class="col-sm-2">
                            <div class="custom-dropdown">

                                <button class="custom-dropdown-toggle btn" type="button" data-toggle="dropdown"
                                    style="width:150px; border: 2px solid #E58A00; border-radius:10px; color: #E58A00;">
                                    <b>Active Lesson</b> <!-- Updated the button text -->
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu custom-dropdown-menu">
                                    <li><a href="#" data-lesson-type="active-lesson"><b>Active Lesson</b></a></li>
                                    <li><a href="#" data-lesson-type="archive-lesson"><b>Archived Lesson</b></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-10">
                        </div>
                    </div>
                </section>
                <br><br>
                <!-- Main content -->
                <section class="content container" id="lesson-table">
                    <?php include_once "../PagesContent/LessonContent/TableFolder/LessonTable.php"?>
                </section>

                <!-- Section for topic -->
                <section class="content container" id="add-topic-panel">
                    <?php include_once("../PagesContent/LessonContent/TopicFolder/LessonTopic.php");?>
                </section>

            </div>

        </div>

        <?php 
        include_once("../CommonCode/footer.php");
        ?>
    </div>

    <?php include_once("../bootstrap/jquery.php");?>

    <?php include_once("../PagesContent/LessonContent/CommonLesson/ModalLesson.php");?>
    <!-- Script for adding lesson -->
    <?php include_once("../PagesContent/LessonContent/CommonLesson/AddLessonScript.php");?>

    <!-- Script when button is click to view topic in lesson -->
    <?php include_once("../PagesContent/LessonContent/CommonLesson/ViewLessonScript.php");?>

    <!-- modified jquery for lesson - will modify if view button is click from the lesson-->
    <?php include_once("../PagesContent/LessonContent/CommonLesson/JqueryLesson.php");?>

    <!-- All Jquery for topic -->
    <?php include_once("../PagesContent/LessonContent/CommonLesson/JqueryTopic.php");?>

    <?php include_once "../PagesContent/LessonContent/TopicFolder/TopicScript.php";?>


    <!-- This Script Contain Common Script used on other pages  -->
    <?php include_once "../CommonScript/CommonAllScript.php";?>
</body>

</html>