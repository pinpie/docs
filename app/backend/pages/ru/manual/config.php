[title[=Конфигурация]]
[sidemenu[ru/manual/sidemenu]]
[menu config[=
<ul>
	<li><a href="#simplest-config">Простейший конфиг</a></li>
	<li><a href="#config-files">Файлы конфигов</a></li>
	<li><a href="#config-variables">Переменные конфига</a></li>
	<li><a href="#default-pinpie-settings">Дефолты</a></li>
	<li><a href="#pinpie">$pinpie</a></li>
	<li><a href="#preinclude">preinclude.php</a></li>
	<li><a href="#tags">$tags</a></li>
	<li><a href="#other-variables">Прочие переменные</a></li>
</ul>
]]

<article>
	<header><h1>Конфигурация</h1></header>
	<p>
		Настройки могут храниться в файлах или могут быть переданы напрямую в конструктор.
		PinPIE не нуждается в конфигурации при использовании <a href="/en/manual#file-structure">базовой структуры папок</a>.
	</p>
	<section>
		<header>
			<h1>
				<a name="simplest-config" href="#simplest-config">#</a>
				Простейший конфиг
			</h1>
		</header>
		<?= pcx('/* пусто */') ?>
		<p>
			Да, он пустой. На самом деле его даже и нет.
			Единственный шаг, которые потребуется сделать это направить все запросы на index.php.
			И PinPIE сделает всё остальное.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="config-files" href="#config-files">#</a>
				Файл конфига
			</h1>
		</header>
		<p>
			PinPIE может читать конфигурацию из php-файла.
			Все файлы конфигов лежат в папке <?= scx('/config') ?>.
			По умолчанию, при каждом запросе конфиг выбирается автоматически, основываясь на имени сервера.
			Да, вот так просто:
		</p>
		<?= pcx('basename($_SERVER["SERVER_NAME"]) . ".php"') ?>
		<p>
			Таким образом вы можете держать несколько конфигураций в одной папке.
			В зависимости от того, на какой сервер пришёл запрос, будет выбран соответствующий конфиг.
			Это позволяет вести разработку на локальном сайте с другим именем и держать для него свой набор настроек.
		</p>
		<p>
			Чтобы создать файл конфигурации вам нужно создать файл внутри папки <?= scx('/config') ?> с именем
			вашего сервера и расширением ".php", например <?= pcx('/config/mysite.com.php') ?>.
		</p>
		<p>Чтобы начать работать с PinPIE никаких обязательных настроек не требуется.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="config-variables" href="#config-variables">#</a>
				Переменные конфига
			</h1>
		</header>
		<p>В конфиге вы можете устанавливать следующие переменыне:</p>

		<ul>
			<li><?= scx('$pinpie') ?> &mdash; массив для хранения настроек PinPIE.</li>
			<li><?= scx('$tags') ?> &mdash; массив настроек тегов (см доку по <a href="/ru/manual/tags">тегам</a>).</li>
			<li>
				<?= scx('$oth') ?> &mdash; массив для хранения ваших личных настроек. Вы можете хранить тут любые настройки, какие
				требуется и иметь глобальный доступ к ним через <?= scx('PinPIE::$conf->oth', 'php') ?>.
			</li>
			<li>
				<?= scx('$databases') ?> &mdash; храните тут ваши найстройки для подключения к базам данных.
				Доступ к ним возможен через <?= scx('PinPIE::$conf->databases', 'php') ?>.
			</li>
			<li><?= scx('$static_servers') ?> &mdash; массив статических серверов (см <a href="/ru/manual/static">статик доку</a>).</li>
			<li><?= scx('$cache') ?> &mdash; массив настроек кешера (см доку по <a href="/ru/manual/cache">кешу</a>).</li>
			<li><?= scx('$debug') ?> &mdash; включает дебаг (true), по умолчанию отключен (false).</li>
		</ul>
		<p>Эти настройки доступны глобально через <?= scx('PinPIE->conf') ?>.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="default-pinpie-settings" href="#default-pinpie-settings">#</a>
				Дефолтные настройки PinPIE
			</h1>
		</header>
		<p>
			Для работы PinPIE нужно не так уж и много разных настроек. Их дефолтные значения находятся в файле
			<?= scx('CFG.php', 'html') ?>. Вот они:
		</p>
		<?= pcx('$pinpie = [
  "cache class" => false,
  "cache rules" => [
    "default" => ["ignore url" => false, "ignore query params" => []],
    200 => ["ignore url" => false, "ignore query params" => []],
    404 => ["ignore url" => true, "ignore query params" => []]
  ],
  "cache forever time" => PHP_INT_MAX,
  "codepage" => "utf-8",
  "log" => [
    "path" => "pin.log",
    "show" => false,
  ],
  "page not found" => "index.php",
  "route to parent" => 1, //read doc. if exact file not found, instead of 404, PinPIE will try to route request to nearest existing parent entry in url. Default is 1, it means PinPIE will handle "site.com/url" and "site.com/url/" as same page.
  "site url" => $_SERVER["SERVER_NAME"],
  "templates folder" => $this->pinpie->root . DIRECTORY_SEPARATOR . "templates",
  "template function" => false,
  "template clear vars after use" => false,
  "templates realpath check" => true,
  "preinclude" => $this->pinpie->root . DIRECTORY_SEPARATOR . "preinclude.php",
  "postinclude" => $this->pinpie->root . DIRECTORY_SEPARATOR . "postinclude.php",
];

$tags = [
  "" => [
    "class" => "\pinpie\pinpie\Tags\Chunk",
    "folder" => $this->pinpie->root . DIRECTORY_SEPARATOR . "chunks",
    "realpath check" => true,
  ],
  "$" => [
    "class" => "\pinpie\pinpie\Tags\Snippet",
    "folder" => $this->pinpie->root . DIRECTORY_SEPARATOR . "snippets",
    "realpath check" => true,
  ],
  "PAGE" => [
    "class" => "\pinpie\pinpie\Tags\Page",
    "folder" => $this->pinpie->root . DIRECTORY_SEPARATOR . "pages",
    "realpath check" => true,
  ],
  "%" => [
    "class" => "\pinpie\pinpie\Tags\Staticon",
    "folder" => $this->pinpie->root,
    "realpath check" => true,
    "gzip level" => 5,
    "gzip types" => ["js", "css"],
    "minify types" => ["js", "css"],
    "minify function" => false,
    "dimensions types" => ["img"],
    "dimensions function" => false,
    "draw function" => false,
  ],
  "=" => ["class" => "\pinpie\pinpie\Tags\Constant"],
  "@" => ["class" => "\pinpie\pinpie\Tags\Command"],
];', 'php') ?>
	</section>

	<section>
		<header>
			<h1>
				<a name="pinpie" href="#pinpie">#</a>
				<b>$pinpie</b> &mdash; Настройки PinPIE
			</h1>
		</header>
		<p>Настройки движка PinPIE живут в массиве <?= scx('$pinpie') ?>.</p>

		<header>
			<h2>
				<a name="pinpie-cache" href="#pinpie-cache">#</a>
				Кэш
			</h2>
		</header>

		<p>Некоторые универсальные настройки кеширования задаются в <?= scx('$pinpie') ?>:</p>
		<ul>
			<li>cache class &mdash; задаёт <a href="/ru/manual/cache#set">класс кешера</a></li>
			<li>cache forever time &mdash; определяет длину <a href="/ru/manual/cache#usage">вечности</a> (в секундах)</li>
			<li>
				cache rules &mdash; <a href="/ru/manual/cache#cache-rules">правила кэширования</a> призваны бороться с распуханием кэша в случаях с большим количеством
				уникальных запросов.
			</li>
		</ul>
		<p>Крайне рекомендую прочесть об устройстве кэша в <a href="/ru/manual/cache">доках кэша</a>.</p>

		<header>
			<h2>
				<a name="codepage" href="#codepage">#</a>
				codepage
			</h2>
		</header>
		<p>
			PinPIE хранит текущую кодировку в <?= scx('$pinpie["codepage"]') ?>. Вы можете использовать это значение в ваших
			скриптах. Значение по умолчанию "utf-8".
		</p>

		<header>
			<h2>
				<a name="log" href="#log">#</a>
				Log
			</h2>
		</header>
		<p>
			PinPIE будет писать в лог "pin.log" некоторые ошибки вроде несуществующего файла тега.
			Можно указать другой путь в <?= scx('$pinpie["log"]["path"]') ?>.
		</p>
		<p>
			Также в <?= scx('$pinpie["log"]["show"]') ?> можно включить вывод ошибок прямо на страницу, что по дефолту конечно выключено.
		</p>

		<header>
			<h2>
				<a name="page-not-found" href="#page-not-found">#</a>
				page not found
			</h2>
		</header>
		<p>
			Указывает страницу, которая будет обрабатывать запросы к ненайденным страницам.
			По умолчанию это <?= scx('/pages/index.php') ?>, но хорошо бы для этих нужд выделить
			отдельную страницу вроде <?= scx('/pages/notfound.php') ?>.
			В любом случае, если запрошенная страница не найдена, будет автоматически использован заголовок с кодом 404.
		</p>

		<header>
			<h2>
				<a name="route-to-parent" href="#route-to-parent">#</a>
				route to parent
			</h2>
		</header>
		<p>
			Эта переменная отвечает за обработку урлов.
			Подробнее читайте в <a href="/ru/manual/routing">доке по роутингу</a>.
		</p>

		<header>
			<h2>
				<a name="site-url" href="#site-url">#</a>
				site url
			</h2>
		</header>
		<p>
			Эта переменная используется при автоматическом создании урлов для статичных файлов в случае, если список
			статик серверов пуст.
			Значение по умолчанию &mdash; <?= scx('$_SERVER["SERVER_NAME"]') ?>.
		</p>

		<header>
			<h2>
				<a name="templates-settings" href="#templates-settings">#</a>
				Настройки темплейтов
			</h2>
		</header>
		<p>
		<ul>
			<li>templates clear vars after use &mdash; очищать значение плейсхолдера после использования</li>
			<li>templates folder &mdash; папка с темплейтами</li>
			<li>templates function &mdash; Даёт возможность вызвать пользовательскую функцию отрисовки темплейта</li>
			<li>templates realpath check &mdash; проверка того, что файл темплейта находится в папке темплейтов, а не где-то в другом месте</li>
			<li></li>
		</ul>
		Подробнее читайте в <a href="/ru/manual/templates">доке по темплейтам</a>
		</p>

		<header>
			<h2>
				<a name="preinclude" href="#preinclude">#</a>
				Файлы preinclude.php и postinclude.php
			</h2>
		</header>
		<p>
			При отрисовке каждой страницы PinPIE попытается подключить два файла, если они существуют:
			<?= scx("/preinclude.php") ?> и <?= scx("/postinclude.php") ?>.
		</p>
		<p>
			Сначала проверяется существование файла <?= scx("/preinclude.php") ?>.
			Если он есть &mdash; он инклудится. Его отличие от <?= scx("/index.php") ?> в том,
			что в момент его инклуда уже заданы основные параметры PinPIE: прочитан конфиг,
			определён файл-обработчик запроса <?= scx('PinPIE::$document', 'php') ?>, который можно изменить
			по своему усмотрению.
		</p>
		<p>
			Данный файл не подходит для размещения кода автозагрузчика классов.
			Используйте для этого <?= scx("/index.php") ?>.
		</p>
		<p>
			Потом, когда закончена обработка страницы, PinPIE пытается включить файл <?= scx("/postinclude.php") ?>.
			Этот файл подходит для вывода дебаг информации и отложенных действий,
			например с помощью <a href="http://php.net/manual/en/function.fastcgi-finish-request.php">fastcgi_finish_request()</a>.
		</p>
		<p>
			При обновлении файлов PinPIE на новую версию, эти файлы не пропадут и не будут перезаписаны,
			т.к. они отсутствуют в самом PinPIE. Так что можете уверенно использовать эти файлы
			для своих нужд.
		</p>
		<p>
			Пути к этим файлам можно изменить в файле конфигурации в массиве настроек PinPIE:
		</p>
		<?= pcx('$pinpie["preinclude"] = $this->pinpie->root . DIRECTORY_SEPARATOR . "preinclude.php";
$pinpie["postinclude"] = $this->pinpie->root . DIRECTORY_SEPARATOR . "postinclude.php";') ?>
		<p>Использование этих файлов не является обязательным.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="tags" href="#tags">#</a>
				<b>$tags</b> &mdash; Настройки тегов
			</h1>
		</header>
		<p>
			В переменной $tags, доступной далее как <?= scx('PinPIE::$conf->tags') ?> задаются настройки тегов, которые умеет обрабатывать PinPIE.
			Читайте подробнее в документации по <a href="/ru/manual/tags">тегам</a>.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="other-variables" href="#other-variables">#</a>
				Прочие переменные
			</h1>
		</header>
		<h2><b>$oth</b> &mdash; Разные настройки</h2>
		<p>
			Если хотите, вы можете хранить любые свои настройки в массиве <?= scx('$oth') ?>.
			Он будет глобально доступен через <?= scx('PinPIE::$conf->oth', 'php') ?>.
		</p>
		<h2><b>$databases</b> &mdash; Массив баз данных</h2>
		<p>
			Массив <?= scx('$databases') ?> призван хранить в себе настройки доступа к базам данных.
			Вы можете использовать чтобы передавать настройки в ваши классы работы с БД.
			Он будет глобально доступен через <?= scx('PinPIE::$conf->databases', 'php') ?>.
		</p>
		<h2><b>$static_servers</b> &mdash; Серверы статичного контента</h2>
		<p>
			Список серверов статичного контента можно найти в переменной <?= scx('$static_servers') ?>.
			Подробнее можно прочесть в <a href="/ru/manual/static#servers-sharding">статик доке</a>.
		</p>
		<h2><b>$cache</b> &mdash; Настройки, передаваемые в кешер</h2>
		<p>
			Подробнее можно прочесть в доке по <a href="/ru/manual/cache">кешу</a>.
		</p>
		<h2><b>$debug</b> &mdash; Включает вывод дебаг-информации.</h2>
		<p>
			Подробнее можно прочесть в доке по <a href="/ru/manual/debug">debug</a> отчетам. Глобально доступен через <?= scx('PinPIE::$conf->debug') ?>, можно использовать для собственных нужд.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="config-direct" href="#config-direct">#</a>
				Прямая передача настроек
			</h1>
		</header>
		<p>
			Настройки так же можно указать при запуске PinPIE.
			Ввиде массива они могут быть переданы в метод <?= scx('PinPIE::NewInstance($settings)') ?>,
			или непосредственно в конструктор класса PP <?= scx('new PP($settings)') ?>.
		</p>
		<p>Эти настройки задаются с помощью ассоциативного массива, где ключами служат названия переменных:</p>
		<?= pcx('$settings = [
  "pinpie" => [
    "route to parent" => 100,
    "cache class" => "\pinpie\pinpie\Cachers\Disabled",
  ],
  "debug" => true,
];', 'PHP') ?>
		<p>В данном случае доступны дополнительные настройки:</p>

		<h3>file</h3>
		<p>
			Настройка файла конфигурации. Если отсутствует или равна <?= scx('true') ?>,
			то PinPIE попытается найти и подключить файл конфига, как указано выше.
		</p>
		<p>Если равна <?= scx('false') ?>, то PinPIE вообще не будет производить поиск и загрузку файла конфига.</p>
		<p>
			Если значение это строка, то PinPIE попытается загрузить конфиг
			по указанному пути. В любом случае, любые настройки массива перезапишут настройки из файла.
		</p>

		<h3>root</h3>
		<p>
			Путь к корневому каталогу с ресурсами PinPIE. Это тот самый каталог, в котором PinPIE ищет папки со страницами,
			сниппетами, чанками, статические файлы и конфиг. Данная настройка может быть задана только тут, до загрузки файла конфигурации.
		</p>

		<h3>page</h3>
		<p>
			Путь к файлу, который будет обработан в качестве страницы, относительно папки со страницами.
			Если он указан, то PinPIE не будет искать файл, подходящий под url запроса, а использует указанный в данной настройке.
			При использовании этой настройки необходимо самостоятельно позаботиться о проверке существования этого файла.
		</p>

		<p>
			Настройки, переданные напрямую имеют больший приоритет и перезаписывают настройки из файла.
		</p>
		<h2>Пример</h2>
		<?= pcx('$settings = [
  "root" => "/var/www/site.com.dev/",
  "file" => false,
  "page" => "/users/index.php",
  "pinpie" => [
    "cache class" => "\pinpie\pinpie\Cachers\Disabled",
    "site url" => "site.com",
  ],
];', 'PHP') ?>
	</section>
</article>
