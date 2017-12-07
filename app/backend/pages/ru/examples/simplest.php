[sidemenu[ru/examples/sidemenu]]
[title[=Простейший сайт]]
<article>
  <header>
    <h1>Простейший сайт</h1>
  </header>

  <section>
    <header>
      <h1>Описание</h1>
    </header>
    <p>Это простейший сайт на PinPIE: две страницы, пустой конфиг, но он вполне будет работать. Попробуй.</p>
		<h3>Цель</h3>
		<p>Убедиться, что работает.</p>
		<h3>Код примера</h3>
		<p><a href="https://github.com/pinpie/example-simplest" title="Посмотреть код на GitHub">Есть на GitHub</a></p>
  </section>


		<section>
			<header>
				<h1>Установка</h1>
			</header>
			<?= pcx('git clone https://github.com/pinpie/example-basic
cd example-simplest
composer install', 'html') ?>
			<p>
				Или можно просто <a href="https://github.com/pinpie/example-simplest/archive/master.zip" title="Download example code">скачать</a>
				актуальную версию из репозитория.
			</p>
	</section>


	<section>
		<header>
			<h1>Файлы</h1>
		</header>
		<ul>
			<li>/index.php &mdash; точка входа</li>
			<li>/pages/index.php &mdash; страница</li>
			<li>/pages/about.php &mdash; другая страница</li>
		</ul>

		<h2>/index.php</h2>
		<p>
			Главная точка входа, где нужно подключить автолоад композера или автолоад PinPIE
			и создать объект PinPIE. Он определит запрошенную страницу, проверит на существование её файл,
			выполнит код и отдаст запрошенный контент.
		</p>
		<?= pcx('include __DIR__ . \'/vendor/autoload.php\';
// include __DIR__ . \'/pinpie/autoload.php\';
\pinpie\pinpie\PinPIE::renderPage();', 'PHP') ?>

		<h2>/pages/index.php</h2>
		<p><i>URL:</i> /</p>
		<p>Simplest main page, just to make sure PinPIE works fine. Available at the <?= scx('/') ?> URL.</p>
		<p>Простейшая главная страница, просто чтобы убедиться, что PinPIE рабобтает исправно. Доступна по адресу <?= scx('/') ?>.</p>
		<?= pcx(h('<h1>Привет</h1>
<p>Работает!</p>
<p>Теперь посмотри <a href="/about">другую страницу</a>.</p>'), 'HTML') ?>

		<h2>/pages/about.php</h2>
		<p><i>URL:</i> /about</p>
		<p>Другая простая страница, чтобы увидеть, что PinPIE обрабатывает адреса вроде <?= scx('/about') ?>.</p>
		<?= pcx(h('<h1>About</h1>
<p>Lorem Ipsum - это текст-"рыба", часто используемый в печати и...'), 'HTML') ?>
	</section>
</article>