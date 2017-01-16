<?php

$hostname = 'http://localhost/help.io/';
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
//======================funtions===============================//
function logit($param) {
    $newtxt = file_get_contents($GLOBALS['logfile']) . "\n" . $param;
    file_put_contents($GLOBALS['logfile'], $newtxt);
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
        $data = SearchARow("`user` NATURAL JOIN `jobs`", array('*'), " Uemail='" . antisqli($_COOKIE['username']) . "' ");
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

function Update($table, $data, $where) {
    $conn = $GLOBALS['con'];
    $cols = "";
    foreach ($data as $key => $value) {
        $cols .= '`' . $key . "`='" . antisqli($value) . "',";
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

