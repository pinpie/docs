[title[=Методы]]
[sidemenu[en/manual/sidemenu]]
[menu methods[=
<ul>
	<li><a href="/ru/manual/methods#cacherGet">cacherGet</a></li>
	<li><a href="/ru/manual/methods#cacherSet">cacherSet</a></li>
	<li><a href="/ru/manual/methods#checkPathIsInFolder">checkPathIsInFolder</a></li>
	<li><a href="/ru/manual/methods#getUrlInfo">getUrlInfo</a></li>
	<li><a href="/ru/manual/methods#newInstance">newInstance</a></li>
	<li><a href="/ru/manual/methods#newPage">newPage</a></li>
	<li><a href="/ru/manual/methods#parseString">parseString</a></li>
	<li><a href="/ru/manual/methods#report">report</a></li>
	<li><a href="/ru/manual/methods#reportTags">reportTags</a></li>
	<li><a href="/ru/manual/methods#templateGet">templateGet</a></li>
	<li><a href="/ru/manual/methods#templateSet">templateSet</a></li>
	<li><a href="/ru/manual/methods#varPut">varPut</a></li>
</ul>
]]
<article>
	<header>
		<h1>
			<a name="" href="">#</a>
			Методы
		</h1>
	</header>
	<p>
		Список методов для взаимодействия с PinPIE.
		Однако, обычно никаких прямых взамимодействий с PinPIE не требуется.
	</p>

	<section>
		<header>
			<h1>
				<a name="injectcacher" href="#injectcacher">#</a>
				PinPIE::cacherGet()
			</h1>
		</header>
		<p>Доступ к текущему объекту, выполняющему функции кешера.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="injectcacher" href="#injectcacher">#</a>
				PinPIE::cacherSet(pinpie\pinpie\Cachers\Cacher $cacher)
			</h1>
		</header>
		<p>
			Позволяет вам использовать <a href="/ru/manual/cache#custom-cacher">собственный кэшер</a>, передав его объект.
			Обычно кешер задаётся в <a href="/ru/manual/config#pinpie-cache">конфиге</a>, но так тоже можно.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="checkpathisinfolder" href="#checkpathisinfolder">#</a>
				PinPIE::checkPathIsInFolder($path, $folder)
			</h1>
		</header>
		<p>
			Позволяет проверить, действительно ли путь принадлежит папке.
			Использует функцию <a href="http://php.net/manual/ru/function.realpath.php">realpath()</a>,
			так что симлинки будут преобразованы в реальные системные пути.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="getUrlInfo" href="#getUrlInfo">#</a>
				PinPIE::getUrlInfo
				<wbr>
				($template)
			</h1>
		</header>
		<p>Ищет файл страницы соответствующий пути в URL. Возвращает экземпляр объекта URL или false в случае сбоя.</p>
		<p>В случае, если подходящий файл не был найден, то можешь взять значение из конфига:</p>
		<?= pcx('PinPIE::$config->pinpie["page not found"]') ?>
	</section>

	<section>
		<header>
			<h1>
				<a name="newinstance" href="#newinstance">#</a>
				PinPIE::renderPage($settings)
			</h1>
		</header>
		<p>
			Создаёт экземпляр движка. Используется для работы в привычном окружении, где PHP реинициализируется при каждом запросе.
			<a href="/ru/manual/config#config-direct">Read more..</a>
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="newPage" href="#newPage">#</a>
				PinPIE::newPage
				<wbr>
				($page)
			</h1>
		</header>
		<p>
			Позволяет вывести другую страницу вместо текущей. Пока толком нигде не опробовано, но работает как часы.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="parsestring" href="#parsestring">#</a>
				PinPIE::parseString($string)
			</h1>
		</header>
		<p>Парсит строку и возвращает результат.</p>
		<h2>Пример</h2>
		<?= pcx('echo PinPIE::parseString(\'Ответ [[5$rand]]\');') ?>
		<p>Вывод:</p>
		<?= pcx('Ответ 42', 'html') ?>
	</section>

	<section>
		<header>
			<h1>
				<a name="report" href="#report">#</a>
				PinPIE::report()
			</h1>
		</header>
		<p>
			Выводит дебаг-отчет: время выполнения тегов; из кэша или нет; ошибки; и полный список тегов со всеми их внутренними
			данными. Используется для отладки. Установи $debug = true в конфиге, чтобы включить вывод дебага. По умолчанию ничего не делает и возвращает false.
		</p>
		<p>
			Некоторые отчеты выводятся через var_dump(), так что рекомендую Xdebug &mdash; он сделает всё красивым.
			Но не забудьте выключить Xdebug на продакшене, так как он сильно снижает производительность.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="reportTags" href="#reportTags">#</a>
				PinPIE::reportTags()
			</h1>
		</header>
		<p>
			Выводит дамп тегов и их параметры. Используется для отладки. Установи $debug = true в конфиге, чтобы включить вывод дебага. По умолчанию ничего не делает и возвращает false.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="templateget" href="#templateget">#</a>
				PinPIE::templateGet()
			</h1>
		</header>
		<p>Возвращает текущий <a href="/ru/manual/templates#page-templates">темплейт страницы</a> или false.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="templateset" href="#templateset">#</a>
				PinPIE::templateSet($template)
			</h1>
		</header>
		<p>Устанавливает <a href="/ru/manual/templates#page-templates">темплейт страницы</a>. Может быть строкой или false.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="varput" href="#varput">#</a>
				PinPIE::varPut($name, $content)
			</h1>
		</header>
		<p>Позволяет запихать строку в плейсхолдер.</p>
		<h2>Пример</h2>
		<p>PHP-код:</p>
		<?= pcx('PinPIE::varPut("pltest", "some text");') ?>
		<p>Плейсхолдер:</p>
		<?= pcx('[[*pltest]]') ?>
		<p>Вывод:</p>
		<?= pcx('some text', 'html') ?>
	</section>

</article>