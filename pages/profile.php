<html style="height: auto; min-height: 100%;">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Teacher Portal</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php include_once("../bootstrap/style.php");?>
    <!-- jQuery 3 -->
    <script src="../design/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../design/bower_components/jquery-ui/jquery-ui.min.js"></script>
</head>

<body class="skin-blue layout-top-nav fixed" data-new-gr-c-s-check-loaded="14.1131.0" data-gr-ext-installed
    style="height: auto; min-height: 100%;">


    <div class="wrapper" style="height: auto; min-height: 100%;">
        <?php include_once("../CommonCode/header.php");?>

        <div class="content-wrapper" style="min-height: 606.2px;">
            <?php include_once "../CommonCode/ModifiedAlert.php";?>

            <div class="container">
                <section class="content-header">
                    <h1>
                        Teacher Profile
                        <small>Edit Teacher Data Here</small>
                    </h1>
                </section>


                <section class="content" id="main-content">
                    <?php include_once "../PagesContent/ProfileContentFolder/ProfileMain/TeacherProfile.php";?>
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

    <!-- // Assign Data and Modified Data in Main or dashboard -->
    <?php include_once "../PagesContent/MainContentFolder/AllSciptMain/AssignDataScript.php"; ?>
    
    <!-- Profile modified Script -->
    <?php include_once "../PagesContent/ProfileContentFolder/ScriptProfile/ProfileJqueryScript.php" ?>

    <!-- hide/ unhide password script -->
    <?php include_once "../PagesContent/ProfileContentFolder/ScriptProfile/PasswordScript.php" ?>

</body>

</html>