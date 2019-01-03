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
    if(mcrypt_generic_init ($td, $key, $iv) != -1){
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




///online///
$result = mysqli_query($connection, "SELECT COUNT(*) FROM rvuti_users WHERE online='1'");
$row = mysqli_fetch_array($result);
$online = $row['COUNT(*)'];
mysqli_free_result($result);
///online///

///
if($_GET['i']) {
    setcookie('ref', $_GET['i'], time()+360000, '/');
}

///
if($_COOKIE["sid"] == "") {

$go = <<<HERE
<section class="index__description">
      <div class="container">
        <div class="row wow animated fadeInDown animated" style="visibility: visible; animation-name: fadeInDown;">
          <div class="col-12">
            <h1>BRUTI.RU</h1>
             <p>Сайт мгновенных игр, где победа зависит от Вас!</p>
            
            <a class="button button-1" id="vhrg">ВХОД / РЕГИСТРАЦИЯ</a>
          </div>
        </div>
        <div class="index__macbook wow animated fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;"><img class="img-fluid" src="files/macbook.png" alt=""></div>
      </div>
    </section>
    
    <section class="index__advantages">
      <div class="container">
        <div class="section__title"><h2>Почему нам стоит доверять?</h2></div>
        <div class="index__advantages__items">
          <div class="row">
            <div class="col-lg-4">
              <div class="adv__item wow animated fadeInUp animated" data-wow-delay="0.2s" style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                <div class="icon"><div class="bg-adv bg-adv_icon_1"></div></div>
                <div class="text">
                  <h3>Это бесплатно</h3>
                  <p>Вы можете зарегистрировать свой аккаунт абсолютно бесплатно, далее вам дадут бонусные рубли, с которых вы уже сможете сорвать куш, не вкладывая деньги в игру!</p>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="adv__item wow animated fadeInUp animated" data-wow-delay="0.4s" style="visibility: visible; animation-delay: 0.4s; animation-name: fadeInUp;">
                <div class="icon"><div class="bg-adv bg-adv_icon_2"></div></div>
                <div class="text">
                  <h3>Безопасность</h3>
                  <p>Ваши пароли шифруются при регистрации, так что они в безопасности!</p>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="adv__item wow animated fadeInUp animated" data-wow-delay="0.6s" style="visibility: visible; animation-delay: 0.6s; animation-name: fadeInUp;">
                <div class="icon"><div class="bg-adv bg-adv_icon_3"></div></div>
                <div class="text">
                  <h3>Отзывчивая поддержка</h3>
                  <p>Наши люди работают 24/7 без выходных и всегда готовы помочь с решением возникших проблем. </p>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-4 offset-lg-2">
              <div class="adv__item wow animated fadeInUp animated" data-wow-delay="0.8s" style="visibility: visible; animation-delay: 0.8s; animation-name: fadeInUp;">
                <div class="icon"><div class="bg-adv bg-adv_icon_4"></div></div>
                <div class="text">
                  <h3>Большой спрос</h3>
                  <p>Мы вкладываем огромные силы и вложения в продвижения нашего магазина, чтобы обойти всех конкурентов и доказать, что мы лучшие.</p>
                </div>
              </div>
            </div>
            <div class="col-lg-4">
              <div class="adv__item wow animated fadeInUp animated" data-wow-delay="1s" style="visibility: visible; animation-delay: 1s; animation-name: fadeInUp;">
                <div class="icon"><div class="bg-adv bg-adv_icon_5"></div></div>
                <div class="text">
                  <h3>Большой функционал</h3>
                  <p>Вы сможете автоматически отключить звуки которые вам мешают, или уже поменять свой аватар.</p>
                </div>
              </div>
            </div>
          </div>
        </div> 
      </div>
    </section>
    
     <script>
                                                            $(function() {
    $("#vhrg").click(function() {
        $("#over-block").fadeIn(1000);
    })
});
$(function() {
    $("#close-overlay").click(function() {
        $("#over-block").fadeOut(1000);
    })
});
                                                        </script>
    <div class="overlay-block" id="over-block">
        <div class="row">
                            <div class="col-xs-12">
                                <div class="card media-margin" style="
            transform: translate(-50%, 50%);
    width: 30%;
    position: absolute;
    top: 50%;
    left: 50%;
">
                                    <div class="card-body" style="box-shadow: rgba(210, 215, 222, 0.5) 7px 10px 23px -11px;border-radius: 6px!important;">
                                        <div id="close-overlay" style="position: absolute;top: 0px;right: 5px;display: block;font-size: 18px;cursor:  pointer;padding: 15px;z-index: 100;"><i class="fas fa-times"></i></div>
                                        <div class="row">
                                            <div class="col-lg-12  col-md-12 col-sm-12 ">
                                                <div id="login">
                                                    
                                                    <div class="col-lg-10 offset-lg-1">
													<div class="card-header no-border pb-0">
                                                        <h6 id="m1" class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2"><span style="font-size:17px"> Авторизация </span></h6>
                                                    </div>
                                                        <div class="card-body collapse in">
                                                            <div class="card-block">
                                                                <form class="form-horizontal">
                                                                    <fieldset class="form-group position-relative has-icon-left">
                                                                        <input type="text" class="form-control form-control-md input-md" id="userLogin" value="" placeholder="Логин"  >
                                                                        <div class="form-control-position">
                                                                            <i class="ft-user"></i>
                                                                        </div>
                                                                    </fieldset>
                                                                    <fieldset class="form-group position-relative has-icon-left">
                                                                        <input type="password" class="form-control form-control-md input-md" id="userPass" value="" placeholder="Пароль">
                                                                        <div class="form-control-position">
                                                                            <i class="ft-lock"></i>
                                                                        </div>
                                                                    </fieldset>
																	<div style="padding-bottom:11px" class="g-recaptcha" data-sitekey="6Leov1QUAAAAAHv1ApORTURwZZaWw_JgLOnfvJJC"></div>
																
                                                                    <a id="error_enter" class="btn  btn-block btnError" style="color:#fff;display:none"></a>

                                                                    <a id="enter_but" onclick="login()" class="btn   btn-block btnEnter" style="color:#fff;margin-bottom:5px">
                                                                        <center><span id="text_enter"> <i class="ft-unlock"></i>  Войти</span>

                                                                            <div id="loader" style="position:absolute">
                                                                                <div id='dot-container' style='display:none'>
                                                                                    <div id="left-dot" class='white-dot'></div>
                                                                                    <div id='middle-dot' class='white-dot'></div>
                                                                                    <div id='right-dot' class='white-dot'></div>
                                                                                </div>
                                                                            </div>

                                                                        </center>
                                                                    </a>
                                                                </form>
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="card-footer no-border" style="margin-top:-12x">
                                                            <p class="float-sm-left text-xs-center"><a onclick="register_show()" class="card-link">Регистрация</a></p>
                                                            <p class="float-sm-right text-xs-center"><a onclick="reset_show()" class="card-link">Забыли пароль? </a></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="register" style="display:none">
                                                   
                                                    <div class="col-lg-10 offset-lg-1">
													 <div class="card-header no-border pb-0" >
                                                        <h6  class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2"><span style="font-size:17px">Регистрация </span></h6>
                                                    </div>
                                                        <div class="card-body collapse in">
                                                            <div class="card-block">
                                                                <form class="form-horizontal" >
                                                                    <fieldset class="form-group position-relative has-icon-left">
                                                                        <input type="text" class="form-control form-control-md input-md" id="userLoginRegister" placeholder="Логин">
                                                                        <div class="form-control-position">
                                                                            <i class="ft-user"></i>
                                                                        </div>
                                                                    </fieldset>
                                                                    <fieldset class="form-group position-relative has-icon-left">
                                                                        <input type="email" class="form-control form-control-md input-md" id="userEmailRegister" placeholder="E-mail">
                                                                        <div class="form-control-position">
                                                                            <i class="ft-mail"></i>
                                                                        </div>
                                                                    </fieldset>
                                                                    <fieldset class="form-group position-relative has-icon-left">
                                                                        <input type="password" class="form-control form-control-md input-md" id="userPassRegister" placeholder="Пароль">
                                                                        <div class="form-control-position">
                                                                            <i class="ft-lock"></i>
                                                                        </div>
                                                                    </fieldset>
																	<fieldset style="padding-bottom: 7px;">
																		<label class="check1">
																		  <input id="rulesagree" type="checkbox"/>
																		  <div class="box1"></div>
																		 
																		 
																		</label>
																		 <div style="display:inline-block;padding-left:10px;position:absolute">Согласен c <u data-toggle="modal" data-target="#large" style="cursor:pointer">правилами</u></div>
																	</fieldset>
																	<!-- <div style="padding-bottom:11px" class="g-recaptcha" data-sitekey="6Leov1QUAAAAAHv1ApORTURwZZaWw_JgLOnfvJJC"></div> -->
                                                                    <a id="error_register" class="btn  btn-block btnError" style="color:#fff;display:none"></a>
                                                                    <a onclick="register1()" class="btn   btn-block btnEnter" style="color:#fff;margin-bottom:5px">

                                                                        <center><span id="text_register"><i class="ft-check"></i> Зарегистрироваться</span>

                                                                            <div id="loader_register" style="position:absolute">
                                                                                <div id='dot-container_register' style='display:none'>
                                                                                    <div id="left-dot_register" class='white-dot'></div>
                                                                                    <div id='middle-dot_register' class='white-dot'></div>
                                                                                    <div id='right-dot_register' class='white-dot'></div>
                                                                                </div>
                                                                            </div>

                                                                        </center>
                                                                    </a>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <div class="card-footer no-border" style="margin-top:-12px">
                                                            <p class="float-sm-left text-xs-center"><a onclick="login_show()" class="card-link">Есть аккаунт</a></p>
                                                            <p class="float-sm-right text-xs-center"><a onclick="reset_show()" class="card-link">Забыли пароль? </a></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="reset" style="display:none">
                                                    
                                                    <div class="col-lg-10 offset-lg-1">
													<div class="card-header no-border pb-0">
                                                        <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2"><span style="font-size:17px">Вспомнить пароль</span></h6>
                                                    </div>
                                                        <div class="card-body collapse in">
                                                            <div class="card-block">
                                                             
                                                                    <fieldset class="form-group position-relative has-icon-left">
                                                                        <input type="text" class="form-control form-control-md input-md" id="loginemail" placeholder="Логин или E-mail">
                                                                        <div class="form-control-position">
                                                                            <i class="ft-search"></i>
                                                                        </div>
                                                                    </fieldset>
																	<!-- <div style="padding-bottom:11px" class="g-recaptcha" data-sitekey="6Leov1QUAAAAAHv1ApORTURwZZaWw_JgLOnfvJJC"></div> -->
                                                                    <a id="error_reset" class="btn  btn-block btnError" style="color:#fff;display:none"></a>
                                                                    <a id="reset_success" class="btn  btn-block btnSuccess" style="color:#fff;display:none"></a>
                                                                    <a  id="reset_but" onclick="reset_password()" class="btn   btn-block btnEnter" style="color:#fff;margin-bottom:5px">

                                                                        <center><span id="text_reset"><i class="ft-check"></i> Вспомнить</span>

                                                                            <div id="loader_reset" style="position:absolute">
                                                                                <div id='dot-container_reset' style='display:none'>
                                                                                    <div id="left-dot_reset" class='white-dot'></div>
                                                                                    <div id='middle-dot_reset' class='white-dot'></div>
                                                                                    <div id='right-dot_reset' class='white-dot'></div>
                                                                                </div>
                                                                            </div>

                                                                        </center>
                                                                    </a>                                                               
                                                            </div>
                                                        </div>
 
                                                        <div class="card-footer no-border" style="margin-top:-12px">
                                                            <p class="float-sm-left text-xs-center"><a onclick="login_show()" class="card-link">Есть аккаунт</a></p>
                                                            <p class="float-sm-right text-xs-center"><a onclick="register_show()" class="card-link">Регистрация </a></p>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    </div>
		
HERE;
$panel = <<<HERE
<span onclick="bPlay('shutter.mp3')" class="closed-toggled" id="close-toggle" style="
    font-size: 26px;
    position:  absolute;
    font-weight: 700;
    right: 10px;
    top: -10px;
    z-index:  100;
    padding: 20px;
    cursor: pointer;
">&lt;</span>
                    <ul id="main-menu-navigation" class="ul-toggle-menu">
                        <li class="dropdown nav-item active" onclick="$('.dsec').hide();$('#lastBets').show();$(document.body).removeClass('menu-open');$(window).scrollTop($('#lastBets').offset().top);">
                            <a class="dropdown-toggle nav-link" onclick="bPlay('snap.mp3')"><i class="fas fa-home"></i><span>Главная</span></a>

                        </li>
                        <li class="dropdown nav-item " onclick="$('.dsec').hide();$('#rules').show();$(document.body).removeClass('menu-open');$(window).scrollTop($('#rules').offset().top);">
                            <a class="dropdown-toggle nav-link" onclick="bPlay('snap.mp3')"><i class="fas fa-dice-five"></i><span>Как играть</span></a>
                        </li>
						
												<li class="dropdown nav-item " onclick="$('.dsec').hide();$('#contacts').show();$(document.body).removeClass('menu-open');$(window).scrollTop($('#contacts').offset().top);">
                            <a class="dropdown-toggle nav-link" onclick="bPlay('snap.mp3')"><i class="fas fa-comments"></i><span>Контакты</span></a>
                        </li>
						<li class="dropdown nav-item " onclick="$('.dsec').hide();$('#lastWithdraw').show();$(document.body).removeClass('menu-open');$(window).scrollTop($('#lastWithdraw').offset().top);">
                            <a class="dropdown-toggle nav-link" onclick="bPlay(snap.mp3')"><i class="fas fa-clock"></i><span>Выплаты</span></a>
                        </li>
							
						<button style="margin-top:12px;float:right;" class="flat_button logo_button  color3_bg" onclick="window.open(&quot;https://vk.com/brutiru&quot;);">Мы Вконтакте</button>
                    </ul>

HERE;
} else {
	$hashh = fuck_sql_hackers($_COOKIE["sid"]);
	$result = mysqli_query($connection, "SELECT * FROM rvuti_users WHERE hash='$hashh'");
    $row = mysqli_fetch_array($result);
    if($row) {	
        $userhash = $row['hash'];
        $userid = $row['id'];
        $idref = $row['id'];
        $balance = $row['balance'];
        $login = $row['login'];
        $bon = $row['bonus'];
        
        $rand = rand(0, 999999);
    	$hash = hash('sha512', getUniqId());
    	$code = strToHex(encode($rand, '12345'));
        $code1 = implode("-", str_split($code, 4));
        setcookie('hid', $code1, time()+31536000, '/');
        mysqli_free_result($result);
    if($bon == 0) {
	    $bonusrow = <<<HERE
<div class="col-xs-12" id="bonusRow">
										
                                        <div class="card" style="box-shadow: rgb(210, 215, 222) 7px 10px 23px -11px;border-radius: 6px!important;">
										<div class="card-header" style="border-radius: 4px!important;">
                                                    
                                                   
                                                     
													<div class="heading-elements">
                                                        <ul class="list-inline mb-0 font-medium-2">
                                                            <li onclick="hideBonus()" data-toggle="tooltip" data-placement="top" title="" data-original-title="Больше не показывать"><a><i class="ft-x"></i></a></li>
                                                           <script>
														   function hideBonus(){
										$.ajax({
											type: 'POST',
											url: 'action.php',
											data: {
												type: "hideBonus",
												sid: Cookies.get('sid'),
											},
											success: function(data) {
												var obj = jQuery.parseJSON(data);
												if (obj.success == "success") {
													 $('#bonusRow').hide();
												}
											}
										});
														   }
														   </script>
                                                        </ul>
                                                    </div>
													 
                                                </div>
                                            <div class="card-body" style="margin-top:-35px">
                                                <div class="row">
													<div class="p-2 text-xs-center ">
													
													<h5>Для получения денежного бонуса</h5> 
													1. Подписаться на наш паблик, <a target="_blank" href="https://vk.com/brutiru">ссылка</a><br>
													2. Введите ссылку на Вашу страницу для проверки
													<center><input class="form-control text-xs-center" id="vkPage" style="width:240px;margin-top:6px" placeholder="https://vk.com/durov">
													<a id="error_bonus" class="btn  btn-block btnError" style="color: rgb(255, 255, 255); display: none;width:240px;margin-top:6px"></a>
													<a id="enter_but" onclick="getBonus()" class="btn   btn-block btnEnter" style="color:#fff;width:240px;margin-top:6px">
                                                                        Получить бонус</a></center>
													
													
													</div>
												</div>
												
											</div>
											<script>
											function getBonus() {
													if ($('#vkPage').val() == ''){
														$('#error_bonus').show();
														return $('#error_bonus').html('Введите страницу');
													}
													
													
												$.ajax({
                                                                            type: 'POST',
                                                                            url: 'action.php',
                                                                            data: {
                                                                                type: 'getBonus',
                                                                                sid: Cookies.get('sid'),
                                                                                vk: $('#vkPage').val(),
																				a:  Cookies.get('ab')
                                                                            },
                                                                            success: function(data) {
                                                                             var obj = jQuery.parseJSON(data);
                                                                                if (obj.success == "success") 
																				{
																						Cookies.set('ab', '1');
																						return location.href = "";
																				
																				}
																				if (obj.success == "error") {
																					$('#error_bonus').show();
																					return $('#error_bonus').html(obj.error);
																				}
                                                                            }
                                                                        });
											}
										</script>
										</div>
									</div>
HERE;
}
$result = mysqli_query($connection, "SELECT COUNT(*) FROM rvuti_payments WHERE user_id='".fuck_sql_hackers($userid)."'");
$row = mysqli_fetch_array($result);
if($row['COUNT(*)'] == 0) {
	$paymentss = '<tr><td colspan="6" class="text-xs-center">История пополнений пуста</td>                 
                        </tr>';
} else {
    $result33 = mysqli_query($connection, "SELECT * FROM rvuti_payments WHERE user_id='".fuck_sql_hackers($userid)."' ORDER BY `data` DESC");
    $rows33 = mysqli_num_rows($result33);
    for($b = 0; $b < $rows33; ++$b) {
        $row33 = mysqli_fetch_array($result33);
        $paymentss = $paymentss.'<tr style="cursor:default!important;""><td></td><td></td><td>'.$row33['data'].'<td style="text-align: center;">'.$row33['suma'].' B</td></td><td></td><td></td>
    
    							</tr>';
    } 
} 
mysqli_free_result($result33);
mysqli_free_result($result);

$result = mysqli_query($connection, "SELECT COUNT(*) FROM rvuti_payout WHERE user_id='".fuck_sql_hackers($userid)."' ORDER BY `data`");
$row = mysqli_fetch_array($result);

if($row['COUNT(*)'] == 0) {
	$payouts = '<tr><td id="emptyHistory" colspan="4" class="text-xs-center">История пуста</td>
															</tr>';
} else {	
	$result3 = mysqli_query($connection, "SELECT * FROM rvuti_payout WHERE user_id='".fuck_sql_hackers($userid)."' ORDER BY `data` DESC");
    $rows3 = mysqli_num_rows($result3);
    for($i = 0; $i < $rows3 ; ++$i) {
        $row3 = mysqli_fetch_array($result3);
    	if($row3['status'] == "Обработка") {
    		$tag = "warning";
    		$s = '';
    	}
    	if($row3['status'] == "Выполнено") {
    		$tag = "success";
    		$s = '';
    	}
    	if($row3['status'] == "Отменен") {
    		$tag = "danger";
    		$s = '';
    	}
    	$payouts = $payouts.'<tr style="cursor:default!important;" id=""><td>'.$s.$row3['data'].'</td><td><img src="files/qiwi.png"> '.$row3['suma'].' B</td><td>'.$row3['qiwi'].'</td>
    							<td><div class="tag tag-'.$tag.'">'.$row3['status'].' </div></td>
    
    							</tr>';
    	$tag = "";
    	++$i;
    }
    mysqli_free_result($result3);
}
//go
$modal = <<<HERE

<div class="modal fade text-xs-left" id="deposit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color:#F5F7FA;border-radius:6px">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="ft-x"></i></span>
                        </button>
                        <h4 class="modal-title" style="font-weight:600">Мы принимаем Free-Kassa</h4>
                    </div>
                    <div class="modal-body">
                    <div class="row" style="padding-bottom:15px">
					<div class="col-lg-8 offset-lg-2" style="padding-bottom:5px">
					<h5 class="text-xs-center"> </h5>
                                <h6></h6><h6> 
								</h6></div>
								<input id="systemPay" style="display:none">
					</div>
                    <div class="row">
                            <div class="col-lg-8 offset-lg-2">
                                <h6 id="fk_textamount">Cумма: </h6><h6>
								<input type="number" id="fk_amount" class="form-control" value="50">
								<a id="error_deposit" class="btn  btn-block btnError" style="color:#fff;margin-top:15px;display:none"></a>
								</h6></div>
								
								</div> 
							    
								 <div class="row">
                              <div id="payfk_result" class="col-lg-4 offset-lg-4" style="margin-top:8px;margin-bottom:18px">
                                
                            </div>
                            
							 <div class="col-lg-4 offset-lg-4" style="margin-top:8px;margin-bottom:18px">
                                <a class="btn  btn-block  " id="payfk_check" style="color:#fff;background: #6c7a89!important;" onclick="payfk()">
                                    <span>Пополнить</span>
                                </a>
                            </div>
							<div class="col-lg-4 offset-lg-4">
							<div class="text-xs-center">
                                <svg id="depositLoad" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="40px" height="40px" viewBox="0 0 100 100" style="background: none;display:none">
                                    <g transform="translate(50,50)">
                                        <circle cx="0" cy="0" r="7.142857142857143" fill="none" stroke="#31444f" stroke-width="2" stroke-dasharray="22.43994752564138 22.43994752564138" transform="rotate(337.283)">
                                            <animateTransform attributeName="transform" type="rotate" values="0 0 0;360 0 0" times="0;1" dur="1.6s" calcMode="spline" keySplines="0.2 0 0.8 1" begin="0" repeatCount="indefinite"></animateTransform>
                                        </circle>
                                        <circle cx="0" cy="0" r="14.285714285714286" fill="none" stroke="#465e6b" stroke-width="2" stroke-dasharray="44.87989505128276 44.87989505128276" transform="rotate(359.621)">
                                            <animateTransform attributeName="transform" type="rotate" values="0 0 0;360 0 0" times="0;1" dur="1.6s" calcMode="spline" keySplines="0.2 0 0.8 1" begin="-0.16666666666666666" repeatCount="indefinite"></animateTransform>
                                        </circle>
                                        <circle cx="0" cy="0" r="21.428571428571427" fill="none" stroke="#4c6470" stroke-width="2" stroke-dasharray="67.31984257692413 67.31984257692413" transform="rotate(15.8588)">
                                            <animateTransform attributeName="transform" type="rotate" values="0 0 0;360 0 0" times="0;1" dur="1.6s" calcMode="spline" keySplines="0.2 0 0.8 1" begin="-0.3333333333333333" repeatCount="indefinite"></animateTransform>
                                        </circle>
                                        <circle cx="0" cy="0" r="28.571428571428573" fill="none" stroke="#546E7A" stroke-width="2" stroke-dasharray="89.75979010256552 89.75979010256552" transform="rotate(50.6171)">
                                            <animateTransform attributeName="transform" type="rotate" values="0 0 0;360 0 0" times="0;1" dur="1.6s" calcMode="spline" keySplines="0.2 0 0.8 1" begin="-0.5" repeatCount="indefinite"></animateTransform>
                                        </circle>
                                        <circle cx="0" cy="0" r="35.714285714285715" fill="none" stroke="#fff" stroke-width="2" stroke-dasharray="112.1997376282069 112.1997376282069" transform="rotate(92.2943)">
                                            <animateTransform attributeName="transform" type="rotate" values="0 0 0;360 0 0" times="0;1" dur="1.6s" calcMode="spline" keySplines="0.2 0 0.8 1" begin="-0.6666666666666666" repeatCount="indefinite"></animateTransform>
                                        </circle>
                                        <circle cx="0" cy="0" r="42.857142857142854" fill="none" stroke="#fff" stroke-width="2" stroke-dasharray="134.63968515384826 134.63968515384826" transform="rotate(137.453)">
                                            <animateTransform attributeName="transform" type="rotate" values="0 0 0;360 0 0" times="0;1" dur="1.6s" calcMode="spline" keySplines="0.2 0 0.8 1" begin="-0.8333333333333334" repeatCount="indefinite"></animateTransform>
                                        </circle>
                                    </g>
                                </svg>
                            </div>
                            </div>
                            </div>
							<div class="table-responsive">
                    <table class="table mb-0">
                        <thead>
                            <tr style="cursor:default">
                                <th></th>
                                <th></th>
                                <th class="text-xs-center">Дата</th>
                                <th class="text-xs-center">Сумма</th>
                                <th></th>
                                <th></th>

                            </tr>
                        </thead>
                        <tbody>
						$paymentss
						</tbody>
                    </table>
                </div>
                    </div>
					<script>
					function deposit() {
						if ( $('#systemPay').val() > 2 || !$.isNumeric($('#systemPay').val())){
							$('#error_deposit').show();
							return $('#error_deposit').html('Укажите систему пополнения');
						}
						if ( $('#depositSize').val() == ''){
							$('#error_deposit').show();
							return $('#error_deposit').html('Введите сумму');
						}
						if (!$.isNumeric($('#depositSize').val()) || parseInt($('#depositSize').val()) < 50){
							$('#error_deposit').show();
							return $('#error_deposit').html('Введите корректную сумму');
						}
						$.ajax({
                    type: 'POST',
                    url: 'action.php',
                    data: {
                        type: "deposit",
                        sid: Cookies.get('sid'),
                        system: $('#systemPay').val(),
                        size: $('#depositSize').val()
                    },
                    success: function(data) {
                        var obj = jQuery.parseJSON(data);
                        if ('success' in obj) {
							 $('#depositLoad').show();
							window.location.href = obj.success.location;
                        }

                        if ('error' in obj) {
                            $('#error_deposit').show();
                            return $('#error_deposit').html(obj.error.text);
                        }

                    }
                });
						
					}
					</script>
                </div>
            </div>
        </div>
		<div class="modal fade text-xs-left" id="default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
									  <div class="modal-dialog" role="document">
										<div class="modal-content">
										  <div class="modal-header" style="background-color:#F5F7FA;border-radius:6px">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											  <span aria-hidden="true"><i class="ft-x"></i></span>
											</button>
											<h4 class="modal-title" style="font-weight:600">Настройки</h4>
										  </div>
										  <div class="modal-body">
										  <div class="row">
										    <div class="col-lg-8 offset-lg-2" style="margin-top:8px"><center><h2>Звуки</h2>(в разработке)</center></div>
										    <div class="col-lg-8 offset-lg-2" style="margin-top:8px">
    										    <div id="sounddiv" class="switch">
                                                        <input id="soundbox" type="checkbox" onclick="sound()">
                                                        <label><i></i></label>
                                                </div>
                                            </div>
                                            <div class="col-lg-8 offset-lg-2">
                                                <a id="sound_status" class="btn  btn-block btnSuccess" style="color: rgb(255, 255, 255); margin-top: 15px;display:none"></a>
										    </div>
										  </div>
										  <div class="row">
										    <div class="col-lg-8 offset-lg-2" style="margin-top:8px"><center><h2>Пароль</h2></center></div>
											<div class="col-lg-8 offset-lg-2" style="margin-top:8px">
                                <h6>Новый пароль:</h6>
                                <input type="password" id="resetPass" class="form-control">
                            </div><div class="col-lg-8 offset-lg-2" style="margin-top:8px">
                                <h6>Повторите пароль:</h6>
                                <input type="password" id="resetPassRepeat" class="form-control">

                            </div>
							
                            <div class="col-lg-8 offset-lg-2">
                                <a id="error_resetPass" class="btn  btn-block btnError" style="color:#fff;margin-top:15px;display:none"></a>
								<a id="succes_resetPass" class="btn  btn-block btnSuccess" style="color:#fff; cursor:default;  margin-top:15px;display:none;">Пароль изменен</a>
								</div>
								
							<div class="col-lg-4 offset-lg-4" style="margin-top:15px;margin-bottom:18px">
                                <a class="btn  btn-block  " style="color:#fff;background: #ed1a80!important;" onclick="resetPass()">
                                   <span>  Изменить</span>
                                </a>
                            </div>
										  </div>
										  
										  </div>
										 
										</div>
									  </div>
									</div>

<div class="modal fade text-xs-left" id="withdraw" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color:#F5F7FA;border-radius:6px">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="ft-x"></i></span>
                        </button>
                        <h4 class="modal-title" style="font-weight:600">Вывод средств</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">
							<h5 class="text-xs-center"> Выплаты от 5 минут до 7 дней</h5>
							<h5 class="text-xs-center"> Все комиссии берем на себя</h5>
							<br>
                                <h6>Cумма: </h6><h6> 
								<input onkeyup="validateWithdrawSize(this)" id="WithdrawSize" class="form-control " value="">
								</h6></div>
								</div>
								<div class="row">

<div class="col-lg-8 offset-lg-2">
											<h6>Платежная система:</h6>
                                <select class="hide-search form-control select2-hidden-accessible" id="hide_search" onchange="withdrawSelect()" tabindex="-1" aria-hidden="true">
                                    <optgroup label="Платежные системы">
                                        <option value="4">Qiwi</option>
                                       
</optgroup>
                                </select>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-lg-8 offset-lg-2" style="margin-top:8px">
                                <h6 id="nameWithdraw">Номер телефона:</h6>
                                <input id="walletNumber" class="form-control">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">
                                <a id="error_withdraw" class="btn  btn-block btnError" style="color:#fff;display:none;margin-top:15px;"></a>
                                <a id="succes_withdraw" class="btn  btn-block btnSuccess" style="color:#fff; cursor:default;  margin-top:15px;display:none;">Выплата успешно создана</a>
                            </div>
                            <div class="col-lg-4 offset-lg-4" style="margin-top:15px;margin-bottom:18px">
                                <a class="btn  btn-block  " style="color:#fff;background: #6c7a89!important;" onclick="withdraw()">
                                    <center><span id="withdrawB">  Выплата</span>

                                        <div id="loader" style="display:none">
                                            <div id="dot-container">
                                                <div id="left-dot" class="white-dot"></div>
                                                <div id="middle-dot" class="white-dot"></div>
                                                <div id="right-dot" class="white-dot"></div>
                                            </div>
                                        </div>

                                    </center>
                                </a>
                            </div>
                        </div>
						
						<br>
						<h5 class="text-xs-center"> Выплаты происходят в ручном режиме</h5>
						<br>
<div class="table-responsive">
                        <table class="table mb-0" id="withdrawTable">
                            <thead>
                                <tr style="cursor:default">
                                    <th style="width:1%">Дата</th>
                                    <th style="width:100%">Сумма</th>
                                    <th style="width:62%">Описание </th>
                                    <th>Статус</th>

                                </tr>
                            </thead>
                            <tbody id="withdrawT">
                               
                           
$payouts
                         </tbody>
                        </table>						</div>
						<div id="sh"></div>
                          
                            <div class="text-xs-center">
                                <svg id="withdrawHistoryLoad" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink" width="40px" height="40px" viewBox="0 0 100 100" style="background: none;display:none">
                                    <g transform="translate(50,50)">
                                        <circle cx="0" cy="0" r="7.142857142857143" fill="none" stroke="#31444f" stroke-width="2" stroke-dasharray="22.43994752564138 22.43994752564138" transform="rotate(15.8588)">
                                            <animateTransform attributeName="transform" type="rotate" values="0 0 0;360 0 0" times="0;1" dur="1.6s" calcMode="spline" keySplines="0.2 0 0.8 1" begin="0" repeatCount="indefinite"></animateTransform>
                                        </circle>
                                        <circle cx="0" cy="0" r="14.285714285714286" fill="none" stroke="#465e6b" stroke-width="2" stroke-dasharray="44.87989505128276 44.87989505128276" transform="rotate(50.6171)">
                                            <animateTransform attributeName="transform" type="rotate" values="0 0 0;360 0 0" times="0;1" dur="1.6s" calcMode="spline" keySplines="0.2 0 0.8 1" begin="-0.16666666666666666" repeatCount="indefinite"></animateTransform>
                                        </circle>
                                        <circle cx="0" cy="0" r="21.428571428571427" fill="none" stroke="#4c6470" stroke-width="2" stroke-dasharray="67.31984257692413 67.31984257692413" transform="rotate(92.2943)">
                                            <animateTransform attributeName="transform" type="rotate" values="0 0 0;360 0 0" times="0;1" dur="1.6s" calcMode="spline" keySplines="0.2 0 0.8 1" begin="-0.3333333333333333" repeatCount="indefinite"></animateTransform>
                                        </circle>
                                        <circle cx="0" cy="0" r="28.571428571428573" fill="none" stroke="#546E7A" stroke-width="2" stroke-dasharray="89.75979010256552 89.75979010256552" transform="rotate(137.453)">
                                            <animateTransform attributeName="transform" type="rotate" values="0 0 0;360 0 0" times="0;1" dur="1.6s" calcMode="spline" keySplines="0.2 0 0.8 1" begin="-0.5" repeatCount="indefinite"></animateTransform>
                                        </circle>
                                        <circle cx="0" cy="0" r="35.714285714285715" fill="none" stroke="#fff" stroke-width="2" stroke-dasharray="112.1997376282069 112.1997376282069" transform="rotate(184.948)">
                                            <animateTransform attributeName="transform" type="rotate" values="0 0 0;360 0 0" times="0;1" dur="1.6s" calcMode="spline" keySplines="0.2 0 0.8 1" begin="-0.6666666666666666" repeatCount="indefinite"></animateTransform>
                                        </circle>
                                        <circle cx="0" cy="0" r="42.857142857142854" fill="none" stroke="#fff" stroke-width="2" stroke-dasharray="134.63968515384826 134.63968515384826" transform="rotate(230.652)">
                                            <animateTransform attributeName="transform" type="rotate" values="0 0 0;360 0 0" times="0;1" dur="1.6s" calcMode="spline" keySplines="0.2 0 0.8 1" begin="-0.8333333333333334" repeatCount="indefinite"></animateTransform>
                                        </circle>
                                    </g>
                                </svg>
                            </div>

                    </div>

                </div>
            </div>
			
        </div>

HERE;
$panel = <<<HERE
<script>
updateBalance(0,$balance);
</script>
<span onclick="bPlay('Camera-shutter.mp3')" class="closed-toggled" id="close-toggle" style="
    font-size: 26px;
    position:  absolute;
    font-weight: 700;
    right: 10px;
    top: -10px;
    z-index:  100;
    padding: 20px;
    cursor: pointer;
">&lt;</span>
                    <ul id="main-menu-navigation" class="ul-toggle-menu">
                        <li class="dropdown nav-item active" onclick="$('.dsec').hide();$('#lastBets').show();$(document.body).removeClass('menu-open');$(window).scrollTop($('#lastBets').offset().top);">
                            <a class="dropdown-toggle nav-link" onclick="bPlay('snap.mp3')"><i class="fas fa-home"></i><span>Главная</span></a>

                        </li>
                        <li class="dropdown nav-item " onclick="$('.dsec').hide();$('#rules').show();$(document.body).removeClass('menu-open');$(window).scrollTop($('#rules').offset().top);">
                            <a class="dropdown-toggle nav-link" onclick="bPlay('snap.mp3')"><i class="fas fa-dice-five"></i><span>Как играть</span></a>
                        </li>
                        
                        <li class="dropdown nav-item " onclick="$('.dsec').hide();$('#promo1').show();$(document.body).removeClass('menu-open');$(window).scrollTop($('#promo1').offset().top);">
                            <a class="dropdown-toggle nav-link" onclick="bPlay('snap.mp3')"><i class="fas fa-ticket-alt"></i><span>Промокод</span></a>
                        </li>

						                        <li id="setPop" data-toggle="modal" data-target="#default" class="dropdown nav-item " style="float:right!impotant">
                            <a class="dropdown-toggle nav-link" onclick="loadsoundbox(); bPlay('snap.mp3')"><i class="fas fa-circle-notch"></i><span>Настройки</span></a>
                        
                        </li> <li class="dropdown nav-item " style="float:right!impotant" onclick="$('.dsec').hide();$('#referals').show();$(document.body).removeClass('menu-open');$(window).scrollTop($('#referals').offset().top);">  
                        
                            <a class="dropdown-toggle nav-link" onclick="bPlay('snap.mp3')"><i class="fas fa-coins"></i><span>Мои рефералы</span></a>
                        </li> 
						
												<li class="dropdown nav-item " onclick="$('.dsec').hide();$('#contacts').show();$(document.body).removeClass('menu-open');$(window).scrollTop($('#contacts').offset().top);">
                            <a class="dropdown-toggle nav-link" onclick="bPlay('snap.mp3')"><i class="fas fa-comments"></i><span>Контакты</span></a>
                        </li>
						<li class="dropdown nav-item " onclick="$('.dsec').hide();$('#lastWithdraw').show();$(document.body).removeClass('menu-open');$(window).scrollTop($('#lastWithdraw').offset().top);">
                            <a class="dropdown-toggle nav-link" onclick="bPlay('snap.mp3')"><i class="fas fa-clock"></i><span>Выплаты</span></a>
                        </li>
                        <li class="dropdown nav-item " onclick="$('.dsec').hide();$('#topRef').show();$(document.body).removeClass('menu-open');$(window).scrollTop($('#lastWithdraw').offset().top);">
                            <a class="dropdown-toggle nav-link" onclick="bPlay('snap.mp3')"><i class="fas fa-users"></i><span>Топ рефоводов</span></a>
                        </li>
												<li id="exit" class="dropdown nav-item " style="float:right!impotant" onclick="Cookies.set('sid', '');location.href = 'https://bruti.ru/';">
                            <a class="dropdown-toggle nav-link" onclick="bPlay('snap.mp3')"><i class="fas fa-times"></i><span>Выйти</span></a>
                        </li>
						                        <script>
                            $(function() {
                                $("#main-menu-navigation  li").click(function() {
                                    
									if ($(this).attr('id') !== 'setPop' && $(this).attr('id') !== 'exit'){
										$("#main-menu-navigation  li").removeClass("active");
										$(this).toggleClass("active");
									}
                                    
                                })
                            });
                        </script>
						<button style="margin-top:12px;float:right;" class="flat_button logo_button  color3_bg" onclick="window.open(&quot;https://vk.com/brutiru&quot;);">Мы Вконтакте</button>
                    </ul>

HERE;
$go = <<<HERE

<div class="row">
																$bonusrow
									                                    <div class="col-xs-12">
										
                                        <div class="card">
                                            <div class="card-body" style="box-shadow: rgb(210, 215, 222) 7px 10px 23px -11px;border-radius: 6px!important;">
                                                <div class="row">
                                                <div class="col-sm-4 col-12" style="border-right: solid 1px #eaeaea;">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 ">
													
                                                        <div class="text-xs-center mt52">
                                                            <h3 class="display-6 blue-grey darken-1" style="text-transform: capitalize!important;">$login </h3>
                                                            
															<img class="avatar23" src="img/avatarM.png">

                                                            <div class="card-body">
                                                                <center>
																
                                                                    <ul class="list-inline list-inline-pipe" style="font-size:15px; margin-top: 20px;">
                                                                        <li style="cursor:pointer;padding:  10px;background: rgb(141,85,238);background: -moz-linear-gradient(top, rgb(141,85,238) 0%, rgb(74,121,239) 100%);background: -webkit-linear-gradient(top, rgb(141,85,238) 0%,rgb(74,121,239) 100%);background: linear-gradient(to bottom, rgb(141,85,238) 0%,rgb(74,121,239) 100%);filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#8d55ee', endColorstr='#4a79ef',GradientType=0 );color: #fff;border-radius: 5px;" data-toggle="modal" data-target="#deposit" style="cursor:pointer">Пополнить</li>
                                                                        <li data-toggle="modal" data-target="#withdraw" style="cursor:pointer;cursor: pointer;padding: 10px;background: rgb(141,85,238);background: -moz-linear-gradient(top, rgb(141,85,238) 0%, rgb(74,121,239) 100%);background: -webkit-linear-gradient(top, rgb(141,85,238) 0%,rgb(74,121,239) 100%);background: linear-gradient(to bottom, rgb(141,85,238) 0%,rgb(74,121,239) 100%);filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#8d55ee', endColorstr='#4a79ef',GradientType=0 );color: #fff;border-radius: 5px;">Вывод </li>
                                                                    </ul>
                                                                </center>
																	
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                    
                                                    <div class="col-12">
                                                        <div class="p-1">

                                                            <div class="card-body" style="margin-top:2px;"><center style="margin-left: 15px;"><h1>ВАШ БАЛАНС:</h1>
<h3 class="display-4 blue-grey darken-1"><span class="odometer odometer-auto-theme" id="userBalance" mybalance="$balance"><div class="odometer-inside"><span class="odometer-digit"><span class="odometer-digit-spacer">8</span><span class="odometer-digit-inner"><span class="odometer-ribbon"><span class="odometer-ribbon-inner"><span class="odometer-value">$balance</span></span></span></span></span></div></span> B</h3></center>
                                                                <div id="controlBet" style="margin-left: 1px;" class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <input id="BetSize" type="number" onkeyup="updateProfit();" class="form-control text-xs-center" placeholder="Сумма ставки">
                                                                            <script>
                                                                                /* function validateBetSize(inp) {
                                                                                    inp.value = inp.value.replace(/[,]/g, '.')
                                                                                        .replace(/[^\d,.]*/g, '')
                                                                                        .replace(/([,.])[,.]+/g, '$1')
                                                                                        .replace(/^[^\d]*(\d+([.,]\d{0,2})?).*$/g, '$1');
                                                                                } */
                                                                            </script>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">

                                                                        <div class="form-group">
                                                                            <input id="BetPercent" onkeyup="validateBetPercent(this); updateProfit();" class="form-control text-xs-center" placeholder="% Шанса">
                                                                            <script>
                                                                                function validateBetPercent(inp) {
                                                                                    if (inp.value > 95) {
                                                                                        inp.value = 95;
                                                                                    }
																					

                                                                                    inp.value = inp.value.replace(/[,]/g, '.')
                                                                                        .replace(/[^\d,.]*/g, '')
                                                                                        .replace(/([,.])[,.]+/g, '$1')
                                                                                        .replace(/^[^\d]*(\d+([.,]\d{0,2})?).*$/g, '$1');
                                                                                }
                                                                            </script>
                                                                        </div>
                                                                    </div>

                                                                </div>
																
                                                       
                                                            </div>

                                                        </div>

                                                    </div>
													
													
													
                                                    <div id="betStart" class="col-12" style="margin-top: -20px;">
                                                        <div class="p-1 text-xs-center" style="margin-left: 15px;">
                                                            
															
                                                            <div class="card-body">
                                                                <div class="row text-xs-center" style="padding-top:10px">
                                                                    <div class="col-md-12 col-xs-12">
                                                                        <div class="form-group">
                                                                            <button onclick="bet('betMin')" id="buttonMin" style="margin-top:5px;color:#fff;background: rgb(41,53,86);background: -moz-linear-gradient(top, rgb(41,53,86) 1%, rgb(57,64,81) 100%, rgb(46,57,96) 100%);background: -webkit-linear-gradient(top, rgb(41,53,86) 1%,rgb(57,64,81) 100%,rgb(46,57,96) 100%);background: linear-gradient(to bottom, rgb(41,53,86) 1%,rgb(57,64,81) 100%,rgb(46,57,96) 100%);filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#293556', endColorstr='#2e3960',GradientType=0 );box-shadow:rgba(119, 133, 148, 0.73) 7px 10px 23px -11px;border-radius:  10px;" type="button" class="bg-blue-grey bg-lighten-2  btn  btn-block mr-1 mb-1 sound_button">Меньше</button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 col-xs-12">

                                                                        <div class="form-group">
                                                                            <button onclick="bet('betMax')" type="button" id="buttonMax" style="margin-top:5px;color:#fff;box-shadow:rgba(119, 133, 148, 0.73) 7px 10px 23px -11px;border: 0px solid;background: rgb(41,53,86);background: -moz-linear-gradient(top, rgb(41,53,86) 1%, rgb(57,64,81) 100%, rgb(46,57,96) 100%);background: -webkit-linear-gradient(top, rgb(41,53,86) 1%,rgb(57,64,81) 100%,rgb(46,57,96) 100%);background: linear-gradient(to bottom, rgb(41,53,86) 1%,rgb(57,64,81) 100%,rgb(46,57,96) 100%);filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#293556', endColorstr='#2e3960',GradientType=0 );border-radius: 10px;" class="bg-blue-grey bg-lighten-2  btn  btn-block mr-1 mb-1 sound_button">Больше</button>

                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                
                                                                <div>
                                                                    <h3 class="display-4 success1 " style="word-wrap:break-word;"><span id="BetProfit">2.00</span> BRU</h3>
                                                                    <span class="blue-grey darken-1 " style="font-size:17px">Возможный выигрыш</span>

                                                                </div>
                                                             
																
												<center><div id="betLoad" class="cssload-loader" style="background: none;display:none;">
												  <div class="cssload-inner cssload-one"></div>
												  <div class="cssload-inner cssload-two"></div>
												  <div class="cssload-inner cssload-three"></div>
												</div></center>
                                                                <a id="error_bet" class="btn  btn-block btnError" style="color:#fff;display:none"></a>
                                                                <a id="succes_bet" class="btn  btn-block btnSuccess" style="color:#fff; cursor:default;   margin-top: 0rem; display:none"></a>

                                                            </div>
                                                            <center style="padding: 0.4rem!important;">

                                                                <a id="checkBet" style="display:none;-webkit-user-select: none;-moz-user-select: none;" class="blue-grey darken-1 " href="" target="_blank">Проверить игру</a>
                                                            </center>
                                                        </div>
                                                    </div>
                                                    </div>
                                                <div class="col-sm-8 col-12" style="">
                                            <div class="card">
                                                <div class="card-header"   style="border-radius: 4px!important;-webkit-user-select: none;-moz-user-select: none;">
                                                    <h4 class="card-title" style=""><b>История игр</b></h4> <div  style="margin-top: -13px;margin-left: 135px;display: inline-block;position: absolute;" class="circle-online pulse-online" ></div> <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Онлайн" id="oe" style="margin-top: -19px;margin-left: 150px;display: inline-block;position: absolute;"><?php echo $online; ?></span>
                                                   
                                                     
													<div class="heading-elements">
                                                        <ul class="list-inline mb-0">
                                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                                        </ul>
                                                    </div>
													 
                                                </div>
                                                <div class="card-body collapse in" style="-webkit-user-select: none;-moz-user-select: none; box-shadow: rgb(210, 215, 222) 7px 10px 23px -11px;" >
                                                   <center>
                                                    <h4>История игры временно не будет отображаться, в связи с перегрузкой на сервер. :(</br>Приносим свои извинения.<h4>
                                                    </center>
                                                    <!-- ИСТОРИЯ ИГР
                                                    <div class="table-responsive">
                                                        <table class="table mb-0" style="width: 98%;">
                                                            <thead>
                                                
															
															
                                                                <tr style="cursor:default!important" class="polew">
                                                                    <th style="width:20%" >Игрок</th>
                                                                    <th>Число</th>
                                                                    <th>Диапазон</th>
                                                                    <th style="width:14%">Сумма</th>
                                                                    <th>Шанс</th>
                                                                    <th>Выигрыш</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="response">
																<tr><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td></tr>
<tr><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td></tr>
<tr><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td></tr>
<tr><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td></tr>
<tr><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td></tr>
<tr><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td></tr>
<tr><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td></tr>
<tr><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td></tr>
<tr><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td></tr>
<tr><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td></tr>
<tr><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td></tr>
<tr><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td></tr>
<tr><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td></tr>
<tr><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td></tr>
<tr><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td></tr>
<tr><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td></tr>
<tr><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td></tr>
<tr><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td></tr>
<tr><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td></tr>
<tr><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td></tr>
<tr><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td></tr>
<tr><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td><td class="text-xs-center font-small-2"><span><progress style="margin-top:8px;" class="progress progress-sm mb-0" value="0" max="100"></progress></span></td></tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    -->
                                                    
                                                    
                                                </div>
                                            </div>
                                        </div>
                                                    

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
HERE;
}
else
{
	setcookie('sid', "", time()- 10000);
	//setcookie('login', "", time()- 10000);
	$panel = <<<HERE

<div data-menu="menu-container" class="navbar-container main-menu-content container center-layout">
                    <!-- include ../../../includes/mixins-->
                    <ul id="main-menu-navigation" data-menu="menu-navigation" class="nav navbar-nav">
                        <li class="dropdown nav-item active" onclick="$('.dsec').hide();$('#lastBets').show();$(document.body).removeClass('menu-open');$(window).scrollTop($('#lastBets').offset().top);">
                            <a class="dropdown-toggle nav-link"><span>Главная</span></a>

                        </li>
                        <li class="dropdown nav-item " id="gg" onclick="$('.dsec').hide();$('#realGame').show();$(document.body).removeClass('menu-open');$(window).scrollTop($('#realGame').offset().top);">
                            <a class="dropdown-toggle nav-link"><span>Честная игра</span></a>

                        </li>
                        <li class="dropdown nav-item " onclick="$('.dsec').hide();$('#rules').show();$(document.body).removeClass('menu-open');$(window).scrollTop($('#rules').offset().top);">
                            <a class="dropdown-toggle nav-link"><span>Как играть</span></a>
                        </li>

												<li class="dropdown nav-item " onclick="$('.dsec').hide();$('#contacts').show();$(document.body).removeClass('menu-open');$(window).scrollTop($('#contacts').offset().top);">
                            <a class="dropdown-toggle nav-link"><span>Контакты</span></a>
                        </li>
						<li class="dropdown nav-item " onclick="$('.dsec').hide();$('#lastWithdraw').show();$(document.body).removeClass('menu-open');$(window).scrollTop($('#lastWithdraw').offset().top);">
                            <a class="dropdown-toggle nav-link"><span>Выплаты</span></a>
                        </li>
						<button style="margin-top:12px;float:right;" class="flat_button logo_button  color3_bg" onclick="window.open(&quot;https://vk.com/brutiru&quot;);">Мы Вконтакте</button>
                    </ul>
                </div>

HERE;

$go = <<<HERE
	
					                         <div class="row">
                            <div class="col-xs-12">
                                <div class="card">
                                    <div class="card-body" style="box-shadow: rgba(210, 215, 222, 0.5) 7px 10px 23px -11px;border-radius: 6px!important;">
                                        <div class="row">
                                            <div class="col-lg-6  col-md-12 col-sm-12 ">
                                                <div id="what-is" class="card">
                                                    <div  class="card-header"   style="border-radius: 4px!important;">
                                                        <h4 class="card-title"><b>Что такое Bruti?</b></h4>

                                                    </div>
                                                    <div class="card-body collapse in">
                                                        <div class="card-block">
                                                            <div class="card-text">
                                                                <p style="font-size:15.5px">Сайт мгновенных игр, где шанс выигрыша указываете сами. </p>
                                                                <ul>
                                                                    <li>Денежный бонус при регистрации</li>
                                                                    <li>Быстрые выплаты без комиссий и прочих сборов</li>
                                                                    <li>Активируйте промо-коды друзей</li>
                                                                    <li>Дополнительно зарабатывайте на рефералах</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6  col-md-12 col-sm-12 ">
                                                <div id="login">
                                                    
                                                    <div class="col-lg-10 offset-lg-1">
													<div class="card-header no-border pb-0">
                                                        <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2"><span style="font-size:17px"> Авторизация </span></h6>
                                                    </div>
                                                        <div class="card-body collapse in">
                                                            <div class="card-block">
                                                                <form class="form-horizontal">
                                                                    <fieldset class="form-group position-relative has-icon-left">
                                                                        <input type="text" class="form-control form-control-md input-md" id="userLogin" value="" placeholder="Логин"  >
                                                                        <div class="form-control-position">
                                                                            <i class="ft-user"></i>
                                                                        </div>
                                                                    </fieldset>
                                                                    <fieldset class="form-group position-relative has-icon-left">
                                                                        <input type="password" class="form-control form-control-md input-md" id="userPass" placeholder="Пароль">
                                                                        <div class="form-control-position">
                                                                            <i class="ft-lock"></i>
                                                                        </div>
                                                                    </fieldset>
																	<!-- <div style="padding-bottom:11px" class="g-recaptcha" data-sitekey="6Leov1QUAAAAAHv1ApORTURwZZaWw_JgLOnfvJJC"></div> -->
																
                                                                    <a id="error_enter" class="btn  btn-block btnError" style="color:#fff;display:none"></a>

                                                                    <a id="enter_but" onclick="login()" class="btn   btn-block btnEnter" style="color:#fff;margin-bottom:5px">
                                                                        <center><span id="text_enter"> <i class="ft-unlock"></i>  Войти</span>

                                                                            <div id="loader" style="position:absolute">
                                                                                <div id='dot-container' style='display:none'>
                                                                                    <div id="left-dot" class='white-dot'></div>
                                                                                    <div id='middle-dot' class='white-dot'></div>
                                                                                    <div id='right-dot' class='white-dot'></div>
                                                                                </div>
                                                                            </div>

                                                                        </center>
                                                                    </a>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <div class="card-footer no-border" style="margin-top:-12x">
                                                            <p class="float-sm-left text-xs-center"><a onclick="register_show()" class="card-link">Регистрация</a></p>
                                                            <p class="float-sm-right text-xs-center"><a onclick="reset_show()" class="card-link">Забыли пароль? </a></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="register" style="display:none">
                                                   
                                                    <div class="col-lg-10 offset-lg-1">
													 <div class="card-header no-border pb-0" >
                                                        <h6  class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2"><span style="font-size:17px">Регистрация </span></h6>
                                                    </div>
                                                        <div class="card-body collapse in">
                                                            <div class="card-block">
                                                                <form class="form-horizontal" >
                                                                    <fieldset class="form-group position-relative has-icon-left">
                                                                        <input type="text" class="form-control form-control-md input-md" id="userLoginRegister" placeholder="Логин">
                                                                        <div class="form-control-position">
                                                                            <i class="ft-user"></i>
                                                                        </div>
                                                                    </fieldset>
                                                                    <fieldset class="form-group position-relative has-icon-left">
                                                                        <input type="email" class="form-control form-control-md input-md" id="userEmailRegister" placeholder="E-mail">
                                                                        <div class="form-control-position">
                                                                            <i class="ft-mail"></i>
                                                                        </div>
                                                                    </fieldset>
                                                                    <fieldset class="form-group position-relative has-icon-left">
                                                                        <input type="password" class="form-control form-control-md input-md" id="userPassRegister" placeholder="Пароль">
                                                                        <div class="form-control-position">
                                                                            <i class="ft-lock"></i>
                                                                        </div>
                                                                    </fieldset>
																	<fieldset style="padding-bottom: 7px;">
																		<label class="check1">
																		  <input id="rulesagree" type="checkbox"/>
																		  <div class="box1"></div>
																		 
																		 
																		</label>
																		 <div style="display:inline-block;padding-left:10px;position:absolute">Согласен c <u data-toggle="modal" data-target="#large" style="cursor:pointer">правилами</u></div>
																	</fieldset>
																	<!-- <div style="padding-bottom:11px" class="g-recaptcha" data-sitekey="6Leov1QUAAAAAHv1ApORTURwZZaWw_JgLOnfvJJC"></div> -->
                                                                    <a id="error_register" class="btn  btn-block btnError" style="color:#fff;display:none"></a>
                                                                    <a onclick="register1()" class="btn   btn-block btnEnter" style="color:#fff;margin-bottom:5px">

                                                                        <center><span id="text_register"><i class="ft-check"></i> Зарегистрироваться</span>

                                                                            <div id="loader_register" style="position:absolute">
                                                                                <div id='dot-container_register' style='display:none'>
                                                                                    <div id="left-dot_register" class='white-dot'></div>
                                                                                    <div id='middle-dot_register' class='white-dot'></div>
                                                                                    <div id='right-dot_register' class='white-dot'></div>
                                                                                </div>
                                                                            </div>

                                                                        </center>
                                                                    </a>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <div class="card-footer no-border" style="margin-top:-12px">
                                                            <p class="float-sm-left text-xs-center"><a onclick="login_show()" class="card-link">Есть аккаунт</a></p>
                                                            <p class="float-sm-right text-xs-center"><a onclick="reset_show()" class="card-link">Забыли пароль? </a></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="reset" style="display:none">
                                                    
                                                    <div class="col-lg-10 offset-lg-1">
													<div class="card-header no-border pb-0">
                                                        <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2"><span style="font-size:17px">Вспомнить пароль</span></h6>
                                                    </div>
                                                        <div class="card-body collapse in">
                                                            <div class="card-block">
                                                             
                                                                    <fieldset class="form-group position-relative has-icon-left">
                                                                        <input type="text" class="form-control form-control-md input-md" id="loginemail" placeholder="Логин или E-mail">
                                                                        <div class="form-control-position">
                                                                            <i class="ft-search"></i>
                                                                        </div>
                                                                    </fieldset>
																	<!-- <div style="padding-bottom:11px" class="g-recaptcha" data-sitekey="6Leov1QUAAAAAHv1ApORTURwZZaWw_JgLOnfvJJC"></div> -->
                                                                    <a id="error_reset" class="btn  btn-block btnError" style="color:#fff;display:none"></a>
                                                                    <a id="reset_success" class="btn  btn-block btnSuccess" style="color:#fff;display:none"></a>
                                                                    <a  id="reset_but" onclick="reset_password()" class="btn   btn-block btnEnter" style="color:#fff;margin-bottom:5px">

                                                                        <center><span id="text_reset"><i class="ft-check"></i> Вспомнить</span>

                                                                            <div id="loader_reset" style="position:absolute">
                                                                                <div id='dot-container_reset' style='display:none'>
                                                                                    <div id="left-dot_reset" class='white-dot'></div>
                                                                                    <div id='middle-dot_reset' class='white-dot'></div>
                                                                                    <div id='right-dot_reset' class='white-dot'></div>
                                                                                </div>
                                                                            </div>

                                                                        </center>
                                                                    </a>                                                               
                                                            </div>
                                                        </div>
 
                                                        <div class="card-footer no-border" style="margin-top:-12px">
                                                            <p class="float-sm-left text-xs-center"><a onclick="login_show()" class="card-link">Есть аккаунт</a></p>
                                                            <p class="float-sm-right text-xs-center"><a onclick="register_show()" class="card-link">Регистрация </a></p>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
HERE;
	
}
}
?>
    <!DOCTYPE html>

    <html lang="ru" >

    <head>
	<style>
	.avatar23 {
	width: 150px;
	height: 150px;
	border-radius: 100px; /* половина ширины и высоты */
	    display: block;
    margin: 0 auto;

}

	</style>
	<link rel="shortcut icon" href="/files/fav_logo.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="referrer" content="no-referrer">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="description" content="Что такое Bruti? Сервис мгновенных игр, где шанс выигрыша указываете сами. Быстрые выплаты без комиссий и прочих сборов.">
        <meta name="keywords" content="">
        <meta name="google-site-verification" content="L33UAmT2CILB0_clEQoqnL5XmzTicSSTipTBGS1b3JA">
        <title>Bruti - Сайт мгновенных игр, где шанс выигрыша указываете сами.
        </title>
        <link rel="stylesheet" type="text/css" href="files/palette-climacon.css">
        <link rel="stylesheet" type="text/css" href="files/style.min(1).css">
        <!-- END PAGE VENDOR JS-->
        <!-- BEGIN STACK JS-->
        <link rel="stylesheet" type="text/css" href="files/css.css" >
        <!-- BEGIN VENDOR CSS-->
        <link rel="stylesheet" type="text/css" href="files/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="files/style.minn.css">
        <link rel="stylesheet" type="text/css" href="files/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="files/flag-icon.min.css">
        <link rel="stylesheet" type="text/css" href="files/morris.css">
        <link rel="stylesheet" type="text/css" href="files/emoji.css">
		
        <link rel="stylesheet" type="text/css" href="files/climacons.min.css">
        <link rel="stylesheet" type="text/css" href="files/loader-gg.css">
        <!-- END VENDOR CSS-->
        <!-- BEGIN STACK CSS-->
        <link rel="stylesheet" type="text/css" href="files/bootstrap-extended.min.css">
        <link rel="stylesheet" type="text/css" href="files/app.min.css">
        <link rel="stylesheet" type="text/css" href="files/colors.min.css">
        <!-- END STACK CSS-->
        <!-- BEGIN Page Level CSS-->
        <link rel="stylesheet" type="text/css" href="files/horizontal-menu.min.css">
		<link rel="stylesheet" href="files/right-nav-style.css">
		
        <link rel="stylesheet" type="text/css" href="files/vertical-overlay-menu.min.css">
        <!-- link(rel='stylesheet', type='text/css', href='../../../app-assets/css#{rtl}/pages/users.css')-->
        <!-- END Page Level CSS-->
        <!-- BEGIN Custom CSS-->
        <link rel="stylesheet" type="text/css" href="files/style.css">
        <!-- END Custom CSS-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">


<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>		
	</head>
<script language="javascript" type="text/javascript">
window.onerror = myOnError;
function myOnError(msg, url, lno) {
return true;
}
</script>

<script type="text/javascript" src="//vk.com/js/api/openapi.js?154"></script> 
    <body bgcolor="red">
        <!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter48938210 = new Ya.Metrika({
                    id:48938210,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/48938210" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<input type="checkbox" id="navs-toggle" hidden>
        <!-- navbar-fixed-top-->
        <nav class="header-navbar navbar navbar-with-menu navbar-static-top navbar-light navbar-border navbar-brand-center" style="border-radius: 0;" data-nav="brand-center">
             <a id="toggle" class="menus-bars" onclick="bPlay('shutter.mp3')"><i style="color: #FFFFFF;" class="ft-menu font-large-1"></i></a>
            <div class="navbar-wrapper">
                <div class="navbar-header">
                    <ul class="nav navbar-nav">
                        <li class="nav-item">
                            <a href="" class="navbar-brand">
                                </center><img src="files/logo.png"></center></a>
                        </li>
                       
                    </ul>
                </div>

            </div>
        </nav>

        <!-- ////////////////////////////////////////////////////////////////////////////-->

        <!-- Horizontal navigation-->
													
        <div id="menu-show" class="toggle-menu" style="border-radius: 0;" >
            <?php echo $panel; ?>                
        </div>
        <div class="container">
            <div class="row">
            <div class="col-xs-12">
                <section id="promo1" class="card dsec" style="display:none; margin-top: 20px">
                                        <div  class="card-header"   style="border-radius: 4px!important;">
                                            <h4 class="card-title "><b>Промокод:</b></h4>
<div class="heading-elements">
                                                        <ul class="list-inline mb-0">
                                                            <li><a onclick="$('.dsec').hide();$('#lastBets').show();$(document.body).removeClass('menu-open');$(window).scrollTop($('#lastBets').offset().top);"><i class="ft-minus"></i></a></li>
                                                        </ul>
                                                    </div>
                                        </div>
                                        <div class="card-body collapse in">
                                            <div class="card-block">
                                                <div class="card-text">

                                                    <ul><center>
                                                        <h3>Введите промокод, для получения бонусных очков на баланс.</h3>
                                                        <div id="promo_result"></div>
                                                        <p></p><input id="promo_code" name="code" type="text" size="20"></p>
                                                        <button id="promo_check" onclick="promo_active()" style="margin-top:5px;color:#fff;    background: linear-gradient(to right, rgb(122, 134, 148), rgb(99, 107, 116))!important; border: 0px solid;box-shadow:rgba(119, 133, 148, 0.73) 7px 10px 23px -11px; " class="bg-blue-grey bg-lighten-2  btn  btn-block mr-1 mb-1 sound_button" >Получить бонус!</button>
                                                        </center>
                                                    </ul>

                                                </div>
                                            </div>
                                        </div>
                                    </section>
                 <section id="rules" class="card dsec" style="display:none; margin-top: 20px">
                                        <div  class="card-header"   style="border-radius: 4px!important;">
                                            <h4 class="card-title "><b>Очень простая игра</b></h4>
<div class="heading-elements">
                                                        <ul class="list-inline mb-0">
                                                            <li><a onclick="$('.dsec').hide();$('#lastBets').show();$(document.body).removeClass('menu-open');$(window).scrollTop($('#lastBets').offset().top);"><i class="ft-minus"></i></a></li>
                                                        </ul>
                                                    </div>
                                        </div>
                                        <div class="card-body collapse in">
                                            <div class="card-block">
                                                <div class="card-text">

                                                    <ul>
                                                        <li>Укажите размер ставки и свой шанс выигрыша. Будет показан возможный (расчетный) выигрыш от вашей ставки.</li>
                                                        <li>Выбираете промежуток больше или меньше.</li>
                                                        <li><a style="color: #00A5A8;" onclick="$('.dsec').hide();$('#realGame').show();$('#main-menu-navigation  li').removeClass('active');$('#gg').addClass('active');">Заранее генерируется число от 0 до 999 999</a>. Если число находится в пределах диапазона больше/меньше , который вы выбрали,вы выигрываете.</li>

                                                    </ul>

                                                </div>
                                            </div>
                                        </div>
                                    </section> 
                <section id="referals" class="dsec"  style="display:none; margin-top: 20px;">
                                	<div class="row ">
                                        <div class="col-xs-12">
                                            <div class="card">
                                                <div  class="card-header"   style="border-radius: 4px!important;">
                                                    <h4 class="card-title "><b>Ваша реферальная ссылка: </b> <span style="text-transform:none!important">https://bruti.ru/?i=<?php echo $idref; ?></span> <i id="sucCopy" style="display:none"class="ft-check"></i><i onclick="$(this).hide();$('#sucCopy').show()"class="ft-copy btn-clipboard" data-clipboard-text="https://bruti.ru/?i=<?php echo $idref; ?>" style="cursor:pointer" data-toggle="tooltip" data-placement="top" title="" data-original-title="Скопировать ссылку"></i></h4>
<div class="heading-elements">
                                                        <ul class="list-inline mb-0">
                                                            <li><a onclick="$('.dsec').hide();$('#lastBets').show();$(document.body).removeClass('menu-open');$(window).scrollTop($('#lastBets').offset().top);"><i class="ft-minus"></i></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="card-body collapse in">
												<div class="card-block card-dashboard">
                    Получайте 10% с каждого пополнения баланса реферала
                </div>
																	
                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                       <thead>
                            <tr >
<?php
$result221 = mysqli_query($connection, "SELECT * FROM rvuti_users WHERE referer='$idref' ORDER BY `data_reg` DESC");
$rows221 = mysqli_num_rows($result221);

for($k = 0; $k < $rows221; ++$k) {
    $row221 = mysqli_fetch_array($result221);
    $result423 = mysqli_query($connection, "SELECT SUM(suma) FROM rvuti_payments WHERE user_id=".fuck_sql_hackers($row221['id']));
    $row423 = mysqli_fetch_array($result423);
	$sumapey += $row423['SUM(suma)'];
    $sumapeys = ($sumapey / 100) * 10;
}

mysqli_free_result($result221);
mysqli_free_result($result423);

echo <<<HERE
		                                <th></th>
                                <th></th>
                                <th class="text-xs-center">Дата</th>
                                <th class="text-xs-center">Пользователь (Всего: $rows221)</th>
                                <th class="text-xs-center">Принес (Всего: $sumapeys  P) </th>
                                <th></th>
                                <th></th>
                                
                            </tr>
                        </thead>
                        <tbody>
HERE;
$result22 = mysqli_query($connection, "SELECT * FROM rvuti_users WHERE referer='".fuck_sql_hackers($idref)."' ORDER BY `data_reg` DESC");
$rows22 = mysqli_num_rows($result22);
for($k = 0; $k < $rows22; ++$k) {
    $row22 = mysqli_fetch_array($result22);
    $result = mysqli_query($connection, "SELECT SUM(suma) FROM rvuti_payments WHERE user_id=".fuck_sql_hackers($row22['id']));
    $row = mysqli_fetch_array($result);
    
    $sumapey2 = $row['SUM(suma)'];
    
    $sumapey2 = ($sumapey2 / 100) * 10;
    
    echo
<<<HERE
    <tr style="cursor:default!important">
    <td></td>
    <td></td>
    <td>$row22[data_reg]</td>
    <td>$row22[login]</td>
    <td>$sumapey2 P</td>
    <td></td>
    <td></td>
    </tr>
HERE;
    
    $num = "";
    $refbank = "";
}

mysqli_free_result($result);
mysqli_free_result($result22);
?></tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </section>
                <section id="contacts" class="card dsec" style="display:none; margin-top: 20px;">
                                        <div  class="card-header"   style="border-radius: 4px!important;">
                                            <h4 class="card-title "><b>Контакты</b></h4>
                <div class="heading-elements">
                                                        <ul class="list-inline mb-0">
                                                            <li><a onclick="$('.dsec').hide();$('#lastBets').show();$(document.body).removeClass('menu-open');$(window).scrollTop($('#lastBets').offset().top);"><i class="ft-minus"></i></a></li>
                                                        </ul>
                                                    </div>
                                        </div>
                                        <div class="card-body collapse in">
                                            <div class="card-block">
                                                <div class="card-text">

                                                  
                                                        <h6>Для связи с администрацией пишите в <a href="https://vk.com/im?media=&sel=-165472436" target="_blank">сообщество Вконтакте</a></h6>
                 

                                                 

                                                </div>
                                            </div>
                                        </div>
                                    </section> 
                </div>
            </div>
            <div class="row dsec" id="topRef" style="display:none; margin-top: 20px;">
                                        <div class="col-xs-12">
                                            <div class="card">
                                                <div class="card-header" style="border-radius: 4px!important;">
                                                    <h4 class="card-title"><b>Топ рефоводов</b></h4>
                                                   <div class="heading-elements">
                                                        <ul class="list-inline mb-0">
                                                            <li><a onclick="$('.dsec').hide();$('#lastBets').show();$(document.body).removeClass('menu-open');$(window).scrollTop($('#lastBets').offset().top);"><i class="ft-minus"></i></a></li>
                                                        </ul>
                                                    </div>
                                                     
													
													 
                                                </div>
                                                <div class="card-body collapse in">

                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                            <thead>
															
                                                                <tr class="polew">
                                                                    <th>Никнейм игрока</th>
                                                                    <th>Количество рефералов</th>
                                                                </tr>
                                                            </thead>
                                                           
                                                            <tbody>
<?php
                       $rf = mysqli_query($connection, "SELECT referer,COUNT(*) AS total FROM rvuti_users WHERE referer > 0 GROUP BY referer ORDER BY total DESC LIMIT 5 ");
                        
                        while ( ( $rfs = mysqli_fetch_assoc($rf) ) )
                        {
                            ?>
                                <tr style=\"cursor:default!important\"><td><?php echo get_login($rfs['referer']) ?></td><td><?php echo $rfs['total'] ?></td></tr>
                            <?php
                        }
                        function get_login($id) {
                            global $connection;
                            $row = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM `rvuti_users` WHERE `id` = '$id'"));
                            return $row['login'];
                        }
                    ?>
															</table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
            
            <div class="row dsec" id="lastWithdraw" style="display:none; margin-top: 20px;">
                                        <div class="col-xs-12">
                                            <div class="card">
                                                <div class="card-header" style="border-radius: 4px!important;">
                                                    <h4 class="card-title"><b>Последние выплаты</b></h4>
                                                   <div class="heading-elements">
                                                        <ul class="list-inline mb-0">
                                                            <li><a onclick="$('.dsec').hide();$('#lastBets').show();$(document.body).removeClass('menu-open');$(window).scrollTop($('#lastBets').offset().top);"><i class="ft-minus"></i></a></li>
                                                        </ul>
                                                    </div>
                                                     
													
													 
                                                </div>
                                                <div class="card-body collapse in">

                                                    <div class="table-responsive">
                                                        <table class="table mb-0">
                                                            <thead>
															
                                                                <tr class="polew">
                                                                    <th>ID Игрока</th>
                                                                    <th>Сумма</th>
                                                                    <th>Система</th>
                                                                    <th>Кошелек</th>
                                                                </tr>
                                                            </thead>
                                                           
                                                            <tbody>
<?php
$result22 = mysqli_query($connection, "SELECT * FROM rvuti_payout ORDER BY `id` DESC LIMIT 20");
$rows22 = mysqli_num_rows($result22);
    for($z = 0; $z < $rows22; ++$z) {
        $row22 = mysqli_fetch_array($result22);
        $num = substr_replace($row22['qiwi'],'****',-4);
        echo("<tr style=\"cursor:default!important\"><td>$row22[user_id]</td><td>$row22[suma] P</td><td><img src=\"files/qiwi.png\"></td><td>$num</td></tr>");
        
        $num = "";
    }
mysqli_free_result($result22);
?>
															</table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
        </div>
        <div class="app-content container center-layout mt-2">
            <div class="content-wrapper">

                <div class="content-body">
												
<?php
echo $go;
?>

                                                    
                                                        <div class="row dsec" id="lastBets" style="">
                                        
                                    </div>
                                    <section id="realGame" class="card dsec" style="display:none">
                                        <div  class="card-header"   style="border-radius: 4px!important;">
                                            <h4 class="card-title "><b>Абсолютно честно</b></h4>

                                        </div>
                                        <div class="card-body collapse in">
                                            <div class="card-block">
                                                <div class="card-text">
                                                    <p>Перед каждой игрой генерирутеся строка <a href="https://ru.wikipedia.org/wiki/SHA-2" target="_blank">алгоритмом SHA-512 </a> в которой содержится <a href="https://ru.wikipedia.org/wiki/%D0%A1%D0%BE%D0%BB%D1%8C_(%D0%BA%D1%80%D0%B8%D0%BF%D1%82%D0%BE%D0%B3%D1%80%D0%B0%D1%84%D0%B8%D1%8F)" target="_blank">соль</a> и победное число (от 0 до 999999). Можно сказать, что перед Вами зашифрованный исход данной игры. Метод гарантирует <b>100% честность</b>, так как результат игры Вы видите заранее, а при изменении победного числа приведет к изменению Hash.</p>

                                                    Проверяйте самостоятельно:
                                                    <ul>
                                                        <li>Скоприруйте Hash до начала игры</li>
                                                        <li>После окончания нажмите <code class="highlighter-rouge">"Проверить игру"</code></li>
                                                        <li>Откроется окно с результатом</li>
                                                        <li>Скопируйте вручную поля c Победным числом</li>
                                                        <li>Вставьте в любой независимый SHA-512 генератор (Например: <a href="https://emn178.github.io/online-tools/sha512.html" target="_blank">Ссылка 1</a> <a href="https://www.md5calc.com/sha512" target="_blank">Ссылка 2</a> <a href="https://passwordsgenerator.net/sha512-hash-generator/" target="_blank">Ссылка 3</a>)</li>
                                                        <li>Hash должен совпадать c Hash до начала игры</li>

                                                    </ul>
                                                    Например:
                                                    <ul>
                                                        <li>Hash до начала игры: 9008354d492a2678fb81a33464a06f06ab6639998d4be7864d04acf3d72921962ad42fd86a9b5d985abe607de4de1cfcef526eefd1ab0e5de6bba6b69b6813e4 </li>
                                                        <li>Победное число: 366209</li>
														<li>После окончания нажали на "Проверить игру", открылось <a>окно</a></li>
                                                        <li>Копируем значения Победного числа</li>
                                                        <li>Получаем строку <code class="highlighter-rouge">366209</code></li>
                                                        <li>Вставляем строку в <a href="https://emn178.github.io/online-tools/sha512.html" target="_blank">генератор</a> </li>
                                                        <li>Получили hash как и до начала игры</li>

                                                    </ul>

                                                </div>
                                            </div>
                                        </div>
                                        
                                    </section>
                                    
                                    
                                    
                                   
									
				
				<div style="display:none">
				<h1>Bruti - Никаких комиссий и сборов, быстрые выводы, абсолютно честно и моментально. Получите бонус при первой регистрации!</h1>
				</div>
				</div>
            </div>
			<noindex>
			<!--/LiveInternet-->

</div>
		</noindex>	
        </div>
        
<div class="margin_blockVk" id="vk_community_messages"></div> 
<script type="text/javascript"> 
VK.Widgets.CommunityMessages("vk_community_messages", 165472436, {tooltipButtonText: "Есть вопрос?"}); 
</script>
       
 	<noindex>
	
	<div class="modal fade text-xs-left in" id="large" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" style="display: none; ">
									  <div class="modal-dialog modal-lg" role="document">
										<div class="modal-content">
										  <div class="modal-header" style="background-color:#F5F7FA;border-radius:6px">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											  <span aria-hidden="true"><i class="ft-x"></i></span>
											</button>
											<h4 class="modal-title" id="myModalLabel17">Правила</h4>
										  </div>
										  <div class="modal-body">
											<h5>1. ОБЩИЕ ПОЛОЖЕНИЯ. ТЕРМИНЫ.</h5>
											<p>1.1. Настоящее соглашение – официальный договор на пользование услугами сервиса BRUTI.RU. Ниже приведены основные условия пользования услугами сервиса. Пожалуйста, прежде чем принять участие в проекте внимательно изучите правила.</p>
											<p>1.2. Услугами сервиса могут пользоваться исключительно лица, достигшие совершеннолетия (18 лет) и старше. </p>
											<p>1.3. On-line проект под названием BRUTI.RU представляет собой систему добровольных пожертвований, принадлежит его организатору и находится в сети Интернет непосредственно по адресу – BRUTI.RU. </p>
											<p>1.4. Участие пользователей в проекте является исключительно добровольным.</p>
											<hr>
											<h5>2. УЧЁТНАЯ ЗАПИСЬ УЧАСТНИКА ПРОЕКТА (ПОЛЬЗОВАТЕЛЯ СИСТЕМЫ).</h5>
											<p>2.1. Способом непосредственной регистрации учетной записи является авторизация участников проекта с помощью логина и пароля.</p>
											<p>2.3. Кроме того, участник проекта несет непосредственную ответственность за любые предпринятые им действия в рамках проекта. </p>
											<p>2.4. Участник проекта обязуется своевременно сообщить о противозаконном доступе к его учетной записи, противозаконном использовании его учетной записи, по средствам технической поддержки сервиса. </p>
											<p>2.5. Сервис, а также его правообладатель не несут ответственность за любые предпринятые действия участником проекта касательно третьих лиц. </p>
											<p>2.6. При использовании несколькими участниками проекта одно и тоже устройство или выход в интернет для игры, необходимо согласование с администрацией. </p>
											<hr>
											<h5>3. КОНФИДЕНЦИАЛЬНОСТЬ</h5>
											<p>3.1. В рамках проекта гарантируется абсолютная конфиденциальность информации, предоставленной участником проекта сервису. </p>
											<p>3.2. В рамках проекта гарантируется шифрование личных паролей участников. </p>
											<p>3.3	Личные данные участника проекта могут быть представлены третьим лицам исключительно в случаях непосредственного нарушения действующих законов РФ, в случаях оскорбительного поведения, клеветы в отношении третьих лиц. </p>
											<hr>
											<h5>4. УЧАСТНИК ПРОЕКТА (ПОЛЬЗОВАТЕЛЬ СИСТЕМЫ).</h5>
											<p>4.1. В случае непосредственного нарушения участником проекта изложенных условий и правил настоящего соглашения, а также действующих законов РФ, учетная запись может быть заблокирована. </p>
											<p>4.2. Недопустимы попытки противозаконного доступа, нанесения вреда работе системы сервиса. </p>
											<p>4.3. Недопустима любая агрессия, сообщения, запрограммированные на причинение ущерба сервису (вирусы), информация, способная повлечь за собой несущественный, или существенный вред третьим лицам.</p> 
											<hr>
											<h5>5. КАТЕГОРИЧЕСКИ ЗАПРЕЩЕНО</h5>
											<p>5.1. Размещение информации, содержащей поддельные (неправдивые) данные. 
											<p>5.2. Проводить попыток взлома сайта и использовать возможные ошибки в скриптах. Нарушители будут немедленно забанены и удалены. 
											<p>5.3. Регистрация более чем одной учетной записи индивидуального участника проекта. 
											<p>5.4. Передача информации иным, третьим лицам, содержащей данные для доступа к личной учетной записи участника проекта. 
											<p>5.5. Выплата на одинаковые реквизиты с разных аккаунтов. 
											<p>5.6. Махинации с реферальной системой.
											<p>5.7. Иметь больше 1 аккаунта.
											
											<hr>
											<h5>6. Выплаты.</h5>
											<p>6.1 Выплаты производятся в ручном режиме.</p>
											<p>6.2 Если сумма последних пополнений равна сумме вывода, комиссию оплачивает пользователь.</p>
											<p>6.3 При выводе бонусных рублей может быть отказано без всяких причин.</p>
											<p>6.4 Администрация сайта может потребовать скан или фото паспорта для верификации.</p>
											<p>6.5 При выводе средств, необходимо сыграть хотя бы 15 игр на сумму более 5% последнего пополения счета.</p>
											<p>6.6 При отказе предоставить дополнительную информацию или верификации кошелька аккаунт может быть заблокирован.</p>
											<p>6.7 При нарушении правил баланс аккаунта может быть заморожен.</p>
											<p>6.8 Если вы имеете больше 1 аккаунта Администрация в праве отказать в выплате.</p>
											<hr>
											<h5>7. ПРИНЯТИЕ ПОЛЬЗОВАТЕЛЬСКОГО СОГЛАШЕНИЯ.</h5>
											<p>7.1. Непосредственная регистрация в системе данного проекта предполагает полное принятие участником проекта условий и правил настоящего пользовательского соглашения.</p>
											<p>7.2. При нарушении правил учетная запись может быть заблокирована вместе с балансом.</p>
										  </div>
										  
										</div>
									  </div>
									</div></noindex>
									
<?php
#echo $modal;
mysqli_close($connection);
echo($modal);
?>									
									
									<!-- JS -->
	<script type="text/javascript">
		setInterval(function() {
			changeBackground();
		}, 2500);
	</script>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <script type="text/javascript" src="/files/script.js"></script>
        <script type="text/javascript" src="/files/background.js"></script>
	<script src="./files/js.cookie.js" type="text/javascript"></script>
        <script src="./files/jquery-latest.min.js"></script>
	<script src="https://www.google.com/recaptcha/api.js?onload=renderRecaptchas&render=explicit" async defer></script>
	<script src="./files/vendors.min.js" type="text/javascript"></script>
        <script src="./files/popover.min.js" type="text/javascript"></script>
        <script src="./files/raphael-min.js" type="text/javascript"></script>
        <script src="./files/morris.min.js" type="text/javascript"></script>
        <script src="./files/app-menu.min.js" type="text/javascript"></script>
        <script src="./files/app.min.js" type="text/javascript"></script>
        <script src="./files/odometer.js"></script></body></html>
        <script>
            $(document).ready(function() {
              $("#toggle").click(function() {
                $('#menu-show').addClass("menu_sss");
              });
            });
            $(document).ready(function() {
              $("#close-toggle").click(function() {
                $('#menu-show').removeClass("menu_sss");
              });
            });
        </script>
        
        <footer class="footer">
			<div class="container">
			<div class="row">
			    <div class="col-md-4 col-sm-4 col-xs-12">
			        <span style="cursor:pointer;float:left;line-height: 6em;color: #DDDDDD;" data-toggle="modal" data-target="#large">
            			Правила сервиса
            		</span>
			    </div>
			    <div style="color: #FFFFFF" class="col-md-4 col-sm-4 col-xs-12">
			        <p class="footer_logo" style="text-align: center">Bruti.ru</p>
				    <p class="footer_decr_txt" style="text-align: center"> © 2018</p>
			    </div>
			    <div class="col-md-4 col-sm-4 col-xs-12">
			        <a href="//www.free-kassa.ru/" style="    cursor: default;
    float: right;
    line-height: 6em;"><img src="//www.free-kassa.ru/img/fk_btn/18.png"></a>
			    </div>
			</div>
			</div>
	</footer>
