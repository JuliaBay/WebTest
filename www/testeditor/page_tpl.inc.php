<html>
	<head>		
		<title>ЛК Преподавателя</title>		
		<link rel="stylesheet" href="/css/main.css"/>
		<script type="text/javascript" src="/scripsJS/jquery-1_11_0_min.js"></script>
		<script type="text/javascript">
			function add_question() {
				var list = document.getElementById('li');
				var li = document.createElement('li');
				li.type = 'q';
				li.id = 'li' + (document.getElementById('li').getElementsByTagName('li').length+1);
				li.innerHTML = '<a href="/testeditor/edit_question.php">Вопрос №' + (document.getElementById('li').getElementsByTagName('li').length+1) + '</a>';
				li.innerHTML=li.innerHTML+'<button type="del" onclick="del_question(this.parentNode)">X</button>';
				list.append(li);
			}
			function del_question(obj) {
				document.getElementById('li').removeChild(obj);
			}
			function del_qst(qst_id) {
				location.href="/admin/del_qst.php?qst_id="+qst_id;
			}
		</script>
	</head>
	
	<body>
		<div id="wrapper">
			<header>
				<a href="http://webtest"><img src="/images/logo.png" alt="logo"></a>
				<div name="right">
					<a href="http://webtest/LK.php"><img src="/images/samples.png" alt="logo"></a>
					<button name="q" type="header" onclick="location.href='http://webtest';">Выйти</button>
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
						<?// print_r($_SESSION);?>
						<li><a href="http://webtest/professor-tests.php">СПИСОК ТЕСТОВ</a></li>
						<li id="li" class="active">
							<?if(isset($_SESSION["test_ID"])):?>
								<a href="/testeditor/edit_test.php?edit_id=<?=$_SESSION["test_ID"]?>">РЕДАКТИРОВАТЬ ТЕСТ</a>
								<ul >
								<?while($question=DBFetchQuestion($_SESSION["test_ID"])):?>
								<li class="active"><a href="/testeditor/edit_question.php?qst_id=<?=$question["ID"]?>"><?=substr($question["text"],0,10)?></a><button type="del" onclick="del_qst(<?=$question["ID"]?>)">X</button></li>
								<?endwhile;?>
								</ul>
							<?else:?>
								<a href="/testeditor/edit_test.php">СОЗДАТЬ ТЕСТ</a>
							<?endif;?>
						</li>
                        <button name="q" type="aside" onclick="add_question()">+ Вопрос</button>
                            
                        
						<script language="javascript">
						</script>
					</ul>
				</nav>
			</aside>
			<section>
                <?=get_body()?>
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