<?php
require_once("$_SERVER[DOCUMENT_ROOT]/../dal.inc.php");
	
	//require_once("$_SERVER[DOCUMENT_ROOT]/auth.php");
	//require "auth.php";
	//session_start();
	if(isset($_POST["Go1"]))
	{
		$form_fields=$_POST;
		$f_log=mysql_real_escape_string($_POST["f_log"]);
		$f_pass=mysql_real_escape_string($_POST["f_pass"]);
		
		$err="";
		$wrong=Array();
		if(trim($f_log)=="")
		{
			$wrong[]="#f_log";
			$err.="- Обязательное поле Логин не заполнено!<br/>";
		}
		if(trim($f_pass)=="")
		{//Добавление идентификатора поля в массив wrong
			$wrong[]="#f_pass";
			$err.="- Обязательное поле Пароль не заполнено!<br/>";
		}
		try
		{				
			//while($item=DBAuthUser($form_fields["f_log"],$form_fields["f_pass"])):
				//$_SESSION['ID'] = $item["ID"];
			//endwhile;
			
				$user_info=DBAuthUser($f_log,$f_pass);
				session_start();
				$_SESSION["user_authorized"]=1;
				$_SESSION["user_info"]=$user_info;
				
				header("Location: http://webtest/professor-tests.php");
		}	
		catch(Exception $ex)
		{
			$err=$ex->getMessage();
		}
	}
	//Запрет кэширования
	//header("Cache-Control: no-store, no-cache, must-revalidate");
	//header("Expires: " . date("r"));
?>
<html>
	<head>		
		<title>Вход</title>		
		<link rel="stylesheet" href="css/styles.css"/>
		<link rel="stylesheet" href="css/main.css"/>
		<script type="text/javascript" src="/scripsJS/jquery-1_11_0_min.js"></script>
		<script type="text/javascript">
		
		</script>
	</head>
	
	<body id="bd" class="body_hover">
		<?=$err?>
		<div id="wrapper">
			<header>
				<a href="http://webtest"><img src="images/logo.png" alt="logo"></a>
				<div name="right">
					<button name="q" onclick="location.href='http://webtest/reg_user.php';">Регистрация</button>
				</div>
			</header>
			<nav>
				<ul class="top-menu">
				</ul>
			</nav>
		
			<div id="reg-form">
				<fieldset>
					<form action="" method="POST">
						<div id="body-hat">
						<H1> Вход </H1>
						</div>
						<input id="f_log" name="f_log" type="text" size="50" value="Логин/E-mail" onBlur="if(this.value=='')this.value='Логин/E-mail'" onFocus="if(this.value=='Логин/E-mail')this.value=''"/>
						<input id="f_pass" name="f_pass" type="text" size="14" value="Пароль" onBlur="if(this.value=='')this.value='Пароль'" onFocus="if(this.value=='Пароль')this.value=''"/>
						<input name="Go1" type="Submit" value="Войти"/>
					</form>
				</fieldset>
			</div>
		</div>
	</body>
	<footer>
		<div id="footer">
			<div id="sitemap">
				<h3>SITEMAP</h3>
				<div>
					<a href="/home/">Главная</a>
					<a href="/about/">О нас</a>
					<a href="/services/">Возможности</a>
				</div>
				<div>
					<a href="/partners/">чтонибудь</a>
					<a href="/customers/">чтонибудь</a>
					<a href="/contact/">Контакты</a>
				</div>
			</div>
			<div id="social">
				<h3>SOCIAL NETWORKS</h3>
				<a href="http://twitter.com/" class="social-icon twitter"></a>
				<a href="http://facebook.com/" class="social-icon facebook"></a>
				<a href="http://plus.google.com/" class="social-icon google-plus"></a>
				<a href="http://vimeo.com/" class="social-icon-small vimeo"></a>
				<a href="http://youtube.com/" class="social-icon-small youtube"></a>
				<a href="http://flickr.com/" class="social-icon-small flickr"></a>
				<a href="http://instagram.com/" class="social-icon-small instagram"></a>
				<a href="/rss/" class="social-icon-small rss"></a>
			</div>
			<div id="footer-logo">
				<a href="/"><img src="" alt="logo"></a>
				<p>Copyright © 2016 and bla bla bla</p>
			</div>
		</div>
	</footer>
</html>