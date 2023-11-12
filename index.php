<!DOCTYPE html>
<html>
<?php session_start(); 
$_SESSION['admin'] = false;
$_SESSION['teacher'] = false;
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Teacher</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
    body {
        color: #999;
        background: #f5f5f5;
        font-family: 'Varela Round', sans-serif;
        overflow: hidden;
    }

    .form-control {
        box-shadow: none;
        border-color: #ddd;
    }

    .form-control:focus {
        border-color: #f0ad4e;
    }

    .login-form {
        width: 350px;
        margin: 85px auto;
        padding: 30px 0;
    }

    .login-form form {
        color: #434343;
        border-radius: 1px;
        margin-bottom: 15px;
        background: #fff;
        border: 1px solid #f3f3f3;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        padding: 30px;
    }

    .login-form h4 {
        text-align: center;
        font-size: 22px;
        margin-bottom: 20px;
    }

    .login-form .avatar {
        color: #fff;
        margin: 0 auto 30px;
        text-align: center;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        z-index: 9;
        background: #f0ad4e;
        padding: 15px;
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
    }

    .login-form .avatar i {
        font-size: 62px;
    }

    .login-form .form-group {
        margin-bottom: 20px;
    }

    .login-form .form-control,
    .login-form .btn {
        min-height: 40px;
        border-radius: 2px;
        transition: all 0.5s;
    }

    .login-form .close {
        position: absolute;
        top: 15px;
        right: 15px;
    }

    .login-form .btn {
        background: #f0ad4e;
        border: none;
        line-height: normal;
    }

    .login-form .btn:hover,
    .login-form .btn:focus {
        background: #ff8800;
    }

    .login-form .checkbox-inline {
        float: left;
    }

    .login-form input[type="checkbox"] {
        margin-top: 2px;
    }

    .login-form .forgot-link {
        float: right;
    }

    .login-form .small {
        font-size: 13px;
    }

    .login-form a {
        color: #4aba70;
    }
    </style>
</head>

<body>
    <div class="wrapper" style="height: auto; min-height: 100%;">

        <?php include_once "CommonCode/ErrorModal.php"?>
        <section class="content container" style="margin-top: 40px">
            <a href=" https://www.tagakauloedu.com/Mobile/Download.php"<span>Download the Mobile Application</span><i class="glyphicon glyphicon-download-alt"></i></a>
        </section>
        <section>
            <div class="login-form">
                <!-- <form action="ActionValidateUser.php" method="post"> -->
                <form id="validate_user">
                    <div class="avatar"><i class="material-icons">&#xE7FF;</i></div>
                    <h4 class="modal-title">Welcome Teacher!</h4>
                    <h5>Please Login using your Credentials</h5>
                    <div class="form-group">
                        <input type="text" name="username_teacher" class="form-control" placeholder="Username"
                            required="required">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password_teacher" class="form-control" placeholder="Password"
                            required="required">
                    </div>
                    <!-- <div class="form-group small clearfix">
                <label class="checkbox-inline"><input type="checkbox"> Remember me</label>
                <a href="#" class="forgot-link">Forgot Password?</a>
            </div> -->
                    <input type="submit" class="btn btn-primary btn-block btn-lg" value="Login">
                </form>
                <!-- <div class="text-center small">Don't have an account? <a href="#">Sign up</a></div> -->
            </div>
        </section>
    </div>
    <!-- /.login-box -->
    <!-- Modal HTML -->

    <!-- jQuery 3 -->
    <script src="design/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="design/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="design/plugins/iCheck/icheck.min.js"></script>

    <!-- handle Error modal Script -->
    <script>
    $(function() {
        $("#validate_user").on("submit", function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                // Use this will redirect to Teacher Folder
                url: "ActionValidateUser.php",
                method: "post",
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    var responseData = JSON.parse(response);

                    if (responseData.hasOwnProperty('success')) {
                        console.log(responseData.success);
                        window.location.href = "pages/main.php";
                    } else if (responseData.hasOwnProperty('error')) {
                        var msg = responseData.error;
                        //assign text to modal and show
                        $('#errorMessage').text(msg);
                        $('#errorModal').modal('show');
                        setTimeout(function() {
                            $("#errorModal").fadeOut(
                                "slow"); // Hide the .alert element after 3 seconds
                            location.reload();
                        }, 1500);
                    }
                },
                error: function(response) {
                    console.log(response);
                    var msg = "Possible Ajax issue!"
                    $('#errorMessage').text(msg);
                    $('#errorModal').modal('show');

                    setTimeout(function() {
                        $("#errorModal").fadeOut(
                            "slow"); // Hide the .alert element after 3 seconds
                        location.reload();
                    }, 1500);
                }
            });
        });
    });
    </script>
</body>

</html>

<!-- This is only a sample for debugging to delete with ValidateCredsClass.php -->