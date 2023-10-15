<?php
session_start();
if ($_SESSION['teacher'] !== true || $_SESSION['admin'] !== false) {
    header('Location: ../../index.php');
    exit;
}
?>

<header class="main-header">
    <nav class="main-header navbar navbar-expand-md navbar-light bg-warning">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="dashboard.php" class="navbar-brand"><b>Teacher</b> Portal</a>
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#navbar-collapse" aria-expanded="false">
                    <i class="fa fa-bars"></i>
                </button>
            </div>

            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
                    <li><a href="#">Link</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Dropdown <span
                                class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li><a href="#">Something else here</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Separated link</a></li>
                            <li class="divider"></li>
                            <li><a href="#">One more separated link</a></li>
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
                    <!-- Task Menu with notifications   
                    <li class="dropdown messages-menu">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success">4</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 4 messages</li>
                            <li>

                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                            <div class="pull-left">

                                                <img src="../../dist/img/user2-160x160.jpg" class="img-circle"
                                                    alt="User Image">
                                            </div>

                                            <h4>
                                                Support Team
                                                <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                            </h4>

                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>

                                </ul>

                            </li>
                            <li class="footer"><a href="#">See All Messages</a></li>
                        </ul>
                    </li>
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

                                </ul>
                            </li>
                            <li class="footer"><a href="#">View all</a></li>
                        </ul>
                    </li>
                    
                    <li class="dropdown tasks-menu">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag-o"></i>
                            <span class="label label-danger">9</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 9 tasks</li>
                            <li>

                                <ul class="menu">
                                    <li>
                                        <a href="#">

                                            <h3>
                                                Design some buttons
                                                <small class="pull-right">20%</small>
                                            </h3>

                                            <div class="progress xs">

                                                <div class="progress-bar progress-bar-aqua" style="width: 20%"
                                                    role="progressbar" aria-valuenow="20" aria-valuemin="0"
                                                    aria-valuemax="100">
                                                    <span class="sr-only">20% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#">View all tasks</a>
                            </li>
                        </ul>
                    </li>
                    -->

                    <li class="dropdown user user-menu">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                            <img src="../design/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">

                            <span class="hidden-xs" id="teacher_name_main">
                                <?php include_once "../Database/DisplayUserInfo.php";
                                $displayUserInfo = new DisplayUserInfo();
                                $sql = "SELECT * FROM user_info_view WHERE teacher_id = " . $_SESSION['id'];
                                $displayUserInfo->displayTeacherName($sql);
                                ?>
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <img src="../design/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                <p id=teacher_name>
                                   
                                </p>
                                <p id=teacher_email>
                                   
                                </p>
                            </li>

                            <li class="user-body">
                                <div class="row">

                                </div>

                            </li>

                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
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