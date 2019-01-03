<?php
#ini_set('error_reporting', E_ALL);
#ini_set('display_errors', 1);
#ini_set('display_startup_errors', 1);
include("db_connect.php");
include("config.php");

$result = mysqli_query($connection, 'SELECT * FROM rvuti_games ORDER BY `id` DESC LIMIT 20');
$i = 0;
while($i < 20) {
    $row = mysqli_fetch_array($result);
    ++$i;
	$result1 = mysqli_query($connection, 'SELECT * FROM rvuti_users WHERE id='.$row['user_id']);
    $row1 = mysqli_fetch_array($result1);
    
    if($row['shans'] >= 60)
    {
    	$sts = "success";
    }
    if($row['shans'] < 60 && $row['shans'] >= 30)
    {
    	$sts = "warning";
    }
    if($row['shans'] <= 29)
    {
    	$sts = "danger";
    }
    
    if($row['type'] == "win")
    {
    	$st = "success";
    }
    if($row['type'] == "lose")
    {
    	$st = "danger";
    }
    $login = ucfirst($row['login']);
    
    $game = 
<<<HERE
    $game
    <tr data-user="$row[user_id]" data-game="$row[id]"><td class="text-truncate " style="font-weight:600">$login</td><td class="text-truncate $st" style="font-weight:600">$row[chislo]</td><td class="text-truncate " style="font-weight:600">$row[cel]</td><td class="text-truncate " style="font-weight:600">$row[suma] <b>B</b></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px" class="progress progress-sm progress-$sts mb-0" value="$row[shans]" max="100"></progress></span></td><td class="text-truncate $st " style="font-weight:600">$row[win_summa]<i style="margin-left:7px;" class="fas fa-coins"></i></td></tr>
HERE;

    $st = "";
    $sts = "";
    $login = "";
}


    $sid = $_COOKIE["sid"];
    $time = time() + 5;
    $ip = $_SERVER["REMOTE_ADDR"];
    $update_sql1 = "Update rvuti_users set online='1', online_time='$time', ip='$ip' WHERE hash='$sid'";
    mysqli_query($connection, $update_sql1) or die(mysqli_error());
    	
    $online_time = time() - 100;
    $sql_select = "SELECT COUNT(*) FROM rvuti_users WHERE online_time > '$online_time'";
    $result = mysqli_query($connection, $sql_select);
    $row = mysqli_fetch_array($result);
    
    $online = $row['COUNT(*)'] + 20;

    mysqli_free_result($result);
    
    mysqli_free_result($result1);
// массив для ответа
    $result = array(
	'game' => "$game",
    'online' => "$online"
    );
    
    #bot
    $nicks = array("catferq", "Edwador", "Psazy", "betlaska", "ticker", "kotow", "killoff", "bigboss", "alex007", "juice01", "kotikheh", "andr3y", "iwinner", "leo_ins", "solowei", "yo_yo", "wideray477", "mazuk", "nice777", "LightHD", "luck9");
    $winfal = rand(1, 100);
    if($winfal <= 60) {
        $number = mt_rand(0, count($nicks) - 1); // Берём случайное число от 0 до (длины массива минус 1) включительно
        $nick = $nicks[$number];
        $isbot = rand(1, 1000);
        if($isbot < 100) {
            $maxmin = rand(1,2);
            if($maxmin == 1) {
                $dete = time();
                $rand = rand(1000, 400000);
                $insert_sql1 = "INSERT INTO `rvuti_games` (`login`,`user_id`, `chislo`, `cel`, `suma`, `shans`, `win_summa`, `type`, `data`) 
                    VALUES ('$nick', '1', '$rand', '0-499999', '1', '50', '2', 'win', '$dete');
                ";
                mysqli_query($connection, $insert_sql1);
            } else {
                $dete = time();
                $rand = rand(600000, 900000);
                $insert_sql1 = "INSERT INTO `rvuti_games` (`login`,`user_id`, `chislo`, `cel`, `suma`, `shans`, `win_summa`, `type`, `data`) 
                    VALUES ('$nick', '1', '$rand', '500000-999999', '1', '50', '2', 'win', '$dete');
                ";
                mysqli_query($connection, $insert_sql1);
            }
        } 
    } else {
        $maxmin = rand(1,2);
            if($maxmin == 1) {
                $number = mt_rand(0, count($nicks) - 1); // Берём случайное число от 0 до (длины массива минус 1) включительно
                $nick = $nicks[$number];
                $isbot = rand(1, 1000);
                if($isbot < 100) {
                    $dete = time();
                    $rand = rand(499999, 900000);
                    $insert_sql1 = "INSERT INTO `rvuti_games` (`login`,`user_id`, `chislo`, `cel`, `suma`, `shans`, `win_summa`, `type`, `data`) 
                        VALUES ('$nick', '1', '$rand', '0-499999', '1', '50', '0', 'lose', '$dete');
                    ";
                    mysqli_query($connection, $insert_sql1);
                }
            } else {
                $number = mt_rand(0, count($nicks) - 1); // Берём случайное число от 0 до (длины массива минус 1) включительно
                $nick = $nicks[$number];
                $isbot = rand(1, 1000);
                if($isbot < 100) {
                    $dete = time();
                    $rand = rand(1000, 400000);
                    $insert_sql1 = "INSERT INTO `rvuti_games` (`login`,`user_id`, `chislo`, `cel`, `suma`, `shans`, `win_summa`, `type`, `data`) 
                        VALUES ('$nick', '1', '$rand', '500000-999999', '1', '50', '0', 'lose', '$dete');
                    ";
                    mysqli_query($connection, $insert_sql1);
                }
            }
    }
	mysqli_close($connection);
    echo json_encode($result);
?>