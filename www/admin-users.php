<?php
	require_once("$_SERVER[DOCUMENT_ROOT]/../dal.inc.php");

	if(isset($_GET["del_id"]))
	{
		$user_id=(int)$_GET["del_id"];
		try
		{
			DBDeleteUser($user_id);
			header("Location: $_SERVER[PHP_SELF]");
		}
		catch(Exception $ex)
		{
			$err=$ex->getMessage();
		}
	}

	if(trim($err)=="")
	{
		try
		{
		if(!isset($form_fields["f_ID"]))
			DBAddUser($f_uni_ID,$f_name,$f_log,$f_fac_ID,$f_spec_ID,$f_mail,$f_pass);
		else
			DBEditUser($f_ID,$f_uni_ID,$f_name,$f_log,$f_fac_ID,$f_spec_ID,$f_mail,$f_pass);
			
		header("Location: $_SERVER[PHP_SELF]");
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
<html>
	<head>		
		<title>ЛК Администратора</title>		
		<link rel="stylesheet" href="css/main.css"/>
		<script type="text/javascript" src="/scripsJS/jquery-1_11_0_min.js"></script>
		<script type="text/javascript">
		</script>
	</head>
	
		<body>
		<div id="wrapper">
			<header>
				<a href="http://webtest"><img src="images/logo.png" alt="logo"></a>
				<div name="right">
					<a href="http://webtest/LK.php"><img src="images/samples.png" alt="logo"></a>
					<button name="q" onclick="location.href='http://webtest';">Выйти</button>
				</div>
			</header>
			<nav>
				<ul class="top-menu">
					<li><a href="http://webtest/admin-news.php">НОВОСТИ</a></li>
					<li class="active">ПОЛЬЗОВАТЕЛИ</li>
					<li><a href="http://webtest/admin-journal.php">ЖУРНАЛ СОБЫТИЙ</a></li>
					<li><a href="http://webtest/admin-statistics.php">СТАТИСТИКА</a></li>
				</ul>
			</nav>
			<div id="heading">
				<h1>ПОЛЬЗОВАТЕЛИ</h1>
			</div>
			<aside>
				<nav>
					<ul class="aside-menu">
						<li class="active">СТУДЕНТЫ</li>
						<li><a href="http://webtest/admin-users-professors.php">ПРЕПОДАВАТЕЛИ</a></li>
					</ul>
				</nav>
			</aside>
			<section>
				<blockquote>
					<h2>СТУДЕНТЫ</h2>
					<div name="right"><button name="b" type="btn_form" onclick="location.href='http://webtest/reg_student.php';">Добавить студента</button></div>
					<figure>
						<table border="1">
							<tr>
								<th>Имя &nbsp;<a href="?sort_desc">V</a>&nbsp;<a href="?sort_asc">^</a></th>
								<th>Логин</th>
								<th>Группа</th>
								<th>Почта</th>
								<th>Действия</th>
							</tr>
							<tbody>
								<? 
								$sort=""; 
								if(isset($_GET["sort_asc"])) 
								$sort="ORDER BY Name ASC"; 
								elseif(isset($_GET["sort_desc"])) 
								$sort="ORDER BY Name DESC"; 

								$res=mysql_query("SELECT users.ID As ID, users.Name As Name, users.Login As Login, 
								users.Mail As Mail, groups.Numb As GroupNumber FROM users,students,groups 
								WHERE students.usr_ID=users.ID AND students.grp_ID=groups.ID GROUP BY users.ID $sort",$cms_db_link); 
								?>
							</tbody>
							<?while($item=DBFetchStudent()):?>
							<tr>
								<td><?=$item["Name"]?></td>
								<td><?=$item["Login"]?></td>
								<td><?=$item["GroupNumber"]?></td>
								<td><?=$item["Mail"]?></td>								
								<td>
									<a href="/edit-student.php?edit_id=<?=$item["ID"]?>">Редактировать</a>
									<a href="?del_id=<?=$item["ID"]?>" onclick="return confirm('Действительно удалить?');">Удалить</a>
								</td>
							</tr>
							<?endwhile;?>
							</tbody>
						</table>
					</figure>
					<div class="team-row">
						<figure>
						</figure>
					</div>
				</blockquote>
			</section>
		</div>
	</body>
	<footer>
		<div id="footer">
			<div id="sitemap">
				<h3>SITEMAP</h3>
				<div>
					<a href="http://webtest/news.php">НОВОСТИ</a>
					<a href="http://webtest/users.php">ПОЛЬЗОВАТЕЛИ</a>
				</div>
				<div>
					<a href="http://webtest/admin-journal.php">ЖУРНАЛ</a>
					<a href="http://webtest/statistics.php">СТАТИСТИКА</a>
				</div>
			</div>
			<div id="social">
				<h3>SOCIAL NETWORKS</h3>
				<a href="http://twitter.com/" class="social-icon twitter"></a>
				<a href="http://facebook.com/" class="social-icon facebook"></a>
				<a href="http://plus.google.com/" class="social-icon google-plus"></a>
				<a href="http://vimeo.com/" class="social-icon-small vimeo"></a>
				<a href="http://youtube.com/" class="social-icon-small youtube"></a>
				<a href="http://flickr.com/" class="social-icon-small flickr"></a>
				<a href="http://instagram.com/" class="social-icon-small instagram"></a>
				<a href="/rss/" class="social-icon-small rss"></a>
			</div>
			<div id="footer-logo">
				<a href="/"><img src="" alt="logo"></a>
				<p>Copyright © 2016 and bla bla bla</p>
			</div>
		</div>
	</footer>
</html>