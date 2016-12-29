<?php
	require_once("$_SERVER[DOCUMENT_ROOT]/../dal.inc.php");
	if(isset ($_POST["btn"])){
		header("Location://webtest/aut_user.php");
	}
	//Запрет кэширования
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Expires: " . date("r"));
?>
<html>
	<head>		
		<title> Главная </title>		
		<link rel="stylesheet" href="css/main.css"/>
		<script type="text/javascript" src="/scripsJS/jquery-1_11_0_min.js"></script>
		<script type="text/javascript">
		</script>
	</head>
	
	<body>
		<div id="wrapper">
			<header>
				<a href="http://webtest"><img src="images/logo.png" alt="logo"></a>
				<form name="search" action="#" method="get">
				<input type="text" name="q" placeholder="Search"><button type="submit">GO</button></br>
				<button id = "btn" name="btn">Войти</button>
				<button name="btn">Зарегистрироваться</button>
				</form>
			</header>
			<nav>
				<ul class="top-menu">
					<li><a href="/home/">HOME</a></li>
					<li class="active">ABOUT US</li>
					<li><a href="/services/">SERVICES</a></li>
					<li><a href="/SOMETHING/">SOMETHING</a></li>
					<li><a href="/SOMETHING/">SOMETHING</a></li>
					<li><a href="/contact/">CONTACT</a></li>
				</ul>
			</nav>
			<div id="heading">
				<h1>ABOUT US</h1>
			</div>
			<aside>
				<nav>
					<ul class="aside-menu">
						<li class="active">LOREM IPSUM</li>
						<li><a href="/donec/">DONEC TINCIDUNT LAOREET</a></li>
						<li><a href="/vestibulum/">VESTIBULUM ELIT</a></li>
						<li><a href="/etiam/">ETIAM PHARETRA</a></li>
						<li><a href="/phasellus/">PHASELLUS PLACERAT</a></li>
						<li><a href="/cras/">CRAS ET NISI VITAE ODIO</a></li>
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

		<footer>
			<div id="footer">
				<div id="sitemap">
					<h3>SITEMAP</h3>
					<div>
						<a href="/home/">Home</a>
						<a href="/about/">About</a>
						<a href="/services/">Services</a>
					</div>
					<div>
						<a href="/partners/">Partners</a>
						<a href="/customers/">Support</a>
						<a href="/contact/">Contact</a>
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