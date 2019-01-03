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
    
    $sid = $_COOKIE['sid'];
    
    $sql_select = "SELECT * FROM `rvuti_users` WHERE `hash` = '".fuck_sql_hackers($sid)."'";
    $result = mysqli_query($connection, $sql_select);
    $row = mysqli_fetch_array($result);
    $uid = $row['id'];
    
    $merchant_id = '73982';
    $secret_word = '4hwyui1b';
    $order_id = $uid.rand(1,99999);
    $order_amount = $_GET['amount'];
    if(!is_numeric($_GET['amount'])){
        mysqli_close($connection);
        die('unknown amount');
    }
    if(!is_numeric($uid)) {
        mysqli_close($connection);
        die('unknown uid');
    }
    
    $sign = md5($merchant_id.':'.$order_amount.':'.$secret_word.':'.$order_id);
    $sql_select = "SELECT * FROM `rvuti_payments` ORDER BY `rvuti_payments`.`id` DESC
";
    $result = mysqli_query($connection, $sql_select);
    
    mysqli_free_result($result);
    mysqli_close($connection);
?>

                        <form method='get' action='https://www.free-kassa.ru/merchant/cash.php'>
                        <input type='hidden' name='m' value='<?php echo $merchant_id?>'>
    <input type='hidden' name='oa' value='<?php echo $order_amount?>'>
    <input type='hidden' name='o' value='<?php echo $order_id?>'>
    <input type='hidden' name='s' value='<?php echo $sign?>'>
    <input type='hidden' name='lang' value='ru'>
    <input type='hidden' name='us_uid' value='<?php echo $uid?>'>
    <button type='submit' name='pay' class="btn  btn-block"  style="color:#fff;background: #6c7a89!important;">
        Продолжить
    </button>
                        </form>