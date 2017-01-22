[title[=How to start with PinPIE]]
[sidemenu[en/manual/sidemenu]]
[menu start[=
<ul>
	<li><a href="#composer">Composer</a></li>
	<li><a href="#standalone">Standalone</a></li>
	<li><a href="#required-files">Required files</a></li>
	<li><a href="#launch">Launch</a></li>
	<li><a href="#config">Config</a></li>
	<li><a href="#preinclude">preinclude.php</a></li>
</ul>
]]
<article>
	<header>
		<h1>
			<a name="" href="">#</a>
			Start using PinPIE
		</h1>
	</header>

	<section>
		<header>
			<h1>
				<a name="composer" href="#composer">#</a>
				Install with Composer
			</h1>
		</header>
		<p>
			First, install <?= scx('pinpie/pinpie') ?> package and copy basic folder structure
			from <?= scx('/basic structure', 'html') ?> folder to your project.
		</p>
		<?= pcx('composer require "pinpie/pinpie"
composer install', 'html') ?>
		<p>
			Second, you should route all requests to single entry point of your project.
			Usually, it's <?= scx('index.php', 'html') ?> file in the root of your site.
			In that file you have to start PinPIE engine.
			Read <a href="#launch">how to launch PinPIE</a> below.
		</p>
	</section>
	<section>
		<header>
			<h1>
				<a name="standalone" href="#standalone">#</a>
				Standalone install
			</h1>
		</header>
		<p>
			If you don't use Composer for some reason, you can just download and copy PinPIE files from <?= scx('/src') ?> to some folder in your project.
			You can find basic folder structure in <?= scx('/basic structure', 'html') ?> folder of PinPIE package.
		</p>
		<p>
			You can download any version of PinPIE from <a href="https://github.com/pinpie/pinpie/">PinPIE repo</a>.
			Always available current <a href="https://github.com/pinpie/pinpie/archive/stable.zip">stable</a>
			and a <a href="https://github.com/pinpie/pinpie/archive/dev.zip">dev</a> version.
		</p>
		<p>
			To run PinPIE it should be included in the main entry point of your project,
			and all requests should be routed to that file.
			This can be done in web server config. You can find some examples of server configurations
			in <a href="/en/manual/server-configuration">server config manual</a>.
			Usually, main entry point is an <?= scx('/index.php') ?> file.
		</p>
		<p>To make PinPIE work in standalone mode, this line is required:</p>
		<?= pcx('include __DIR__ . \'/pinpie/src/autoload.php\';') ?>
		<p>
			You are not required to use exactly this path to store PinPIE files.
			You can put PinPIE files to any other folder you want.
			Just make sure to include <?= scx('/src/autoload.php') ?>.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="required-files" href="#required-files">#</a>
				Required files
			</h1>
		</header>
		<p>
			PinPIE require only one file to work properly. PinPIE will look for an index page at <?= scx('/pages/index.php') ?>.
			There is no other files required to start using PinPIE.
		</p>

		<p>Basic folder structure (default):</p>
		<?= pcx('/
├── chunks/                              chunks folder
├── config/                              config folder
├── filecache/                           used only if filecache enabled
├── pages/                               pages files should be located here
├── pinpie/                              possible place to store PinPIE files in case of standalone install
├── snippets/                            folder to store snippets
└── templates/                           folder for page wrappers', 'html') ?>

		<p>Every that path can be changed in config. Even a config path.</p>

	</section>

	<section>
		<header>
			<h1>
				<a name="launch" href="#launch">#</a>
				Launch
			</h1>
		</header>
		<p>In most cases, this code is enough to run PinPIE:</p>
		<?= pcx('\pinpie\pinpie\PinPIE::newInstance();', 'PHP') ?>
		<p>To make usage of PinPIE class more convenient, you can make it globally accessible with class_alias() function:</p>
		<?= pcx('class_alias(\'\pinpie\pinpie\PinPIE\', \'PinPIE\');
PinPIE::newInstance();', 'PHP') ?>
	</section>

	<section>
		<header>
			<h1>
				<a name="config" href="#config">#</a>
				PinPIE configuration
			</h1>
		</header>
		<p>
			PinPIE has no obligatory settings and will work with an empty config, or even without it.
			Read more about configuration in <a href="/en/manual/config">PinPIE config docs</a>.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="preinclude" href="#preinclude">#</a>
				Special files: preinclude.php and postinclude.php
			</h1>
		</header>
		<p>
			On every request PinPIE will check and try to include two files, if they exist:
			<?= scx("/preinclude.php") ?> and <?= scx("/postinclude.php") ?>.
			Paths to this files could be set in config.
			Read more about this files usage and why they are useful in
			<a href="/en/manual/config#preinclude">config docs</a>.
		</p>
	</section>

</article>