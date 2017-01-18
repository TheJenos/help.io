<!DOCTYPE html>
<?php
include './config.php';
CookieLogin();
if (isset($_SESSION['userdata'])) {
    header("Location: index.php");
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Loging</title>
        <?php
        links();
        ?>
        <script type="text/javascript">
            var app = angular.module("myApp", []);
            var login_info = {};
            function showError($txt) {
                $('#error').fadeIn('fast');
                $('#error').html($txt);
                setTimeout(function() {
                    $('#error').fadeOut('fast');
                }, 2000);
            }
            app.controller("login", function($scope) {
                login_info = $scope;
            });
            $(function() {
                $('#error').hide();
                $('#loginbtn').click(function(e) {
                    if (!login_info.username) {
                        showError("Invalid Username");
                        return;
                    }
                    if (!login_info.pass) {
                        showError("Invalid Password");
                        return;
                    }
                    $.post("backend.php", {
                        "uname": login_info.username,
                        "upass": login_info.pass,
                        "json": true
                    }).done(function(response) {
                        var result = $.parseJSON(response);
                        if (result.status == "Fail") {
                            showError(result.msg);
                        } else {
                            $('#myform').submit();
                        }
                    });
                });
            });
        </script>
        <style>
            body{
                background: url('images/bg/<?php echo randImages(); ?>');
                background-size: 1366px;
            }
            
        </style>
    </head>
    <body >
        <div class="row" style="margin-top: 150px;" >
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <h1 class="text-center" style="color:white">Login</h1>
            </div>
            <div class="col-md-4"></div>
        </div>    
        <div class="row" ng-app="myApp" style="margin-top: 5px;" ng-controller="login" >
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="alert alert-danger" id="error"></div>
                <div class="well" style="margin: 5px;color: white;margin: 5px;">
                    <form role="form" id="myform" action="backend.php" method="POST" novalidate="" >
                        <div class="form-group">
                            <label for="email">Username or Email</label>
                            <input type="text" name="username" class="form-control simple" id="user" ng-model="username" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label for="pwd">Password</label>
                            <input type="password" name="pass" class="form-control simple" id="pass" ng-model="pass" autocomplete="off">
                        </div>
                        <div class="checkbox">
                            <label><input name="re" type="checkbox"> Remember me</label>
                        </div>
                        <div style="text-align: right">
                            <input type="button" id="loginbtn" name="login" class="simple" value="Login">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </body>    
</html>

