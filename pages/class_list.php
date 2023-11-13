<html style="height: auto; min-height: 100%;">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Student | Active</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">


    <?php 
        include_once("../bootstrap/style.php");
    ?>
    <?php include_once "../CommonCode/ModifiedSearchStyle.php";?>

    <!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<!-- Include Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>

<body class="skin-blue layout-top-nav" data-new-gr-c-s-check-loaded="14.1131.0" data-gr-ext-installed
    style="height: auto; min-height: 100%;">


    <div class="wrapper" style="height: auto; min-height: 100%;">
        <!-- This is a Header -->
        <?php include_once("../CommonCode/header.php");?>
        <!-- Modified Search  -->
        <?php include_once "../CommonCode/ModifiedSearchStyle.php";?>

        <div class="content-wrapper" style="min-height: 606.2px;">

            <div class="container">

                
                <!-- Edit Student Modal -->
                <?php include_once "../PagesContent/StudentContentFolder/ModalFolder/EditStudentModal.php"?>
                <!-- Archive Modal -->
                <?php include_once "../PagesContent/StudentContentFolder/ModalFolder/ArchiveStudentModal.php"?>
                <!-- Modified Alert -->
                <?php include_once "../CommonCode/ModifiedAlert.php";?>
                <section class="content-header">
                    <h1>
                        Class List
                        <small>Assigned class</small>
                    </h1>
                </section>

                <!-- Main Content-->
                <section class="content" id="main-content">
                    <!-- Script was also in StudentMainContent.php dynamic script which load all the class-->
                    <?php include_once "../PagesContent/StudentContentFolder/StudentMainFolder/StudentMainContent.php";?>
                </section>
            </div>
        </div>
        <?php include_once("../CommonCode/footer.php");?>
    </div>

    <?php include_once("../bootstrap/jquery.php");?>

    <!-- This Script Contain Common Script used on other pages  -->
    <?php include_once "../CommonScript/CommonAllScript.php";?>

    <!-- Add student script -->
</body>

</html>