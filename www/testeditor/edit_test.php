<?php
	require_once("$_SERVER[DOCUMENT_ROOT]/../dal.inc.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/auth.php");

	if(isset($_GET["edit_id"]))
	{
		$_SESSION["test_ID"]=(int)$_GET["edit_id"];		
	}
	else
		unset($_SESSION["test_ID"]);
	//print_r($_SESSION);
	//echo "<xmp>";print_r($_POST);echo "</xmp>";
	if(isset($_POST["Go"]))
	{		
		$form_fields=$_POST;
		$f_name=mysql_real_escape_string($_POST["f_name"]);//Строка
		$f_type_ID=(int)$_POST["f_type"];
		$f_est_ID=(int)$_POST["f_est"];
		$f_ID=(int)$_POST["f_ID"];

		$err="";
		$wrong=Array();
		if(trim($f_name)=="")
		{//Добавление идентификатора поля в массив wrong
			$wrong[]="#f_name";
			$err.="- Обязательное поле Название не заполнено!<br/>";
		}
		if(trim($f_type_ID)==-1)
		{
			$wrong[]="#f_type_ID";
			$err.="- Обязательное поле Тип теста не заполнено!<br/>";
		}
		if($f_est_ID==-1)
		{
			$wrong[]="#f_est_ID";
			$err.="- Обязательное поле Критерии оценивания не заполнено!<br/>";
		}
		try
		{
			if(!isset($form_fields["f_ID"]))
			{
				//printf($f_ID);
				DBAddTest($f_name,$f_type_ID,$f_est_ID);
				$_SESSION["test_ID"]=mysql_insert_id();
				$test = mysql_insert_id();
			}
			else {
				//printf($f_type_ID);
				DBEditTest($f_ID,$f_name,$f_type_ID,$f_est_ID);			
			}
			header("Location: /testeditor/edit_question.php?edit_id=$test");
			exit;
		}
		catch(Exception $ex)
		{
			$err=$ex->getMessage();
		}
	}

	if(isset($_GET["edit_id"]) && !isset($_POST["Go"]))
	{
		$test_id=(int)$_GET["edit_id"];
		
		try
		{
			$form_fields=Array();
			//echo $test_id;
			$form_fields=DBGetTest($test_id);
			//print_r($form_fields);
			$form_fields["f_name"]=$form_fields["Name"];
			$form_fields["f_est"]=$form_fields["Est_ID"];
			$form_fields["f_type"]=$form_fields["Type_ID"];
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


<?function get_body() { global $cms_db_link,$form_fields; ?>
	<?if(isset($_GET["edit_id"])):?>
		<h2>РЕДАКТИРОВАНИЕ ТЕСТА</h2>
	<?else:?>
		<h2>СОЗДАНИЕ ТЕСТА</h2>
	<?endif;?>
	<form action="" method="POST">
		<input id="f_name" name="f_name" type="text" size="50" value="<?=$form_fields["f_name"]?>" onBlur="if(this.value=='')this.value='Введите название'" onFocus="if(this.value=='Введите название')this.value=''"/></br>
		<? //print_r(DBGetEstimations());?>
		<?if(isset($_GET["edit_id"])):?>
			<?=ShowList("-- Выберите тип теста --",DBGetTypes(),"f_type",$form_fields["f_type"])?><br/>
			<?=ShowList("-- Выберите критерии оценки --",DBGetEstimations(),"f_est",$form_fields["f_est"])?><br/>
		<?else :?>
			<select type="text" id="f_type" name="f_type">
			<option value="-1">-- Выберите тип теста --</option>
				<?while($item=DBFetchTypeTest($res)):?>
				<option value="<?=$item["ID"]?>" <?=($form_fields["f_type"]==$item["ID"])?"selected":""?>><?=$item["name"]?></option>
				<?endwhile;?>
		</select></br>
		<select type="text" id="f_est" name="f_est">
			<option value="-1">-- Выберите критерии оценки --</option>
				<?while($item=DBFetchEstimation($res)):?>
				<option value="<?=$item["ID"]?>" <?=($form_fields["f_est"]==$item["ID"])?"selected":""?>><?=$item["five"]?></option>
				<?endwhile;?>
		</select></br>
		<?endif;?>
		<?if(isset($form_fields["f_ID"])):?>
			<input name="f_ID" type="hidden" value=<?=$form_fields["f_ID"]?>/>
		<?endif;?>
		<input id="Send" name="Go" type="Submit"  value="Сохранить"/>
	</form>
<?}?>			

<?function ShowList($caption,$list_items,$name,$sel){ ?>
<select type="text" id="<?=$name?>" name="<?=$name?>">
<option value="-1"><?=$caption?></option>
<?foreach($list_items As $id=>$value):?>
<option value="<?=$value?>" <?=($id==$sel)?"selected=\"selected\"":""?> ><?=$value?></option>
<?endforeach;?>
</select>
<?}?>

<?require_once("$_SERVER[DOCUMENT_ROOT]/testeditor/page_tpl.inc.php");?>