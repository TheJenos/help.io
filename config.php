<?php

$hostname = './';
$host = 'localhost:3306';
$root = 'root';
$pass = '';
$database = 'help_io';
$logfile = 'log.txt';
$key = hex2bin('000102030405060708090a0b0c0d0e0f101112131415161718191a1b1c1d1e1f');
$con = mysqli_connect($host, $root, $pass, $database);
if (!$con) {
    logit("Connection Error");
}
error_reporting(E_ALL ^ E_WARNING);
session_start();
$bgimages = array();
if ($handle = opendir('images/bg/')) {
    while (false !== ($entry = readdir($handle))) {
        if ($entry != "." && $entry != "..") {
            array_push($bgimages, $entry);
        }
    }
    closedir($handle);
}
$quotes = array(
    "“The purpose of life is not to be happy. It is to be useful, to be honorable, to be compassionate, to have it make some difference that you have lived and lived well.”</br>― Ralph Waldo Emerson",
    "“No one has ever become poor by giving.”<br>― Anne Frank, diary of Anne Frank: the play",
    "“No one is useless in this world who lightens the burdens of another.”<br>― Charles Dickens",
    "“When we give cheerfully and accept gratefully, everyone is blessed.” <br>― Maya Angelou",
    "“You have not lived today until you have done something for someone who can never repay you.” <br>― John Bunyan",
    "“He has a right to criticize, who has a heart to help.” <br>― Abraham Lincoln",
    );
//======================funtions===============================//
function logit($param) {
    $newtxt = file_get_contents('logs/'.date("Y-m-d").$GLOBALS['logfile']) . "\n" . $param;
    file_put_contents('logs/'.date("Y-m-d").$GLOBALS['logfile'], $newtxt);
}
function mylogit($param) {
    $newtxt = file_get_contents('logs/'.date("Y-m-d")."Mylog.txt") . "\n" . $param;
    file_put_contents('logs/'.date("Y-m-d")."Mylog.txt", $newtxt);
}

function hostname() {
    echo $hostname;
}

function debug($txt) {
    echo '<h1>' . $txt . '</h1>';
}

function myencyption($txt) {
    return crypt($txt, '$1$rasmusle$');
}

function randImages() {
    if(count($GLOBALS['bgimages'])>0) {
        $randval = rand(0, count($GLOBALS['bgimages']) - 1);
        $val = $GLOBALS['bgimages'][$randval];
        array_splice($GLOBALS['bgimages'], $randval, 1);
        return $val;
    } else {
        return FALSE;
    }
}
function randQuotes() {
    if(count($GLOBALS['quotes'])>0) {
        $randval = rand(0, count($GLOBALS['quotes']) - 1);
        $val = $GLOBALS['quotes'][$randval];
        array_splice($GLOBALS['quotes'], $randval, 1);
        return $val;
    } else {
        return FALSE;
    }
}

//=============================validations==========================//
function validateNIC($nic) {
    $final = TRUE;
    if (strlen($nic) == 10) {
        if (!(substr($nic, strlen($nic) - 1, 1) == "v" || substr($nic, strlen($nic) - 1, 1) == "V")) {
            $final = FALSE;
        }
    } else if (strlen($nic) == 12) {
        $final = TRUE;
    } else {
        $final = FALSE;
    }
    return $final;
}

function validateLenth($txt, $len) {
    return strlen($txt) > 1 && strlen($txt) <= $len;
}

//============================Imports===============================//
function links() {
    echo file_get_contents("imports.php");
}

//===========================Login With Cookie===============================//
function CookieLogin() {
    if (isset($_COOKIE['username'])) {
        $data = SearchARow("`user` NATURAL JOIN `jobs`", array('*','(Urate/Uratetime) AS `Rate`'), " Uemail='" . antisqli($_COOKIE['username']) . "' ");
        if (!isset($data)) {
            session_destroy();
        }
        if ($_COOKIE['userpass'] == myencyption($data['Upass'])) {
            $user = $data;
            $user['Upass'] = myencyption($data['Upass']);
            $_SESSION['userdata'] = $user;
            setcookie('username', $_SESSION['userdata']['Uemail'], time() + 60 * 60 * 24 * 14, "/");
            setcookie('userpass', $_SESSION['userdata']['Upass'], time() + 60 * 60 * 24 * 14, "/");
            logit("Cookie Login Pass " . $_COOKIE['username']);
        } else {
            logit("Cookie Login Fail " . $_COOKIE['username']);
        }
    }
}

//=========================================DBMS=======================//
function antisqli($param) {
    return str_replace("'", "''", $param);
}

function Insert($table, $data) {
    $conn = $GLOBALS['con'];
    $cols = "(";
    $rows = "(";
    foreach ($data as $key => $value) {
        $cols .= '`' . $key . '`,';
        $rows .= "'" . antisqli($value) . "',";
    }
    $cols = substr($cols, 0, strlen($cols) - 1);
    $rows = substr($rows, 0, strlen($rows) - 1);
    $cols .= ")";
    $rows .= ")";
    $query = "INSERT INTO $table $cols VALUES $rows";
    logit($query);
    return mysqli_query($conn, $query);
}

function excquery($query){
    $conn = $GLOBALS['con'];
    logit($query);
    return mysqli_query($conn, $query);
}

function Update($table, $data, $where) {
    $conn = $GLOBALS['con'];
    $cols = "";
    foreach ($data as $key => $value) {
        $value = ($value=="CURRENT_TIMESTAMP")?"CURRENT_TIMESTAMP":("'".antisqli($value)."'");
        $cols .= '`' . $key . "`=".$value.",";
    }
    $cols = substr($cols, 0, strlen($cols) - 1);
    $query = "UPDATE $table SET $cols WHERE $where";
    logit($query);
    return mysqli_query($conn, $query);
}

function Delete($table, $where) {
    $conn = $GLOBALS['con'];
    $query = "DELETE FROM $table WHERE $where";
    logit($query);
    return mysqli_query($conn, $query);
}

function mySearchARow($table, $rows, $where) {
    $con = $GLOBALS['con'];
    $cols = "";
    foreach ($rows as $key => $value) {
        $cols .= "$value,";
    }
    $cols = substr($cols, 0, strlen($cols) - 1);
    $query = "SELECT " . $cols . " FROM $table WHERE $where";
    $result = mysqli_query($con, $query);
    mylogit($query);
    if (mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
}
function SearchARow($table, $rows, $where) {
    $con = $GLOBALS['con'];
    $cols = "";
    foreach ($rows as $key => $value) {
        $cols .= "$value,";
    }
    $cols = substr($cols, 0, strlen($cols) - 1);
    $query = "SELECT " . $cols . " FROM $table WHERE $where";
    $result = mysqli_query($con, $query);
    logit($query);
    if (mysqli_num_rows($result) > 0) {
        return mysqli_fetch_assoc($result);
    }
}
function SearchARows($table, $rows, $where) {
    $con = $GLOBALS['con'];
    $cols = "";
    foreach ($rows as $key => $value) {
        $cols .= "$value,";
    }
    $cols = substr($cols, 0, strlen($cols) - 1);
    $query = "SELECT " . $cols . " FROM $table WHERE $where";
    logit($query);
    $result = mysqli_query($con, $query);
    $datalines = array();
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($datalines, $row);
    }
    return $datalines;
}

function SearchToItems($table, $rows, $where, $pattern, $id) {
    $con = $GLOBALS['con'];
    $cols = "";
    foreach ($rows as $key => $value) {
        $cols .= "$value,";
    }
    $cols = substr($cols, 0, strlen($cols) - 1);
    $query = "SELECT " . $cols . " FROM $table WHERE $where";
    $result = mysqli_query($con, $query);
    logit($query);
    if (mysqli_num_rows($result) > 0) {
        while ($rowss = mysqli_fetch_assoc($result)) {
            $txt = $pattern;
            for ($index = 0; $index < count($id); $index++) {
                $txt = str_replace("data-$index", $rowss[$id[$index]], $txt);
            }
            echo $txt;
        }
    }
}

function SearchToTable($table, $rows, $where, $id, $removebtn, $updatebtn) {
    $con = $GLOBALS['con'];
    $cols = "";
    $ths = "";
    $tr = "<tr>";
    foreach ($rows as $key => $value) {
        $cols .= "$key,";
        $ths .= "<th>$value</th>";
    }
    $tr .= "$ths";
    if (isset($updatebtn)) {
        $tr .= "<th>Update</th>";
    }
    if (isset($removebtn)) {
        $tr .= "<th>Remove</th>";
    }
    $tr .= "</tr>";
    $cols = substr($cols, 0, strlen($cols) - 1);
    $query = "SELECT " . $cols . " FROM $table WHERE $where";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($rowss = mysqli_fetch_assoc($result)) {
            $tds = "";
            foreach ($rows as $key => $value) {
                $tds .= "<td>" . $rowss[$key] . "</td>";
            }
            if (isset($updatebtn)) {
                $tds .= "<td>" . str_replace("did", $rowss[$id], $updatebtn) . "</td>";
            }
            if (isset($removebtn)) {
                $tds .= "<td>" . str_replace("did", $rowss[$id], $removebtn) . "</td>";
            }
            $tr .= "<tr>$tds</tr>";
        }
    }
    logit($query);
    echo $tr;
}
