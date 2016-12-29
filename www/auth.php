<?
if(isset($_POST["Go1"])) {
		$f_log=mysql_real_escape_string($_POST["f_log"]);
		$f_pass=mysql_real_escape_string($_POST["f_pass"]);
  $res=mysql_query("SELECT * FROM Users WHERE Login='$f_log' AND Password='$f_pass'",$cms_db_link);
  //$res = mysql_query($query) or trigger_error(mysql_error().$query);
  if ($row = mysql_fetch_assoc($res)) {
    session_start();
    $_SESSION['user_id'] = $row['ID'];
    $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
  }
  header("Location: http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
  exit;
}
//if (isset(@$_GET['action']) AND @$_GET['action']=="logout") {
  //session_start();
  //session_destroy();
  //header("Location: http://".$_SERVER['HTTP_HOST']."/");
  //exit;
//}

if (isset($_REQUEST[session_name()])) 
{
session_start();
if(isset($_GET["logout"]))
{
  session_destroy();
  //echo "Removing";
  unset($_SESSION);
  header("Location: $_SERVER[PHP_SELF]");
}
//echo "Session works<br/>";
//print_r($_SESSION);
}
/*echo "session_name=".session_name();
echo "R";
print_r($_REQUEST);
echo "P";
print_r($_POST);
echo "G";
print_r($_GET);*/
if (isset($_SESSION["user_info"]['user_id']) /*AND $_SESSION['ip'] == $_SERVER['REMOTE_ADDR']*/) 
{
 /*echo "[";
  print_r($_SESSION);
  echo "]";*/
  //echo "User authorized";
}
else {
  //echo "User not authorized";
  header("Location:  /aut_user.php");
  exit;
}
/*
if (isset($_POST['auth_name'])) {
  $name=mysql_real_escape_string($_POST['auth_name']);
  $pass=mysql_real_escape_string($_POST['auth_pass']);
  $query = "SELECT * FROM users WHERE name='$name' AND pass='$pass'";
  $res = mysql_query($query) or trigger_error(mysql_error().$query);
  if ($row = mysql_fetch_assoc($res)) {
    session_start();
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
  }
  header("Location: http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
  exit;
}
if (isset(@$_GET['action']) AND @$_GET['action']=="logout") {
  session_start();
  session_destroy();
  header("Location: http://".$_SERVER['HTTP_HOST']."/");
  exit;
}
if (isset($_REQUEST[session_name()])) session_start();
if (isset($_SESSION['user_id']) AND $_SESSION['ip'] == $_SERVER['REMOTE_ADDR']) return;
else {
?>
<form method="POST">
<input type="text" name="auth_name"><br>
<input type="password" name="auth_pass"><br>
<input type="submit"><br>
</form>
&lt;?
}
exit;
*/
?>