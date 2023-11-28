<html style="height: auto; min-height: 100%;">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Gradebook</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php 
        include_once("../bootstrap/style.php");
    ?>
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
                        Gradebook
                        <small>Teacher Portal</small>
                    </h1>
                    <!-- Breadcrumb   
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Layout</a></li>
                        <li class="active">Top Navigation</li>
                    </ol> -->
                </section>
                <br>


                <section>
                    <!-- <div class="align-items-start">
                        <div class="col-sm-2">
                            <div class="custom-dropdown">

                                <button class="custom-dropdown-toggle btn" type="button" data-toggle="dropdown"
                                    style="width:150px; border: 2px solid #3C8DBC; border-radius:10px; color: #3C8DBC;">
                                    <b>Module</b> 
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu custom-dropdown-menu">
                                    <li><a href="#" data-quiz-type="-quiz"><b>All Active quiz</b></a></li>
                                    <li><a href="#" data-quiz-type="archive-quiz"><b>All Archive quiz</b></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-10">
                        </div>
                    </div> -->
                  
                </section>
                <br>
                <br>
                <!-- Main Content-->
                <section class="content" id="gradebook_content">
                    <?php include_once "../PagesContent/GradeBookContent/MainTableContent/GradebookData.php"?>
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
</body>

</html>