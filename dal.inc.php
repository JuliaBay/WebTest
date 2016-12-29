<?require_once("$_SERVER[DOCUMENT_ROOT]/../dbinit.inc.php");
define("EXP_QUERYERR",2);
define("EXP_USERNOTFOUND",2);

//------------------USER FUNCTIONS------------------------------------------------------------------------

function DBAuthUser($f_log,$f_pass)
{
	global $cms_db_link;
	$res=mysql_query("SELECT * FROM Users WHERE Login='$f_log' AND Password='$f_pass'",$cms_db_link);
	if(!$res)
		throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
	if(mysql_num_rows($res)<=0)
		throw new Exception("Пользователь не найден",EXP_USERNOTFOUND);

	$user=mysql_fetch_array($res);
	return Array("user_id"=>$user["ID"], "role_id"=>$user["role_ID"]);
}

function DBAddUser($f_name,$f_log,$f_dep_ID,$f_mail,$f_pass)
{
	global $cms_db_link;
	$res=mysql_query("INSERT INTO Users(name,login,dep_ID,mail,password) VALUES ('$f_name','$f_log','$f_dep_ID','$f_mail','$f_pass')",$cms_db_link);
	mysql_query("INSERT INTO Students(usr_ID,grp_ID) VALUES(".mysql_insert_id().",1)",$cms_db_link);
	if(!$res)
		throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
}

function DBEditUser($f_ID,$f_name,$f_log,$f_dep_ID,$f_mail,$f_pass)
{
	global $cms_db_link;
	$res=mysql_query("UPDATE Users SET name='$f_name',login='$f_log',dep_ID='$f_dep_ID',mail='$f_mail',password='$f_pass' WHERE ID=$f_ID",$cms_db_link);
	
	if(!$res)
		throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
}

function DBGetUser($user_id)
{
	global $cms_db_link;
	
	$res=mysql_query("SELECT Users.ID As ID, Users.Name As Name, Users.Login As Login, Users.Mail as Mail, Users.Dep_ID As Dep_ID,  Departments.Fac_ID As Fac_ID, Universities.ID As Uni_ID FROM Users,Universities,Faculties,Departments WHERE Users.Dep_ID=Departments.ID AND Departments.Fac_ID=Faculties.ID AND Faculties.Uni_ID=Universities.ID AND 
Users.ID=$user_id",$cms_db_link);
	
	if(!$res)
		throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);	
	
	return mysql_fetch_array($res);
}

function DBDeleteUser($user_id)
{
	global $cms_db_link;
	$res=mysql_query("DELETE FROM Users WHERE ID=$user_id",$cms_db_link);
	
	if(!$res)
		throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
}

//------------------TABLE "ESTIMATION"------------------------------------------------------------------------
function DBFetchEstimation()
{
	global $cms_db_link;
	static $is_first,$res;
	if($is_first==0)
	{
		$res=mysql_query("SELECT * FROM Estimation",$cms_db_link);
		$is_first=1;
		if(!$res)
			throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
	}
	return mysql_fetch_array($res);
}

function DBGetEstimations()
{	global $cms_db_link;
	
		$res=mysql_query("SELECT * FROM Estimation",$cms_db_link);
		
		if(!$res)
			throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
	
	$items=Array();
	while($item=mysql_fetch_array($res))
	{
		$items[$item["id"]]=$item["five"];
	}

	return $items;
}

function DBGetTypes()
{	global $cms_db_link;
	
		$res=mysql_query("SELECT * FROM Types",$cms_db_link);
		
		if(!$res)
			throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
	
	$items=Array();
	while($item=mysql_fetch_array($res))
	{
		$items[$item["id"]]=$item["name"];
	}

	return $items;
}

//------------------TABLE "STUDENTS"------------------------------------------------------------------------
function DBFetchStudent()
{
	global $cms_db_link;
	static $is_first,$res;
	if($is_first==0)
	{
		$res=mysql_query("SELECT users.ID As ID, users.Name As Name, users.Login As Login, users.Mail As Mail, groups.Numb As GroupNumber FROM users,students,groups WHERE students.usr_ID=users.ID AND students.grp_ID=groups.ID AND users.role_ID=1",$cms_db_link);
		$is_first=1;
		if(!$res)
			throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
	}
	return mysql_fetch_array($res);
}

function DBAddStudent($f_name,$f_log,$f_dep_ID,$f_grp_ID,$f_mail,$f_pass)
{
	global $cms_db_link;
	$res=mysql_query("INSERT INTO Users(name,login,role_ID,dep_ID,mail,password) VALUES ('$f_name','$f_log',1,'$f_dep_ID','$f_mail','$f_pass')",$cms_db_link);
	mysql_query("INSERT INTO Students(usr_ID,grp_ID) VALUES(".mysql_insert_id().",'$f_grp_ID')",$cms_db_link);
	if(!$res)
		throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
}

function DBEditStudent($f_ID,$f_name,$f_log,$f_dep_ID,$f_grp_ID,$f_mail,$f_pass)
{
	global $cms_db_link;
	$res=mysql_query("UPDATE Users SET name='$f_name',login='$f_log',dep_ID='$f_dep_ID',mail='$f_mail',password='$f_pass' WHERE ID=$f_ID",$cms_db_link);
	mysql_query("UPDATE Students SET grp_ID='$f_grp_ID' WHERE usr_ID=$f_ID",$cms_db_link);
	if(!$res)
		throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
}
//------------------TABLE "PROFESSORS"------------------------------------------------------------------------
function DBFetchProfessor()
{
	global $cms_db_link;
	static $is_first,$res;
	if($is_first==0)
	{
		$res=mysql_query("SELECT users.ID As ID, users.Name As Name, users.Login As Login, users.Mail As Mail, skills.Name As SkillName FROM users,professors,skills WHERE professors.usr_ID=users.ID AND professors.skill_ID=skills.ID AND users.role_ID=2",$cms_db_link);
		$is_first=1;
		if(!$res)
			throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
	}
	
	return mysql_fetch_array($res);
}
function DBAddProfessor($f_name,$f_log,$f_dep_ID,$f_skill_ID,$f_mail,$f_pass)
{
	global $cms_db_link;
	$res=mysql_query("INSERT INTO Users(name,login,role_ID,dep_ID,mail,password) VALUES ('$f_name','$f_log',2,'$f_dep_ID','$f_mail','$f_pass')",$cms_db_link);
	mysql_query("INSERT INTO Professors(usr_ID,skill_ID) VALUES(".mysql_insert_id().",'$f_skill_ID')",$cms_db_link);
	if(!$res)
		throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
}
function DBEditProfessor($f_ID,$f_name,$f_log,$f_dep_ID,$f_skill_ID,$f_mail,$f_pass)
{
	global $cms_db_link;
	$res=mysql_query("UPDATE Users SET name='$f_name',login='$f_log',dep_ID='$f_dep_ID',mail='$f_mail',password='$f_pass' WHERE ID=$f_ID",$cms_db_link);
	mysql_query("UPDATE Professors SET skill_ID='$f_skill_ID' WHERE usr_ID=$f_ID",$cms_db_link);
	if(!$res)
		throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
}
//------------------COMBOBOX FUNCTIONS------------------------------------------------------------------------

function DBFetchUniversity()
{	global $cms_db_link;
	static $is_first,$res;
	if($is_first==0)
	{
		$res=mysql_query("SELECT * FROM Universities",$cms_db_link);
		$is_first=1;
		if(!$res)
			throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
	}
	
	return mysql_fetch_array($res);
}

function DBFetchFaculty($f_univ)
{	global $cms_db_link;
	static $is_first,$res;
	if($is_first==0)
	{
		$res=mysql_query("SELECT * FROM faculties WHERE uni_ID=$f_univ",$cms_db_link);
		$is_first=1;
		if(!$res)
			throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
	}
	
	return mysql_fetch_array($res);
}

function DBFetchDepartment($f_fac)
{	global $cms_db_link;
	static $is_first,$res;
	if($is_first==0)
	{
		$res=mysql_query("SELECT * FROM departments WHERE fac_ID=$f_fac",$cms_db_link);
		$is_first=1;
		if(!$res)
			throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
	}
	
	return mysql_fetch_array($res);
}

//------------------GROUP FUNCTIONS------------------------------------------------------------------------
function DBFetchGroup()
{
	global $cms_db_link;
	static $is_first,$res;
	if($is_first==0)
	{
		$res=mysql_query("SELECT * FROM Groups",$cms_db_link);
		$is_first=1;
		if(!$res)
			throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
	}
	
	return mysql_fetch_array($res);
}
//------------------SKILL FUNCTIONS------------------------------------------------------------------------
function DBFetchSkill()
{
	global $cms_db_link;
	static $is_first,$res;
	if($is_first==0)
	{
		$res=mysql_query("SELECT * FROM Skills",$cms_db_link);
		$is_first=1;
		if(!$res)
			throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
	}
	
	return mysql_fetch_array($res);
}
//------------------TEST FUNCTIONS------------------------------------------------------------------------
function DBAddTest($f_name,$f_type_ID,$f_est_ID)
{
	global $cms_db_link;
	//echo "INSERT INTO Tests(prof_ID,est_ID,name,type_ID) VALUES (7,'$f_est_ID','$f_name','$f_type_ID')";
	$res=mysql_query("INSERT INTO Tests(prof_ID,est_ID,name,type_ID) VALUES (7,'$f_est_ID','$f_name','$f_type_ID')",$cms_db_link);
	//mysql_query("INSERT INTO Estimation(five,four,three) VALUES( )",$cms_db_link);
	if(!$res)
		throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
} 


function DBAddQuestion($test_ID,$f_textq,$f_type_ID)
{
	global $cms_db_link;
	//echo "INSERT INTO Questions(test_ID,text,type_ID) VALUES ('$test_ID','$f_textq', 4)";
	$res=mysql_query("INSERT INTO Questions(test_ID,text,type_ID) VALUES ('$test_ID','$f_textq', 4)",$cms_db_link);
	//mysql_query("INSERT INTO Answers(five,four,three) VALUES(mysql_insert_id() )",$cms_db_link);
	if(!$res)
		throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
} 
function DBAddAnswers($qst_ID,$f_texts,$f_istrue)
{
	global $cms_db_link;
	foreach($f_texts as $k=>$v)
	{
		//echo "INSERT INTO Answers(q_ID,text,istrue) VALUES ('$qst_ID','".$f_texts[$k]."', '".((isset($f_istrue[$k]))?1:0)."')";
		$res=mysql_query("INSERT INTO Answers(q_ID,text,istrue) VALUES ('$qst_ID','".$f_texts[$k]."', '".((isset($f_istrue[$k]))?1:0)."')",$cms_db_link);
	}
	if(!$res)
		throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
} 
function DBEditQuestion($f_ID,$f_text,$f_type_ID)
{
	global $cms_db_link;
	//echo "UPDATE Questions SET Questions.text='$f_text',type_ID='$f_type_ID' WHERE ID=$f_ID";
	$res=mysql_query("UPDATE Questions SET Questions.text='$f_text' WHERE ID=$f_ID",$cms_db_link);
	//mysql_query("UPDATE Students SET grp_ID='$f_grp_ID' WHERE usr_ID=$f_ID",$cms_db_link);
	if(!$res)
		throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
}
function GetTestData($test_ID)
{
	if(!$test_ID) return;
	global $cms_db_link;
	$res=mysql_query("SELECT q.ID, q.test_ID , q.text, a.q_ID, a.text, a.ID FROM Questions q
	LEFT JOIN Answers a ON  q.ID = a.q_ID 
	WHERE q.test_ID = $test_ID",$cms_db_link);
	if(!$res)
		throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
	$data = null;
	while($row = mysql_fetch_assoc($res)){
		if(!$row["q_ID"]) return false;
		$data[$row["q_ID"]][0] = $row["question"];
		$data[$row["q_ID"]][$row["ID"]] = $row["answer"];
	}
	return $data;
}
function DBCountQuestions($test_ID)
{
	global $cms_db_link;	
	
	$res=mysql_query("SELECT * FROM Questions WHERE test_ID = $test_ID",$cms_db_link);
	$is_first=1;
	if(!$res)
		throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
	
	
	return mysql_num_rows($res);
}

function DBFetchTest($prof_ID)
{
	global $cms_db_link;
	static $is_first,$res;
	if($is_first==0)
	{
		$res=mysql_query("SELECT * FROM Tests WHERE prof_ID = $prof_ID",$cms_db_link);
		$is_first=1;
		if(!$res)
			throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
	}
	
	return mysql_fetch_array($res);
}


function DBFetchTypeTest()
{
	global $cms_db_link;
	static $is_first,$res;
	if($is_first==0)
	{
		$res=mysql_query("SELECT * FROM Types",$cms_db_link);
		$is_first=1;
		if(!$res)
			throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
	}
	
	return mysql_fetch_array($res);
}
function DBEditTest($f_ID,$f_name,$f_type_ID,$f_est_ID)
{
	global $cms_db_link;
	$res=mysql_query("UPDATE Tests SET est_ID='$f_est_ID',name='$f_name',type_ID='$f_type_ID' WHERE ID=$f_ID",$cms_db_link);
	if(!$res)
		throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
}
function DBDeleteTest($test_id)
{
	global $cms_db_link;
	$res=mysql_query("DELETE FROM Tests WHERE ID=$test_id",$cms_db_link);
	
	if(!$res)
		throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
}
function DBDeleteQuestion($qst_id)
{
	global $cms_db_link;
	$res=mysql_query("DELETE FROM Questions WHERE ID=$qst_id",$cms_db_link);
	//mysql_query("DELETE FROM Answers WHERE qst_ID=$qst_id",$cms_db_link);
	
	if(!$res)
		throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
}
function DBGetTest($test_ID)
{
	global $cms_db_link;
	
	$res=mysql_query("SELECT Tests.ID As ID, Tests.Name As Name, Tests.Est_ID As Est FROM Tests WHERE ID=$test_ID",$cms_db_link);
	
	if(!$res)
		throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);	
	
	return mysql_fetch_array($res);
}

function DBGetQuestion($qst_ID)
{
	global $cms_db_link;
	
	//echo "SELECT Questions.ID As ID, Questions.Text As Textq, Questions.type_ID As Type FROM Questions WHERE ID=$qst_ID";
	$res=mysql_query("SELECT Questions.ID As ID, Questions.Text As Textq, Questions.type_ID As Type FROM Questions WHERE ID=$qst_ID",$cms_db_link);
	
	if(!$res)
		throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);	
	
	return mysql_fetch_array($res);
}

function DBFetchQuestion($test_id)
{
	global $cms_db_link;
	static $is_first,$res;
	if($is_first==0)
	{
		$res=mysql_query("SELECT * FROM Questions WHERE test_ID=$test_id",$cms_db_link);
		$is_first=1;
		if(!$res)
			throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
	}

	return mysql_fetch_array($res);
}

function DBFetchAnswer($q_id)
{
	global $cms_db_link;
	static $is_first,$res,$old_arg=0;
	if($q_id!=$old_arg)
	{
		$res=mysql_query("SELECT * FROM Answers WHERE q_ID=$q_id",$cms_db_link);
		//$is_first=1;
		if(!$res)
			throw new Exception("ОШИБКА СУБД: [".mysql_errno()."] ".mysql_error(),EXP_QUERYERR);
		$old_arg=$q_id;
	}
	return mysql_fetch_array($res);
}

function CheckTest($answ)
{
	global $cms_db_link;

	$right_answ=0;
	foreach($answ as $k=>$v)
	{
		$res=mysql_query("SELECT * FROM Answers WHERE ID=$v",$cms_db_link);
		if($answ=mysql_fetch_array($res))
			if($answ["istrue"]==1)
				$right_answ++;
	}

	return $right_answ;
}
?>