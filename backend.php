<?php

include './config.php';
$json = array();

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
    $data = SearchARow("user", array('*'), "Uemail='" . antisqli($_SESSION['userdata']['Uemail']) . "' ");
    $user['Uname'] = $data['Uname'];
    $user['UID'] = $data['UID'];
    $user['Upass'] = myencyption($data['Upass']);
    $user['Uemail'] = $data['Uemail'];
    $user['Ugen'] = $data['Ugen'];
    $user['Ubdate'] = $data['Ubdate'];
    $user['Upic'] = $data['Upic'];
    $GLOBALS['json']['user'] = $user;
}

//=====================RUN=====================//
if (isset($_POST['json'])) {
    if (!isset($_POST['uname'])) {
        fail("Username Missing");
    }
    if (!isset($_POST['upass'])) {
        fail("Password Missing");
    }
    $data = SearchARow("user", array('UID', 'Uname', 'Upass'), "Uemail='" . antisqli($_POST['uname']) . "' ");
    if (!isset($data)) {
        fail("Invalid Username");
    }
    if ($data['Upass'] == $_POST['upass'] || myencyption($data['Upass']) == $_POST['upass']) {
        $json['status'] = "Success";
        if (isset($_POST['userinfo'])) {
            userinfo();
        }
        exitWithPrint();
    } else {
        fail("Invalid Password");
    }
}

//====================DerectLoging===========================================//
if (isset($_POST['username'])) {
    $data = SearchARow("user", array('*'), " Uemail='" . antisqli($_POST['username']) . "' ");
    if (!isset($data)) {
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
        header("Location: Index.php");
    }
}



