<?	require_once("$_SERVER[DOCUMENT_ROOT]/../dal.inc.php");
	if(isset($_POST['format_message']) &&
	$_POST['format_message'] == 'Yes')
	{
		echo "Преподаватель.";
	}
	else
	{
		echo "Студент";
	}
?>