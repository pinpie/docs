[title[=Кэш]]
[sidemenu[ru/manual/sidemenu]]
[menu cache[=
<ul>
	<li><a href="/ru/manual/cache#simple">Просто</a></li>
	<li><a href="/ru/manual/cache#usage">Использование</a></li>
	<li><a href="/ru/manual/cache#separate-caching">Раздельное кэширование</a></li>
	<li><a href="/ru/manual/cache#cache-storage">Где хранится</a></li>
	<li><a href="/ru/manual/cache#set">Выбор кэшера</a></li>
	<li><a href="/ru/manual/cache#settings">Настройки кэша</a></li>
	<li><a href="/ru/manual/cache#hash">Хэш</a></li>
	<li><a href="/ru/manual/cache#cacher-class">Класс кэшера</a></li>
	<li><a href="/ru/manual/cache#cacher-disabled">Кэшер Disabled</a></li>
	<li><a href="/ru/manual/cache#cacher-files">Кэшер Files</a></li>
	<li><a href="/ru/manual/cache#cacher-memcached">Кэшер Memcached</a></li>
	<li><a href="/ru/manual/cache#cacher-apcu">Кэшер APCu</a></li>
	<li><a href="/ru/manual/cache#cacher-custom">Свой кэшер</a></li>
	<li><a href="/ru/manual/cache#cache-rules">Правила кэша</a></li>
</ul>
]]
<article>
	<header>
		<h1>
			<a name="" href="">#</a>
			Кэш
		</h1>
	</header>
	<p>
		PinPIE позволяет прозрачно и управляемо <a href="/ru/manual/tags#snippet" title="See tags manual">кешировать сниппеты</a>.
	</p>
	<p>
		А вот <a href="/ru/manual/tags#chunk" title="See tags manual">чанки</a> никогда не кэшируются.
		Чанки это просто кусочки текста.
		Чанки хранятся в "*.php" файлах, и обычно кешируются опкод кешерами, такими как Zend OPcache, APC, XCache, eAccelerator и т.п.
		Поэтому чанки никак дополнительно не кэшируются. Если кэширование всё же требуется &mdash; используйте сниппет.
	</p>
	<p>
		Код страниц исполняется каждый раз. Если требуется кэшировать некий тяжёлый код &mdash; используйте сниппет.
		Если не требуется выполнять php-код каждый раз &mdash; используйте
		<a href="https://www.yandex.ru/yandsearch?text=генератор%20статических%20сайтов" target="_blank" title="yandex">генератор статических сайтов</a>.
	</p>
	<p>
		При записи в кэш также сохраняется информация о путях всех дочерних тегов (и их детей тоже).
		Соответственно, все эти файлы будут проверены на существование и время изменения.
		Если любой из них изменился после кэширования, то сниппет будет перерисован, и кэш будет обновлён.
	</p>

	<section>
		<header>
			<h1>
				<a name="simple" href="#simple">#</a>
				Просто
			</h1>
		</header>
		<p>
			Основная идея PinPIE &mdash; это простота.
			Именно поэтому, кэширование в PinPIE носит очевидный и предсказуемый характер.
			Одновременно с этим, оно весьма удобно.
			Для лучшего представления о том, как работает кэш, нужно знать вот эти простые вещи:
		</p>
		<ul>
			<li>Если сниппет закэшировался &mdash; он закешировался так, как был нарисован.</li>
			<li>Если файл сниппета изменился &mdash; он будет перерисован.</li>
			<li>Если в сниппете есть дочерние теги &mdash; они будут отрисованы единожды, и будут закешированы в выводе этого сниппета.</li>
			<li>Если у сниппета есть дочерние теги (на любой глубине) и один из их файлов изменился &mdash; сниппет будет перерисован.</li>
		</ul>
		<p>
			Это означает, что вам больше не нужно как-то управляться с кэшем, когда вы хоть что-либо где-то немного поменяли.
			<b>PinPIE обнаружит изменения, перерисует и перекеширует всё сам автоматически.</b>
		</p>
		<p>
			Если вы хотите очистить кэш &mdash; просто удалите все файлы из папки "/filecache", или перезапустите Memcached, и т.п.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="usage" href="#usage">#</a>
				Использование
			</h1>
		</header>
		<p>Чтобы закешировать сниппет, нужно выставить в теге желаемое время в секундах: <?= scx('[[<b>тут</b>$snippet]]') ?>.</p>
		<p>На текущий момент есть три варианта:</p>
		<ul>
			<li><?= scx('[[$some_snippet]]') ?> &mdash; кеширование отключено, сниппет будет выполняться каждый раз</li>
			<li><?= scx('[[<b>3600</b>$some_snippet]]') ?> &mdash; сниппет закеширован на один час</li>
			<li>
				<?= scx('[[!$some_snippet]]') ?> &mdash; закэширован навечно. Сниппет кэшируется на
				<span><code>PinPIE::$config->pinpie['cache forever time']</code></span> секунд,
				что по-умолчанию равно примерно 10 лет (315360000 секунд).
				Если потребуется, вы можете установить ваше собственное значение времени вечного кэширования
				в вашем <a href="/ru/manual/config#pinpie-cache" title="Read config manual">конфиге</a>.
			</li>
		</ul>
	</section>

	<section>
		<header>
			<h1>
				<a name="separate-caching" href="#separate-caching">#</a>
				Раздельное кэширование
			</h1>
		</header>
		<p>
			Все сниппеты, даже одинаковые, кэшируются отдельно друг от друга.
			Вот, взгляните на примеры.
		</p>
		<h2>Примеры</h2>
		<h3>Пример 1</h3>
		<p>Предположим, у вас есть сниппет <?= scx('[[$rand]]') ?> с таким кодом:</p>
		<?= pcx(h('<?php
echo rand(1, 100);')); ?>
		<p>
			Если на странице вы его используете несколько раз, то каждый раз будете получать разные числа.
			Если вы его закэшируете, то именно разные числа закэшируются.
			Так что если вы его используете несколько раз в коде одной страницы,
		</p>
		<?= pcx('[[5$rand]]
[[5$rand]]
[[5$rand]]'); ?>
		<p>то вы получите числа, которые будут меняться каждые пять секунд:</p>
		<pre><code>[[5$rand]]<br>[[5$rand]]<br>[[5$rand]]</code></pre>

		<p>
			Эти не просто примеры, а рабочие сниппеты. Так что <b>прямо сейчас обновите эту страницу</b> и вы увидите изменения.
			Кстати, иногда с вероятностью 1 к 1000000 оно выдаёт "42 42 42" (и однажды так и вышло, из-за чего я
			какое-то время в ночи безнадёжно пытался победить этот <i>баг</i>), так что не удивляйтесь.
		</p>
		<h3>Пример 2</h3>
		<p>Этот пример позволит вам лучше понять кэширование.</p>
		<?= pcx('[[$rand]]
[[5$rand]]
[[!$rand]]') ?>
		<p>
			Если вы будете обновлять страницу, то увидите, что первое число меняется каждый раз, второе &mdash; каждые пять секунд,
			а последнее не меняется никогда.
		</p>
		<pre><code>[[$rand]]<br>[[5$rand]]<br>[[!$rand]]</code></pre>
	</section>

	<section>
		<header>
			<h1>
				<a name="cache-storage" href="#cache-storage">#</a>
				Где хранится
			</h1>
		</header>
		<p>На текущий момент из коробки есть четыре варианта места хранения кэша:</p>
		<ul>
			<li>Disabled &mdash; каждый сниппет будет выполняться каждый раз</li>
			<li>Files &mdash; кеш хранится в файлах (по умолчанию)</li>
			<li>Memcached &mdash; это memcache</li>
			<li>APCu &mdash; хранение в хранилище переменных APCu</li>
		</ul>
		<p>
			Место хранения кэша может быть задано в конфиге в <?= scx('$pinpie["cache class"]') ?>.
			Эта переменная отвечает за то, какой класс кешера будет использован.
			Значение по умолчанию это <?= scx('\pinpie\pinpie\Cachers\Files') ?>.
			Более подробное описание смотрите ниже.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="set" href="#set">#</a>
				Установить кешер
			</h1>
		</header>
		<p>
			Чтобы включить нужный кешер, нужно в конфиге прописать его класс в
			<?= scx('$pinpie["cache class"]') ?> например так:
		</p>
		<?= pcx('$pinpie[\'cache class\'] = \'\pinpie\pinpie\Cachers\Disabled\';') ?>
		<p>Вы можете установить свой собственный кешер.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="settings" href="#settins">#</a>
				Настройки
			</h1>
		</header>
		<p>
			В выбранный класс кешера передаются настройки из конфига, которые задаются в переменной <?= scx('$cache') ?>.
			Дефолтные настройки у каждого класса свои. Если вы хотите использовать свой кешер, то можете передавать любые свои
			настройки через эту переменную.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="hash" href="#hash">#</a>
				Хэш
			</h1>
		</header>
		<p>Каждая запись в кэше сохраняется с хэшем, основанным на параметрах сниппета и страницы. Они включают:</p>
		<ul>
			<li>имя сниппета</li>
			<li>дата и время изменения файла сниппета</li>
			<li>запрошенный URL</li>
			<li>параметры URL query (если <a href="/ru/manual/cache#cache-rules" title="See below on this page">возможно</a>)</li>
			<li>имена всех родительских тегов</li>
			<li>имя сервера</li>
			<li>некоторые другие параметры</li>
		</ul>
		<p>
			При изменении любого из этих параметров будет изменён и хэш.
			А так как PinPIE не сможет найти сниппет в кеше, то будет вынужден выполнить его ещё раз.
			Таким образом, если изменится файл сниппета &mdash; он будет перекэширован.
		</p>
		<p>Кешер может переопределить функцию хэширования getHash(), наследуемую от класса Cachers\Cacher.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="cacher-class" href="#cacher-class">#</a>
				Класс Cacher
			</h1>
			Каждый кешер должен наследоваться от этого класса.
		</header>
		<p>
			Этот класс содержит два основных метода get() и set(), которые обеспечивают взаимодействие с кешем.
			Так же он содержит вспомогательные методы getHash() и hashBase(), которые отвечают за генерацию хеша кешируемого сниппета.
		</p>
		<p>
			Являясь прототипом для всех остальных кешеров, этот класс содержит в себе настройки, которые могут использоваться в других
			классах.
		</p>
		<ul>
			<li><b>algo</b> &mdash; алгоритм хеширования. Дефолтное значение <?= scx('sha1') ?>.</li>
			<li><b>random stuff</b> &mdash; должно содержать строку со случайным набором символов.</li>
			<li><b>raw hash</b> &mdash; Настройка определяет выдавать ли хеш в виде набора октетов, или прямо теми закорючками, что сгенерировались.</li>
		</ul>
		<p>
			Эти настройки живут в поле <?= scx('settings') ?> экземпляра класса и мержатся с дефолтами и настройками, приходящими из конфига:
		</p>
		<?= pcx('  public function __construct(PP $pinpie, $settings = []) {
    $this->pinpie = $pinpie;
    $defaults = [];
    $defaults[\'algo\'] = \'sha1\';
    $defaults[\'random stuff\'] = \'\';
    $defaults[\'raw hash\'] = false;
    $this->settings = array_merge($defaults, $settings);
  }
', 'PHP') ?>
		<p>Желательно задать значение <?= scx('random stuff', 'HTML') ?> в конфиге:</p>
		<pre><code class="PHP hljs">$cache[<span class="hljs-string">"random stuff"</span>]&nbsp;=&nbsp;<span class="hljs-string">"[[$random_stuff]]"</span>;</code></pre>
	</section>

	<section>
		<header>
			<h1>
				<a name="cacher-disabled" href="#cacher-disabled">#</a>
				Кэшер Disabled
			</h1>
		</header>
		<p><?= scx('$pinpie["cache class"] = \'\pinpie\pinpie\Cachers\Disabled\';') ?></p>
		<p>Это простейший класс кэшера:</p>
		<?= pcx('namespace pinpie\pinpie\Cachers;

use pinpie\pinpie\Tags\Tag;

class Disabled extends Cacher {

  public function get(Tag $tag) {
    return false;
  }

  public function set(Tag $tag, $data, $time = 0) {
    return true;
  }
  
}', 'php') ?>
		<p>
			Этот класс наследуется от класса <?= scx('Cacher') ?>, который имеет два метода-заглушки на чтение и запись.
			Чтение всегда возвращает <?= scx('false') ?>, а запись &mdash; <?= scx('true') ?>, что заставляет PinPIE думать,
			что любая запись в кэш всегда проходит удачно, а любое чтение &mdash; неудачно.
			Таким образом всегда, когда PinPIE запрашивает данные, он получает "false".
			Это заставляет его выполнить сниппет в любом случае.
		</p>
		<p>Настроек у него нет.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="cacher-files" href="#cacher-files">#</a>
				Кэшер Files
			</h1>
		</header>
		<p><?= scx('$pinpie["cache class"] = \'\pinpie\pinpie\Cachers\Files\';') ?></p>
		<p>
			Кэшер "files" хранит кэш в файлах, названных по их хэшу.
			Место хранения может быть задано в массиве настроек кеша <?= scx('$cache[\'path\']') ?>.
		</p>
		<p>По умолчанию это:</p>
		<?= pcx('$defaults["path"] = $this->pinpie->root . DIRECTORY_SEPARATOR . "filecache";', 'PHP') ?>
		<p>
			Т.е. относительно корня вашего сайта, это папка <?= scx('/filecache') ?>
			с разрешением на запись для юзера, из под которого запущен процесс PHP.
		</p>
		<p>
			Это простой, но весьма быстрый способ кэширования сниппетов. Пока в вашей ОС есть <b>свободная</b> память, у вас будет и
			очень быстрое кэширование, порой быстрее даже memcached. Неудобство состоит в том, что файлы чистить придётся
			вручную, так как PinPIE сам не этого не умеет.
		</p>
		<p>
			Каждый раз, когда PinPIE генерирует новый хэш для тега, он будет создавать новый файл.
			Это не проблема, потому что большую часть времени размер кэша довольно стабилен, и будет прирастать только
			при изменении или создании новых сниппетов. Из-за того, что хэш основан на времени изменения файла,
			PinPIE не может догадаться, какой был хэш у сниппета раньше, а соответственно, не может удалить старый файл.
		</p>
		<p>Преимущества этого метода такие:</p>
		<ul>
			<li>Очень быстрый.</li>
			<li>
				Работает везде. Единственное требование это право писать в папку "filecache".
				Может использоваться на хостинге, где нет возможности устанавливать расширения PHP, отсутствует Memcache или APCu.
			</li>
		</ul>
		<p>
			Этот тип кэша быстр, потому, что современные ОС хранят недавние файлы в свободной памяти.
			Все файловые операции крайне оптимизированы. Поэтому производительность кэширования в файлах может быть
			выше, чем даже у Memcached через юникс-сокет. К сожалению, он же может быть и самым медленным.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="cacher-memcached" href="#cacher-memcached">#</a>
				Кэшер Memcached
			</h1>
		</header>
		<p><?= scx('$pinpie["cache class"] = \'\pinpie\pinpie\Cachers\Memcache\';') ?></p>
		<p>
			Кэширование на основе Memcached использует для работы объект Memcache.
			Естественно с поддержкой подключения к нескольким серверам.
			Пул серверов задаётся в переменной конфига <?= scx('$cache["servers"]') ?> в виде массива пар хост и порт. Вот код:
		</p>
		<?= pcx('$cache["servers"] = [
  ["host" => "localhost", "port" => 11211],
]', 'php') ?>
		<p>
			Обязательно проверьте, что вы установили уникальную соль для каждого сайта в переменной <?= scx('$cache[\'random stuff\']') ?>.
			Это предотвратит совпадения хэша для разных сайтов, запущенных на одном хостинге, или имеющих доступ к одному хранилищу кеша.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="cacher-apcu" href="#cacher-apcu">#</a>
				Кэшер APCu
			</h1>
			<p><?= scx('$pinpie["cache class"] = \'\pinpie\pinpie\Cachers\APCu\';') ?></p>
		</header>
		<p>
			Основано на расширении <a href="http://php.net/manual/ru/book.apcu.php">APCu</a> (ранее APC).
			Настроек кроме стандартных из Cacher не имеет. Вот весь его код:
		</p>
		<?= pcx('namespace pinpie\pinpie\Cachers;

use \pinpie\pinpie\PP;
use \pinpie\pinpie\Tags\Tag;

class APCu extends Cacher {
	/**
	 * @var bool Will be true if APC or APCu functions are available. If APC or APCu is not detected - a message will be logged to default PinPIE log.
	 */
	protected $ok = false;
	/**
	 * @var bool Will be set to true to enable backward compatibility with PHP < 7
	 */
	protected $bc = false;


	public function __construct(PP $pinpie, array $settings = []) {
		parent::__construct($pinpie, $settings);

		if (\function_exists(\'apcu_fetch\')) {
			$this->ok = true;
			$this->bc = false;
		}
		if (\function_exists(\'apc_fetch\')) {
			$this->ok = true;
			$this->bc = true;
		}

		if (!$this->ok) {
			// APS is not installed !
			$pinpie->logit(\'APC cache error: APC not installed. Check APC cacher class at pinpie/Cachers/APCu.php for more info.\');
		}
	}

	public function get(Tag $tag) {
		if (!$this->ok) {
			return false;
		}
		$hash = $this->getHash($tag);
		if ($this->bc) {
			return \apc_fetch($hash);
		} else {
			return \apcu_fetch($hash);
		}
	}

	public function set(Tag $tag, $data, $time = 0) {
		if (!$this->ok) {
			return false;
		}
		$hash = $this->getHash($tag);
		if ($this->bc) {
			return \apc_store($hash, $data, $time);
		} else {
			return \apcu_store($hash, $data, $time);
		}
	}

}', 'php') ?>
		<p>Самый быстрый вариант. APC работает внутри самого процесса PHP, имеет доступ к его памяти и хранит переменные PHP как есть, что и является причиной скорости.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="cacher-custom" href="#cacher-custom">#</a>
				Свой кэшер
			</h1>
		</header>
		<p><?= scx('$pinpie["cache class"] = \'\YourCacher\';') ?></p>
		<p>
			PinPIE позволяет использовать и ваш собственный кэшер. Вам нужно наследоваться от класса <?= scx('\pinpie\pinpie\Cachers\Cacher') ?>,
			который можно найти в файле <?= scx('/scr/Cachers/Cacher.php') ?>.
		</p>
		<p>
			PinPIE в своей работе использует два метода: <?= scx('get(pinpie\pinpie\Tags\Tag $tag)') ?> и
			<?= scx('set(pinpie\pinpie\Tags\Tag $tag, $data, $time = 0)') ?>, куда передаются следующие параметры:
		</p>
		<ul>
			<li><b>$tag</b> &mdash; экземпляр тега, со всеми настройками</li>
			<li><b>$data</b> &mdash; то, что кеширует PinPIE в set(); то, что он потом ожидает получить из get()</li>
			<li><b>$time</b> &mdash; время в секундах на сколько кешировать. Не обязательно. PinPIE всё равно сохраняет время в $data и потом проверяет.</li>
		</ul>
		<p>
			Кешер можно назначить в конфиге через <?= scx('$pinpie["cache class"] = "\YourCacher";') ?>
			или установить кешер во время работы PinPIE, если вдруг вам это потребовалось.
			Для инъекции кэшера используйте эту функцию:
		</p>
		<?= pcx('PinPIE::injectCacher($cacher);') ?>
		<p>где <b>$cacher</b> это ваш объект, унаследованный от класса <b>\PinPIE\Cacher</b></p>
	</section>

	<section>
		<header>
			<h1>
				<a name="cache-rules" href="#cache-rules">#</a>
				Правила кэша
			</h1>
		</header>
		<p>
			PinPIE даёт вам дополнительный контроль над процессом кэширования совершенно бесплатно. Все страницы 404 имеют разный URL, и из-за
			этого может расплодиться слишком много нежелательного кэша, который никогда не используется. Или могут быть некие
			GET-параметры, которые не влияют на страницу, и вы бы не хотели, чтобы они использовались при генерации хэша, так как это
			опять же породит дополнительный кэш. Чтобы предотвратить это безобразие существуют правила кэширования, позволяющие
			всё это дело контролировать.
		</p>
		<p>
			PinPIE позволяет вам игнорировать URL или GET-параметры, и задать правила генерации хэша.
			Правила кэширования можно установить в конфиге в <?= scx('PinPIE::$config->pinpie["cache rules"]') ?>.
			Вот дефолтные правила:
		</p>
		<?= pcx('"cache rules" => [
  "default" => ["ignore url" => false, "ignore query params" => false],
  200 => ["ignore url" => false, "ignore query params" => false],
  404 => ["ignore url" => true, "ignore query params" => true]
],', 'php') ?>
		<p>
			Правила кэширования применяются согласно текущему коду ответа HTTP. Для всех обычных страниц это 200.
			Для не найденных страниц это 404. Для всех остальных случаев будет использовано правило "default".
		</p>
		<p>
			Для случая 404 можно игнорировать весь URL и все GET-параметры, дабы предотвратить раздельное кеширование для неправильных
			ненайденных страниц.
		</p>
		<p>Можно установить свои собственные правила для любых HTTP-кодов.</p>
		<h2>Параметры</h2>
		<h3>ignore url</h3>
		<p>
			Этот параметр позволяет вам игнорировать url при генерации хэша. Это приведёт к тому, что все страницы с этим правилом
			будут иметь одинаковый кеш при одинаковых GET-параметрах.
		</p>
		<p>Можно установить false или true.</p>
		<h3>ignore query params</h3>
		<p>
			Позволяет игнорировать все или некоторые GET-параметры при генерации хэша.
			Может быть false, true или массив ключей $_GET которые надо проигнорировать.
			Удобно, если у вас есть параметры трекинга пользователей в ссылках с других сайтов на ваш.
		</p>
		<?= pcx('$pinpie["cache rules"][200] = [
  "ignore query params" => ["XDEBUG_SESSION_START", "_openstat", "yclid"],
];') ?>
	</section>
</article>