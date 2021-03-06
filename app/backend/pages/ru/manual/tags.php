[title[=Все теги PinPIE]]
[sidemenu[ru/manual/sidemenu]]
[menu tags[=
<ul>
	<li><a href="#chunk">Чанк</a></li>
	<li><a href="#snippet">Сниппет</a></li>
	<li><a href="#snippet-caching">Кэширование сниппетов</a></li>
	<li><a href="#page">PAGE</a></li>
	<li><a href="#constant">Константа</a></li>
	<li><a href="#placeholder">Плейсхолдер</a></li>
	<li><a href="#command">Команда</a></li>
	<li><a href="#static-tags">Статик теги</a></li>
	<li><a href="#tag-templates">Темплейты тегов</a></li>
</ul>
]]
<article>
	<header>
		<h1>
			<a name="" href="">#</a>
			Теги
		</h1>
	</header>
	<p>PinPIE работает с тегами. Синтаксис тегов вдохновлён системой тегов ModX. В этом документе описываются все теги PinPIE.</p>
	<section>
		<header>
			<h1>
				<a name="chunk" href="#chunk">#</a>
				Чанк
			</h1>
			<p>Синтаксис: <?= scx('[[chunk]]') ?></p>
			<p>Настройки: <?= scx('$tags[""]') ?></p>
			<p>Класс: <?= scx('\pinpie\pinpie\Tags\Chunk') ?></p>
		</header>
		<p>
			Чанк это просто текст, содержащийся в файле с расширением *.php
			в папке <?= scx('$tags[""]["folder"]') ?>.
		</p>
		<p>Встретив такую конструкцию</p>
		<?= scx('[[some_chunk]]') ?>
		<p>PinPIE попробует найти файл</p>
		<?= pcx('$tags[""]["folder"] . DIRECTORY_SEPARATOR . "some_chunk.php"') ?>
		и загрузит его содержимое, как простой текст.
		PinPIE будет парсить этот текст в поисках других тегов, но php-код исполнен не будет.
		</p>
		<p>
			Для лучшей организации, можно размещать чанки внутри папок:
			<?= scx('[[some/chunk]]') ?> или <?= scx('[[some/long/path/chunk]]') ?>.
		</p>
		<h2>Настройки</h2>
		<h3>Дефолты</h3>
		<?= pcx('$tags[""] => [
    "class" => "\pinpie\pinpie\Tags\Chunk",
    "folder" => $this->pinpie->root . DIRECTORY_SEPARATOR . "chunks",
    "realpath check" => true,
]') ?>
		<h3>Описание</h3>
		<ul>
			<li>class &mdash;
				Определяет, какой класс будет использован при создании экземпляра чанка.
				Можно задать свой класс, если требуется.
			</li>
			<li>
				folder &mdash;
				Задаёт папку, где PinPIE будет искать файлы чанков.
			</li>
			<li>
				realpath check &mdash;
				Проверка принадлежности пути к файлу той папке, в которой он должен быть.
				Служит для защиты от путей типа <?= scx('..\\..\\..\\file.php') ?>, но может быть отключен в случае
				использования линков или прочей необходимости.
			</li>
		</ul>
		<p>Больше примеров использования тегов можно найти в <a href="/ru/examples/tags">примерах тегов</a>.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="snippet" href="#snippet">#</a>
				Сниппет
			</h1>
			<p>Синтаксис: <?= scx('[[$snippet]]') ?></p>
			<p>Настройки: <?= scx('$tags[\'$\']') ?></p>
			<p>Класс: <?= scx('\pinpie\pinpie\Tags\Snippet') ?></p>
		</header>
		<p>
			Сниппет это файл php, который будет заинклюден, исполнен и вывод будет спарсен в поисках других тегов.
			Тег сниппета начинается с символа <b>$</b>: <?= scx('[[$some_snippet]]') ?>.
		</p>
		<h2>Параметры</h2>
		<p>
			В сниппеты можно передавать GET-подобные параметры в имени, как в url:
		</p>
		<?= pcx('[[$snippet?foo=bar&cat=dog]]') ?>
		<p>
			Внутри сниппета они будут доступны в PHP как переменные
			<span><code>$foo</code></span> и <span><code>$cat</code></span>.
			Если изменятся переменные или их значения, сниппет будет принудительно перепарсен.
			Так что во время активной разработки волноваться о кэше не придётся.
		</p>
		<h2>Настройки</h2>
		<h3>Дефолты</h3>
		<?= pcx('$tags[\'$\'] => [
    "class" => "\pinpie\pinpie\Tags\Snippet",
    "folder" => $this->pinpie->root . DIRECTORY_SEPARATOR . "snippets",
    "realpath check" => true,
]') ?>
		<h3>Описание</h3>
		<ul>
			<li>class &mdash;
				Определяет, какой класс будет использован при создании экземпляра сниппета.
				Можно задать свой класс, если требуется.
			</li>
			<li>
				folder &mdash;
				Задаёт папку, где PinPIE будет искать файлы сниппетов.
			</li>
			<li>
				realpath check &mdash;
				Проверка принадлежности пути к файлу той папке, в которой он должен быть.
				Служит для защиты от путей типа <?= scx('..\\..\\..\\file.php') ?>, но может быть отключен в случае
				использования линков или прочей необходимости.
			</li>
		</ul>
		<p>Больше примеров использования тегов можно найти в <a href="/ru/examples/tags">примерах тегов</a>.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="snippet-caching" href="#snippet-caching">#</a>
				Кэширование сниппетов
			</h1>
			<p></p>
		</header>
		<p>
			Дефолтно сниппет выполняется каждый раз заново. Но можно и кэшировать.
			Установите нужное время в секундах, или можно закешируйте навсегда указав вместо времени восклицательный знак.
			Если файл сниппета или файлы его детей изменятся, то сниппет будет автоматически перевыполнен.
		</p>
		<h2>Примеры использования:</h2>
		<ul>
			<li><?= scx('[[$some_snippet]]') ?> &mdash; кэширование отключено, сниппет выполняется каждый раз</li>
			<li><?= scx('[[<b>3600</b>$some_snippet]]') ?> &mdash; сниппет закешируется на час</li>
			<li>
				<?= scx('[[!$some_snippet]]') ?> &mdash; сниппет закеширован очень надолго, а именно на
				<span><code>PinPIE::$config->pinpie['cache forever time']</code></span> секунд,
				что по-умолчанию равно примерно 10 лет (315360000 секунд).
				Можно установить своё значение <a href="/ru/manual/cache#usage">cache forever time</a>
				в <a href="/ru/manual/config#pinpie-cache">конфиге</a>.
			</li>
		</ul>
		<p>Читайте об этом более подробно в доке по <a href="/ru/manual/cache">кэшу</a>.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="page" href="#page">#</a>
				PAGE
			</h1>
			<p>Синтаксис: нет</p>
			<p>Настройки: <?= scx('$tags["PAGE"]') ?></p>
			<p>Класс: <?= scx('\pinpie\pinpie\Tags\Page') ?></p>
		</header>
		<p>
			Страница в PinPIE представлена в виде тега <?= scx('PAGE') ?>, который автоматически создаётся при запуске и является корнем для
			других тегов.
		</p>
		<h2>Настройки</h2>
		<h3>Дефолты</h3>
		<?= pcx('$tags["PAGE"] => [
    "class" => "\pinpie\pinpie\Tags\Page",
    "folder" => $this->pinpie->root . DIRECTORY_SEPARATOR . "pages",
    "realpath check" => true,
]') ?>
		<h3>Описание</h3>
		<ul>
			<li>class &mdash;
				Определяет, какой класс будет использован при создании экземпляра страницы.
				Можно задать свой класс, если требуется.
			</li>
			<li>
				folder &mdash;
				Задаёт папку, где PinPIE будет искать файлы страниц.
			</li>
			<li>
				realpath check &mdash;
				Проверка принадлежности пути к файлу той папке, в которой он должен быть.
				Служит для защиты от путей типа <?= scx('..\\..\\..\\file.php') ?>, но может быть отключен в случае
				использования линков или прочей необходимости.
			</li>
		</ul>
	</section>

	<section>
		<header>
			<h1>
				<a name="constant" href="#constant">#</a>
				Константа
			</h1>
			<p>Синтаксис: <?= scx('[[=constant]]') ?></p>
			<p>Настройки: нет</p>
			<p>Класс: <?= scx('\pinpie\pinpie\Tags\Constant') ?></p>
		</header>
		<p>
			Константа это просто текст, который нужно вывести. Без указания плейсхолдера в этом нет смысла.
			Но так как все страницы хранятся в файлах, константы это удобный способ вывести небольшой текст в другом месте, например
			в темплейте. В этой же доке можно прочесть про <a href="#placeholder">плейсхолдеры</a> подробнее.
		</p>
		<p>Тег константы начинается с символа равно. Вот пример константы: <?= scx('[[=simple constant text]]') ?>.</p>
		<p>Текст константы конечно же может быть многострочным:</p>
		<?= pcx('[[=какой-то
многострочный
текст]]') ?>
		<p>Примеры использования констант можно найти в <a href="/ru/examples/tags">примерах тегов</a>.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="placeholder" href="#placeholder">#</a>
				Плейсхолдер
			</h1>
			<p>Синтаксис: <?= scx('[[*placeholder]]', 'html') ?></p>
			<p>Синтаксис: <?= scx('[[*placeholder=default value]]', 'html') ?></p>
			<p>Не является настоящим тегом и не имеет настроек.</p>
		</header>
		<p>
			Вывод любого чанка, сниппета или константы можно засунуть как бы в переменную. Эта переменная может быть использована
			на странице или в теге, или, конечно же, в темлейте. Тег плейсхолдера начинается со звёздочки. Вот пример плейсхолдера:
			<?= scx('[[*placeholder]]', 'html') ?>.
		</p>
		<?= pcx(h('[foobar[$some_snippet]]
...
<span>[[*foobar]]</span>'), 'html') ?>
		<p>
			Вывод сниппета <?= scx('some_snippet', 'html') ?> не будет использован там, где сниппет находится.
			Он отправится в плейсхолдер <?= scx('foobar', 'html') ?> и будет выведен там.
		</p>
		<p>
			В плейсхолдере можно использовать значения по умолчанию. Ты можешь задать это значение прямо в плейсхолдере. Оно будет использовано если никакое другое значение не будет задано.
		</p>
		<?= pcx(h('<span>[[*var=some default text]]</span>')) ?>
		<p>Это сделает вот такой HTML:</p>
		<?= pcx(h('<span>some default text</span>')) ?>
		<p>
			Если этому плейсхолдеру назначен какой-либо контент, например <?= scx('[var[$rand]]') ?>,
			то вместо плейсхолдера будет выведено именно этот контент:
		</p>
		<?= pcx(h('<span>42</span>')) ?>

		<p>
			Содержимое плейсхолдера можно использовать и во внешнем темлейт-движке с помощью вашей кастомной функции.
			Оно передаётся в эту функцию в виде массива. См. документацию по темплейтам.
		</p>
		<p>
			Содержимое плейсхолдеров кешируется в родительском кэше, так что вам не стоит переживать за ситуацию, когда
			содержимое плейсхолдера устанавливается внутри закешированного сниппета, но используется где-то снаружи
			этого сниппета. Всё будет закешировано и отдано в PinPIE для использования там, где требуется.
		</p>
		<p>Теги плейсхолдеров по умолчанию убираются из вывода. Т.е. каждый плейсхолдер будет заменён на какой-либо контент, либо на пустую строку. Плейсхолдеры не попадают в результат работы. Но при включенном дебаге они остаются.</p>
		<h3>Важно</h3>
		<p>
			Существует зарезервинованный плейсхолдер <?= scx('[[*content]]') ?> для вывода содержимого страницы или тега
			в темплейте. См. <a href="/ru/manual/templates">доку по темплейтам</a>.
		</p>
		<h2>Примеры</h2>
		<h3>Пример 1</h3>
		<p>
			Чтобы вывести тайтл страницы в темплейте в теге &lt;title&gt;, можно запихнуть его в плейсхолдер через константу
			<?= scx('[var[=About]]') ?> на странце, а вывести через тег плейсхолдера <?= scx(h('<title>[[*var]]</title>')) ?> в темплейте.
		</p>
		<h3>Пример 2</h3>
		<p>
			Можно даже использовать плейсхолдеры до того, как вы в него введёте данные, потому что плейсхолдеры заменяются содержимым
			уже после того, как страница или иной тег были обработаны.
		</p>

		<p>Этот код</p>
		<?= pcx(h('<span>[[*var]]</span>
[var[=pinpie]]')) ?>
		<p>или этот</p>
		<?= pcx(h('[var[=pinpie]]
<span>[[*var]]</span>')) ?>
		<p>дадут в результате один и тот же HTML code:</p>
		<?= pcx(h('<span>pinpie</span>')) ?>

		<h3>Пример 3</h3>
		<p>Плейсхолдеры можно использовать и со сниппетами или чанками.</p>
		<?= pcx(h('[var[some_chunk]]
<span>[[*var]]</span>'), 'html') ?>

		<p>Если в файле /chunks/some_chunk.php содержится код</p>
		<?= pcx("pinpie") ?>
		<p>или</p>
		<?= pcx(h('[var[$some_snippet]]
<span>[[*var]]</span>'), 'html') ?>
		<p>или же в файле /snippets/some_snippet.php такой код:</p>
		<?= pcx(h('<?php echo "pinpie"; ?>')) ?>
		<p>или если в том же файле просто написать</p>
		<?= pcx('pinpie') ?>
		<p>то всё это в результате даёт один и тот же HTML код:</p>
		<?= pcx(h('<span>pinpie</span>')) ?>
	</section>

	<section>
		<header>
			<h1>
				<a name="command" href="#command">#</a>
				Команда
			</h1>
			<p>Синтаксис: <?= scx('[[@template=main]]', 'html') ?> или <?= scx('[[#template=main]]', 'html') ?></p>
			<p>Настройки: нет</p>
			<p>Класс: <?= scx('\pinpie\pinpie\Tags\Command') ?></p>
		</header>
		<p>
			Для управления некоторыми функциями движка PinPIE на странице или в теге используйте команды.
			Тег команды начинается с <b>@</b> для подавления вывода команды, или с <b>#</b> чтобы увидеть возвращаемое значение.
			Правда, на текущий момент поддерживается только одна команда, и лучше использовать её вот так:
			<?= scx('[[@template=wide]]') ?>.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="static-tags" href="#static-tags">#</a>
				Статик теги
			</h1>
			<p>Синтаксис: <?= scx('[[%type=path]]') ?></p>
			<p>Настройки: <?= scx('$tags["%"]') ?></p>
			<p>Класс: <?= scx('\pinpie\pinpie\Tags\Staticon') ?></p>
		</header>

		<p>
			Статик теги представляют собой удобный способ использования всяких статик-фич, таких как <b>минификация</b>,
			<b>gzip сжатие</b> и <b>серверный шардинг</b>. Статик теги начинаются с символа <b>%</b> и указания типа
			статик контента, который не обязательно связан расширением или типом этого файла.
		</p>
		<p>
			Для более детальной информации о статик тегах, пре-минификации и gzip-сжатии, пожалуйста смотри <a href="/ru/manual/static">доку по статик тегам</a>.
		</p>
		<p>
			На текущий момент эти типы поддерживаются из коробки:
		<ul>
			<li>js &mdash; для файлов javascript</li>
			<li>css &mdash; каскадных страниц стилей</li>
			<li>img &mdash; для всяких картинок</li>
		</ul>
		</p>
		<p>
			Эти теги заменяются соответствующими HTML тегами, в которых URL ведёт на один из статик серверов из списка
			(если включен шардинг), и имеет GET-параметр <?= scx('time') ?> содержаший солёный хэш от имени и времени изменения файла.
			Это приводит к <b>автоматичекому обновлению кэша браузера</b>. Таким образом вам не придётся нажимать Ctrl+F5 во время
			разработки вашего сайта, а посетители получат свежие версии всех файлов сразу же.
		</p>
		<p>
			Более подробно это описано в <a href="/ru/manual/static">статик доке</a>.
		</p>
		<h2>Пример</h2>

		<p>Этот код</p>
		<?= pcx('[[%js=/javascript/jquery.js]]', 'html') ?>
		<p>по умолчанию создаёт html тег</p>
		<?= pcx(h('<script type="text/javascript" src="/javascript/jquery.js?time=hash"></script>'), 'html') ?>
		<p>
			В случае необходимости, статик файлы могут находиться вне корневой папки сайта.
			Вы можете установить в <?= scx('PinPIE::$config->pinpie["static folder"]') ?> путь к папке со статик файлами.
			Дефолтное значение это <?= scx('ROOT') ?> (см. <a href="/ru/manual/constants#root">константы</a>).
		</p>
		<h2>Настройки</h2>
		<h3>Дефолты</h3>
		<?= pcx('$tags["%"] => [
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
    "servers" => [],
]') ?>
		<h3>Описание</h3>
		<ul>
			<li>class &mdash;
				Определяет, какой класс будет использован при создании экземпляра статик тега.
				Можно задать свой класс, если требуется.
			</li>
			<li>
				folder &mdash;
				Задаёт папку, где PinPIE будет искать статические файлы.
			</li>
			<li>
				realpath check &mdash;
				Проверка принадлежности пути к файлу той папке, в которой он должен быть.
				Служит для защиты от путей типа <?= scx('..\\..\\..\\file.php') ?>, но может быть отключен в случае
				использования линков или прочей необходимости.
			</li>
		</ul>
		<p>
			Более подробная информация о статик тегах, их настройках, пре-минификации и предарихвации gzip содержится в
			<a href="/ru/manual/static">статик доке</a>.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="tag-templates" href="#tag-templates">#</a>
				Темплейты тегов
			</h1>
		</header>
		<p>
			К любому тегу могут применяться темплейты. Единственным исключением является плейсхолдер.
			Эти темплейты не такого рода как <a href="http://twig.sensiolabs.org/">twig</a>
			или <a href="http://mustache.github.io/">mustache</a>, например. По сути это просто врапперы для вывода тегов.
			Код темплейта выполняется всегда, в отличии от контента тега, который может быть загружен из кэша.
		</p>

		<h3>Пример</h3>
		<p>Чтобы обернуть вывод сниппета в див, вам нужно создать темплейт с именем, допустим, "wrap" с таким кодом:</p>
		<?= pcx(h('<div>[[*content]]</div>')) ?>
		<p>И теперь можно прменить этот темплейт к сниппету вот так:</p>
		<?= pcx('[[$snippet]wrap]') ?>
		<p>Допустим, код сниппета такой:</p>
		<?= pcx(h('<?php echo rand(1, 100); ?>'), 'php') ?>
		<p>Тогда мы получим такой результат:</p>
		<?= pcx(h('<div>42</div>'), 'html') ?>
		<p>В темплейт можно передать параметры, как в сниппет.</p>
		<?= pcx('[[$snippet]wrap?foo=bar]') ?>
		<p>Они будут доступны в темплейте как обычные переменные PHP:</p>
		<?= pcx('var_dump($foo); // bar', 'PHP') ?>
		<p>
			Более подробно можно прочитать в доке по <a href="/ru/manual/templates#tag-templates">темплейтам</a>.
			Некоторые примеры использования темплейтов можно увидеть в <a href="/ru/examples/templates">примерах темплейтов</a>.
		</p>
	</section>
</article>