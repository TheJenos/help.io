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
    $data = SearchARow("`user` NATURAL JOIN `jobs`", array('*', '(Urate/Uratetime) AS `Rate`'), "Uemail='" . antisqli($_SESSION['userdata']['Uemail']) . "' ");
    $user = $data;
    $user['Upass'] = myencyption($data['Upass']);
    $GLOBALS['json']['user'] = $user;
}

function transinfo() {
    $from = SearchARows("`transaction` JOIN `user` ON `transaction`.`Tto`=`user`.`UID` ", array('TID', 'Tamount', 'Tto', 'Uname', 'Tdatetime', "'Outcome' as `Ttype`"), "Tfrom='" . antisqli($GLOBALS['myprofile']['UID']) . "'");
    $to = SearchARows("`transaction` JOIN `user` ON `transaction`.`Tfrom`=`user`.`UID` ", array('TID', 'Tamount', 'Tfrom', 'Uname', 'Tdatetime', "'Income' as `Ttype`"), "Tto='" . antisqli($GLOBALS['myprofile']['UID']) . "'");
    $GLOBALS['json']['Tfrom'] = $from;
    $GLOBALS['json']['Tto'] = $to;
}

function online() {
    if ($GLOBALS['myprofile']['Ustatus'] == "Online" || $GLOBALS['myprofile']['Ustatus'] == "Away") {
        $data = array('Ulastonline' => "CURRENT_TIMESTAMP");
        Update("`user`", $data, "UID='" . antisqli($GLOBALS['myprofile']['UID']) . "'");
    }
}

function requestforhealp(){
    $resquest= array(
        
    );
    Insert("helprequest", $resquest);
}

function searchHealper() {
    if (isset($_POST['search']) && $_POST['search'] != "") {
        if ($_POST['find'] == "job") {
            $result = SearchARows("`user` NATURAL JOIN `jobs` ", array('*', '(Urate/Uratetime) AS `Rate`'), " `UID`!='" . antisqli($GLOBALS['myprofile']['UID']) . "' AND `Jname` LIKE '" . antisqli($_POST['search']) . "%' AND `Ustatus` IN ('Online','Away') ORDER BY `Rate`,`Ulastonline` DESC LIMIT 10");
        } else if ($_POST['find'] == "skill") {
            $data = explode(",", $_POST['search']);
            $where = "";
            foreach ($data as $value) {
                $where .= "'$value',";
            }
            $where = substr($where, 0, strlen($where) - 1);
            $result = SearchARows("`skills_of_user` NATURAL JOIN `user` NATURAL JOIN `skills` NATURAL JOIN `jobs`", array('*', '(Urate/Uratetime) AS `Rate`'), " `UID`!='" . antisqli($GLOBALS['myprofile']['UID']) . "' AND `Sname` IN ($where) AND `Ustatus` IN ('Online','Away') GROUP BY `UID` ORDER BY `Rate`,`Ulastonline` DESC LIMIT 10");
            for ($index = 0; $index < count($result); $index++) {
                $skilldata = SearchARows("`skills_of_user` NATURAL JOIN `skills`", array('*'), "`UID`='" + antisqli($result[$index]['UID']) + "'");
                $result[$index]['Udiscription'] = "";
                $result[$index]['Skills'] = $skilldata;
            }
        } else {
            $result = SearchARows("`user` NATURAL JOIN `jobs` ", array('*', '(Urate/Uratetime) AS `Rate`'), " `UID`!='" . antisqli($GLOBALS['myprofile']['UID']) . "' AND `Uname` LIKE '" . antisqli($_POST['search']) . "%' AND `Ustatus` IN ('Online','Away') ORDER BY `Rate`,`Ulastonline` DESC LIMIT 10");
        }
        $GLOBALS['json']['found'] = $result;
    }
}

//=====================RUN=====================//
if (isset($_POST['json'])) {
    if (!isset($_POST['uname'])) {
        fail("Username Missing");
    }
    if (!isset($_POST['upass'])) {
        fail("Password Missing");
    }
    $data = SearchARow("user", array('*', '(Urate/Uratetime) AS `Rate`'), "Uemail='" . antisqli($_POST['uname']) . "' ");
    if (!isset($data)) {
        fail("Invalid Username");
    }
    if ($data['Upass'] == $_POST['upass'] || myencyption($data['Upass']) == $_POST['upass']) {
        $json['status'] = "Success";
        $myprofile = $data;
        online();
        if (isset($_POST['want'])) {
            call_user_func($_POST['want']);
        }
        exitWithPrint();
    } else {
        fail("Invalid Password");
    }
}
//====================DerectLoging===========================================//
if (isset($_POST['username'])) {
    $data = SearchARow("`user` NATURAL JOIN `jobs`", array('*', '(Urate/Uratetime) AS `Rate`'), " Uemail='" . antisqli($_POST['username']) . "' ");
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



