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
                $scope.$watch('email', function(value) {
                    $.post("backend.php", {
                        "ccemail": value
                    }).done(function(response) {
                        if (response == 'TRUE') {
                            $scope.cemail = true;
                        } else {
                            $scope.cemail = false;
                        }
                    });
                });
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
        <?php if (isset($_GET['newaccout'])) { ?>
        <div class="row" style="margin-top: 20px;" >
                    <?php } else { ?>
        <div class="row" style="margin-top: 150px;" >
                    <?php } ?>
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <h1 class="text-center" style="color:white">
                    <?php if (isset($_GET['newaccout'])) { ?>
                        Sign Up
                    <?php } else { ?>
                        Login
                    <?php } ?>
                </h1>
            </div>
            <div class="col-md-4"></div>
        </div> 
        <div class="row" ng-app="myApp" style="margin-top: 5px;" ng-controller="login" >
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="alert alert-danger" id="error"></div>
                <div class="well" style="margin: 5px;margin: 5px;background: #ffffff;">
                    <?php if (isset($_GET['newaccout'])) { ?>
                        <form role="form" id="myform" action="backend.php?caccout" method="POST" novalidate="" >
                            <div class="form-group">
                                <label for="email">Username</label>
                                <input type="text" name="uname" class="form-control simple" id="user" ng-model="uname" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control simple" id="user" ng-model="email" autocomplete="off">
                            </div>
                            <h4 style="color:red" ng-show="cemail">Email Are Already In Use</h4>
                            <h4 style="color:red" ng-hide="email == email1">Emails Are Not Matching</h4>
                            <div class="form-group">
                                <label for="email">Re Type Email</label>
                                <input type="email" name="email2" class="form-control simple" id="user" ng-model="email1" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="pwd">Password</label>
                                <input type="password" name="upass" class="form-control simple" id="pass" ng-model="upass" autocomplete="off">
                            </div>
                            <h4 style="color:red" ng-hide="upass == upass1">Passwords Are Not Matching</h4>
                            <div class="form-group">
                                <label for="pwd">Re Type Password</label>
                                <input type="password" name="upass2" class="form-control simple" id="pass" ng-model="upass1" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="pwd">Birth Date</label>
                                <input type="date" name="bday" class="form-control simple" id="pass" ng-model="bday" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="pwd">Gender</label>
                                <p>
                                    <input type="radio" name="gen" checked="ture" class="form-control simple" id="gen"  autocomplete="off" value="male">
                                    <label for="gen">Male</label>
                                    <input type="radio" name="gen" class="form-control simple" id="gen2" autocomplete="off" value="female">
                                    <label for="gen2">Female</label>
                                </p>
                            </div>
                            <div class="form-group">
                                <label for="pwd">Job</label>
                                <select name="JID" class="form-control simple"  >
                                    <?php
                                    $txt = "<option value='data-0'>data-1</option>";
                                    echo SearchToItems("`jobs`", array('JID', 'Jname'), "1", $txt, array('JID', 'Jname'));
                                    ?>
                                </select>
                            </div>
                            <div style="text-align: right">
                                <input type="submit" ng-hide="cemail" class="simple" value="Sign Up">
                            </div>
                        </form>
                    <?php } else { ?>
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
                                <p>
                                    <input name="re" type="checkbox" id="test1"><label for="test1"> Remember me</label>
                                </p>
                            </div>
                            <div style="text-align: right">
                                <a href="Login.php?newaccout=">
                                    <input type="button" class="simple" value="Sign Up">
                                </a>
                                <input type="button" id="loginbtn" name="login" class="simple" value="Login">
                            </div>
                        </form>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </body>    
</html>

