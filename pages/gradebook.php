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
                </section>
                <br>
                <br>
                <section id="gradebook_dropdown" class="container">
                    <form class="form-inline">
                        <div class="form-group">
                            <!-- Mao ni siya ang dropdown selection for class section-->
                            <label for="classFilter">Filter by Class:</label>
                            <select id="classFilter" onchange="filterTable()" class="form-control">
                                <option value="all">All</option>
                                <?php
                                    include_once "../Database/Connection.php";
                                    $conn = new Connection();
                                    $connection = $conn->getConnection();
                                    $classQuery = "SELECT class_name FROM tbl_class WHERE class_status = 1";
                                    $classResult = mysqli_query($connection, $classQuery);
                                    while ($classRow = mysqli_fetch_assoc($classResult)) { 
                                        $className = $classRow['class_name'];
                                        echo "<option value='$className'>$className</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="genderFilter">Filter by Gender:</label>
                            <select id="genderFiltr" class="form-control" onchange="filterTable()">
                                <option value="all">All</option>
                                <option value="MALE">Male</option>
                                <option value="FEMALE">Female</option>
                            </select>
                        </div>
                    </form>
                </section>
                <!-- Filter Modal -->
                <!-- Main Content-->
                <section class="content" id="main_content">
                    <?php include_once "../PagesContent/GradeBookContent/MainTableContent/GradebookData.php"?>
                    <?php include_once "../PagesContent/GradeBookContent/MainTableContent/LessonProgress.php"?>
                    <?php include_once "../PagesContent/GradeBookContent/MainTableContent/QuizProgress.php"?>

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

    <!-- get student lesson progress -->
    <?php include_once "../PagesContent/GradeBookContent/GradebookScripts/LearnerProgressScript.php"?>
    <!-- get student quiz progress -->
    <?php include_once "../PagesContent/GradeBookContent/GradebookScripts/QuizProgressScript.php"?>

    <script>
    $(document).ready(function() {
        $("#gradebook_content").show();
        $("#lesson_progress_content").hide();
        $("#quiz_progress_content").hide();
    });
    </script>
    

</body>

</html>