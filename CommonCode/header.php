<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

            <div class="collapse navbar-collapse pull-left" id="navbar-collapse" aria-expanded="false"
                style="height: 0.8px;">
                <ul class="nav navbar-nav">
                    <li><a href="main.php">Dashboard <span class="sr-only">(current)</span></a></li>

                    <li><a href="class_list.php">Clas Management</a>
                        <!-- <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Class List <span
                                class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="student_active.php">Student - Active</a></li>
                            <li><a href="student_inactive.php">Student - Archive</a></li>
                        </ul> -->
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Workspace<span
                                class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="lesson.php">Lesson</a></li>
                            <li class="divider"></li>
                            <li><a href="quiz.php">Quiz</a></li>
                        </ul>
                    <li><a href="gradebook.php">Gradebook</a></li>
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
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">10</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 10 notifications</li>
                            <li>
                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-warning text-yellow"></i> Very long description here that
                                            may not fit into the
                                            page and may cause design problems
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-users text-red"></i> 5 new members joined
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-user text-red"></i> You changed your username
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer"><a href="#">View all</a></li>
                        </ul>
                    </li>
                    <!-- end of notification  -->
                    <li class="dropdown user user-menu">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                            <img src="../Media/Images/UserAvatar/temp_profpic.png" class="user-image" alt="User Image">

                            <span class="hidden-xs" id="teacher_name_main">
                                <?php include "../Database/DisplayUserInfo.php";
                                $displayUserInfo = new DisplayUserInfo();
                                $displayUserInfo->displayTeacherName();
                                ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <img src="../Media/Images/UserAvatar/temp_profpic.png" class="img-circle"
                                    alt="User Image">
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