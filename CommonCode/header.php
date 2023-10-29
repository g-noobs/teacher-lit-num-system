<?php
session_start();
if ($_SESSION['teacher'] !== true || $_SESSION['admin'] !== false) {
    header('Location: ../../index.php');
    exit;
}
?>

<header class="main-header">
    <nav class="navbar navbar-static-top">

        <div class="container-fluid">
            <div class="navbar-header">
                <a href="main.php" class="navbar-brand"><b>Teacher</b> Portal</a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar-collapse" aria-expanded="false">
                    <i class="fa fa-bars"></i>
                </button>
            </div>

            <div class="collapse navbar-collapse pull-left" id="navbar-collapse" aria-expanded="false" style="height: 0.8px;">
                <ul class="nav navbar-nav">
                    <li><a href="main.php">Dashboard <span class="sr-only">(current)</span></a></li>
                    
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Student List <span
                                class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="student_active.php">Student - Active</a></li>
                            <li class="divider"></li>
                            <li><a href="student_inactive.php">Student - Archive</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Lesson<span
                                class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="lesson.php">Lesson List</a></li>
                            <li class="divider"></li>
                            <li><a href="quiz.php">Quiz List</a></li>
                        </ul>
                    </li>
                </ul>
                
                <!-- Search Bar
                <form class="navbar-form navbar-left" role="search">
                    <div class="form-group">
                        <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
                    </div>
                </form>
                -->
            </div>


            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                
                    <li class="dropdown user user-menu">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                            <img src="../design/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">

                            <span class="hidden-xs" id="teacher_name_main">
                                <?php include "../Database/DisplayUserInfo.php";
                                $displayUserInfo = new DisplayUserInfo();
                                $displayUserInfo->displayTeacherName();
                                ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <img src="../design/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                <p id=teacher_name>
                                    <?php $displayUserInfo->displayTeacherName();?>
                                </p>
                                <p id=teacher_email>
                                    <?php $displayUserInfo->displayTeacherEmail();?>
                                </p>
                            </li>

                            <li class="user-body">
                                <div class="row">

                                </div>

                            </li>

                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="profile.php" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right" id="logoutTeachBtn">
                                    <a href="#" class="btn btn-default btn-flat">Sign out</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>