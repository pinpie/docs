[title[=Cache]]
[sidemenu[en/manual/sidemenu]]
[menu cache[=
<ul>
	<li><a href="/en/manual/cache#simple">Simple</a></li>
	<li><a href="/en/manual/cache#usage">Usage</a></li>
	<li><a href="/en/manual/cache#separate-caching">Separate caching</a></li>
	<li><a href="/en/manual/cache#cache-storage">Cache storage</a></li>
	<li><a href="/en/manual/cache#set">Set cacher</a></li>
	<li><a href="/en/manual/cache#settings">Cache settings</a></li>
	<li><a href="/en/manual/cache#hash">Hash</a></li>
	<li><a href="/en/manual/cache#cacher-class">Cacher class</a></li>
	<li><a href="/en/manual/cache#cacher-disabled">Disabled cacher</a></li>
	<li><a href="/en/manual/cache#cacher-files">Files cacher</a></li>
	<li><a href="/en/manual/cache#cacher-memcached">Memcached cacher</a></li>
	<li><a href="/en/manual/cache#cacher-apcu">APCu cacher</a></li>
	<li><a href="/en/manual/cache#cacher-custom">Custom cacher</a></li>
	<li><a href="/en/manual/cache#cache-rules">Cache rules</a></li>
</ul>
]]
<article>
	<header>
		<h1>
			<a name="" href="">#</a>
			Cache
		</h1>
	</header>
	<p>
		PinPIE provides clear and controllable <a href="/en/manual/tags#snippet" title="See tags manual">snippet</a> caching.
	</p>
	<p>
		In the same time, <a href="/en/manual/tags#chunk" title="See tags manual">chunks</a> are never cached.
		Chunks are just pieces of text.
		Chunks are stored in "*.php" files, and are mostly cached by acceleration software like Zend OPcache, APC, XCache, eAccelerator, etc.
		That's why chunks are not additionally cached. If you want to cache &mdash; use snippet.
	</p>
	<p>
		Pages code is executed every time. If you want to cache some heavy code &mdash; use a snippet.
		If you don't need a php-code executed every time &mdash; you can use a
		<a href="//google.com/search?q=static+site+generator" target="_blank" tltle="Google">static site generator</a>.
	</p>
	<p>
		Each cache entry includes all file paths of used tags and their children.
		It means that all files will be checked for existence and modification time.
		If any of them is changed after cache was created, then snippet will be redrawn, and cache will be refreshed.
	</p>

	<section>
		<header>
			<h1>
				<a name="simple" href="#simple">#</a>
				Simple
			</h1>
		</header>
		<p>
			Simplicity is the main idea of PinPIE.
			That's why caching in PinPIE is obvious and predictable.
			In the same time it's convenient.
			To understand how does the cache works you need to know this simple things:
		</p>
		<ul>
			<li>If snippet is cached &mdash; it is cached as it was drawn.</li>
			<li>If snippet file is modified &mdash; it will be redrawn.</li>
			<li>If snippet has some children tags &mdash; they will be rendered only once and cached in the output of that snippet.</li>
			<li>If snippet has children (any depth) and one of their files was modified &mdash; snippet will be redrawn.</li>
		</ul>
		<p>
			That means you don't have to get deal with cache every time you change a bit something somewhere.
			<b>PinPIE will detect changes, redraw and recache by it self automatically.</b>
		</p>
		<p>
			If you want to purge the cache &mdash; just delete all files from "/filecache" folder or restart Memcached, etc.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="usage" href="#usage">#</a>
				Usage
			</h1>
		</header>
		<p>To cache snippet you need to set desired time in seconds in the tag: <?= scx('[[<b>here</b>$snippet]]') ?>.</p>
		<p>Currently there are three options:</p>
		<ul>
			<li><?= scx('[[$some_snippet]]') ?> &mdash; caching disabled, snippet will be executed every time</li>
			<li><?= scx('[[<b>3600</b>$some_snippet]]') ?> &mdash; snippet is cached for one hour</li>
			<li>
				<?= scx('[[!$some_snippet]]') ?> &mdash; cache forever. Snippet is cached for
				<span><code>$pinpie['cache forever time']</code></span> seconds,
				which by default is about ten years (315360000 seconds).
				You can set your own <a href="/en/manual/cfg#cache_forever_time" title="Read more">cache forever time</a>
				option value in <a href="/en/manual/config#pinpie-cache" title="Read config manual">config</a>.
			</li>
		</ul>
	</section>

	<section>
		<header>
			<h1>
				<a name="separate-caching" href="#separate-caching">#</a>
				Separate caching
			</h1>
		</header>
		<p>
			All snippets are cached separately one from each other, even same snippets.
			Just look at this examples.
		</p>
		<h2>Examples</h2>
		<h3>Example 1</h3>
		<p>Assuming you have snippet <?= scx('[[$rand]]') ?> with code:</p>
		<?= pcx(h('<?php
echo rand(1, 100);')); ?>
		<p>
			If you will use it many times in a page, you will get different numbers for each use.
			If you will cache this snippet, you will also get different cashed numbers.
			So if you use it several times in the code of the same single page:
		</p>
		<?= pcx('[[5$rand]]
[[5$rand]]
[[5$rand]]'); ?>
		<p>you'll get output, that will change every five seconds:</p>
		<pre><code>[[5$rand]]<br>[[5$rand]]<br>[[5$rand]]</code></pre>

		<p>
			This examples are not just text, but active snippets, so <b>refresh this page now</b> to see changes.
			Actually, with probability 1 / 1000000 it will do "42 42 42"
			(and it happened to me once, forcing me to desperately debug this <i>bug</i> one night), so be not surprised.
		</p>
		<h3>Example 2</h3>
		<p>This example will make you better understand caching.</p>
		<?= pcx('[[$rand]]
[[5$rand]]
[[!$rand]]') ?>
		<p>
			When you will refresh a page, you will see,
			that first number will change every time, next &mdash; every five seconds, and the last one will never change.
		</p>
		<pre><code>[[$rand]]<br>[[5$rand]]<br>[[!$rand]]</code></pre>
	</section>

	<section>
		<header>
			<h1>
				<a name="cache-storage" href="#cache-storage">#</a>
				Cache storage
			</h1>
		</header>
		<p>Currently out of the box four cache storages are supported:</p>
		<ul>
			<li>Disabled &mdash; every snippet is forced to be executed each time</li>
			<li>Files &mdash; file-based storage (default)</li>
			<li>Memcached &mdash; memcached-based storage support</li>
			<li>APCu &mdash; APC and APCu storage support</li>
		</ul>
		<p>
			Cache storage can be set in config by <?= scx('$pinpie["cache class"]') ?>.
			This variable defines whitch cache class will be used.
			Default value is <?= scx('\pinpie\pinpie\Cachers\Files') ?>.
			Read more below.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="set" href="#set">#</a>
				Set Cacher
			</h1>
		</header>
		<p>
			To switch cacher you should set its class in config in
			<?= scx('$pinpie["cache class"]') ?> variable:
		</p>
		<?= pcx('$pinpie[\'cache class\'] = \'\pinpie\pinpie\Cachers\Disabled\';') ?>
		<p>You can set your own cacher class.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="settings" href="#settings">#</a>
				Settings
			</h1>
		</header>
		<p>
			Caching settings are stored in <?= scx('$cache') ?> variable and are passed into the constructor of cacher class.
			Each class have its own default settings. If you have custom cacher class, you can use this variable to store settings.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="hash" href="#hash">#</a>
				Hash
			</h1>
		</header>
		<p> Every cache entry is stored with hash based on snippet and page parameters. That includes:</p>
		<ul>
			<li>snippet name</li>
			<li>snippet file modification date and time</li>
			<li>requested URL</li>
			<li>URL query params (if <a href="/en/manual/cache#cache-rules" title="See below on this page">possible</a>)</li>
			<li>all parent tags names</li>
			<li>server name</li>
			<li>some other params</li>
		</ul>
		<p>
			If any of this parameters changes, that will produce different hash.
			PinPIE will not find the snippet in the cache and will have to execute it again.
			It means if snippet file was modified, it will be recached.
		</p>
		<p>Cacher can override getHash(), inherited from Cachers\Cacher.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="cacher-class" href="#cacher-class">#</a>
				Cacher class
			</h1>
			Every cacher class have to be inherited from this class.
		</header>
		<p>
			This class contains two main methods get() and set(), which provides cache interactions.
			Also it contains getHashe() and hashBase() which responsible for hash generation of a shippet.
		</p>
		<p>
			Being a prototype for other cachers, this class contains
			settings, which should be used in other classes:
		</p>
		<ul>
			<li><b>algo</b> &mdash; hashing algorithm. Default value is <?= scx('sha1') ?></li>
			<li><b>random stuff</b> &mdash; must be a string, containing random chars</li>
			<li><b>raw hash</b> &mdash; determines will be a hash returned binary or in hex format</li>
		</ul>
		<p>
			This settings will be in <?= scx('settings') ?> class field. They are merged with defauls and settings from config:
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
		<p>It is recommended to set <?= scx('random stuff', 'HTML') ?> value in config:</p>
		<pre><code class="PHP hljs">$cache[<span class="hljs-string">"random stuff"</span>]&nbsp;=&nbsp;<span class="hljs-string">"[[$random_stuff]]"</span>;</code></pre>
	</section>

	<section>
		<header>
			<h1>
				<a name="cacher-disabled" href="#cacher-disabled">#</a>
				Disabled cacher
			</h1>
		</header>
		<p><?= scx('$pinpie["cache class"] = \'\pinpie\pinpie\Cachers\Disabled\';') ?></p>
		<p>This is the simplest cacher class:</p>
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
			This class is inherited from <?= scx('Cacher') ?> class, and contains two fake methods for reading and writing cache values.
			Reading always returns <?= scx('false') ?> and writing &mdash; <?= scx('true') ?>.
			That make PinPIE to think, that any cache writing completes successfully, and any reading fails.
			So any time PinPIE want to get cached data, it receives "false".
			This forces it to execute snippet anyway.
		</p>
		<p>This class have no settings.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="cacher-files" href="#cacher-files">#</a>
				Files cacher
			</h1>
		</header>
		<p><?= scx('$pinpie["cache class"] = \'\pinpie\pinpie\Cachers\Files\';') ?></p>
		<p>
			Files cacher stores cache in files named by its hash.
			Storage path can be set in cache settings array <?= scx('$cache[\'path\']') ?>.
		</p>
		<p>Default value is:</p>
		<?= pcx('$defaults["path"] = $this->pinpie->root . DIRECTORY_SEPARATOR . "filecache";', 'PHP') ?>
		<p>
			Relative to the root of your site it's <?= scx('/filecache') ?> folder.
			It needs right to write to that folder from the user running PHP process.
		</p>
		<p>
			It is the simple, but very fast way to cache snippets. Until your OS have <b>free</b> unused memory, you will have
			very fast caching, sometimes even faster than memcached. The disadvantage is that you have to clean
			cache by your own, because PinPIE can't.
		</p>
		<p>
			Every time PinPIE generates new hash for tag, it will create new file. That is not a problem, because for most of the time the size of cache will be stable, and will grow only by newly added or edited snippets. Because hash is based on file modification time, PinPIE can't find previous versions of cache files, and can't
			automatically delete them.</p>
		<p>The advantages of this mode are:</p>
		<ul>
			<li>Very fast.</li>
			<li>
				Works everywhere. Only requirement is permission to write to "filecache" folder.
				Can be used at hostings, which lack APCu or Memcache, and where you can't install PHP extensions.
			</li>
		</ul>
		<p>
			This type of cache is fast, because modern OS stores recent files content in free unused memory.
			All file access operations are highly optimized. So file cache performance could be faster even than Memcached
			at unix socket. Unfortunately, it can be the slowest.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="cacher-memcached" href="#cacher-memcached">#</a>
				Memcached cacher
			</h1>
		</header>
		<p><?= scx('$pinpie["cache class"] = \'\pinpie\pinpie\Cachers\Memcached\';') ?></p>
		<p>
			Memcached-based caching class uses Memcache object to store cache. Sure it have multiple servers support.
			Server pool is set in config var <?= scx('$cache["servers"]') ?> as array of host and port pairs.
			Here is the code:
		</p>
		<?= pcx('$cache["servers"] = [
  ["host" => "localhost", "port" => 11211],
]', 'php') ?>
		<p>
			Make sure you have set unique salt for every site in <?= scx('$cache[\'random stuff\']') ?> variable.
			That will prevent possible hash collisions for different snippets.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="cacher-apcu" href="#cacher-apcu">#</a>
				APCu cacher
			</h1>
			<p><?= scx('$pinpie["cache class"] = \'\pinpie\pinpie\Cachers\APCu\';') ?></p>
		</header>
		<p>
			Based on <a href="http://php.net/manual/en/book.apcu.php">APCu</a> extension (former APC).
			It doesn't have additional settings, only those from in Cacher class. Here is whole its code:
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
		<p>The fastest. APC works inside PHP process itself, have access to its memory and stores PHP values as is, which is the source of its speed.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="cacher-custom" href="#cacher-custom">#</a>
				Custom cacher
			</h1>
		</header>
		<p><?= scx('$pinpie["cache class"] = \'\YourCacher\';') ?></p>
		<p>
			PinPIE allows you to use your own cacher. You need to inherit from <?= scx('\pinpie\pinpie\Cachers\Cacher') ?> class.
			It can be found in <?= scx('/scr/Cachers/Cacher.php') ?> file.
		</p>
		<p>
			In its work PinPIE uses two methods: <?= scx('get(pinpie\pinpie\Tags\Tag $tag)') ?> and
			<?= scx('set(pinpie\pinpie\Tags\Tag $tag, $data, $time = 0)') ?>. Passed parameters are:
		</p>
		<ul>
			<li><b>$tag</b> &mdash; tag instance with all its settings</li>
			<li><b>$data</b> &mdash; data that have to be cached with set(), and that PinPIE expect to get back from get()</li>
			<li><b>$time</b> &mdash; storage time in seconds, optional. PinPIE will stores time and check it any way.</li>
		</ul>
		<p>
			You can set cacher in config <?= scx('$pinpie["cache class"] = "\YourCacher";') ?>,
			or set cacher while running PinPIE, if you need it.
			To inject cacher use this function:
		</p>
		<?= pcx('PinPIE::injectCacher($cacher);') ?>
		<p>where <b>$cacher</b> is your class instance, inherited from <b>\PinPIE\Cacher</b> class.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="cache-rules" href="#cache-rules">#</a>
				Cache rules
			</h1>
		</header>
		<p>
			PinPIE provides you additional control of caching process absolutely free. All 404 pages have different URL, and that could produce too much
			unwanted cache, mostly never used again. Or there could be some GET-params that doesn't affect a page, so you don't
			need to use them in hash generation, because that will also produce additional cache. To prevent all this mess cache rules
			were implemented, allowing you to control that stuff.
		</p>
		<p>
			PinPIE allow you to ignore url or GET-params, and set the cache hash generation rules.
			Caching rules could be set in config file with <?= scx('$pinpie["cache rules"]') ?>.
			Here are the default rules:
		</p>
		<?= pcx('"cache rules" => [
  "default" => ["ignore url" => false, "ignore query params" => false],
  200 => ["ignore url" => false, "ignore query params" => false],
  404 => ["ignore url" => true, "ignore query params" => true]
],', 'php') ?>
		<p>
			Caching rules are applied according current HTTP response code. For all general pages it is 200.
			For not found pages it will be 404. For all others the "default" rule will be applied.
		</p>
		<p>For 404 case whole url and query params are ignored to prevent separate caching for all wrong and unknown pages.</p>
		<p>You can set your own rules for any other HTTP-codes.</p>
		<h2>Params</h2>
		<h3>ignore url</h3>
		<p>
			This parameter allow you to ignore whole url in hash generation, that will make all pages with this rule have same
			cached output, if query params are the same.
		</p>
		<p> It could be set to false or true.</p>
		<h3>ignore query params</h3>
		<p>
			Ignore query params allow you to ignore all or some GET-params when cache hash is generated.
			It could be set to false, true, or array of $_GET keys to ignore. Useful, if you have user tracking get-params in links
			from external sites to yours.
		</p>
		<?= pcx('$pinpie["cache rules"][200] = [
  "ignore query params" => ["XDEBUG_SESSION_START", "_openstat", "yclid"],
];') ?>
	</section>
</article>