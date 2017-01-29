<!DOCTYPE html>
<?php
include './config.php';
CookieLogin();
if (isset($_GET['logout'])) {
    session_destroy();
    setcookie('username', '', 0, "/");
    setcookie('userpass', '', 0, "/");
    header("Location: index.php");
} else if (isset($_GET['status'])) {
    $data = array('Ustatus' => $_GET['status']);
    Update("`user`", $data, "UID='" . antisqli($_SESSION['userdata']['UID']) . "'");
    header("Location: index.php?profile");
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>HELP.IO</title>
        <?php
        links();
        ?>
        <style>
            @import url(https://fonts.googleapis.com/css?family=Roboto:300,400,600);
            @keyframes draw {
                0% {
                    box-shadow: 0px 0px 5px black; 
                }
                100% {
                    box-shadow: 0px 0px 5px ;
                }
            }
            @keyframes blink-animation {
                from{
                    opacity: 1
                }
                to {
                    opacity: 0;
                }
            }

            body{
                background: white;
                color: #00365a;
                font: "Noto Sans", Arial;
            }
            p,i,b{
                color: #00365a;
            }
            p {
                font-size: 16px;
            }
            .cusname:after{
                content: ".IO";
                color: #00365a;
                animation: blink-animation 1s infinite;
                -webkit-animation: blink-animation 1s infinite;
                animation-direction: alternate;
            }
            .well{
                color: #00365a;
                border: 0px; 
                background: white;
                /*box-shadow: 0px 0px 5px black;*/
                border-radius: 0px;
                border-radius: 5px;
            }
            .navbar-custom{
                background: white;
            }
            .footer .footer-above{
                background: white;
            }
            .footer h1,.footer h2,.footer h3,.footer h4{
                color:#00365a;
            }
            .footer .footer-below{
                background: #faf3f3;
                color:#00365a;
            }
            .parallax1 {
                content: "";
                background-image: url("images/bg/<?php echo randImages(); ?>");
                /*height: 760px;*/ 
                padding: 20%;
                background-attachment: fixed;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
                text-align: center;

            }
            .box-h3{
                background-color: white;
                padding: 20px;
                width: fit-content;
                color:#00365a;
                border-radius: 5px;
            }
            .txtarea .box-h3{
                background-color:#82b0e1;
                padding: 20px;
                width: fit-content;
                color:white;
                font-size: 17px;
            }
            .parallax {
                background-image: url("images/bg/<?php echo randImages(); ?>");
                padding-bottom: 100px;
                background-attachment: fixed;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
            }
            .snip1336 {
                border-radius: 5px;
                position: relative;
                font-family: 'Roboto', Arial, Arial;
                overflow: hidden;
                min-width: 230px;
                width: 100%;
                color: #00365a;
                text-align: left;
                line-height: 1.4em;
                background-color: white;
            }
            .snip1336 .lastonline {
                position: absolute;
                top: 0px;
                right: 9px;
                background: white;
            }
            .snip1336 .perhour {
                position: absolute;
                top: 0px;
                left: 9px;
                background: white;
            }
            .snip1336 * {
                -webkit-box-sizing: border-box;
                box-sizing: border-box;
                -webkit-transition: all 0.25s ease;
                transition: all 0.25s ease;
            }
            .snip1336 img {
                max-width: 100%;
                vertical-align: top;
                opacity: 0.85;
            }
            .snip1336 figcaption {
                width: 100%;
                background-color: white;
                padding: 25px;
                position: relative;
            }
            .snip1336 figcaption:before {
                position: absolute;
                content: '';
                bottom: 100%;
                left: 0;
                width: 0;
                height: 0;
                border-style: solid;
                border-width: 55px 0 0 400px;
                border-color: transparent transparent transparent white;
            }
            .snip1336 figcaption a {
                padding: 5px;
                border: 1px solid #00365a;
                color: #00365a;
                font-size: 0.7em;
                text-transform: uppercase !important;
                margin: 10px 0;
                display: inline-block;
                opacity: 0.65;
                width: 47%;
                text-align: center;
                text-decoration: none;
                font-weight: 600;
                letter-spacing: 2px;
            }
            .snip1336 figcaption a:hover {
                opacity: 1;
            }
            .snip1336 .profile {
                border-radius: 50%;
                position: absolute;
                bottom: 100%;
                left: 25px;
                z-index: 1;
                max-width: 90px;
                opacity: 1;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
            }
            .snip1336 .follow {
                margin-right: 4%;
                border-color: #2980b9;
                color: #2980b9;
            }
            .snip1336 h2 {
                margin: 0 0 5px;
                font-weight: 300;
            }
            .snip1336 h2 span {
                display: block;
                font-size: 0.5em;
                color: #2980b9;
            }
            .snip1336 p {
                margin: 0 0 10px;
                font-size: 13px;
                letter-spacing: 1px;
                opacity: 0.8;
            }
            .page-scroll a{
                font: 14px "Noto Sans", Arial;
            }

            h1 {
                letter-spacing: 2px;
                text-transform: none !important;
                font: 40px "Noto Sans", Arial;
                color: #00365a;
            }
            h2 {
                letter-spacing: 2px;
                text-transform: none !important;
                font: 25px "Noto Sans", Arial;
                color: #00365a;
            }
            h3 {
                letter-spacing: 2px;
                text-transform: none !important;
                font: 20px "Noto Sans", Arial;
                color: #00365a;
            }
            .defs-only {
                position: absolute;
                height: 0; width: 0;
                overflow: none;
                left: -100%;
            }
            .btn-social{
                border: 2px solid #00365a;
            }
            .navbar-custom .navbar-brand, .navbar-custom .navbar-brand.active, .navbar-custom .navbar-brand:active, .navbar-custom .navbar-brand:focus, .navbar-custom .navbar-brand:hover, .navbar-custom .navbar-nav li a, header{
                color: #00365a;
            }
        </style>
        <script type="text/javascript">
            window.onclick = function(event) {
                var modal = document.getElementById('reqs');
                if (event.target == modal) {
                    $("#reqs").fadeOut();
                }
            }
            var app = angular.module("home", []);
            var sellect = "skill";
            var wallet = 0;
            var datas = '<?php echo (isset($_SESSION['userdata'])) ? json_encode($_SESSION['userdata']) : "{}"; ?>';
            var User = $.parseJSON(datas);
            function showError($txt) {
                if ($txt != 'no') {
                    $('#error').fadeIn('fast');
                    $('#error').html($txt);
                    setTimeout(function() {
                        $('#error').fadeOut('fast');
                    }, 2000);
                }
            }
            function hideDialog($id) {
                $($id).fadeOut();
            }
            function sum(a, b) {
                if (typeof (a.Tamount) == "undefined") {
                    return b.Tamount;
                }
                if (typeof (b.Tamount) == "undefined") {
                    return a.Tamount;
                }
                return a.Tamount + b.Tamount;
            }
            function getchips() {
                var txt = "";
                var chips = $('.chip');
                for (var i = 0; i < chips.length; i++) {
                    txt += $(chips[i]).attr("value") + ",";
                }
                txt = txt.substring(0, txt.length - 1);
                return txt;
            }
            $(function() {
                $('#error').hide();
                $('.dialogbox').hide();
                $('#bar').barrating({
                    theme: 'fontawesome-stars'
                });
<?php if (isset($_SESSION['userdata'])) { ?>
                    setInterval(function() {
                        $.post("backend.php", {
                            "uname": "<?php echo isset($_SESSION['userdata']) ? $_SESSION['userdata']['Uemail'] : "tmp"; ?>",
                            "upass": "<?php echo isset($_SESSION['userdata']) ? $_SESSION['userdata']['Upass'] : "tmp"; ?>",
                            "want": "userinfo",
                            "json": true
                        }).done(function(response) {
                            var result = $.parseJSON(response);
                            if (result.status == "Fail") {
                                showError(result.msg);
                            }
                            result.user.Ulastonline = ($.timeago(result.user.Ulastonline) == "Online ago") ? (result.user.Ustatus == "Online") ? "Online Now" : "Online But Away" : "Last Online " + $.timeago(result.user.Ulastonline);
                            User = result.user;
                        });
                    }, 1000);
<?php } ?>
            });
<?php if (isset($_SESSION['userdata'])) { ?>
                app.controller("userinfo", function($scope, $interval) {
                    var datas = '<?php echo json_encode($_SESSION['userdata']); ?>';
                    $scope.User = $.parseJSON(datas);
                    User = $scope.User;
                    $scope.User.Ulastonline = "Wait A Movement";
                    $interval(function() {
                        $scope.User = User;
                    }, 1000);
                });
                app.controller("help", function($scope, $interval) {
                    $scope.rating = 0;
                    $interval(function() {
                        if (User.Ustatus == "Busy") {
                            $.post("backend.php", {
                                "uname": "<?php echo $_SESSION['userdata']['Uemail']; ?>",
                                "upass": "<?php echo $_SESSION['userdata']['Upass']; ?>",
                                "want": "gethelp",
                                "json": true
                            }).done(function(response) {
                                var result = $.parseJSON(response);
                                if (result.status == "Fail") {
                                    showError(result.msg);
                                } else {
                                    $("#help").fadeIn();
                                }
                                $scope.rating = $('#bar').val();
                                $('#chat-scroll').animate({
                                    scrollTop: $('#chat-scroll').get(0).scrollHeight}, 2000);
                                $('#chat-scroll1').animate({
                                    scrollTop: $('#chat-scroll1').get(0).scrollHeight}, 2000);
                                $scope.result = result;
                            });
                        } else {
                            $("#help").fadeOut();
                        }
                    }, 100);
                    $scope.runScript = function(txt, e) {
                        if (sellect == "skill" && e.which == 13) {
                            $.post("backend.php", {
                                "uname": "<?php echo $_SESSION['userdata']['Uemail']; ?>",
                                "upass": "<?php echo $_SESSION['userdata']['Upass']; ?>",
                                "want": "chat",
                                "msg": $scope.chattxt,
                                "id": $scope.result.data.RID,
                                "json": true
                            }).done(function(response) {
                                var result = $.parseJSON(response);
                                if (result.status == "Fail") {
                                    showError(result.msg);
                                } else {
                                    $scope.chattxt = "";
                                }
                            });
                        }
                    }
                    $scope.cancelit = function() {
                        $.post("backend.php", {
                            "uname": "<?php echo $_SESSION['userdata']['Uemail']; ?>",
                            "upass": "<?php echo $_SESSION['userdata']['Upass']; ?>",
                            "want": "cancelrequest",
                            "id": $scope.result.data.RID,
                            "json": true
                        }).done(function(response) {
                            var result = $.parseJSON(response);
                            if (result.status == "Fail") {
                                showError(result.msg);
                            } else {
                                $("#help").fadeOut();
                            }
                        });
                    }
                    $scope.endit = function() {
                        $.post("backend.php", {
                            "uname": "<?php echo $_SESSION['userdata']['Uemail']; ?>",
                            "upass": "<?php echo $_SESSION['userdata']['Upass']; ?>",
                            "want": "endit",
                            "rate": $scope.rating,
                            "id": $scope.result.data.RID,
                            "json": true
                        }).done(function(response) {
                            var result = $.parseJSON(response);
                            if (result.status == "Fail") {
                                showError(result.msg);
                            } else {
                                $("#help").fadeOut();
                            }
                        });
                    }
                    $scope.accpetit = function() {
                        $.post("backend.php", {
                            "uname": "<?php echo $_SESSION['userdata']['Uemail']; ?>",
                            "upass": "<?php echo $_SESSION['userdata']['Upass']; ?>",
                            "want": "accpetrequest",
                            "id": $scope.result.data.RID,
                            "json": true
                        }).done(function(response) {
                            var result = $.parseJSON(response);
                            if (result.status == "Fail") {
                                showError(result.msg);
                            }
                        });
                    }
                    $scope.addtime = function(time) {
                        $.post("backend.php", {
                            "uname": "<?php echo $_SESSION['userdata']['Uemail']; ?>",
                            "upass": "<?php echo $_SESSION['userdata']['Upass']; ?>",
                            "want": "addtime",
                            "id": $scope.result.data.RID,
                            "time": time,
                            "json": true
                        }).done(function(response) {
                            var result = $.parseJSON(response);
                            if (result.status == "Fail") {
                                showError(result.msg);
                            }
                        });
                    }
                });
                app.controller("trans", function($scope, $interval) {
                    $interval(function() {
                        $.post("backend.php", {
                            "uname": "<?php echo $_SESSION['userdata']['Uemail']; ?>",
                            "upass": "<?php echo $_SESSION['userdata']['Upass']; ?>",
                            "want": "transinfo",
                            "json": true
                        }).done(function(response) {
                            var result = $.parseJSON(response);
                            if (result.status == "Fail") {
                                showError(result.msg);
                            }

                            var fromsum = result.Tfrom.reduce(sum, 0);
                            var tosum = result.Tto.reduce(sum, 0);
                            result.Wallet = tosum - fromsum;
                            wallet = tosum - fromsum;
                            $scope.User = User;
                            result.trans = result.Tfrom.concat(result.Tto);
                            result.Count = result.Tfrom.length + result.Tto.length;
                            $scope.result = result;
                        });
                    }, 1000);
                });
<?php } else { ?>
                app.controller("userinfo", function($scope, $interval) {

                });
                app.controller("help", function($scope, $interval) {

                });
                app.controller("trans", function($scope, $interval) {

                });
<?php } ?>
            app.controller("search", function($scope, $interval) {
                $scope.find = "skill";
                $scope.rand = "skill";
                $scope.$watch('find', function(value) {
                    $('#chiparea').html("");
                    $scope.searcharc();
                });
                $scope.runScript = function(txt, e) {
                    if (sellect == "skill" && e.which == 13) {
                        var chip = '<div class="chip" value="' + $scope.searchtxt + '">' + $scope.searchtxt + '<i class="fa fa-times" onclick="$(this).parent().remove()"></i></div>';
                        $('#chiparea').html($('#chiparea').html() + chip);
                        $scope.searchtxt = "";
                    }
                    if (e.which == 8 && $scope.searchtxt.length < 1) {
                        var chips = $('.chip');
                        chips[chips.length - 1].remove();
                    }
                    $scope.searcharc();
                }
                $scope.showDialog = function($id, $sid) {
                    $scope.wallet = wallet;
                    $scope.time = 1;
                    $.each($scope.result.found, function(index, value) {
                        if ($scope.result.found[index].UID == $sid) {
                            $scope.Suser = $scope.result.found[index];
                        }
                    });
                    $($id).fadeIn();
                }
                $scope.sendrequest = function() {
                    $.post("backend.php", {
                        "uname": "<?php echo isset($_SESSION['userdata']) ? $_SESSION['userdata']['Uemail'] : "tmp"; ?>",
                        "upass": "<?php echo isset($_SESSION['userdata']) ? $_SESSION['userdata']['Upass'] : "tmp"; ?>",
                        "want": "requestforhealp",
                        "who": $scope.Suser.UID,
                        "time": $scope.time,
                        "json": true
                    }).done(function(response) {
                        var result = $.parseJSON(response);
                        if (result.status == "Fail") {
                            showError(result.msg);
                        }
                        hideDialog("#reqs");
                    });
                }
                $interval(function() {
                    $scope.rand = Math.random();
                }, 100);
                $scope.searcharc = function() {
                    sellect = $scope.find;
                    $.post("backend.php", {
                        "uname": "<?php echo isset($_SESSION['userdata']) ? $_SESSION['userdata']['Uemail'] : "tmp"; ?>",
                        "upass": "<?php echo isset($_SESSION['userdata']) ? $_SESSION['userdata']['Upass'] : "tmp"; ?>",
                        "want": "searchHealper",
                        "search": ($scope.find == "skill") ? getchips() : $scope.searchtxt,
                        "find": $scope.find,
                        "json": true
                    }).done(function(response) {
                        var result = $.parseJSON(response);
                        if (result.status == "Fail") {
                            showError(result.msg);
                        }
                        $.each(result.found, function(index, value) {
                            value.Ulastonline = ($.timeago(value.Ulastonline) == "Online ago") ? (value.Ustatus == "Online") ? "Online Now" : "Online But Away" : "Last Online " + $.timeago(value.Ulastonline);
                        });
                        //alert(result.found.length);
                        $scope.result = result;
                    });
                };
            });

        </script>
    </head>
    <body ng-app="home" >
        <div class="parallax">
            <nav id="mainNav" style="border-radius:0px;margin-bottom: 50px;padding: 0px" class="navbar navbar-default  navbar-custom affix-top">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header page-scroll">
                        <button style="margin-top: 15px;border-color: #00365a" type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span><i style="" class="glyphicon glyphicon-menu-down"></i>
                        </button>
                        <a class="navbar-brand" href="index.php" style="padding: 5px;height: auto;"><h1 class="cusname" style="margin: 5px;color: #00365a">HELP</h1></a>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1" >
                        <ul class="nav navbar-nav navbar-right" style="margin: 7.5px -15px;">
                            <li class="hidden active">
                                <a href="#page-top"></a>
                            </li>
                            <li class="page-scroll">
                                <a href="?helpers">Helpers</a>
                            </li>
                            <li class="page-scroll" >
                                <?php if (isset($_SESSION['userdata'])) { ?>
                                <li class="dropdown" ng-controller="trans">
                                    <a href="#" style="font: 14px 'Lato', Arial;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        Profile 
                                        <i ng-show="User.Ustatus == 'Online'" class ="fa fa-user-circle-o" aria-hidden="true"></i>
                                        <i ng-show="User.Ustatus == 'Away'" class="fa fa-bell-slash" aria-hidden="true"></i>
                                        <i ng-show="User.Ustatus == 'Busy'" class="fa fa-plug" aria-hidden="true"></i>
                                        <i ng-show="User.Ustatus == 'Offline'" class="fa fa-user" aria-hidden="true"></i>
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">My Wallet : ${{result.Wallet}}</a></li>
                                        <li><a href="#">Transections Count : {{result.Count}}</a></li>
                                        <li><a href="#">Status : {{User.Ustatus}}</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li ng-show="User.Ustatus == 'Online'"><a href="?status=Offline">Go Offline <i class="fa fa-user" aria-hidden="true"></i></a></li>
                                        <li ng-show="User.Ustatus == 'Online'"><a href="?status=Away">Away For Site <i class="fa fa-bell-slash" aria-hidden="true"></i></a></li>
                                        <li ng-hide="User.Ustatus == 'Online'"><a href="?status=Online">Go Online <i class="fa fa-user-circle" aria-hidden="true"></i></a></li>
                                        <li><a href="?profile">Profile Info <br>And Transection <i class="fa fa-credit-card-alt" aria-hidden="true"></i></a></li>
                                    </ul>
                                </li>
                                <li class="page-scroll">  
                                    <a href="?logout" >Logout <i class="glyphicon glyphicon-log-out"></i></a>
                                <?php } else { ?>
                                    <a href="Login.php" >Sign in <i class="glyphicon glyphicon-log-in"></i></a>
                                <?php } ?>
                            </li>

                        </ul>
                    </div>
                </div>

            </nav>
            <div class="container">
                <div class="alert alert-danger" id="error"></div>
                <div class="dialogbox askcard" id="help" ng-controller="help" style="display:none;">
                    <div style="display: inline-block;width: 100%;">
                        <div  ng-show="result.type == 'accpted'">
                            <div class="well">
                                <div class="" style="display: inline-block;width: 100%"  >
                                    <div class="col-xs-7" style="display: inline-block;margin-right: 0px !important;padding-right: 0px;padding-left: 5px;"  >
                                        <h5 style="margin-top: 0px; margin-bottom: 5px;">{{result.data.Uname}} ({{result.data.Rate}})</h5>
                                        <h5 style="margin-top: 0px; margin-bottom: 5px;">Time : {{result.data.Timediv}}</h5>
                                        <h5 style="margin-top: 0px; margin-bottom: 5px;">Requested Hours {{result.data.Rlength}}</h5>
                                        <h5 style="margin-top: 0px; margin-bottom: 5px;">Rating : {{rating}}</h5>
                                        <div class="br-wrapper br-theme-fontawesome-stars">
                                            <select id="bar"> <!-- now hidden -->
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class=" col-xs-5" style="padding-right: 5px;">
                                        <div class="float-right">
                                            <a href="#" style="margin: 2px 0" class="simple " ng-click="addtime(1)">+1 Hour</a><br>
                                            <a href="#" style="margin: 2px 0" class="simple " ng-click="endit()">End Sessions</a>
                                        </div>
                                    </div>
                                </div>
                                <div id="chat-scroll" style="width: 100%;border: 1px solid black;padding:5px;height:200px;overflow-y: scroll;">
                                    <div ng-repeat="x in result.chat">{{x.Uname.split(" ")[0]}}:{{x.Ctxt}}<hr></div>
                                </div>
                                <div class="" style="display: inline-block;width: 100%;margin-top:10px"  >
                                    <input style="margin: 0px 0;width: 100%;padding: 4px 3px;" ng-keyup="runScript(this.value, $event)" type="text" name="username" class="simple" id="user" ng-model="chattxt" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div  ng-show="result.type == 'accpted me'">
                            <div class=" well">
                                <div class="" style="display: inline-block;width: 100%"  >
                                    <div class="col-xs-7" style="display: inline-block;margin-right: 0px !important;padding-right: 0px;padding-left: 5px;"  >
                                        <h5 style="margin-top: 0px; margin-bottom: 5px;">{{result.data.Uname}} ({{result.data.Rate}})</h5>
                                        <h5 style="margin-top: 0px; margin-bottom: 5px;">Time : {{result.data.Timediv}}</h5>
                                        <h5 style="margin-top: 0px; margin-bottom: 5px;">Requested Hours {{result.data.Rlength}}</h5>
                                    </div>
                                    <div class=" col-xs-5" style="padding-right: 5px;">
                                        <div class="float-right">
                                            <a href="#" style="margin: 2px 0" class="simple " ng-click="endit()">End Sessions</a>
                                        </div>
                                    </div>
                                </div>
                                <div id="chat-scroll1" style="width: 100%;border: 1px solid black;padding:5px;height:200px;overflow-y: scroll;">
                                    <div ng-repeat="x in result.chat">{{x.Uname.split(" ")[0]}}:{{x.Ctxt}}<hr></div>
                                </div>
                                <div class="" style="display: inline-block;width: 100%;margin-top:10px"  >
                                    <input style="margin: 0px 0;width: 100%;padding: 4px 3px;" ng-keyup="runScript(this.value, $event)" type="text" name="username" class="simple" id="user" ng-model="chattxt" autocomplete="off">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div  ng-show="result.type == 'from me'">
                        <figure class="snip1336" style="">
                            <img ng-src="<?php echo $hostname; ?>{{result.data.Ubgimage}}" alt="sample87" />
                            <b class="simple lastonline" >Requested Hours {{result.data.Rlength}}</b>
                            <figcaption>
                                <img ng-src="<?php echo $hostname; ?>{{result.data.Upic}}" width="64" alt="profile-sample4" class="profile" />
                                <h2>{{result.data.Uname}}({{result.data.Rate}})</h2>
                                <span>Waiting For The Answer</span>
                                <a href="#" style="width:100%" class="" ng-click="cancelit()">Cancel It</a>
                            </figcaption>
                        </figure>
                    </div>
                    <div  ng-show="result.type == 'to me'">
                        <figure class="snip1336" style="">
                            <img ng-src="<?php echo $hostname; ?>{{result.data.Ubgimage}}" alt="sample87" />
                            <b class="simple lastonline" >Requested Hours {{result.data.Rlength}}</b>
                            <figcaption>
                                <img ng-src="<?php echo $hostname; ?>{{result.data.Upic}}" width="64" alt="profile-sample4" class="profile" />
                                 <h2>{{result.data.Uname}}({{result.data.Rate}})</h2>
                                 <a href="#" style="width:100%" class="" ng-click="accpetit()">Accept The Help</a>
                                <a href="#" style="width:100%" class="" ng-click="cancelit()">Cancel It</a>
                            </figcaption>
                        </figure>
                    </div>
                </div>
            </div>
            <?php if (isset($_GET['helpers'])) { ?>
                <center ng-controller="search">
                    <h3 style="text-align:left;margin-bottom: 40px;width: 90%" class="box-h3">
                        Search
                        <div class="chips" id="searchbox" onclick="$('#searchtxt').focus();">
                            <div id="chiparea" style="display: inline;">
                            </div>
                            <input type="text" name="username" class="input" ng-keyup="runScript(this.value, $event)" id="searchtxt" ng-model="searchtxt" autocomplete="off" ng-change="searcharc()">
                        </div>
                        <br>
                        <p style="text-align:left">
                            Search By 
                            <input name="re" type="radio" ng-model="find" id="test3" value="skill"><label for="test3" ng-click="searcharc()"> Skills</label>
                            <input name="re" type="radio" ng-model="find" id="test1" checked="ture" value="job"><label for="test1" ng-click="searcharc()"> Job</label>
                            <input name="re" type="radio" ng-model="find" id="test2" value="name"><label for="test2" ng-click="searcharc()"> Name</label>
                        </p>
                    </h3>
                    <div class="row"  >
                        <div class="container" style="min-height: 548px;">
                            <?php if (isset($_SESSION['userdata'])) { ?> 
                                <div id='reqs' class="dialogbox" style="display:none">
                                    <div class="well">
                                        <div style="display: inline-block;width: 100%;">
                                            <h4 class="float-left ng-binding">Helper's Name : {{Suser.Uname}}</h4>
                                            <h4 class="float-right ng-binding">Per Hour Cost : ${{Suser.Uperhour}}</h4>
                                        </div>
                                        <hr>
                                        <h4 class="float-right ng-binding">Your Wallet : ${{wallet}}</h4>
                                        <div class="form-group" style="margin-bottom: 0px">
                                            <h4 for="email">Helping Time Period</h4>
                                            <input type="number" name="username" class="form-control simple" id="user" ng-model="time" autocomplete="off">
                                        </div>
                                        <h4 class="float-right ng-binding">Your Total Amount : ${{Suser.Uperhour * time}}</h4><br>
                                        <h4 class="float-right ng-binding">Your Balance : ${{wallet - (Suser.Uperhour * time)}}</h4><br>
                                        <div style="text-align: right">
                                            <input type="button" id="loginbtn" name="login" class="simple" value="Close" onClick="hideDialog('#reqs')">
                                            <input type="button" id="loginbtn" ng-show="(wallet - (Suser.Uperhour * time)) > 0 && time > 0" ng-click="sendrequest()" name="login" class="simple" value="Ask For Help">
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div id='reqs' class="dialogbox">
                                                     <div class="well row">
                                                         <center>
                                                             <h2 class="col-lg-5" style="margin-top: 45px;">Please Create A Account 
                                                                 </br> Or 
                                                                 </br> Sign Up 
                                                             </h2>
                                                             <form class="col-lg-7" style="border-left: 1px solid #00365a;text-align: left;" role="form" id="myform" action="backend.php" method="POST" novalidate="" >
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
                                                                         <input name="re" type="checkbox" id="tsdf"><label for="tsdf"> Remember me</label>
                                                                     </p>
                                                                 </div>
                                                                 <div style="text-align: right">
                                                                     <input type="submit" id="loginbtn" name="login" class="simple" value="Login">
                                                                 </div>
                                                             </form>
                                                         </center>
                                                     </div>
                                                 </div>
                                             <?php } ?>
                                             <div class="col-md-4" ng-repeat="x in result.found" >
                                                 <figure class="snip1336" >
                                                     <img ng-src="<?php echo $hostname; ?>{{x.Ubgimage}}" alt="sample87" />
                                                     <b class="simple lastonline" >{{x.Ulastonline}}</b>
                                                     <b class="simple perhour" >${{x.Uperhour}} Per Hour </b>
                                                     <figcaption>
                                                         <img ng-src="<?php echo $hostname; ?>{{x.Upic}}" width="64" alt="profile-sample4" class="profile" />
                                                     <h2>{{x.Uname}}({{x.Rate}})<span>{{x.Jname}}<br></span></h2>
                                                     <p>{{x.Udiscription}}</p>
                                                     <ul style="padding-left: 15px;">
                                                         <li ng-repeat="y in x.Skills">{{y.Sname}}</li>
                                                     </ul>
                                                     <a href="#" style="width:100%" class="" ng-show="x.Ulastonline == 'Online Now'" ng-click="showDialog('#reqs', x.UID)">Request</a>
                                                 </figcaption>
                                             </figure>

                            </div>
                        </div>
                    </div>
                </center>
            <?php } else if (isset($_SESSION['userdata']) && isset($_GET['profile'])) { ?>
                <div class="row"  >
                    <div class="container">
                        <div class="col-md-4" ng-controller="userinfo">
                            <figure class="snip1336">
                                <img ng-src="<?php echo $hostname; ?>{{User.Ubgimage}}" alt="sample87" />
                                <b class="simple lastonline" >{{User.Ulastonline}}</b>
                                <b class="simple perhour" >${{User.Uperhour}} Per Hour </b>
                                <figcaption>
                                    <img ng-src="<?php echo $hostname; ?>{{User.Upic}}" width="64" alt="profile-sample4" class="profile" />
                                    <h2>{{User.Uname}}({{User.Rate}})<span>{{User.Jname}}</span></h2>
                                    <p>{{User.Udiscription}}</p>
                                    <a href="#" style="width:100%" class="">Edit Profile</a>
                                </figcaption>
                            </figure>

                        </div>
                        <div class="col-md-8" ng-controller="trans">
                            <div class="well" style="">
                                <div style="display: inline-block;width: 100%;">
                                    <h4 class="float-left">My Wallet : ${{result.Wallet}}</h4>
                                    <h4 class="float-right">Transections Count : {{result.Count}}</h4> 
                                </div>
                                <hr style="animation: loader 2s;">
                                <h3 style="margin-top:20px;margin-bottom: 10px;color:#2980b9">My Transections</h3>
                                <table class="table table-responsive table-hover">
                                    <thead>
                                        <tr>
                                            <th>Transections ID</th>
                                            <th>Type</th>
                                            <th>User</th>
                                            <th>Transections Amount</th>
                                            <th>Transections Date</th>
                                            <th>Transections Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="x in result.trans| orderBy : '-Tdatetime'" >
                                            <td>{{x.TID}}</td>
                                            <td>{{x.Ttype}}</td>
                                            <td>{{x.Uname}}</td>
                                            <td>${{x.Tamount}}</td>
                                            <td>{{x.Tdatetime.split(" ")[0]}}</td>
                                            <td>{{x.Tdatetime.split(" ")[1]}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <center>
                    <h3 class="box-h3" style="padding:20px;margin: 10%"><?php echo randQuotes(); ?></h3>

                    </center>
                </div>
                <div class="txtarea" style="">
                    <p>
                        Volunteering your time, money, or energy to help others doesn’t just make the world better—it also makes you better. Studies indicate that the very act of giving back to the community boosts your happiness, health, and sense of well-being. Here are seven scientific benefits of lending a hand to those in need. 
                    </p>
                    <h3 style="text-align:center;" class="box-h3">
                        1. HELPING OTHERS CAN HELP YOU LIVE LONGER. 
                    </h3>
                    <p>
                        Want to extend your lifespan? Think about regularly assisting at a soup kitchen or coaching a basketball team at an at-risk high school. Research has shown that these kinds of activities can improve health in ways that can length your lifespan—volunteers show an improved ability to manage stress and stave off disease as well as reduced rates of depression and an increased sense of life satisfaction—when they were performed on a regular basis. This might be because volunteering alleviates loneliness and enhances our social lives—factors that can significantly affect our long-term health.  
                    </p>
                    <h3 style="text-align:center;" class="box-h3">
                        2. ALTRUISM IS CONTAGIOUS. 
                    </h3>
                    <p>
                        When one person performs a good deed, it causes a chain reaction of other altruistic acts. One study found that people are more likely to perform feats of generosity after observing another do the same. This effect can ripple throughout the community, inspiring dozens of individuals to make a difference.  
                    </p>
                    <h3 style="text-align:center;" class="box-h3">
                        3. HELPING OTHERS MAKES US HAPPY. 
                    </h3>
                    <p>
                        One team of sociologists tracked 2000 people over a five-year period and found that Americans who described themselves as “very happy” volunteered at least 5.8 hours per month. This heightened sense of well-being might be the byproduct of being more physically active as a result of volunteering, or because it makes us more socially active. Researchers also think that giving back might give individuals a mental boost by providing them with a neurochemical sense of reward. 
                    </p>
                    <h3 style="text-align:center;" class="box-h3">
                        4. HELPING OTHERS MAY HELP WITH CHRONIC PAIN. 
                    </h3>
                    <p>
                        According to one study, people who suffered from chronic pain tried working as peer volunteers. As a result, they experienced a reduction in their own symptoms. 
                    </p>
                    <h3 style="text-align:center;" class="box-h3">
                        5. HELPING OTHERS LOWERS BLOOD PRESSURE. 
                    </h3>
                    <p>
                        If you’re at risk for heart problems, your doctor has probably told you to cut back on red meat or the hours at your stressful job. However, you should also consider adding something to your routine: a regular volunteer schedule. One piece of research showed that older individuals who volunteered for at least 200 hours a year decreased their risk of hypertension by a whopping 40 percent. This could possibly be because they were provided with more social opportunities, which help relieve loneliness and the stress that often accompanies it.  
                    </p>
                    <h3 style="text-align:center;" class="box-h3">
                        6. HELPING OTHERS PROMOTES POSITIVE BEHAVIORS IN TEENS. 
                    </h3>
                    <p>
                        According to sociologists, teenagers who volunteer have better grades and self-image. 
                    </p>
                    <h3 style="text-align:center;" class="box-h3">
                        7. HELPING OTHERS GIVES US A SENSE OF PURPOSE AND SATISFACTION. 
                    </h3>
                    <p>
                        Looking for more meaning in your day-to-day existence? Studies show that volunteering enhances an individual’s overall sense of purpose and identity—particularly if they no longer hold a life-defining role like “worker” or “parent.” 
                    </p>
                </div>
                <div class="parallax1" style="padding: 5%">
                        <center>
                            <h3 style="text-align:center;margin-bottom: 40px" class="box-h3">
                                Top 3 Helpers
                            </h3>
                            <div class="row">
                                <div class="col-md-4" ng-controller="userinfo">
                                    <figure class="snip1336">
                                        <img ng-src="<?php echo $hostname; ?>{{User.Ubgimage}}" alt="sample87" />
                                        <b class="simple lastonline" >{{User.Ulastonline}}</b>
                                        <figcaption>
                                            <img ng-src="<?php echo $hostname; ?>{{User.Upic}}" width="64" alt="profile-sample4" class="profile" />
                                            <h2>{{User.Uname}}({{User.Urate}})<span>{{User.Jname}}</span></h2>
                                            <p>{{User.Udiscription}}</p>
                                        </figcaption>
                                    </figure>

                                </div>
                                <div class="col-md-4" ng-controller="userinfo">
                                    <figure class="snip1336">
                                        <img ng-src="<?php echo $hostname; ?>{{User.Ubgimage}}" alt="sample87" />
                                        <b class="simple lastonline" >{{User.Ulastonline}}</b>
                                        <figcaption>
                                            <img ng-src="<?php echo $hostname; ?>{{User.Upic}}" width="64" alt="profile-sample4" class="profile" />
                                            <h2>{{User.Uname}}({{User.Urate}})<span>{{User.Jname}}</span></h2>
                                            <p>{{User.Udiscription}}</p>
                                        </figcaption>
                                    </figure>

                                </div>
                                <div class="col-md-4" ng-controller="userinfo">
                                    <figure class="snip1336">
                                        <img ng-src="<?php echo $hostname; ?>{{User.Ubgimage}}" alt="sample87" />
                                        <b class="simple lastonline" >{{User.Ulastonline}}</b>
                                        <figcaption>
                                            <img ng-src="<?php echo $hostname; ?>{{User.Upic}}" width="64" alt="profile-sample4" class="profile" />
                                            <h2>{{User.Uname}}({{User.Urate}})<span>{{User.Jname}}</span></h2>
                                            <p>{{User.Udiscription}}</p>
                                        </figcaption>
                                    </figure>

                                </div>
                            </div>
                        </center>
                    <?php } ?>
                </div>
                <footer class="footer text-center fix">
                    <div class="footer-above">
                        <div class="container">
                            <div class="row">
                                <div class="footer-col col-md-4">
                                    <h3>Location(HeadOffice)</h3>
                                    <p>99A,Kirulapana Av
                                        <br>Colombo 05</p>
                                </div>
                                <div class="footer-col col-md-4">
                                    <h3>Around the Web</h3>
                                    <ul class="list-inline">
                                        <li>
                                            <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-facebook"></i></a>
                                        </li>
                                        <li>
                                            <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-google-plus"></i></a>
                                        </li>
                                        <li>
                                            <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-twitter"></i></a>
                                        </li>
                                        <li>
                                            <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-linkedin"></i></a>
                                        </li>
                                        <li>
                                            <a href="#" class="btn-social btn-outline"><i class="fa fa-fw fa-dribbble"></i></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="footer-col col-md-4">
                                    <h3>About Developer</h3>
                                    <p>Created By Thanura Nadun Ranasinghe.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="footer-below">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    Copyright © Help.IO 2017
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </body>    
        </html>
