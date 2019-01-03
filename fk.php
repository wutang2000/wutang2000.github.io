<?php
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    include("db_connect.php");
    include("config.php");
    
    function fuck_sql_hackers($text) {
        global $connection;
        return mysqli_real_escape_string($connection, $text);
    }
    date_default_timezone_set("Europe/Moscow");
    
    function getIP() {
        if(isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
        return $_SERVER['REMOTE_ADDR'];
        }
        if (!in_array(getIP(), array('136.243.38.147', '136.243.38.149', '136.243.38.150', '136.243.38.151', '136.243.38.189', '88.198.88.98'))) {
        die("hacking attempt!");
        mysqli_close($connection);
    }
    
   
    
    $merchant_secret = "4hwyui1b";
    $merchant_id = "73982";
    $uid = $_REQUEST['us_uid'];
    
    $sign = md5($merchant_id.':'.$_REQUEST['AMOUNT'].':'.$merchant_secret.':'.$_REQUEST['MERCHANT_ORDER_ID']);
    if ($sign != $_REQUEST['SIGN']) {
        mysqli_close($connection);
        die('wrong sign');
    }
    
    #check user
    $result = mysqli_query($connection, "SELECT * FROM `rvuti_users` WHERE `id` = '".fuck_sql_hackers($uid)."'");
    $row = mysqli_fetch_array($result);
    $balance = $row['balance'];
    $referer = $row['referer'];
    mysqli_free_result($result);
    
    #log
    $date = date('d.m.Y H:i:s');
    $result = mysqli_query($connection, "INSERT INTO `rvuti_payments`(`id`, `user_id`, `suma`, `data`) VALUES ('".fuck_sql_hackers($_REQUEST['MERCHANT_ORDER_ID'])."', '".fuck_sql_hackers($_REQUEST['us_uid'])."', '".fuck_sql_hackers($_REQUEST['AMOUNT'])."', '$date')");
    if(!$result) {
        echo mysqli_error($connection);
    }
    #update balance
    # $paybonus
    $newbalance = $balance + ($_REQUEST['AMOUNT']);
    $result = mysqli_query($connection, "UPDATE `rvuti_users` SET `balance` = '$newbalance' WHERE `rvuti_users`.`id` = '".fuck_sql_hackers($uid)."'");
    $row = mysqli_fetch_array($result);
    
    #refer
    $result = mysqli_query($connection, "SELECT * FROM `rvuti_users` WHERE `id` = '".fuck_sql_hackers($referer)."'");
    $row = mysqli_fetch_array($result);
    $refold = $row['balance'];
    
    
    if($row) { 
        $refback = (10 * $_REQUEST['AMOUNT']) / 100;
        $refnew = $refold + $refback;
        $result = mysqli_query($connection, "UPDATE `rvuti_users` SET `balance` = '$refnew' WHERE `rvuti_users`.`id` = '".fuck_sql_hackers($referer)."'");
    }
    
    #mysqli_free_result($result)
    
    
    
    #test
    #$result = mysqli_query($connection, "INSERT INTO `rvuti_payments`(`id`, `user_id`, `suma`, `data`, 'qiwi', 'transaction') VALUES ('100200300', '1', '1', '1', '1', '1')");
    #$row = mysqli_fetch_array($result);
    
    mysqli_free_result($result);
    mysqli_close($connection);
     die('YES');