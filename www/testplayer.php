<?
require_once("$_SERVER[DOCUMENT_ROOT]/../dal.inc.php");
require_once("$_SERVER[DOCUMENT_ROOT]/auth.php");

$test_counter=1;
$answ_counter=1;

if(isset($_GET["test_id"]))
{
	$_SESSION["test_ID"]=(int)$_GET["test_id"];	
	$test_ID = 	$_GET["test_id"];
	$Test=DBGetTestName($test_ID);
	//printf($test_id);
}
else
	unset($_SESSION["test_ID"]);
//$test_ID = $_SESSION["test_ID"];
//printf($test_ID);
if(isset($_POST["Go"]))
{
	$err="";
	$wrong=Array();
	if(count($_POST["answ"])<$test_counter)
	{
		printf("Вы не выбрали ни одного ответа на вопрос.");
	}
	//echo "<xmp>";print_r($_POST);echo "</xmp>";
	try{
		$points = CheckTest($_POST["answ"]);
	}
	catch(Exception $ex)
	{
		$err=$ex->getMessage();
	}
	//printf("YOU'VE GOT ");echo $points;printf(" POINT(S)");


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
	<head>
		
		<link rel="stylesheet" href="/css/main.css"/>
		<script type="text/javascript" src="/scripsJS/jquery-1_11_0_min.js"></script>
		<script type="text/javascript"> //javascript
		</script>
	</head>
	<body>
		<br/>
		<button name="q" onclick="location.href='http://webtest/professor-tests.php';">вернуться к списку тестов</button>
		<div class=tstplayer>
			<div class=tstname><?=$Test["name"]?></div>
			<form action="" method="POST">
				<?//printf();?>
			<? while($Question=DBFetchQuestion($_SESSION["test_ID"])):?>
				<p id="qst<?=$test_counter?>"><?=$test_counter?>.&nbsp<?=$Question["text"]?></p>
				<?while($Answer=DBFetchAnswer($Question["ID"])):?>
					<?//printf($Question["ID"]);?>
					<input id="answ<?=$Answer["ID"]?>" name="answ[<?=$Question["ID"]?>]" type="radio" value="<?=$Answer["ID"]?>"/> 
					<?//printf($Answer["ID"]);?>
					<label for="answ<?=$Answer["ID"]?>"><?=$Answer["text"]?></label><br/>
					<?$answ_counter++;?>
				<?endwhile;?>
				<hr/>
				<?$test_counter++;?>
			<? endwhile;?>
			<input id="Send" name="Go" type="Submit" value="Отправить на проверку"/>
			<?if($points){printf("YOU'VE GOT ");echo $points;printf(" POINT(S) !!!");}
			else if(isset($_POST["Go"]) && $_POST["answ"])
			{printf("YOU'VE GOT ZERO POINTS. VERY BAD =(.");}?>

			</form>
		</div>
	</body>
</html>