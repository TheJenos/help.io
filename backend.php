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

function requestforhealp() {
    $data = array('Ustatus' => "Busy");
    Update("`user`", $data, "UID='" . antisqli($GLOBALS['myprofile']['UID']) . "'");
    Update("`user`", $data, "UID='" . antisqli($_POST['who']) . "'");
    $resquest = array(
        "Rfrom" => $GLOBALS['myprofile']['UID'],
        "Rto" => $_POST['who'],
        "Rlength" => $_POST['time'],
    );
    Insert("helprequest", $resquest);
}

function updatepro(){
    $data = $_POST['user'];
    Update("`user`", $data, "UID='" . antisqli($GLOBALS['myprofile']['UID']) . "'");
}

function cancelrequest() {
    $data = array('Ranswer' => "Cancel");
    Update("`helprequest`", $data, "RID='" . antisqli($_POST['id']) . "'");
}

function endit() {
    $data = array('Ranswer' => "Ended");
    Update("`helprequest`", $data, "RID='" . antisqli($_POST['id']) . "'");
    $row = SearchARow("`helprequest`", array('*'), "RID='" . antisqli($_POST['id']) . "'");
    $to = SearchARow("`user`", array('*'), "UID='" . antisqli($row['Rto']) . "'");
    $data1 = array(
        'Uratetime' => $to['Uratetime'] + 1,
        'Urate' => $to['Urate'] + $_POST['rate']
    );
    Update("`user`", $data1, "UID='" . antisqli($to['UID']) . "'");
}

function addtime() {
    $row = SearchARow("`helprequest`", array('*'), "RID='" . antisqli($_POST['id']) . "'");
    $to = SearchARow("`user`", array('Uperhour'), "UID='" . antisqli($row['Rto']) . "'");
    $data = array('Rlength' => $row['Rlength'] + $_POST['time']);
    $cac = $_POST['time'] * $to['Uperhour'];
    $resquest = array(
        "Tfrom" => $row['Rfrom'],
        "Tto" => $row['Rto'],
        "Tamount" => $cac,
    );
    Insert("transaction", $resquest);
    Update("`helprequest`", $data, "RID='" . antisqli($_POST['id']) . "'");
}

function chat() {
    if (strlen($_POST['msg']) > 0) {
        $resquest = array(
            "UID" => $GLOBALS['myprofile']['UID'],
            "RID" => $_POST['id'],
            "Ctxt" => $_POST['msg']
        );
        Insert("chats", $resquest);
    }
}

function accpetrequest() {
    $data = array('Ranswer' => "Accepted", 'Rstarttime' => "CURRENT_TIMESTAMP");
    Update("`helprequest`", $data, "RID='" . antisqli($_POST['id']) . "'");
    $row = SearchARow("`helprequest`", array('*'), "RID='" . antisqli($_POST['id']) . "'");
    $to = SearchARow("`user`", array('Uperhour'), "UID='" . antisqli($row['Rto']) . "'");
    $cac = $row['Rlength'] * $to['Uperhour'];
    $resquest = array(
        "Tfrom" => $row['Rfrom'],
        "Tto" => $row['Rto'],
        "Tamount" => $cac,
    );
    Insert("transaction", $resquest);
}

function gethelp() {
    $sql = "DELETE FROM `helprequest` WHERE SUBTIME(NOW(),'0:05:00') > `Rdatetime` AND `Ranswer`='Waiting'";
    excquery($sql);
    $gethelpto = SearchARow("`helprequest` JOIN `user` ON `helprequest`.`Rfrom` = `user`.`UID`", array('RID', 'Rfrom', 'Rlength', 'Rdatetime', 'Ranswer', 'Rstarttime', 'UID', 'Uname', 'Upic', 'Ubgimage', 'Uperhour', '(Urate/Uratetime) AS `Rate`'), "`Rto`='" . antisqli($GLOBALS['myprofile']['UID']) . "' AND `Rdatetime` > SUBTIME(NOW(),'0:05:00') AND `Ranswer`='Waiting' ORDER BY `Rdatetime` DESC");
    $getaccptto = SearchARow("`helprequest` JOIN `user` ON `helprequest`.`Rfrom` = `user`.`UID`", array('RID', 'Rfrom', 'Rlength', 'Rdatetime', 'Ranswer', 'Rstarttime', 'UID', 'Uname', 'Upic', 'Ubgimage', 'Uperhour', '(Urate/Uratetime) AS `Rate`', 'TIMEDIFF(now(),`Rstarttime`) AS `Timediv`'), "`Rto`='" . antisqli($GLOBALS['myprofile']['UID']) . "' AND `Ranswer`='Accepted' ORDER BY `Rdatetime` DESC");
    $gethelpfrom = SearchARow("`helprequest` JOIN `user` ON `helprequest`.`Rto` = `user`.`UID` ", array('RID', 'Rto', 'Rlength', 'Rdatetime', 'Ranswer', 'Rstarttime', 'UID', 'Uname', 'Upic', 'Ubgimage', 'Uperhour', '(Urate/Uratetime) AS `Rate`'), "`Rfrom`='" . antisqli($GLOBALS['myprofile']['UID']) . "' AND `Rdatetime` > SUBTIME(NOW(),'0:05:00') AND `Ranswer`='Waiting' ORDER BY `Rdatetime` DESC");
    $getaccptfrom = SearchARow("`helprequest` JOIN `user` ON `helprequest`.`Rto` = `user`.`UID` ", array('RID', 'Rto', 'Rlength', 'Rdatetime', 'Ranswer', 'Rstarttime', 'UID', 'Uname', 'Upic', 'Ubgimage', 'Uperhour', '(Urate/Uratetime) AS `Rate`', 'TIMEDIFF(now(),`Rstarttime`) AS `Timediv`'), "`Rfrom`='" . antisqli($GLOBALS['myprofile']['UID']) . "' AND `Ranswer`='Accepted' ORDER BY `Rdatetime` DESC");
    $data = null;
    if (isset($gethelpto)) {
        $GLOBALS['json']['type'] = "to me";
        $data = $gethelpto;
    } else if (isset($gethelpfrom)) {
        $GLOBALS['json']['type'] = "from me";
        $data = $gethelpfrom;
    } else if (isset($getaccptto)) {
        $data = $getaccptto;
        $GLOBALS['json']['type'] = "accpted me";
        $GLOBALS['json']['chat'] = SearchARows("`chats` NATURAL JOIN `user`", array('*'), "`RID`='" . $getaccptto['RID'] . "'");
    } else if (isset($getaccptfrom)) {
        $data = $getaccptfrom;
        $GLOBALS['json']['type'] = "accpted";
        $GLOBALS['json']['chat'] = SearchARows("`chats` NATURAL JOIN `user`", array('*'), "`RID`='" . $getaccptfrom['RID'] . "'");
    } else {
        $data1 = array('Ustatus' => "Online");
        Update("`user`", $data1, "UID='" . antisqli($GLOBALS['myprofile']['UID']) . "'");
        fail("no");
    }
    $GLOBALS['json']['data'] = $data;
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
                $skilldata = array();
                $skilldata = SearchARows("`skills_of_user` NATURAL JOIN `skills`", array('*'), "`UID`='" . antisqli($result[$index]['UID']) . "'");
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
    if ($_POST['uname'] == "tmp" && $_POST['upass'] == "tmp") {
        if (isset($_POST['search'])) {
            $myprofile = array("UID" => "tmp");
            searchHealper();
        }
        exitWithPrint();
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



