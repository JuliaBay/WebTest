<?php
	require_once("$_SERVER[DOCUMENT_ROOT]/../dal.inc.php");
	require_once("$_SERVER[DOCUMENT_ROOT]/auth.php");

	if(isset($_GET["test_id"]))
	{
		$test_id=(int)$_GET["test_id"];
		try{
			$test_data=GetTestData($test_id);
			if(is_array($test_data))
			{
				print_r($test_data);
				$count_q = count($test_data);
			}
			//header("Location: $_SERVER[PHP_SELF]");
		}
		catch(Exception $ex)
		{
			$err=$ex->getMessage();
		}
		
	}

	if(isset($_GET["del_id"]))
	{
		$test_id=(int)$_GET["del_id"];
		try
		{
			DBDeleteTest($test_id);
			header("Location: $_SERVER[PHP_SELF]");
		}
		catch(Exception $ex)
		{
			$err=$ex->getMessage();
		}
	}
if(isset($_GET["edit_id"]))
{
	$f_id=(int)$_GET["edit_id"];
	DBEditTest($f_ID,$f_name,$f_type_ID,$f_est_ID());
			
}

	if(trim($err)=="")
	{
		try
		{
		if(!isset($form_fields["f_ID"]))
			DBAddUser($f_uni_ID,$f_name,$f_log,$f_fac_ID,$f_spec_ID,$f_mail,$f_pass);
		else
			DBEditTest($f_ID,$f_name,$f_type_ID,$f_est_ID());
			
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
		<title>ЛК Преподавателя</title>		
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
					<button name="q" onclick="location.href='http://webtest/professor-tests.php?logout';">Выйти</button>
				</div>
			</header>
			<nav>
				<ul class="top-menu">
					<li><a href="http://webtest/admin-news.php">НОВОСТИ</a></li>
					<li class="active">ТЕСТЫ</li>
					<li><a href="http://webtest/admin-journal.php">ЖУРНАЛ СОБЫТИЙ</a></li>
					<li><a href="http://webtest/admin-statistics.php">СТАТИСТИКА</a></li>
				</ul>
			</nav>
			<div id="heading">
				<h1>ТЕСТЫ</h1>
			</div>
			<aside>
				<nav>
					<ul class="aside-menu">
						<li class="active">СПИСОК ТЕСТОВ</li>
						<li><a href="http://webtest/testeditor/edit_test.php">СОЗДАТЬ ТЕСТ</a></li>
					</ul>
				</nav>
			</aside>
			<section>
				<div class="content">
					<?if(isset($test_data)):?>
						<?if(is_array($test_data)):?>
							<p>Всего вопросов: <?=$count_q?></p>
							<div class="test-content">
								<? ;?>
								<p><?=print_r($test_data[1][3])?></p>
							</div>
						<?endif;?>					
					<?endif;?>
				</div>
				<blockquote>
					<h2>СПИСОК ТЕСТОВ</h2>
					<figure>
						<table border="1">
							<tr>
								<td>Дата создания</td>
								<td>Название</td>
								<td>Вопросы</td>
								<td>Результаты</td>
								<td>Действия</td>
							</tr>
							<?while($item=DBFetchTest(7)):?>
							<tr>
								<td><?=$item["creationdate"]?></td>
								<td><a href="testplayer.php?test_id=<?=$item["ID"]?>"><?=$item["name"]?></a></td>
								<td><?=DBCountQuestions($item["ID"])?></td>
								<td>РЕЗУЛЬТАТЫ</td>
								<td>
									<a href="/testeditor/edit_test.php?edit_id=<?=$item["ID"]?>">Редактировать</a>
									<a href="?del_id=<?=$item["ID"]?>" onclick="return confirm('Действительно удалить?');">Удалить</a>
								</td>
							</tr>
							<?endwhile;?>
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
					<a href="http://webtest/users.php">ТЕСТЫ</a>
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