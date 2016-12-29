<?	require_once("$_SERVER[DOCUMENT_ROOT]/../dal.inc.php");
if(!isset($_GET["univ_id"])) die("ВУЗ не выбран");
$univ_id=(int)$_GET["univ_id"];
?>
<option value="-1">-- Выберите факультет --</option>
<?while($faculty=DBFetchFaculty($univ_id)):?>
<option value="<?=$faculty["ID"]?>"><?=$faculty["Name"]?></option>
<?endwhile;?>
	