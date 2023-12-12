<html style="height: auto; min-height: 100%;">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Assignment | LIST</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php include_once("../bootstrap/style.php") ?>
</head>

<body class="skin-blue layout-top-nav fixed" data-new-gr-c-s-check-loaded="14.1131.0" data-gr-ext-installed
    style="height: auto; min-height: 100%;">


    <div class="wrapper" style="height: auto; min-height: 100%;">
        <!-- Header  -->
        <?php include_once("../CommonCode/header.php");?>

        <div class="content-wrapper" style="min-height: 606.2px;">
            <!-- View quiz Data Modal -->
            <div class="container">
                <section class="content-header">
                    <!-- Header name -->
                    <h1>
                        Assignment List
                        <small>Add and Modify Assignment</small>
                    </h1>
                </section>
                <br>
                <!-- Main Content-->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-default container">
                                <br>
                                <div class="box-header with-border">
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                                class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                </div>
                                <br>
                                <!-- /.box-header -->
                                <div class="box-body" style="overflow-y: scroll; max-height: auto;">
                                    <div class="table-responsive">
                                        <table id="example2" class="table table-bordered table-hover text-center">
                                            <thead>
                                                <tr>
                                                    <!-- Table Header -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- table data -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->
                    </div>
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