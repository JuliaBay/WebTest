<?	require_once("$_SERVER[DOCUMENT_ROOT]/../dal.inc.php");
if(!isset($_GET["fac_id"])) die("Факультет не выбран");
$fac_id=(int)$_GET["fac_id"];
?>
<option value="-1">-- Выберите кафедру --</option>
<?while($department=DBFetchDepartment($fac_id)):?>
<option value="<?=$department["ID"]?>"><?=$department["name"]?></option>
<?endwhile;?>
	