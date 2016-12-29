<?php
	require_once("$_SERVER[DOCUMENT_ROOT]/../dal.inc.php");

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
					<button name="q" onclick="location.href='http://webtest';">Выйти</button>
				</div>
			</header>
			<nav>
				<ul class="top-menu">
					<li><a href="http://webtest/admin-news.php">НОВОСТИ</a></li>
					<li><a href="http://webtest/admin-users.php">ПОЛЬЗОВАТЕЛИ</a></li>
					<li class="active">ЖУРНАЛ СОБЫТИЙ</li>
					<li><a href="http://webtest/admin-statistics.php">СТАТИСТИКА</a></li>
				</ul>
			</nav>
			<div id="heading">
				<h1>ЖУРНАЛ СОБЫТИЙ</h1>
			</div>
			<aside>
				<nav>
					<ul class="aside-menu">
						<li><a href="http://webtest/admin-journal.php">ЗАЯВКИ</a></li>
						<li class="active">ПРОХОЖДЕНИЕ ТЕСТОВ</li>
					</ul>
				</nav>
			</aside>
			<section>
				<blockquote>					
					<h2>ПРОХОЖДЕНИЕ ТЕСТОВ</h2>
					<figure>
						<img src="images/sample.jpg" width="320" height="175" alt="">
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