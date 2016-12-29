<?php
	require_once("$_SERVER[DOCUMENT_ROOT]/../dal.inc.php");
	if(isset($_POST["Go"]))
	{		
		$form_fields=$_POST;
		$f_uni_ID=(int)$_POST["f_univ"];//Число
		$f_name=mysql_real_escape_string($_POST["f_name"]);//Строка
		$f_fac_ID=(int)$_POST["f_fac"];
		$f_spec_ID=(int)$_POST["f_dep"];
		$f_mail=mysql_real_escape_string($_POST["f_email"]);
		$f_ID=(int)$_POST["f_ID"];
		
		$err="";
		if(trim($f_name)=="")
		{
			$err.="- Обязательное поле ИМЯ не заполнено!<br/>";
		}
		
		if($f_fac_ID==-1)
		{
			$err.="- Обязательное поле ФАКУЛЬТЕТ не заполнено!<br/>";
		}
		
		if(trim($err)=="")
		{
			try
			{
			if(!isset($form_fields["f_ID"]))
				DBAddUser($f_uni_ID,$f_name,$f_fac_ID,$f_spec_ID,$f_mail);
			else
				DBEditUser($f_ID,$f_uni_ID,$f_name,$f_fac_ID,$f_spec_ID,$f_mail);
				
			header("Location: $_SERVER[PHP_SELF]");
			}
			catch(Exception $ex)
			{
				$err=$ex->getMessage();
			}
		}
	}
	
	if(isset($_GET["del_id"]))
	{
		$user_id=(int)$_GET["del_id"];
		try
		{
			DBDeleteUser($user_id);
			header("Location: $_SERVER[PHP_SELF]");
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
			$form_fields["f_name"]=$form_fields["name"];
			$form_fields["f_univ"]=$form_fields["uni_ID"];
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
		<script type="text/javascript" src="/js/jquery-1.12.4.js"></script>
		<script type="text/javascript">
			$(function() {
				$("#f_univ").change(function(){
				//alert($(this).val());
					$("#f_fac").removeAttr("disabled");		
					//alert("Before");
					$.get("getfaculties.php?univ_id="+$(this).val(),
						function(data) {	
							$("#f_fac").html(data);
						});
					//alert("After");
				});
			
			});
		</script>
	</head>
	<body>
		<?=$err?>
		<form action="" method="POST">
			<div>Имя:*</div>
			<input id="f_name" name="f_name" type="text" size="50" value="<?=$form_fields["f_name"]?>"/>
			<div>ВУЗ:</div>			
			<select id="f_univ" name="f_univ">
				<option value="-1">--Выберите ВУЗppp--</option>
				<?while($item=DBFetchUniversity($res)):?>
				<option value="<?=$item["ID"]?>" <?=($form_fields["f_univ"]==$item["ID"])?"selected":""?>><?=$item["Name"]?></option>
				<?endwhile;?>
			</select>
			<div>Факультет:</div>
			<select id="f_fac" name="f_fac" disabled="disabled">
				<option value="-1">--Выберите факультет--</option>
				<option value="1">ВШЭУ</option>
				<option value="2">ВШЭКН</option>
				<option value="3">ИСТиС</option> 
			</select>
			<div>Кафедра:</div>
			<select id="f_dep" name="f_dep" disabled="disabled">
				<option value="-1">--Выберите кафедру--</option>
				<option value="1">Информатика</option>
				<option value="2">Экономика</option>
				<option value="3">Математика</option> 
			</select>
			<div>Почта:</div>
			<input id="f_email" name="f_email" type="text" size="14" value="<?=$form_fields["f_email"]?>"/><br/>
			<?if(isset($form_fields["f_ID"])):?>
			<input name="f_ID" type="hidden" value=<?=$form_fields["f_ID"]?>/>
			<?endif;?>
			<input name="Go" type="Submit" value="Зарегистрироваться"/>
		</form>
		<table border="1">
			<tr>
				<td>Имя</td>
				<td>Имя</td>
			</tr>
			<?while($item=DBFetchUser()):?>
			<tr>
				<td><?=$item["name"]?></td>
				<td>
					<a href="?edit_id=<?=$item["ID"]?>">Редактировать</a>
					<a href="?del_id=<?=$item["ID"]?>" onclick="return confirm('Действительно удалить?');">Удалить</a>
				</td>
			</tr>
			<?endwhile;?>
		</table>
	</body>
</html>