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
					<li><a href="/home/">ГЛАВНАЯ</a></li>
					<li class="active">О НАС</li>
					<li><a href="/services/">ВОЗМОЖНОСТИ</a></li>
					<li><a href="/SOMETHING/">чтонибудь</a></li>
					<li><a href="/SOMETHING/">чтонибудь</a></li>
					<li><a href="/contact/">КОНТАКТЫ</a></li>
				</ul>
			</nav>
			<div id="heading">
				<h1>ABOUT US</h1>
			</div>
			<aside>
				<nav>
					<ul class="aside-menu">
						<li class="active">ИСТОРИЯ</li>
						<li><a href="/team/">НАША КОМАНДА</a></li>
						<li><a href="/regards/">НАГРАДЫ</a></li>
						<li><a href="/spons/">СПОНСОРЫ</a></li>
					</ul>
				</nav>
			</aside>
			<section>
				<blockquote>
					<p>
						“Потому что.”
					</p>
					<cite>Я</cite>
					<figure>
						<img src="images/sample.jpg" width="320" height="175" alt="">
					</figure>
					<h2>OUR TEAM</h2>
					<div class="team-row">
						<figure>
							<img src="images/samples.png" width="96" height="96" alt="">
							<figcaption>Лень Великая<span>двигатель прогресса</span></figcaption>
						</figure>
						<figure>
							<img src="images/samples.png" width="96" height="96" alt="">
							<figcaption>Кровать Мягкая<span>team leader</span></figcaption>
						</figure>
					</div>
					<div class="team-row">
						<figure>
							<img src="images/samples.png" width="96" height="96" alt="">
							<figcaption>Ночь Бессонная<span>art director</span></figcaption>
						</figure>
						<figure>
							<img src="images/samples.png" width="96" height="96" alt="">
							<figcaption>Растипопа Слоеная<span>senior ui designer</span></figcaption>
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
					<a href="/home/">Главная</a>
					<a href="/about/">О нас</a>
					<a href="/services/">Возможности</a>
				</div>
				<div>
					<a href="/partners/">чтонибудь</a>
					<a href="/customers/">чтонибудь</a>
					<a href="/contact/">Контакты</a>
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