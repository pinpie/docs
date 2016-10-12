[title[=Начало работы с PinPIE]]
[sidemenu[ru/manual/sidemenu]]
[menu start[=
<ul>
	<li><a href="#download">Скачать</a></li>
	<li><a href="#composer">Composer</a></li>
	<li><a href="#standalone">Standalone</a></li>
	<li><a href="#launch">Запуск</a></li>
	<li><a href="#config">Конфиг</a></li>
	<li><a href="#preinclude">preinclude.php</a></li>
</ul>
]]
<article>
	<header>
		<h1>Начни использовать PinPIE</h1>
	</header>

	<section>
		<header>
			<h1>
				<a name="download" href="#download">#</a>
				Скачать
			</h1>
		</header>
		<p>
			Скачать любую версию PinPIE можно из <a href="https://github.com/pinpie/pinpie/">репозитория PinPIE</a>.
			Всегда доступны текущая <a href="https://github.com/pinpie/pinpie/archive/stable.zip">стабильная (пока недоступна)</a>
			и <a href="https://github.com/pinpie/pinpie/archive/dev.zip">девелоперская</a> версии.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="composer" href="#composer">#</a>
				Установка из Composer
			</h1>
		</header>
		<p>
			Для начала работы добавьте и установите пакет <?= scx('pinpie/pinpie') ?> и скопируйте базовую структуру
			папок из <?= scx('basic structure', 'html') ?> в свой проект.</p>
		<?= pcx('composer require "pinpie/pinpie"
composer install', 'html') ?>
		<p>
			Необходимо обеспечить направление всех запросов на единую точку входа.
		</p>
	</section>
	<section>
		<header>
			<h1>
				<a name="standalone" href="#standalone">#</a>
				Установка самостоятельной версии
			</h1>
		</header>
		<p>
			Если по каким-то причинам вы не используете composer, то можете скачать и скопировать файлы PinPIE из <?= scx('/src') ?>
			в удобное для вас место.
		</p>
		<p>
			Для запуска PinPIE необходимо инклудить его в главной точке входа вашего проекта,
			а все запросы направить на этот файл.
			Обеспечить направление всех запросов на "/index.php" или другой файл можно в конфиге веб-сервера.
			Примеры конфигов можно найти в разделе документации по
			<a href="/ru/manual/server-configuration">конфигурации сервера</a>.
			Обычно, главная точка входа в код сайта это "/index.php".
		</p>
		<p> Чтобы PinPIE начал работать, внутри этого файла должна быть такая строчка:</p>
		<?= pcx('include "./pinpie/autoload.php";') ?>
		<p>Вы не обязаны размещать файлы PinPIE в этой папке. Можете размещать их там, где вам удобнее.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="launch" href="#launch">#</a>
				Запуск
			</h1>
		</header>
		<p>Для запуска работы PinPIE в большинстве случаев достаточно кода:</p>
		<?= pcx('\pinpie\pinpie\PinPIE::newInstance();', 'PHP') ?>
		<p>Для удобства работы можно сделать класс PinPIE глобально доступным с помощью функции class_alias():</p>
		<?= pcx('class_alias("\pinpie\pinpie\PinPIE", "PinPIE");
PinPIE::newInstance();', 'PHP') ?>
	</section>

	<section>
		<header>
			<h1>
				<a name="config" href="#config">#</a>
				Настройка PinPIE
			</h1>
		</header>
		<p>
			PinPIE не требует задания каких-либо обязательных настроек, и будет работать и с пустым конфигом, или вообще без него.
			Читайте о настройке в доке по <a href="/ru/manual/config">конфигу PinPIE</a>.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="preinclude" href="#preinclude">#</a>
				Файлы preinclude.php и postinclude.php
			</h1>
		</header>
		<p>
			При каждом запросе PinPIE попытается подключить два файла, если они существуют:
			<?= scx("/preinclude.php") ?> и <?= scx("/postinclude.php") ?>.
			Пути к файлам можно задать в конфиге.
			Читайте о том, зачем они нужны и чем они будут вам полезны
			в доке по <a href="/ru/manual/config#preinclude">конфигу PinPIE</a>.
		</p>
	</section>

</article>