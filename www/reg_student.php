<?php
	require_once("$_SERVER[DOCUMENT_ROOT]/../dal.inc.php");

	$is_state1=false;
	$is_sent=false;
	$is_edit=false;
	
	if(isset($_POST["Go"]))
		$is_sent=true;
	else if(isset($_GET["edit_id"]))
		$is_edit=true;	
	else
		$is_state1=true;
	
	if(isset($_POST["Go"]))
	{		
		$form_fields=$_POST;
		$f_uni_ID=(int)$_POST["f_univ"];//Число
		$f_name=mysql_real_escape_string($_POST["f_name"]);//Строка
		$f_log=mysql_real_escape_string($_POST["f_log"]);//Строка
		$f_fac_ID=(int)$_POST["f_fac"];
		$f_dep_ID=(int)$_POST["f_dep"];
		$f_grp_ID=(int)$_POST["f_grp"];
		$f_email=mysql_real_escape_string($_POST["f_email"]);
		$f_pass=mysql_real_escape_string($_POST["f_pass"]);
		$f_ID=(int)$_POST["f_ID"];
		
		$err="";
		$wrong=Array();
		if(trim($f_name)=="")
		{//Добавление идентификатора поля в массив wrong
			$wrong[]="#f_name";
			$err.="- Обязательное поле Имя не заполнено!<br/>";
		}
		if(trim($f_log)=="")
		{
			$wrong[]="#f_log";
			$err.="- Обязательное поле Логин не заполнено!<br/>";
		}
		if($f_uni_ID==-1)
		{
			$wrong[]="#f_uni_ID";
			$err.="- Обязательное поле Университет не заполнено!<br/>";
		}
		if($f_fac_ID==-1)
		{
			$wrong[]="#f_fac_ID";
			$err.="- Обязательное поле Факультет не заполнено!<br/>";
		}
		if($f_spec_ID==-1)
		{
			$wrong[]="#f_spec_ID";
			$err.="- Обязательное поле Специальность не заполнено!<br/>";
		}
		if(trim($f_email)=="")
		{//Добавление идентификатора поля в массив wrong
			$wrong[]="#f_email";
			$err.="- Обязательное поле e-mail не заполнено!<br/>";
		}
		if(trim($f_pass)=="")
		{//Добавление идентификатора поля в массив wrong
			$wrong[]="#f_pass";
			$err.="- Обязательное поле Пароль не заполнено!<br/>";
		}
		
		try
		{
			//echo $f_name;
			if(!isset($form_fields["f_ID"]))
				DBAddStudent($f_name,$f_log,$f_dep_ID,$f_grp_ID,$f_email,$f_pass);
			else
				DBEditUser($f_ID,$f_name,$f_log,$f_dep_ID,$f_grp_ID,$f_email,$f_pass);			
			
			header("Location: /admin-users.php");
		}
		catch(Exception $ex)
		{
			$err=$ex->getMessage();
		}
	}
	
	if(isset($_GET["edit_id"]) && !isset($_POST["Go"]))
	{
		$user_id=(int)$_GET["edit_id"];
		
		try
		{
			$form_fields=Array();
			$form_fields=DBGetUser($user_id);
			$form_fields["f_name"]=$form_fields["Name"];
			$form_fields["f_log"]=$form_fields["Login"];
			$form_fields["f_univ"]=$form_fields["Uni_ID"];
			$form_fields["f_fac"]=$form_fields["Fac_ID"];
			$form_fields["f_dep"]=$form_fields["Dep_ID"];
			$form_fields["f_grp"]=$form_fields["Grp_ID"];
			$form_fields["f_email"]=$form_fields["Mail"];
			$form_fields["f_ID"]=$form_fields["ID"];
		}
		catch(Exception $ex)
		{
			$err=$ex->getMessage();
		}
	}
	//Запрет кэширования
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Expires: " . date("r"));
?>
<html>
	<head>		
		<title>Регистрация</title>	
		<? 
		//Если форма была заполнена с ошибками
		if(trim($error)!=""): ?>
		<!--Выделение неверно заполненных полей красными рамками
		при помощи стилей -->
			<style>			
				<?=implode(",",$wrong)?>
				{
					border-color: #f00;
				}
			</style>
		<? endif; ?>	
		<link rel="stylesheet" href="css/styles.css"/>
		<link rel="stylesheet" href="css/main.css"/>
		<script type="text/javascript" src="/scripsJS/jquery-1_11_0_min.js"></script>
		<script type="text/javascript"> //javascript
			$(function() {
				$("#f_univ").change(function(){
					$("#f_fac").removeAttr("disabled");
					$.get("getfaculties.php?univ_id="+$(this).val(),
						function(data) {	
							$("#f_fac").html(data);
						});
				});
			});
			$(function() {
				$("#f_fac").change(function(){
					$("#f_dep").removeAttr("disabled");
					$.get("getdepartments.php?fac_id="+$(this).val(),
						function(data) {	
							$("#f_dep").html(data);
						});
				});
			});
			//Объявление регулярных выражений:
			//Шаблон "Email"
			var email_pattern = /^[A-Za-z0-9\._-]+@[A-Za-z0-9_-]+\.[A-Za-z0-9_-]+$/;
			//Назначение обработчика на событие "Документ загружен"
			$(function() {
				//Когда весь документ загрузился - 
				//назначение обработчика нажатия на кнопку "Сохранить"
				$("#Send").click(function()
				{	//Когда нажали на кнопку "Сохранить"
					//В этой переменной будет сформировано сообщение об ошибке
					var error="";
					//Проверка поля "Имя пользователя" на заполненность
					if($.trim($("#f_user").val())=="")
					{	//Если не заполнено - 
						//выделение его красной рамкой
						$("#f_user").css("border-color","#F00");
						//и добавление описания ошибки в переменную error
						error+="- [JS] Обязательное поле \"Имя пользователя\" не заполнено! <br/>";
					}
					else //Если заполнено - установка для рамки цвета по умолчанию
						$("#f_username").css("border-color","");
					
					//Проверка поля "E-mail" на соответствие регулярному выражению
					if(!email_pattern.test($("#f_email").val()))
						{
							$("#f_email").css("border-color","#F00");
							error+="- [JS] Поле \"Email\" содержит недопустимые символы! <br/>";
						}
					else
						$("#f_email").css("border-color","");
				});
			});
		</script>

	</head>
	<body class="body_hover">
		<?=$err?>
		<?
			if(isset($_GET["success"]))
				echo "Данные успешно сохранены";
		?>
		<div id="wrapper">
			<header>
				<a href="http://webtest"><img src="images/logo.png" alt="logo"></a>
				<div name="right">
					<button name="q" onclick="location.href='http://webtest/aut_user.php';">Вход</button>
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
						<H1> Регистрация </H1>
						</div>
						<input id="f_name" name="f_name" type="text" size="50" value="<?=$form_fields["f_name"]?>" onBlur="if(this.value=='')this.value='ФИО'" onFocus="if(this.value=='ФИО')this.value=''"/>
						<input id="f_log" name="f_log" type="text" size="50" value="<?=$form_fields["f_log"]?>" onBlur="if(this.value=='')this.value='Логин'" onFocus="if(this.value=='Логин')this.value=''"/>
						<select type="text" id="f_univ" name="f_univ">
							<option value="-1">--Выберите ВУЗ--</option>
								<?while($item=DBFetchUniversity($res)):?>
								<option value="<?=$item["ID"]?>" <?=($form_fields["f_univ"]==$item["ID"])?"selected":""?>><?=$item["name"]?></option>
								<?endwhile;?>
						</select>
						<select type="text" id="f_fac" name="f_fac" <?if($is_state1){?>disabled="disabled"<?}?>>
							<option value="-1">--Выберите факультет--</option>
								<?if(!$is_state1 && trim($form_fields["f_univ"])!="" && (int)$form_fields["f_univ"]>0):?>			
								<?while($item=DBFetchFaculty($form_fields["f_univ"])):?>
								<option value="<?=$item["ID"]?>" <?=($form_fields["f_fac"]==$item["ID"])?"selected":""?>><?=$item["name"]?></option>
								<?endwhile;?>
								<?endif;?>
						</select>
						<select type="text" id="f_dep" name="f_dep" <?if($is_state1){?>disabled="disabled"<?}?>>
							<option value="-1">--Выберите кафедру--</option>
								<?if(!$is_state1 && trim($form_fields["f_fac"])!="" && (int)$form_fields["f_fac"]>0):?>			
								<?while($item=DBFetchDepartment($form_fields["f_fac"])):?>
								<option value="<?=$item["ID"]?>" <?=($form_fields["f_dep"]==$item["ID"])?"selected":""?>><?=$item["name"]?></option>
								<?endwhile;?>
								<?endif;?>
						</select>
						<select type="text" id="f_grp" name="f_grp">
							<option value="-1">--Выберите группу--</option>
								<?while($item=DBFetchGroup($res)):?>
								<option value="<?=$item["ID"]?>" <?=($form_fields["f_grp"]==$item["ID"])?"selected":""?>><?=$item["name"]?></option>
								<?endwhile;?>
						</select>
						<input id="f_email" name="f_email" type="text" size="14" value="<?=$form_fields["f_email"]?>" onBlur="if(this.value=='')this.value='Почта'" onFocus="if(this.value=='Почта')this.value=''"/>	
						<input id="f_pass" name="f_pass" type="text" size="14" value="<?=$form_fields["f_pass"]?>" onBlur="if(this.value=='')this.value='Пароль'" onFocus="if(this.value=='Пароль')this.value=''"/>
						<div id="error" style="color: #F00">
						<?if(isset($form_fields["f_ID"])):?>
						<input name="f_ID" type="hidden" value=<?=$form_fields["f_ID"]?>/>
						<?endif;?>

						<input id="Send" name="Go" type="Submit" value="Зарегистрироваться"/>
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