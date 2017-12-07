[sidemenu[ru/examples/sidemenu]]
[title[=Простой пример]]
<article>
	<header>
		<h1>Простой пример</h1>
	</header>

	<section>
		<header>
			<h1>Описание</h1>
		</header>
		<p>Познакомься с основными вещами, такими как: страницы, чанки, сниппеты, темплейты, плейсхолдеры.</p>
		<h3>Цель</h3>
		<p>Познакомиться с основными тегами PinPIE.</p>
		<h3>Код примера</h3>
		<p><a href="https://github.com/pinpie/example-basic" title="Посмотреть код на GitHub">Есть на GitHub</a></p>
	</section>

		<section>
			<header>
				<h1>Установка</h1>
			</header>
			<?= pcx('git clone https://github.com/pinpie/example-basic
cd example-basic
composer install', 'html') ?>
			<p>
				Или можно просто <a href="https://github.com/pinpie/example-basic/archive/master.zip" title="Download example code">скачать</a>
				актуальную версию из репозитория.
			</p>
	</section>

	<section>
		<header>
			<h1>Файлы</h1>
		</header>
		<ul>
			<li>/index.php &mdash; точка входа</li>
			<li>/pages/index.php &mdash; просто страница</li>
			<li>/pages/about.php &mdash; другая страница</li>
			<li>/css/css.css &mdash; некоторый css</li>
			<li>/chunks/lorem/ipsum.php &mdash; кусочек текста</li>
			<li>/snippets/rand.php &mdash; сниппет, который выводит случайное число</li>
			<li>/templates/default.php &mdash; темплейт с css в head и title, устанавливаемым через плейсхолдер</li>
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

		<h2>/chunks/lorem/ipsum.php</h2>
		<p>Кусочек текста, который просто выводится на страницу. Внутри чанков PHP код не выполняется.</p>
		<?= pcx(h('<p>Lorem ipsum dolor sit amet...'), 'HTML') ?>

		<h2>/snippets/rand.php</h2>
		<p>Кусок кода PHP. Он будет выполнен, а результат его работы выведен на страницу.</p>
		<?= pcx('echo rand(1, 999);', 'PHP') ?>

		<h2>/templates/default.php</h2>
		<p>Шаблон для вывода страницы.</p>
		<?= pcx(h('<html>
<head>
  <!-- Статик таг, который подключает css в head страницы -->
  [[%css=/css/css.css]]
  <!-- Плейсхолдер названия страницы. Если задать его в файле страницы, то выведется он тут в head страницы. -->
  <title>[[*title]]</title>
</head>
<body>
<article>
  <header>
    <!-- Так же этот плейсхолдер можно использовать в другом месте, чтобы вывести название в теле странцы -->
    <h1>[[*title]]</h1>
  </header>
  <!-- Это служебный плейсхолдер. Он обозначает место, куда PinPIE будет выводить содержимое страницы. -->
  [[*content]]
</article>
</body>
</html>', 'HTML')) ?>

		<h2>/pages/index.php</h2>
		<p><i>URL:</i> /</p>
		<p>Главная страница. Доступна по URL <?= scx('/') ?>.</p>
		<p>Содержит следующие PinPIE теги: константа, сниппет, статик тег и чанк.</p>
		<?= pcx(h('<!-- Текст заголовка. Выводится в плейсходлерах [[*title]] -->
[title[=Привет]]

<p>Hi!</p>

<!-- Сниппет с PHP кодом. Выводит случайное число каждый раз, как страница обновляется. -->
<p>Число: [[$rand]].</p>

<!-- Статик тег. Он будет отрисован как <img... с шириной и высотой (необязательно), см. ниже -->
[[%img=/images/cat.jpg]]

<p>Теперь посети <a href="/about">другую страницу</a>.</p>

<!-- Чанк - просто текст, который удобно использовать в нескольких местах. -->
[[lorem/ipsum]]'), 'HTML') ?>
		<p>&nbsp;</p>
		<p>После обработки страницы её HTML код будет выглядеть так:</p>
		<?= pcx(h('...
<!-- Теги article и заголовок h1 находятся в темплейте.
Название устанавливается с помощью плейсхолдера.
Ниже приводится код темплейта.
 -->
<article>
  <header>
    <h1>Привет</h1>
  </header>
  
<!-- Текст названия теперь находится над этой строкой. -->

<p>Hi!</p>

<!-- Сниппет сгенерировал номер. -->
<p>Число: 453.</p>

  <!-- Статик тег стал картинкой с шириной и хешем, предотвращающем ошибки кеширования.
   Пока файл не меняется - этот хеш тоже остаётся неизменным. -->
<img src="//test.ru/images/cat-1.jpg?time=d9c8899d5833a0616ad2aef0bc2229cd" width="640" height="427">

<p>Теперь посети <a href="/about">другую страницу</a>.</p>

<!-- Чанк - просто текст, который удобно использовать в нескольких местах. -->
<p>Lorem ipsum dolor sit amet...'), 'HTML') ?>

		<h2>/pages/about.php</h2>
		<p><i>URL:</i> /about</p>
		<p>Другая простая страница для демонстрации того, как PinPIE обрабатывает пути вроде <?= scx('/about') ?>.</p>

		<h2>/css/css.css</h2>
		<p>Просто немного стилей, чтобы точно понять, что файл загрузился, и стили применились.</p>

	</section>
</article>