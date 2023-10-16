<html style="height: auto; min-height: 100%;">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Student | Archive</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php 
        include_once("../bootstrap/style.php");
    ?>
    <?php include_once "../CommonCode/ModifiedSearchStyle.php";?>


</head>

<body class="skin-yellow layout-top-nav" data-new-gr-c-s-check-loaded="14.1131.0" data-gr-ext-installed
    style="height: auto; min-height: 100%;">


    <div class="wrapper" style="height: auto; min-height: 100%;">
        <?php 
            include_once("../CommonCode/header.php");
        ?>

        <div class="content-wrapper" style="min-height: 606.2px;">
            <div class="container">
                <?php include_once "../CommonCode/ModifiedAlert.php";?>

                <section class="content-header">
                    <h1>
                        Welcome!
                        <small>Teacher Portal</small>
                    </h1>
                    <!-- Breadcrumb   
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Layout</a></li>
                        <li class="active">Top Navigation</li>
                    </ol> -->
                </section>

                <!-- Main Content-->
                <section class="content" id="main-content">
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <div class="row">
                                <div class="col-xs-6">
                                    <button type="button" class="btn btn-warning" data-toggle="modal"
                                        data-target="#add-user">
                                        <i class="fa fa-plus"></i> <span>Add Admin</span>
                                    </button>
                                </div>
                                <div class="col-xs-6">
                                    <div class="search-box">
                                        <i class="fa fa-search"></i>
                                        <input type="text" id="userInput" class="form-control" placeholder="Search..">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-body" id="content_body">
                            test for boday
                        </div>
                    </div>
                </section>

            </div>

        </div>

        <?php 
        include_once("../CommonCode/footer.php");
        ?>
    </div>

    <?php include_once("../bootstrap/jquery.php");?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- This Script Contain Common Script used on other pages  -->
    <?php include_once "../CommonScript/CommonAllScript.php";?>
</body>

</html>