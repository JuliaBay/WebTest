<?php
	require_once("$_SERVER[DOCUMENT_ROOT]/../dal.inc.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/auth.php");
	$answ_counter =0;
	//echo "<xmp>";print_r($_POST);echo "</xmp>";
	if(isset($_POST["Go"]))
	{		
		$form_fields=$_POST;
		$f_text=mysql_real_escape_string($_POST["f_text"]);//Строка
		//$f_a=(int)$_POST["f_a"];
		$f_ID=(int)$_POST["f_ID"];

		$err="";
		$wrong=Array();
		if(trim($f_text)=="")
		{//Добавление идентификатора поля в массив wrong
			$wrong[]="#f_text";
			$err.="- Обязательное поле Название не заполнено!<br/>";
		}
		if(trim($f_a)=="")
		{
			$wrong[]="#f_a";
			$err.="- Обязательное поле Тип теста не заполнено!<br/>";
		}
		try
		{			
			if(!isset($form_fields["f_ID"])) 
			{
				$test_ID = $_SESSION["test_ID"];
				//printf($test_ID);
				DBAddQuestion($test_ID,$f_text,$f_type_ID); 
				$_SESSION["qst_ID"]=mysql_insert_id();
				//echo $_SESSION["qst_id"];
				$qst_id = mysql_insert_id();
				DBAddAnswers($qst_id,$form_fields["text"],$form_fields["istrue"]);
				//echo $qst_id;
				//header("Location: /testeditor/edit_question.php?qst_id=$qst_id");
			}	
			else {
				DBEditQuestion($f_ID,$f_text,$f_type_ID);
				//echo "<xmp>";print_r($form_fields);echo "</xmp>";
				DBEditAnswers($f_ID,$form_fields["answ"],$form_fields["istrue"]);
				$qst_id = $f_ID;
			}
			//echo $qst_id;
			header("Location: /testeditor/edit_question.php?qst_id=$qst_id");
			
			exit;
		}
		catch(Exception $ex)
		{
			$err=$ex->getMessage();
		}
	}

	if(isset($_GET["qst_id"]) && !isset($_POST["Go"]))
	{
		$qst_id=(int)$_GET["qst_id"];
		//printf($qst_id);
		try
		{
			$form_fields=Array();
			$form_fields=DBGetQuestion($qst_id);
			$form_fields["f_text"]=$form_fields["Textq"];
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
<?function get_create_btn() { global $cms_db_link; ?>
<button name="q" type="aside" onclick="add_question()">+ Вопрос</button>
<?}?>

<?function get_body() { global $cms_db_link,$form_fields;?>
	<?if(isset($_GET["qst_id"])) :?> <?// ------------------ РЕДАКТИРОВАНИЕ ----------------------?>
		<?//printf($_GET["qst_id"]);?>
		<h2>РЕДАКТИРОВАНИЕ ВОПРОСА</h2>
		<form action="" method="POST">
			Условие задания<br/>
			<? $Question=DBGetQuestion($_GET["qst_id"]);?>
			<textarea id="f_text" name="f_text" cols="100" rows="5"><?=$Question["Textq"]?></textarea><br/>
			Варианты ответов<br/>
			<?while($Answer=DBFetchAnswer($Question["ID"])):?>
				<?//printf($Question["ID"]);?>
				<?if($Answer["istrue"]==1) {?>
					<input id="istrue<?=$Answer["ID"]?>" name="istrue[<?=$Question["ID"]?>]" type="radio" checked value="<?=$Answer["ID"]?>"/> 
				<?;}
				else {?>
					<input id="istrue<?=$Answer["ID"]?>" name="istrue[<?=$Question["ID"]?>]" type="radio" value="<?=$Answer["ID"]?>"/> 					
				<?;}?>
				<textarea id="answ<?=$Question["ID"]?>" name="answ[<?=$Answer["ID"]?>]"><?=$Answer["text"]?></textarea>
				<?//$a_ID[$answ_counter] = $Answer["ID"];?>
				<?//printf($Answer["ID"]);?>
				<?/*<label for="answ<?=$Answer["ID"]?>"><?=$Answer["text"]?></label><br/>*/?>
				<?//$answ_counter++;?><br/>
			<?endwhile;?>
			<?if(isset($form_fields["f_ID"])):?>
			<input name="f_ID" type="hidden" value=<?=$form_fields["f_ID"]?>/>
			<?endif;?>
			<input id="Send" name="Go" type="Submit"  value="Сохранить"/>
		</form>
	<?else :?> <?// ------------------ ВВОД ----------------------?>
		<h2>СОЗДАНИЕ ВОПРОСА</h2>
		<form action="" method="POST">
			
			Условие задания<br/>
			<textarea id="f_text" name="f_text" cols="100" rows="5"><?=$form_fields["f_text"]?></textarea><br/>
			Варианты ответов<br/>
			<input name="istrue[1]" type="radio" />
			<textarea name="text[1]" cols="100" rows="3"><?=$form_fields["f_answ"]?></textarea><br/>
			<input name="istrue[2]" type="radio" />
			<textarea name="text[2]" cols="100" rows="3"><?=$form_fields["f_answ"]?></textarea><br/>
			<input name="istrue[3]" type="radio" />
			<textarea name="text[3]" cols="100" rows="3"><?=$form_fields["f_answ"]?></textarea><br/>
			<input id="Send" name="Go" type="Submit"  value="Сохранить"/>
		</form>
	<?endif;?>

<?}?>			

<?
$is_ed_qst=true;
require_once("$_SERVER[DOCUMENT_ROOT]/testeditor/page_tpl.inc.php");?>