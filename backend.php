<?php

include './config.php';
$json = array();
$myprofile;

//====================Funtion==================//
function exitWithPrint() {
    logit(json_encode($GLOBALS['json']));
    die(json_encode($GLOBALS['json']));
}

function fail($msg) {
    $json = $GLOBALS['json'];
    $json['status'] = "Fail";
    $json['msg'] = $msg;
    $GLOBALS['json'] = $json;
    exitWithPrint();
}

function userinfo() {
    $user = array();
    $data = SearchARow("`user` NATURAL JOIN `jobs`", array('*'), "Uemail='" . antisqli($_SESSION['userdata']['Uemail']) . "' ");
    $user = $data;
    $user['Upass'] = myencyption($data['Upass']);
    $GLOBALS['json']['user'] = $user;
}
function transinfo(){
    $from = SearchARows("`transaction` JOIN `user` ON `transaction`.`Tto`=`user`.`UID` ", array('TID','Tamount','Tto','Uname','Tdatetime',"'Outcome' as `Ttype`"), "Tfrom='".antisqli($GLOBALS['myprofile']['UID'])."'");
    $to = SearchARows("`transaction` JOIN `user` ON `transaction`.`Tfrom`=`user`.`UID` ", array('TID','Tamount','Tfrom','Uname','Tdatetime',"'Income' as `Ttype`"), "Tto='".antisqli($GLOBALS['myprofile']['UID'])."'");
    $GLOBALS['json']['Tfrom']=$from;
    $GLOBALS['json']['Tto']=$to;
}
//=====================RUN=====================//
if (isset($_POST['json'])) {
    if (!isset($_POST['uname'])) {
        fail("Username Missing");
    }
    if (!isset($_POST['upass'])) {
        fail("Password Missing");
    }
    $data = SearchARow("user", array('*'), "Uemail='" . antisqli($_POST['uname']) . "' ");
    if (!isset($data)) {
        fail("Invalid Username");
    }
    if ($data['Upass'] == $_POST['upass'] || myencyption($data['Upass']) == $_POST['upass']) {
        $json['status'] = "Success";
        if (isset($_POST['want'])) {
            $myprofile = $data;
            call_user_func($_POST['want']);
        }
        exitWithPrint();
    } else {
        fail("Invalid Password");
    }
}

//====================DerectLoging===========================================//
if (isset($_POST['username'])) {
    $data = SearchARow("`user` NATURAL JOIN `jobs`", array('*'), " Uemail='" . antisqli($_POST['username']) . "' ");
    if (!isset($data)) {
        logit(mysqli_error($con));
        header("Location: Login.php");
    }
    if ($_POST['pass'] == $data['Upass']) {
        $user = $data;
        $user['Upass'] = myencyption($data['Upass']);
        $_SESSION['userdata'] = $user;
        if (isset($_POST['re'])) {
            setcookie('username', $_SESSION['userdata']['Uemail'], time() + 60 * 60 * 24 * 14, "/");
            setcookie('userpass', $_SESSION['userdata']['Upass'], time() + 60 * 60 * 24 * 14, "/");
        }
        header("Location: index.php");
    }
}



