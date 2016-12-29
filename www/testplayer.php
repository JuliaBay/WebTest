<?
require_once("$_SERVER[DOCUMENT_ROOT]/../dal.inc.php");
require_once("$_SERVER[DOCUMENT_ROOT]/auth.php");

$test_counter=1;
$answ_counter=1;

if(isset($_GET["test_id"]))
{
	$_SESSION["test_ID"]=(int)$_GET["test_id"];		
	//print_r($_SESSION);
}
else
	unset($_SESSION["test_ID"]);
//$test_ID = $_SESSION["test_ID"];
//printf($test_ID);
if(isset($_POST["Go"]))
{
	//echo "<xmp>";print_r($_POST);echo "</xmp>";
	$points = CheckTest($_POST["answ"]);
	//printf("YOU'VE GOT ");echo $points;printf(" POINT(S)");

	$err="";
	$wrong=Array();
	/*foreach( as $value)
	{
		if($answ[checked]==true)
		{//Добавление идентификатора поля в массив wrong
			$wrong[]="#f_q";
			$err.="- Обязательное поле Название не заполнено!<br/>";
		}
	}*/

}
?>
<!DOCTYPE html>
<html>
	<head></head>
	<body>
		<br/>
		<button name="q" onclick="location.href='http://webtest/professor-tests.php';">вернуться к списку тестов</button>
		<form action="" method="POST">
			<?//printf();?>
		<? while($Question=DBFetchQuestion($_SESSION["test_ID"])):?>
			<p><?=$test_counter?>.&nbsp<?=$Question["text"]?></p>
			<?while($Answer=DBFetchAnswer($Question["ID"])):?>
				<?printf($Question["ID"]);?>
				<input id="answ<?=$Answer["ID"]?>" name="answ[<?=$Question["ID"]?>]" type="radio" value="<?=$Answer["ID"]?>"/> 
				<?//printf($Answer["ID"]);?>
				<label for="answ<?=$Answer["ID"]?>"><?=$Answer["text"]?></label><br/>
				<?$answ_counter++;?>
			<?endwhile;?>
			<hr/>
			<?$test_counter++;?>
		<? endwhile;?>
		<input name="Go" type="Submit" value="Отправить на проверку"/>
		<?if($points){printf("YOU'VE GOT ");echo $points;printf(" POINT(S) !!!");};?>
		</form>
	</body>
</html>