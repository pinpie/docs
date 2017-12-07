[title[=Configuration]]
[sidemenu[en/manual/sidemenu]]
[menu config[=
<ul>
	<li><a href="#simplest-config">Simplest config</a></li>
	<li><a href="#config-files">Config files</a></li>
	<li><a href="#config-direct">Direct config</a></li>
	<li><a href="#variables">Config variables</a></li>
	<li><a href="#default-pinpie-settings">Defaults</a></li>
	<li><a href="#pinpie">$pinpie</a></li>
	<li><a href="#tags">$tags</a></li>
	<li><a href="#other-variables">Other variables</a></li>
</ul>
]]

<article>
	<header>
		<h1>
			<a name="" href="">#</a>
			Configuration
		</h1>
	</header>
	<p>
		Settings could be stored in files or be passed directly into the constructor as array.
		PinPIE doesn't require any configuration to run if <a href="/en/manual#file-structure">basic folder structure</a> is used.
	</p>
	<section>
		<header>
			<h1>
				<a name="simplest-config" href="#simplest-config">#</a>
				Simplest config
			</h1>
		</header>
		<?= pcx('/* nothing here */') ?>
		<p>
			Yes, it's empty.
			Only thing you have to do is route all requests to index.php.
			And PinPIE will do the job just out of the box.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="config-files" href="#config-files">#</a>
				Config files
			</h1>
		</header>
		<p>
			PinPIE can read configuration from a php-file.
			All config files are stored in <?= scx('/config') ?> folder.
			By default, on every request config file is chosen according to the server name.
			Yes, that simple:
		</p>
		<?= pcx('basename($_SERVER["SERVER_NAME"]) . ".php"') ?>
		<p>
			In such a way you can store several configurations in a single folder.
			Depending on a server name in the received request the corresponding config file will be used.
			That allows to develop site locally with a different name and keep its own set of settings for that site
			in the same place, without risk to put dev settings into the production environment.
		</p>
		<p>
			To create a configuration file you have to create a file in <?= scx('/config') ?> folder
			and name this file like your server and give it a ".php" extension, e.g. <?= scx('/config/mysite.com.php') ?>.
		</p>
		<p>To start working with PinPIE no settings nor files are required.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="config-direct" href="#config-direct">#</a>
				Direct config
			</h1>
		</header>
		<p>
			Configuration also can be set when PinPIE starts.
			It can be passed as associative array to <?= scx('PinPIE::renderPage($settings)', 'PHP') ?>
			or directly to PP class constructor <?= scx('new PP($settings)', 'PHP') ?>.
		</p>
		<p>Any settings, passed directly, have higher priority and overwrites thous from file.</p>
		<p>This settings are passed as associative array key-value pairs, where keys are config variable names:</p>
		<?= pcx('$settings = [
  "pinpie" => [
    "route to parent" => 100,
    "cache class" => "\pinpie\pinpie\Cachers\Disabled",
  ],
  "debug" => true,
];', 'PHP') ?>
		<p>In that case some additional settings are available:</p>
		<h3>file</h3>
		<p>
			Sets config file. If is absent or is <?= scx('true') ?> &mdash; forces PinPIE to load config file automatically.
			If it is <?= scx('false') ?> &mdash; PinPIE will not look for and load any config file.
			If it is a string &mdash; PinPIE will try to load config file using that string as a path to file.
		</p>
		<p>Anyway, any settings from this array will overwrite settings taken from config file.</p>

		<h3>root</h3>
		<p>
			Path to root folder with PinPIE resources. In this folder PinPIE will try to locate folders for
			pages, snippets, chunks, static files, etc. This setting can be defined only here, before config file loading.
		</p>

		<h3>page</h3>
		<p>
			Path to file, which will be used as page. Path is relative to pages folder.
			If it is set, PinPIE will not search for any other file for request url, and will use exactly that one.
			You have to ensure existence of that file on your own.
		</p>

		<h2>Example:</h2>
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

	<section>
		<header>
			<h1>
				<a name="variables" href="#variables">#</a>
				Config variables
			</h1>
		</header>
		<p>In config file you can set this variables:</p>
		<ul>
			<li><?= scx('$pinpie') ?> &mdash; array to store PinPIE settings.</li>
			<li><?= scx('$tags') ?> &mdash; tags settings array (see <a href="/en/manual/tags">Tags manual section</a>).</li>
			<li>
				<?= scx('$other') ?> &mdash; array for your custom settings, you can store here any settings you need,
				and access it by <?= scx('PinPIE::$config->$other', 'php') ?> anywhere.
			</li>
			<li>
				<?= scx('$databases') ?> &mdash; store here settings to connect to your databases. You can access them through <?= scx('PinPIE::$config->databases', 'php') ?>.
			</li>
			<li><?= scx('$cache') ?> &mdash; cacher settings array (read about <a href="/en/manual/cache">Cache</a>).</li>
			<li><?= scx('$debug') ?> &mdash; enables debug output, by default it is false. Set to true to enable.</li>
		</ul>
		<p>
			If you <a href="/en/manual/start#launch" title="Read how to make PinPIE global">use class_alias() for PinPIE class</a>, they will be accessible globally through <?= scx('PinPIE::$config') ?>.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="default-pinpie-settings" href="#default-pinpie-settings">#</a>
				Default PinPIE settings
			</h1>
		</header>
		<p>
			There are not so many settings PinPIE need to work. Here are the defaults from
			<?= scx('Config.php', 'html') ?> class:
		</p>
		<?= pcx('$pinpie = [
  "cache class" => false,
  "cache rules" => [
    "default" => ["ignore url" => false, "ignore query params" => []],
    200 => ["ignore url" => false, "ignore query params" => []],
    404 => ["ignore url" => true, "ignore query params" => []]
  ],
  "cache forever time" => 315360000,
  "codepage" => "utf-8",
  "index file name" => "index.php",
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
    "servers" => [],
  ],
  "=" => ["class" => "\pinpie\pinpie\Tags\Constant"],
  "@" => ["class" => "\pinpie\pinpie\Tags\Command"],
];

$cache = []; // Settings for current cacher
$other = []; // You can put some custom setting here
$databases = []; // To store database settings
$debug = false; // Enables PinPIE::report() output. You can use it to enable your own debug mode. Globally available through PinPIE::$config->debug.', 'php') ?>
	</section>

	<section>
		<header>
			<h1>
				<a name="pinpie" href="#pinpie">#</a>
				<b>$pinpie</b> &mdash; PinPIE settings
			</h1>
		</header>
		<p>PinPIE settings are stored in <?= scx('$pinpie') ?> array.</p>

		<header>
			<h2>
				<a name="pinpie-cache" href="#pinpie-cache">#</a>
				Cache
			</h2>
		</header>

		<p>Some general settings can be set in <?= scx('$pinpie') ?>:</p>
		<ul>
			<li>cache class &mdash; sets the <a href="/en/manual/cache#set">cacher class</a></li>
			<li>cache forever time &mdash; defines the length of <a href="/en/manual/cache#usage">eternity</a> (in seconds)</li>
			<li>
				cache rules &mdash; <a href="/en/manual/cache#cache-rules">Cache rules</a> created to prevent cache bloating in cases
				with big amount of unique requests.
			</li>
		</ul>
		<p>It is highly recommended to read about caching mechanics in <a href="/en/manual/cache">cache docs</a>.</p>

		<header>
			<h2>
				<a name="codepage" href="#codepage">#</a>
				codepage
			</h2>
		</header>
		<p>
			PinPIE stores current code page in <?= scx('$pinpie["codepage"]') ?>.
			You can use its value in your scripts. By default it is "utf-8".
		</p>

		<header>
			<h2>
				<a name="index" href="#index">#</a>
				index file name
			</h2>
		</header>
		<p>
			Default name for "directory index" &mdash; a file, PinPIE will look for, if URL path is a folder.
			Read more in <a href="/en/manual/routing">routing docs</a>.
			By default it is "index.php".
		</p>

		<header>
			<h2>
				<a name="log" href="#log">#</a>
				Log
			</h2>
		</header>
		<p>
			PinPIE will write to log file "pin.log" some errors like not found tag file.
			You can set different path in <?= scx('$pinpie["log"]["path"]') ?>.
		</p>
		<p>
			You can enable log output to the reply body by switching <?= scx('$pinpie["log"]["show"]') ?> to true, which is disabled by default.
		</p>

		<header>
			<h2>
				<a name="page-not-found" href="#page-not-found">#</a>
				page not found
			</h2>
		</header>
		<p>
			Defines page, which will be used in case of request to unknown page.
			Default value is <?= scx('/pages/index.php') ?>, but it is highly recommended to create special page
			for that, e.g. <?= scx('/pages/notfound.php') ?>.
			Anyway, if requested page is not found, the 404 reply code is used automatically.
		</p>

		<header>
			<h2>
				<a name="route-to-parent" href="#route-to-parent">#</a>
				route to parent
			</h2>
		</header>
		<p>This variable defines url handling. Read more in <a href="/en/manual/routing">routing docs</a>.</p>

		<header>
			<h2>
				<a name="site-url" href="#site-url">#</a>
				site url
			</h2>
		</header>
		<p>
			This variable is used in creation of static content url in case if static server list is empty.
			Its default value is <?= scx('$_SERVER["SERVER_NAME"]') ?>.
		</p>

		<header>
			<h2>
				<a name="templates-settings" href="#templates-settings">#</a>
				Templates settings
			</h2>
		</header>
		<p>
		<ul>
			<li>template clear vars after use &mdash; defines if PinPIE have to delete placeholder values after use, so you could use new ones in other snippet with same template, instead of accumulating values (default).</li>
			<li>template function &mdash; custom user function to render template, which will be called if defined</li>
			<li>templates folder &mdash; folder where PinPIE will look for template files</li>
			<li>templates realpath check &mdash; checks if template file really is located in templates folder, instead of some other place</li>
		</ul>
		Read more in <a href="/en/manual/templates">templates docs</a>.
		</p>

		<header>
			<h2>
				<a name="preinclude" href="#preinclude">#</a>
				preinclude.php and postinclude.php files
			</h2>
		</header>
		<p>
			On every request PinPIE tries to include two files if they exist:
			<?= scx("/preinclude.php") ?> and <?= scx("/postinclude.php") ?>.
		</p>
		<p>
			At first, existence of <?= scx("/preinclude.php") ?> is checked.
			If it exists &mdash; it is included.
			In contrast to <?= scx("/index.php") ?> at that moment most PinPIE settings are set and available,
			page file is located and can be changed.
		</p>
		<p>
			Do not place classes autoloader in <?= scx("/preinclude.php") ?>.
			Use <?= scx("/index.php") ?> instead.
		</p>
		<p>
			Later, when page processing is already finished, PinPIE will try to include <?= scx("/postinclude.php") ?> file.
			This file is a good place for debug output and delayed actions
			or some actions done after request is closed with <a href="http://php.net/manual/en/function.fastcgi-finish-request.php">fastcgi_finish_request()</a>.
		</p>
		<p>
			When PinPIE is updated to a new version, this files will stay untouched, and will now be rewritten,
			because this files do not exist in PinPIE itself. So you can use this files for your own purposes freely.
		</p>
		<p>
			This files paths could be set in PinPIE config array:
		</p>
		<?= pcx('$pinpie["preinclude"] = $this->pinpie->root . DIRECTORY_SEPARATOR . "preinclude.php";
$pinpie["postinclude"] = $this->pinpie->root . DIRECTORY_SEPARATOR . "postinclude.php";') ?>
		<p>This files usage is optional.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="tags" href="#tags">#</a>
				<b>$tags</b> &mdash; Tags settings
			</h1>
		</header>
		<p>
			In $tags variable, available globaly like <?= scx('PinPIE::$config->tags') ?>, stored tags settings for PinPIE.
			Read more in <a href="/en/manual/tags">tags section</a> of manual.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="other-variables" href="#other-variables">#</a>
				Other variables
			</h1>
		</header>
		<h2><b>$other</b> &mdash; Multiple user settings</h2>
		<p>
			If you want, you can store any your settings in <?= scx('$other') ?> array.
			It will be globally available through <?= scx('PinPIE::$config->other', 'php') ?>.
		</p>
		<h2><b>$databases</b> &mdash; array to store any databases settings</h2>
		<p>
			This array is created to store databases access settings.
			You can use it to provide settings for your databases classes.
			It will be globally visible like <?= scx('PinPIE::$config->databases', 'php') ?>.
		</p>
		<h2><b>$cache</b> &mdash; Settings passed to cacher class</h2>
		<p>
			Read more in <a href="/en/manual/cache">cache docs</a>.
		</p>
		<h2><b>$debug</b> &mdash; Enables debug output.</h2>
		<p>
			Read more in <a href="/en/manual/debug">debug docs</a>.
			Globally available as <?= scx('PinPIE::$config->debug') ?>.
			Can be used in your own purposes.
		</p>
	</section>

</article>