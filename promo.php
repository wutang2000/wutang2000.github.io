<?php
    #ini_set('error_reporting', E_ALL);
    #ini_set('display_errors', 1);
    #ini_set('display_startup_errors', 1);
    include("db_connect.php");
    include("config.php");
    
    function fuck_sql_hackers($text) {
        global $connection;
        return mysqli_real_escape_string($connection, $text);
    }
    header("Content-Type: text/html; charset=utf-8");

    
    $sid = $_COOKIE['sid'];
    $code = $_POST['code'];
    
    $result = mysqli_query($connection, "SELECT * FROM rvuti_users WHERE hash='".fuck_sql_hackers($sid)."'");
    $row = mysqli_fetch_array($result);
    $user_id = $row['id'];
    $balance = $row['balance'];
    if($row) {
        $result = mysqli_query($connection, "SELECT * FROM rvuti_promocode WHERE code='".fuck_sql_hackers($code)."'");
        $row = mysqli_fetch_array($result);
        $value = $row['value'];
        $limit = $row['use_limit'];
        if($row) {
            $result = mysqli_query($connection, "SELECT * FROM rvuti_promoused WHERE code='".fuck_sql_hackers($code)."'");
            $rows = mysqli_num_rows($result);
            if($rows >= $limit) {
                $error = "Данный промокод более недействителен.";
            } else {
                $result = mysqli_query($connection, "SELECT * FROM rvuti_promoused WHERE user_id='".fuck_sql_hackers($user_id)."' AND code='".fuck_sql_hackers($code)."'");
                $row = mysqli_fetch_array($result);
                $new_bal =  $value + $balance;
                if(!$row) {
                    mysqli_query($connection, "INSERT INTO `rvuti_promoused`(`user_id`, `code`, `time`) VALUES ('".fuck_sql_hackers($user_id)."', '".fuck_sql_hackers($code)."', '".fuck_sql_hackers(time())."');");
                    mysqli_query($connection, "UPDATE `rvuti_users` SET `balance` = '$new_bal' WHERE `rvuti_users`.`id` = $user_id;");
                    $nice = "Вы успешно активировали этот промокод. На Ваш баланс зачислено <b>".$value."</b> BRU.";
                } else {
                    $error = "Вы уже использовали этот промокод.";
                }
            }
        } else {
            $error = "Такого промокода не существует.";
        }
    } else {
        $error = "Вы не авторизованы.";
    }
    if($nice){
        echo json_encode(array('msg' => $nice, 'old_balance' => $balance, 'new_balance' => $new_bal));
    } else {
        echo json_encode(array('msg' => $error));
    }
    mysqli_close($connection);
?>
    
    