<?
require_once("$_SERVER[DOCUMENT_ROOT]/../dal.inc.php");
require_once("$_SERVER[DOCUMENT_ROOT]/auth.php");
	
if(isset($_GET["qst_id"]))
{
	$qst_id=(int)$_GET["qst_id"];
	DBDeleteQuestion($qst_id);
}

header("Location: $_SERVER[HTTP_REFERER]");
?>