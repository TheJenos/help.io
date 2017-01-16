<!DOCTYPE html>
<?php
include './config.php';
CookieLogin();
if (isset($_GET['logout'])) {
    session_destroy();
    setcookie('username', '', 0, "/");
    setcookie('userpass', '', 0, "/");
    header("Location: index.php");
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
                background: #141414;
                font: "Lato", sans-serif;
            }
            .cusname:after{
                content: ".IO";
                animation: blink-animation 1s infinite;
                -webkit-animation: blink-animation 1s infinite;
                animation-direction: alternate;
            }
            .well:hover{
                -webkit-animation: 0.5s draw linear forwards;
                animation: 0.5s draw linear forwards
            }
            .well{
                color: white;
                border: 0px; 
                background: #141414;
                /*box-shadow: 0px 0px 5px black;*/
                border-radius: 0px;
            }
            .parallax {
                /*padding-top: 50px;*/
            }
            .navbar-custom{
                /*background: linear-gradient(#141414, rgba(20, 20, 20, 0.51));*/
                background: #141414;
            }
            .parallax1 {
                background-image: url("images/18-comments-a-helping-hand-ETv8U8-clipart.jpg");
                /*height: 760px;*/ 
                padding-bottom: 100px;
                background-attachment: fixed;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;

            }
            .parallax {
                background-image: url("images/desktop-pozadia-themes-tapety-wallpaper-pictures-creative.jpg");
                /*height: 760px;*/ 
                padding-bottom: 100px;
                background-attachment: fixed;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
            }
            .snip1336 {
                font-family: 'Roboto', Arial, sans-serif;
                overflow: hidden;
                min-width: 230px;
                width: 100%;
                color: #ffffff;
                text-align: left;
                line-height: 1.4em;
                background-color: #141414;
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
                background-color: #141414;
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
                border-color: transparent transparent transparent #141414;
            }
            .snip1336 figcaption a {
                padding: 5px;
                border: 1px solid #ffffff;
                color: #ffffff;
                font-size: 0.7em;
                text-transform: uppercase;
                margin: 10px 0;
                display: inline-block;
                opacity: 0.65;
                width: 47%;
                text-align: center;
                text-decoration: none;
                font-weight: 600;
                letter-spacing: 1px;
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
                font-size: 0.8em;
                letter-spacing: 1px;
                opacity: 0.8;
            }
            .page-scroll a{
                font: 14px "Lato", sans-serif;
            }
            
            h1 {
                letter-spacing: 5px;
                text-transform: uppercase;
                font: 40px "Lato", sans-serif;
                color: #ffffff;
            }
            h2 {
                letter-spacing: 5px;
                text-transform: uppercase;
                font: 25px "Lato", sans-serif;
                color: #ffffff;
            }
            h3 {
                letter-spacing: 5px;
                text-transform: uppercase;
                font: 20px "Lato", sans-serif;
                color: #111;
            }
        </style>
        <script type="text/javascript">
            var app = angular.module("home", []);
            function showError($txt) {
                $('#error').fadeIn('fast');
                $('#error').html($txt);
                setTimeout(function() {
                    $('#error').fadeOut('fast');
                }, 2000);
            }
            $(function() {
                $('#error').hide();
            });
<?php if (isset($_SESSION['userdata'])) { ?>
                app.controller("userinfo", function($scope, $interval) {
                    var datas = '<?php echo json_encode($_SESSION['userdata']); ?>';
                    $scope.User = $.parseJSON(datas);
                    $interval(function() {
                        $.post("backend.php", {
                            "uname": "<?php echo $_SESSION['userdata']['Uemail']; ?>",
                            "upass": "<?php echo $_SESSION['userdata']['Upass']; ?>",
                            "userinfo": true,
                            "json": true
                        }).done(function(response) {
                            var result = $.parseJSON(response);
                            if (result.status == "Fail") {
                                showError(result.msg);
                            }
                            $scope.User = result.user;
                        });
                    }, 5000);
                });
<?php } ?>
        </script>
    </head>
    <body ng-app="home" >

        <div class="parallax">
            <nav id="mainNav" style="border-radius:0px;margin-bottom: 50px;" class="navbar navbar-default  navbar-custom affix-top">
                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header page-scroll">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span><i class="glyphicon glyphicon-menu-down"></i>
                        </button>
                        <a class="navbar-brand" href="index.php" style="padding: 0px;"><h1 class="cusname" style="margin: 5px;color: white">Help</h1></a>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="hidden active">
                                <a href="#page-top"></a>
                            </li>
                            <li class="page-scroll">
                                <a href="#about">Phones</a>
                            </li>
                            <li class="page-scroll">
                                <a href="#contact">News</a>
                            </li>
                            <li class="page-scroll">
                                <?php if (isset($_SESSION['userdata'])) { ?>
                                    <a href="?logout" >Logout <i class="glyphicon glyphicon-log-out"></i></a>
                                <?php } else { ?>
                                    <a href="Login.php" >Sign in <i class="glyphicon glyphicon-log-in"></i></a>
                                <?php } ?>
                            </li>
                        </ul>
                    </div>
                </div>

            </nav>
            <div class="row"  >
                <div class="container">
                    <?php if (isset($_SESSION['userdata'])) { ?>
                        <div class="col-md-4" ng-controller="userinfo">
                            <figure class="snip1336">
                                <img ng-src="<?php echo $hostname; ?>{{User.Ubgimage}}" alt="sample87" />
                                <figcaption>
                                    <img ng-src="<?php echo $hostname; ?>{{User.Upic}}" width="64" alt="profile-sample4" class="profile" />
                                    <h2>{{User.Uname}}<span>{{User.Jname}}</span></h2>
                                    <p>{{User.Udiscription}}</p>
                                    <a href="#" style="width:100%" class="">Edit Profile</a>
                                </figcaption>
                            </figure>

                        </div>
                    <?php } ?>
                    <div class="col-md-<?php echo isset($_SESSION['userdata']) ? "8" : "12" ?>">
                        <div class="alert alert-danger" id="error"></div>
                        <div class="well" style="">
                            dfsdf
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="color: #777;background-color:white;text-align:center;padding:50px 80px;text-align: justify;">
            <h3 style="text-align:center;">Parallax Demo</h3>
            <p>Parallax scrolling is a web site trend where the background content is moved at a different speed than the foreground content while scrolling. Nascetur per nec posuere turpis, lectus nec libero turpis nunc at, sed posuere mollis ullamcorper libero ante lectus, blandit pellentesque a, magna turpis est sapien duis blandit dignissim. Viverra interdum mi magna mi, morbi sociis. Condimentum dui ipsum consequat morbi, curabitur aliquam pede, nullam vitae eu placerat eget et vehicula. Varius quisque non molestie dolor, nunc nisl dapibus vestibulum at, sodales tincidunt mauris ullamcorper, dapibus pulvinar, in in neque risus odio. Accumsan fringilla vulputate at quibusdam sociis eleifend, aenean maecenas vulputate, non id vehicula lorem mattis, ratione interdum sociis ornare. Suscipit proin magna cras vel, non sit platea sit, maecenas ante augue etiam maecenas, porta porttitor placerat leo.</p>
        </div>
        <div class="parallax1">

        </div>
    </body>    
</html>
