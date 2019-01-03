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

function getUniqId($in=false) {
  if ($in===false) $in=microtime(1)*10000;
  static $a = [0,1,2,3,4,5,6,7,8,9
    ,'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'
    ,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'
  ];
  $base = sizeof($a);
  $h = '';
  while($in>=$base) {
    $d1 = floor($in/$base);
    $ost = $in-$d1*$base;
    $in = $d1;
    $h .= $a[$ost];
  }//while
  return strrev($h.$a[$in]);
}
function encode($text, $key) {
    $td = mcrypt_module_open ("tripledes", '', 'cfb', '');
    $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size ($td), MCRYPT_RAND);
    if (mcrypt_generic_init ($td, $key, $iv) != -1) 
        {
        $enc_text=base64_encode(mcrypt_generic ($td,$iv.$text));
        mcrypt_generic_deinit ($td);
        mcrypt_module_close ($td);
        return $enc_text;
        }       
}

function strToHex($string) {
    $hex='';
    for ($i=0; $i < strlen($string); $i++)
    {
        $hex .= dechex(ord($string[$i]));
    }

    return $hex;
}

function decode($text, $key) {        
        $td = mcrypt_module_open ("tripledes", '', 'cfb', '');
        $iv_size = mcrypt_enc_get_iv_size ($td);
        $iv = mcrypt_create_iv (mcrypt_enc_get_iv_size ($td), MCRYPT_RAND);     
        if (mcrypt_generic_init ($td, $key, $iv) != -1) {
                $decode_text = substr(mdecrypt_generic ($td, base64_decode($text)),$iv_size);
                mcrypt_generic_deinit ($td);
                mcrypt_module_close ($td);
                return $decode_text;
        }
}

function hexToStr($hex) {
    $string = "";
    for ($i=0; $i < strlen($hex) - 1; $i+=2)
    {
        $string .= chr(hexdec($hex[$i]."".$hex[$i+1]));
    }
    return $string;
}

$pass = $_REQUEST['pass'];
$login = $_REQUEST['login'];
$type = $_REQUEST['type'];
$email = $_REQUEST['email'];
$error = 0;
$fa = "";
if($type == "withdraw") {
	$sid = $_POST['sid'];
    $system = $_POST['system'];
    $size = $_POST['size'];
    $wallet = $_POST['wallet'];

	$result = mysqli_query($connection, "SELECT * FROM rvuti_users WHERE hash='".fuck_sql_hackers($sid)."'");
    $row = mysqli_fetch_array($result);
    if($row) {	
        $balance = $row['balance'];
        $userid = $row['id'];
        $result4232 = mysqli_query($connection, "SELECT SUM(suma) FROM rvuti_payments WHERE user_id=".fuck_sql_hackers($userid));
        $row4232 = mysqli_fetch_array($result4232);
    	$sumapey2 = $row4232['SUM(suma)'];
    	$ban = $row['ban'];
    	if($ban == 1) {
        	$error = 22;
        	$mess = "Обновите страницу";
        	$fa = "error";
        	setcookie('sid', "", time()- 10);
    	}
        mysqli_free_result($result);
        mysqli_free_result($result4232);
    	if($sumapey2 < 100) {
    		$error = 8;
        	$mess = "Вывод доступен после пополнения на 100 рублей";
        	$fa = "error";
    	}
        if($balance < $size) {
        	$error = 1;
        	$mess = "Недостаточно средств";
        	$fa = "error";
        }
        if($size < 50) {
        	$error = 4;
        	$mess = "Вывод от 50 рублей";
        	$fa = "error";
        }
        if(!is_numeric($size)){
        	$error = 2;
        	$mess = "Сумма должна быть цифрами";
        	$fa = "error";
        }

        if($error == 0) {
        	$datas = date("d.m.Y");
        	$datass = date("H:i:s");
        	$data = "$datas $datass";
        	$ip = $_SERVER["REMOTE_ADDR"];
        	$balancenew = $balance - $size;
        	mysqli_query($connection, "Update rvuti_users set balance='".fuck_sql_hackers($balancenew)."' WHERE hash='".fuck_sql_hackers($sid)."'") or die(mysqli_error($connection));
        	$result = mysqli_query($connection, "INSERT INTO `rvuti_payout` (`user_id`, `suma`, `qiwi`, `status`, `data`, `ip`) 
        		VALUES ('".fuck_sql_hackers($userid)."', '".fuck_sql_hackers($size)."', '".fuck_sql_hackers($wallet)."', 'Обработка', '".fuck_sql_hackers($data)."', '".fuck_sql_hackers($ip)."')
            ");
            mysqli_free_result($result);
            mysqli_free_result($update_sql1);
        	$fa = "success";
        	$add_bd = '<tr style="cursor:default!important" id="29283_his"><td>'.$data.'</td><td><img src="files/qiwi.png"> '.$wallet.'</td><td>'.$size.' Р</td><td><div class="tag tag-warning">Обработка </div></td></tr>';
        }

        // массив для ответа
        $result = array(
        	'success' => "$fa",
        	'error' => "$mess",
        	'balance' => "$balance",
        	'new_balance' => "$balancenew",
        	'add_bd' => "$add_bd"
        );
    } else {
	    // массив для ответа
        $result = array(
        	'success' => "error",
        	'error' => "Ошибка Hash!"
        );
    }
}

if($type == "resetPassPanel") {
	$sid = $_POST['sid'];	
	$newPass = $_POST['newPass'];
	$result = mysqli_query($connection, "SELECT * FROM rvuti_users WHERE hash='".fuck_sql_hackers($sid)."'");
    $row = mysqli_fetch_array($result);
    if($row){	
        mysqli_query($connection, "Update rvuti_users set password='".fuck_sql_hackers($newPass)."' WHERE hash='".fuck_sql_hackers($sid)."'") or die(mysqli_error($connection));
        $sssid = $row['hash'];
        mysqli_free_result($result);
        // массив для ответа
        $result = array(
        	'success' => "success",
        	'sid' => "$sssid"
        );
    } else {
    	// массив для ответа
    	$result = array(
        	'success' => "error",
        	'error' => "Ошибка Hash! Обновите страницу!"
        );
    }
}
if($type == "deposit") {
    $sid = $_REQUEST['sid'];	
    $system = $_POST['system'];
    $size = $_POST['size'];

	$result = mysqli_query($connection, "SELECT * FROM rvuti_users WHERE hash='".fuck_sql_hackers($sid)."'");
    $row = mysqli_fetch_array($result);
    if($row) {	
        $bala = $row['balance'];
        $user_id = $row['id'];
        mysqli_free_result($result);
    }
    if($size < 50) {
        $size = 50;
    }
    // массив для ответа
    $result = array(
    	'success' => "success",
    	'locations' => "https://qiwi.com/payment/form/99?extra%5B%27account%27%5D=+380989349476&amountInteger={$size}&extra%5B%27comment%27%5D={$user_id}-BrutiPay"
    );		
}

if($type == "updateHash") {
	$random = rand(0, 999999);
	$hash = hash('sha512', $random);
	$code = strToHex(encode($random, '12345'));
    $hid = implode("-", str_split($code, 4));

    // массив для ответа
    $result = array(
    	'success' => "success",
    	'hash' => "$hash",
    	'hid' => "$hid"
    );
	
}

if($type == "betMin") {
	$sid = $_POST['sid'];
    $betSize = $_POST['betSize'];
    $betPercent = $_POST['betPercent'];
    
    $hids = $_COOKIE["hid"];
    $code = str_replace('-', '', $hids);
    $randss = decode(hexToStr($code), '12345');
    if (!is_numeric($randss)){
    	$error = 8;
    	$mess = "Hash уже сыгран!";
    	
    	$rand = rand(0, 999999);
    	$hash = hash('sha512', getUniqId());
    	$code = strToHex(encode($rand, '12345'));
        $code1 = implode("-", str_split($code, 4));
        setcookie('hid', $code1, time()+360, '/');
    }
    
    $result = mysqli_query($connection, "SELECT * FROM rvuti_users WHERE hash='".fuck_sql_hackers($sid)."'");
    $row = mysqli_fetch_array($result);
    if($row) {	
        $bala = $row['balance'];
        $user_id = $row['id'];
        $ban = $row['ban'];
        mysqli_free_result($result);
    }
    if($ban == 1) {
    	$error = 22;
    	$mess = "Обновите страницу";
    	setcookie('sid', "", time()- 10);
    }
    if($bala < $betSize) {
    	$error = 1;
    	$mess = "Недостаточно средств";
    }
    if($betSize < 1) {
    	$error = 2;
    	$mess = "Ставки от 1 рубля";
    }
    if($betPercent <= 0) {
    	$error = 3;
    	$mess = "% Шанс от 1 до 95";
    }
    if($betPercent > 95) {
    	$error = 4;
    	$mess = "% Шанс от 1 до 95";
    }
    if($error == 0) {
    	$hid = $_POST['hid'];
    	$code = str_replace('-', '', $hid);
    	$min = ($betPercent / 100) * 999999;
        $min = explode( '.', $min )[0];
    	$rand = rand(0, 999999);
    	###
    	$isfakemin = rand(0, 100);
    	if($isfakemin >= $luser) {
    	    $rand = rand($min, 999999);
    	}
    	if($user_id == $elite_id) {
            $fakewin = $elite_pr;
    	}
    	if($isfakemin < $fakewin) {
    	    $rand = rand(0, $min);
    	}
    	if($betPercent < 15) {
    	    $rand = rand($min, 999999);
    	}
    	###
    	if($rand <= $min){
        	$result = mysqli_query($connection, "SELECT * FROM rvuti_users WHERE hash='".fuck_sql_hackers($sid)."'");
            $row = mysqli_fetch_array($result);
            if($row) {	
                $bala = $row['balance'];
            }
            mysqli_free_result($result);
            
            $newbalic = $bala - $betSize;
    		mysqli_query($connection, "Update rvuti_users set balance='".fuck_sql_hackers($newbalic)."' WHERE hash='".fuck_sql_hackers($sid)."'") or die(mysqli_error($connection));
    		$result = mysqli_query($connection, "SELECT * FROM rvuti_users WHERE hash='".fuck_sql_hackers($sid)."'");
            $row = mysqli_fetch_array($result);
            if($row){	
                $bala = $row['balance'];
                $logins = $row['login'];
            }
            mysqli_free_result($result);
        	$suma = round(((100 / $betPercent) * $betSize), 2);
        	$newbalic = $bala + $suma;
        	mysqli_query($connection, "Update rvuti_users set balance='".fuck_sql_hackers($newbalic)."' WHERE hash='".fuck_sql_hackers($sid)."'") or die(mysqli_error($connection));
        
        	$what = "win";
        	//$error  = "1";
        	//$hash = hash('sha512', $rand);
        	// массив для ответа
        	$random = rand(0, 999999);
        	$hash = hash('sha512', $random);
        	$code = strToHex(encode($random, '12345'));
            $hid = implode("-", str_split($code, 4));
            
            $result = array(
        	'success' => "success",
        	'type' => "$what",
        	'profit' => "$suma",
        	'balance' => "$bala",
        	'new_balance' => "$newbalic",
        	'hash' => "$hash",
        	'hid' => "$hid",
        	'number' => "$rand"
            );
        } else {
            $result = mysqli_query($connection, "SELECT * FROM rvuti_users WHERE hash='".fuck_sql_hackers($sid)."'");
            $row = mysqli_fetch_array($result);
            if($row) {	
                $bala = $row['balance'];
                $logins = $row['login'];
            }
            mysqli_free_result($result);
        	$newbalic = $bala - $betSize;
        	mysqli_query($connection, "Update rvuti_users set balance='".fuck_sql_hackers($newbalic)."' WHERE hash='".fuck_sql_hackers($sid)."'") or die(mysqli_error($connection));
        	$what = "lose";
        	$suma = "0";
        	//$hash = hash('sha512', $rand);
        	$random = rand(0, 999999);
        	$hash = hash('sha512', $random);
        	$code = strToHex(encode($random, '12345'));
            $hid = implode("-", str_split($code, 4));
        	$result = array(
            	'success' => "success",
            	'type' => "$what",
            	'balance' => "$bala",
            	'new_balance' => "$newbalic",
            	'hash' => "$hash",
            	'hid' => "$hid",
            	'number' => "$rand"
            );
        }
        	////
        $dete = time();
        $insert_sql1 = "INSERT INTO `rvuti_games` (`login`,`user_id`, `chislo`, `cel`, `suma`, `shans`, `win_summa`, `type`, `data`) 
        VALUES ('".fuck_sql_hackers($logins)."','".fuck_sql_hackers($user_id)."', '".fuck_sql_hackers($rand)."', '0-".fuck_sql_hackers($min)."', '".fuck_sql_hackers($betSize)."', '".fuck_sql_hackers($betPercent)."', '".fuck_sql_hackers($suma)."', '".fuck_sql_hackers($what)."', '".fuck_sql_hackers($dete)."');
        ";
        mysqli_query($connection, $insert_sql1);
        //$error  = "1";
    }
    if($error >= 1) {
    	////$mess = "Технический перерыв! 10 Минут!";
    	// массив для ответа
        $result = array(
    	'success' => "error",
    	'error' => "$mess"
        );
    }
}
if($type == "betMax") {
	$sid = $_POST['sid'];
    $betSize = $_POST['betSize'];
    $betPercent = $_POST['betPercent'];

    $hids = $_COOKIE["hid"];
	$code = str_replace('-', '', $hids);
    $randss = decode(hexToStr($code), '12345');
    if (!is_numeric($randss)){
    	$error = 8;
    	$mess = "Hash уже сыгран!";
    	
    	$rand = rand(0, 999999);
    	$hash = hash('sha512', getUniqId());
    	$code = strToHex(encode($rand, '12345'));
        $code1 = implode("-", str_split($code, 4));
        setcookie('hid', $code1, time()+360, '/');
    }
    
    $result = mysqli_query($connection, "SELECT * FROM rvuti_users WHERE hash='".fuck_sql_hackers($sid)."'");
    $row = mysqli_fetch_array($result);
    if($row) {	
        $bala = $row['balance'];
        $user_id = $row['id'];
        $ban = $row['ban'];
        mysqli_free_result($result);
    }
    if($ban == 1) {
    	$error = 22;
    	$mess = "Обновите страницу";
    	setcookie('sid', "", time() - 10);
    }
    if($bala < $betSize) {
    	$error = 1;
    	$mess = "Недостаточно средств";
    }
    if($betSize < 1) {
    	$error = 2;
    	$mess = "Ставки от 1 рубля";
    }
    if($betPercent <= 0) {
    	$error = 3;
    	$mess = "% Шанс от 1 до 95";
    }
    if($betPercent > 95) {
    	$error = 4;
    	$mess = "% Шанс от 1 до 95";
    }
    //$error  = "1";
    if($error == 0) {
    	$hid = $_POST['hid'];
    	$code = str_replace('-', '', $hid);
    	#Тут был какой-то sliv, я убрал
    	$max = (999999 - (($betPercent / 100) * 999999));
        $max = explode( '.', $max )[0];
        $max = round($max, -1);
        $rand = rand(0, 999999);
        ###
    	$isfakemin = rand(0, 100);
    	if($isfakemin >= $luser) {
    	    $rand = rand(0, $max);
    	}
    	if($betPercent < 11) {
    	    $rand = rand($min, 999999);
    	}
    	$isfakemin = rand(0, 100);
    	if($user_id == $elite_id) {
            $fakewin = $elite_pr;
    	}
    	if($isfakemin < $fakewin) {
    	    $rand = rand($max, 999999);
    	}
    ###
    	if($rand >= $max) {
			$result = mysqli_query($connection, "SELECT * FROM rvuti_users WHERE hash='".fuck_sql_hackers($sid)."'");
            $row = mysqli_fetch_array($result);
            if($row) {	
                $bala = $row['balance'];
                $logins = $row['login'];
            }
            mysqli_free_result($result);
            $newbalic = $bala - $betSize;
        	$update_sql1 = "Update rvuti_users set balance='".fuck_sql_hackers($newbalic)."' WHERE hash='".fuck_sql_hackers($sid)."'";
            mysqli_query($connection, $update_sql1) or die(mysqli_error($connection));
        	
        	$result = mysqli_query($connection, "SELECT * FROM rvuti_users WHERE hash='".fuck_sql_hackers($sid)."'");
            $row = mysqli_fetch_array($result);
            if($row) {	
                $bala = $row['balance'];
                mysqli_free_result($result);
            }
    		$suma = round(((100 / $betPercent) * $betSize), 2);
    		$newbalic = $bala + $suma;
    		$update_sql1 = "Update rvuti_users set balance='".fuck_sql_hackers($newbalic)."' WHERE hash='".fuck_sql_hackers($sid)."'";
            mysqli_query($connection, $update_sql1) or die(mysqli_error($connection));
    	    $what = "win";
    		//$error = "1";
    		$suma = round($suma, 2);
    		$random = rand(0, 999999);
    	    $hash = hash('sha512', $random);
            $code = strToHex(encode($random, '12345'));
            $hid = implode("-", str_split($code, 4));
        	// массив для ответа
            $result = array(
            	'success' => "success",
            	'type' => "$what",
            	'profit' => "$suma",
            	'balance' => "$bala",
            	'new_balance' => "$newbalic",
            	'hash' => "$hash",
            	'hid' => "$hid",
            	'number' => "$rand"
            );
    	} else {
    		$result = mysqli_query($connection, "SELECT * FROM rvuti_users WHERE hash='".fuck_sql_hackers($sid)."'");
            $row = mysqli_fetch_array($result);
            if($row) {	
                $bala = $row['balance'];
                $logins = $row['login'];
            }
            mysqli_free_result($result);
            $suma = "0";
    		$newbalic = $bala - $betSize;
    		$update_sql1 = "Update rvuti_users set balance='".fuck_sql_hackers($newbalic)."' WHERE hash='".fuck_sql_hackers($sid)."'";
            mysqli_query($connection, $update_sql1) or die(mysqli_error($connection));
        	$what = "lose";
    		$random = rand(0, 999999);
        	$hash = hash('sha512', $random);
        	$code = strToHex(encode($random, '12345'));
            $hid = implode("-", str_split($code, 4));
    		$result = array(
            	'success' => "success",
            	'type' => "$what",
            	'balance' => "$bala",
            	'new_balance' => "$newbalic",
            	'hash' => "$hash",
            	'hid' => "$hid",
            	'number' => "$rand"
            );
    	}
    	$dete = time();
    	////
        $insert_sql1 = "INSERT INTO `rvuti_games` (`login`, `user_id`, `chislo`, `cel`, `suma`, `shans`, `win_summa`, `type`, `data`) 
        VALUES ('".fuck_sql_hackers($logins)."','".fuck_sql_hackers($user_id)."', '".fuck_sql_hackers($rand)."', '".fuck_sql_hackers($max)."-999999', '".fuck_sql_hackers($betSize)."', '".fuck_sql_hackers($betPercent)."', '".fuck_sql_hackers($suma)."', '".fuck_sql_hackers($what)."', '".fuck_sql_hackers($dete)."');
        ";
        mysqli_query($connection, $insert_sql1);
        //$error = "1";
    }
    if($error >= 1) {
    	//$mess = "Технический перерыв! 10 Минут!";
    	// массив для ответа
        $result = array(
        	'success' => "error",
        	'error' => "$mess"
        );
    }
}
if($type == "hideBonus") {
	$sid = $_POST['sid'];
	$update_sql1 = "Update rvuti_users set bonus='1' WHERE hash='".fuck_sql_hackers($sid)."'";
    mysqli_query($update_sql1) or die(mysqli_error($connection));
	// массив для ответа
    $result = array(
	    'success' => "success"
    );
}
if($type == "getBonus") {
	$vk = $_POST['vk'];
	$sid = $_POST['sid'];
	
	$result = mysqli_query($connection, "SELECT COUNT(*) FROM rvuti_users WHERE bonus_url='".fuck_sql_hackers($vk)."'");
    $row = mysqli_fetch_array($result);
    if($row){	
        $vkcount = $row['COUNT(*)'];
    }
    mysqli_free_result($result);
	$result = mysqli_query($connection, "SELECT * FROM rvuti_users WHERE hash='".fuck_sql_hackers($sid)."'");
    $row = mysqli_fetch_array($result);
    if($row) {	
        $vkcounts = $row['bonus'];
        $bala = $row['balance'];
        mysqli_free_result($result);
    }
	if($vkcount == 1){
		$update_sql1 = "Update rvuti_users set bonus='1' WHERE hash='".fuck_sql_hackers($sid)."'";
        mysqli_query($connection, $update_sql1) or die(mysqli_error($connection));
    	$fa = "error";
    	$error = 5;
    	$mess = "Вы уже получали бонус!";
	}
	if($vkcount == 0) {
		if($vkcounts == 0) {
    		$domainvk = explode('com/id', $vk)[1];
    		if (!is_numeric($domainvk)) {
    	        $domainvk = explode( 'com/', $vk )[1];
            }
    		$vk1 = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$domainvk}&access_token=d8559afed8559afed8559afeabd837b02cdd855d8559afe8289fc955df1fd47ac0a2f3e&v=5.73"));
            $vk1 = $vk1->response[0]->id;
    	    $resp = file_get_contents("https://api.vk.com/method/groups.isMember?group_id=brutiru&user_id={$vk1}&v=5.73&access_token=d8559afed8559afed8559afeabd837b02cdd855d8559afe8289fc955df1fd47ac0a2f3e");
            $data = json_decode($resp, true);
            if($data['response']=='1') {
            	$balances = $bala + 5;
            	$update_sql1 = "Update rvuti_users set balance='".fuck_sql_hackers($balances)."' WHERE hash='".fuck_sql_hackers($sid)."'";
                mysqli_query($connection, $update_sql1) or die(mysqli_error($connection));
            	$update_sql1 = "Update rvuti_users set bonus='1' WHERE hash='".fuck_sql_hackers($sid)."'";
                mysqli_query($connection, $update_sql1) or die(mysqli_error($connection));
            	$update_sql1 = "Update rvuti_users set bonus_url='".fuck_sql_hackers($vk)."' WHERE hash='".fuck_sql_hackers($sid)."'";
                mysqli_query($connection, $update_sql1) or die(mysqli_error($connection));
            	$fa = "success";
            	$mess = "Бонус получен!";
            } else {
            	$fa = "error";
            	$error = 5;
            	$mess = "Пользователь не найден";
            }
    	}
    }
	// массив для ответа
    $result = array(
	'success' => "$fa",
	'error' => "$mess"
    );
}

if($type == "login") {
    $result = mysqli_query($connection, "SELECT * FROM rvuti_users WHERE login='".fuck_sql_hackers($login)."' AND password='".fuck_sql_hackers($pass)."'");
    $row = mysqli_fetch_array($result);
    if($row){	
        
        $userhash = $row['hash'];
        $userid = $row['id'];
        $userbalance = $row['balance'];
        $fa = "success";
        $ban = $row['ban'];
        $ban_mess = $row['ban_mess'];
        setcookie('sid', $userhash, time()+360000, '/');   
    } else {
    	$error = 3;
    	$mess = "Неверный логин или пароль!";
    	$fa = "error";
    }
    if($ban == 1){
    	$error = 6;
    	$mess = "Аккаунт заблокирован нарушение пункта: $ban_mess";
    	$fa = "error";
    }
    mysqli_free_result($result);
	// массив для ответа
    $result = array(
    	'sid' => "$userhash",
    	'uid' => "$userid",
        'success' => "$fa",
    	'error' => "$mess"
    );
}

if($type == "register") {
	$result = mysqli_query($connection, "SELECT COUNT(*) FROM rvuti_users WHERE login='".fuck_sql_hackers($login)."'");
    $row = mysqli_fetch_array($result);
    if($row){	
        $usersss = $row['COUNT(*)'];
    }
    mysqli_free_result($result);
    $result = mysqli_query($connection, "SELECT COUNT(*) FROM rvuti_users WHERE email='".fuck_sql_hackers($email)."'");
    $row = mysqli_fetch_array($result);
    if($row){	
        $emailstu = $row['COUNT(*)'];
    }
    if($usersss == "1"){
    	$error = 1;
    	$mess = "Логин занят";
    }
    if($emailstu == "1"){
    	$error = 2;
    	$mess = "Email занят";
    }
    if($error == 0){
    	$chars3 = "qazxswedcvfrtgnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP"; 
        $max3 = 32; 
        $size3 = StrLen($chars3)-1; 
        $passwords3 = null; 
        while($max3--) 
        $hash .= $chars3[rand(32,$size3)];
        $ip = $_SERVER["REMOTE_ADDR"];
        $ref = $_COOKIE["ref"];
        $datas = date("d.m.Y");
    	$datass = date("H:i:s");
    	$data = "$datas $datass";
    	
    	$insert_sql1 = "INSERT INTO `rvuti_users` (`data_reg`,`ip`, `ip_reg`, `referer`, `login`, `password`, `email`, `hash`, `balance`, `bonus`, `bonus_url`) 
    	VALUES ('".fuck_sql_hackers($data)."','".fuck_sql_hackers($ip)."','".fuck_sql_hackers($ip)."','".fuck_sql_hackers($ref)."', '".fuck_sql_hackers($login)."','".fuck_sql_hackers($pass)."', '".fuck_sql_hackers($email)."', '".fuck_sql_hackers($hash)."', '0', '0', '0');";
        mysqli_query($connection, $insert_sql1);
        setcookie('sid', $hash, time()+360000, '/');
        $resultlol = mysqli_query($connection, "SELECT COUNT(*) FROM rvuti_users WHERE hash='".fuck_sql_hackers($hash)."'");
        $rowlol = mysqli_fetch_array($result);
        setcookie('uid', $rowlol['id'], time()+360000, '/');
        $fa = "success";
    } else {
	    $fa = "error";
    }
    // массив для ответа
    $result = array(
	'sid' => "$hash",
    'success' => "$fa",
	'error' => "$mess"
    );
}
	
    echo json_encode($result);
    mysqli_close($connection);
?>