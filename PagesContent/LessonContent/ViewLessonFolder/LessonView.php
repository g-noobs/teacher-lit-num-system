<html style="height: auto; min-height: 100%;">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Teacher Portal</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php include_once "../ViewLessonFolder/lessonStyle.php";?>

</head>

<body class="sidebar-mini wysihtml5-supported skin-yellow-light sidebar-collapse fixed"
    style="height: auto; min-height: 100%;" data-new-gr-c-s-check-loaded="14.1125.0" data-gr-ext-installed="">

    <header class="main-header">
        <a href="#" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>VL</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>View Lesson</b></span>
        </a>
        <nav class="navbar navbar-static-top">
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
        </nav>
    </header>

    <aside class="main-sidebar">
        <section class="sidebar">
            <div class="user-panel">
                <!-- Avatar Here -->
            </div>
            <ul class="sidebar-menu tree" data-widget="tree" id="side-menu">
                
            </ul>

    </aside>

    <div class="content-wrapper" style="min-height: 707px;">
        <div class="container">

            <?php include_once "../../../CommonContent/ModifiedAlert.php"?>
            <section class="content-header">
                <div id="test"></div>
                <h3>Lesson: <strong id="lesson_name"></strong></h3>

                <br>
                <ul class="pager">
                    <li id="prev"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo; Previous</span></a>
                    </li>
                    <li id="next"><a href="#" aria-label="Next"><span aria-hidden="true">Next &raquo;</span></a></li>
                </ul>
            </section>


            <section class="content">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <div id="lesson_description"></div>
                    </div>
                    <div class="box-body">
                        <div id="gallery"></div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <?php include_once "../ViewLessonFolder/lessonScript.php"?>
    <?php include_once "../ViewLessonFolder/ModifiedViewScript.php"?>
    <?php include_once "../ViewLessonFolder/ViewLessonScript.php"?>
</body>

</html>