<?php
	require_once("$_SERVER[DOCUMENT_ROOT]/../init.inc.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/../dbinit.inc.php");
	//ПРИМЕР ПРИМЕНЕНИЯ РЕГУЛЯРНЫХ ВЫРАЖЕНИЙ НА ЯЗЫКЕ PHP	
	//Если нажата кнопка "Сохранить"
	if(isset($_POST["Send"]))
	{			
		//Объявление регулярных выражений:
		//Шаблон "Email"
		$email_pattern="/^[A-Za-z0-9\._-]+@[A-Za-z0-9_-]+\.[A-Za-z0-9_-]+$/";
		//Шаблон "Телефонный номер"
		$phone_pattern = "/^[0-9+]{0,15}$/";
		//Шаблон "Адрес сайта"
		$site_pattern = "/^[A-Za-zА-Яа-я0-9\.\?\&_\-\/\:]*$/";
		//Шаблон "Возраст"
		$age_pattern = "/^[0-9]+$/";
		
		//В этой переменной будет сформировано сообщение об ошибке
		$error="";
		//В этот массив будут заноситься идентификаторы неверно 
		//заполненных полей
		$wrong=Array();
		
		//Проверка поля "Имя пользователя" на заполненность
		if(trim($_POST["f_username"])=="") 
		{
			//Добавление идентификатора поля в массив wrong
			$wrong[]="#f_username";
			//и добавление описания ошибки в переменную error
			$error.="- [PHP] Обязательное поле \"Имя пользователя\" не заполнено! <br/>";
		}		
		
		//Проверка поля "E-mail" на соответствие регулярному выражению
		if(!preg_match($email_pattern,$_POST["f_email"]))
			{
				$wrong[]="#f_email";
				$error.="- [PHP] Поле \"Email\" содержит недопустимые символы! <br/>";
			}		
		
		//Проверка поля "Сайт"
		if(!preg_match($site_pattern,$_POST["f_site"]))	
			{
				$wrong[]="#f_site";
				$error.="- [PHP] Поле \"Сайт\" содержит недопустимые символы! <br/>";
			}
		
		//Проверка поля "Телефонный номер"
		if(!preg_match($phone_pattern,$_POST["f_phone"]))
			{
				$wrong[]="#f_phone";
				$error.="- [PHP] Поле \"Телефон\" содержит недопустимые символы! <br/>";
			}		
		
		//Проверка поля "Возраст" на соответстиве регулярному выражению
		//и попадание в интервал от 18 до 150 лет.
		if(!(preg_match($age_pattern,$_POST["f_age"]) && (int)$_POST["f_age"] >= 18 && (int)$_POST["f_age"]<=150))		
			{
				$wrong[]="#f_age";
				$error.="- [PHP] Поле \"Возраст\" должно быть от 18 до 150! <br/>";
			}
		
		//Это условие выполнится, если форма будет заполнена без ошибок
		if(trim($error)=="")
		{
			$Name=mysql_real_escape_string($_POST["f_username"]);
			$Email=mysql_real_escape_string($_POST["f_email"]);
			$Site=mysql_real_escape_string($_POST["f_site"]);
			$Age=(int)$_POST["f_age"];
			//Здесь может быть код сохранения данных из формы
			mysql_query("INSERT INTO Users(Name,Email,Site,Age) VALUES('$Name','$Email','$Site','$Age')",$cms_db_link);
			header("Location: $_SERVER[PHP_SELF]?success");
		}
	}
	
	if(isset($_GET["delete_id"]))
	{
		mysql_query("DELETE FROM Users WHERE ID=".(int)$_GET["delete_id"],$cms_db_link);		
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>Регистрация пользователя</title>
		<? 
		//Если форма была заполнена с ошибками
		if(trim($error)!=""): ?>
		<!--Выделение неверно заполненных полей красными рамками
		при помощи стилей -->
		<style>			
			<?=implode(",",$wrong)?>
			{
				border-color: #F00;
			}
		</style>
		<? endif; ?>
		<script type="text/javascript" src="/scripsJS/jquery-1_11_0_min.js"></script>
		<script type="text/javascript">
			//ПРИМЕР ПРИМЕНЕНИЯ РЕГУЛЯРНЫХ ВЫРАЖЕНИЙ НА ЯЗЫКЕ JAVASCRIPT
			//Объявление регулярных выражений:
			//Шаблон "Email"
			var email_pattern = /^[A-Za-z0-9\._-]+@[A-Za-z0-9_-]+\.[A-Za-z0-9_-]+$/;
			//Шаблон "Телефонный номер"
			var phone_pattern = /^[0-9+]{0,15}$/;
			//Шаблон "Адрес сайта"
			var site_pattern = /^[A-Za-zА-Яа-я0-9\.\?\&_\-\/\:]*$/; 
			//Шаблон "Возраст"
			var age_pattern = /^[0-9]+$/;					
			
			//Назначение обработчика на событие "Документ загружен"
			$(function() {
				//Когда весь документ загрузился - 
				//назначение обработчика нажатия на кнопку "Сохранить"
				$("#Send").click(function()
				{	//Когда нажали на кнопку "Сохранить"
					
					//В этой переменной будет сформировано сообщение об ошибке
					var error="";
					//Проверка поля "Имя пользователя" на заполненность
					if($.trim($("#f_username").val())=="")
					{	//Если не заполнено - 
						//выделение его красной рамкой
						$("#f_username").css("border-color","#F00");
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
					
					//Проверка поля "Сайт"
					if(!site_pattern.test($("#f_site").val()))	
						{
							$("#f_site").css("border-color","#F00");
							error+="- [JS] Поле \"Сайт\" содержит недопустимые символы! <br/>";
						}
					else
						$("#f_site").css("border-color","");
					
					//Проверка поля "Телефонный номер"
					if(!phone_pattern.test($("#f_phone").val()))
						{
							$("#f_phone").css("border-color","#F00");
							error+="- [JS] Поле \"Телефонный номер\" содержит недопустимые символы! <br/>";
						}
					else
						$("#f_phone").css("border-color","");
					
					//Проверка поля "Возраст" на соответстиве регулярному выражению
					//и попадание в интервал от 18 до 150 лет.
					if(age_pattern.test($("#f_age").val()) && parseInt($("#f_age").val()) >= 18 && parseInt($("#f_age").val())<=150)					
						$("#f_age").css("border-color","");					
					else
						{
							$("#f_age").css("border-color","#F00");
							error+="- [JS] Поле \"Возраст\" должно быть от 18 до 150! <br/>";
						}
					
					//Если есть какие-либо сообщения об ошибке
					if($.trim(error)!="")
						{
							//Вывод этих сообщений в контейнер с id="error"
							$("#error").html(error);
							//и блокировка отправки формы возвратом
							//false из обработчика нажатия кнопки "Отправить" 
							return false;
						}
				});
				
				$("#mylink").click(function() {alert('clicked');return false;});
			});
		</script>
	</head>
	<body>
		<div style="color: #0F0">
		<?
			if(isset($_GET["success"]))
				echo "Данные успешно сохранены";
		?>
		</div>
		<form action="" method="POST">			
			<b>Имя пользователя:</b><br/>
			<input id="f_username" name="f_username" type="text" size="50" value="<?=$_POST["f_username"]?>"/><br/>
			<b>Email:</b><br/>
			<input id="f_email" name="f_email" type="text" size="15" value="<?=$_POST["f_email"]?>"/><br/>
			<b>Сайт:</b><br/>
			<input id="f_site" name="f_site" type="text" size="57" value="<?=$_POST["f_site"]?>"/><br/>
			<b>Телефон:</b><br/>
			<input id="f_phone" name="f_phone" type="text" size="25" value="<?=$_POST["f_phone"]?>"/><br/>
			<b>Возраст:</b><br/>
			<input id="f_age" name="f_age" type="text" size="3" value="<?=$_POST["f_age"]?>"/><br/>
			<b>Дополнительно:</b><br/>
			<textarea id="f_about" name="f_about" rows="5" cols="50"><?=$_POST["f_about"]?></textarea><br/>
			<div id="error" style="color: #F00"><?
			//Если есть сообщения об ошибках - их вывод
			if(trim($error)!="") echo $error;
			?></div>
			<input id="js_supported" name="js_supported" type="hidden" value="no" />
			<input id="Send" name="Send" type="Submit" value="Сохранить"/>
		</form>
		<?=$msg?>
		<hr/>
		<table border="1">
			<tr>
				<td>ID</td>
				<td>Имя</td>
				<td>Email</td>
				<td>Сайт</td>
				<td>Возраст</td>
			</tr>
			<?	$res=mysql_query("SELECT * FROM Users",$cms_db_link);
				while($user=mysql_fetch_array($res,MYSQL_BOTH)):?>
				<tr>
					<td><?=$user["ID"]?></td>
					<td><?=$user["Name"]?></td>
					<td><?=$user["Email"]?></td>
					<td><?=$user["Site"]?></td>
					<td><?=$user["Age"]?></td>
					<td><a href="?edit_id=<?=$user["ID"]?>">Редактировать</a><a href="?delete_id=<?=$user["ID"]?>" onclick="return confirm('Действительно удалить?')">Удалить</a></td>
				</tr>
			<?endwhile;?>
		</table>
		<a id="mylink" href="">My Link</a>
	</body>
</html>