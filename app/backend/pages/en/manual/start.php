[title[=How to start with PinPIE]]
[sidemenu[en/manual/sidemenu]]
[menu start[=
<ul>
	<li><a href="#download">Download</a></li>
	<li><a href="#composer">Composer</a></li>
	<li><a href="#standalone">Standalone</a></li>
	<li><a href="#launch">Launch</a></li>
	<li><a href="#config">Config</a></li>
	<li><a href="#preinclude">preinclude.php</a></li>
</ul>
]]
<article>
	<header>
		<h1>Start using PinPIE</h1>
	</header>

	<section>
		<header>
			<h1>
				<a name="download" href="#download">#</a>
				Download
			</h1>
		</header>
		<p>
			You can download any version of PinPIE from <a href="https://github.com/pinpie/pinpie/">PinPIE repo</a>.
			Always available <a href="https://github.com/pinpie/pinpie/archive/dev.zip">dev</a> version.
			Current <a href="https://github.com/pinpie/pinpie/archive/stable.zip">stable</a> coming soon.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="composer" href="#composer">#</a>
				Install with Composer
			</h1>
		</header>
		<p>
			First, install <?= scx('pinpie/pinpie') ?> package and copy basic folder structure
			from <?= scx('/basic structure', 'html') ?> folder to your project.</p>
		<?= pcx('composer require "pinpie/pinpie"
composer install', 'html') ?>
		<p>
			Second, you should route all requests to single entry point of your project.
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
			If you don't use Composer for some reason, you can just download and copy PinPIE files from <?= scx('/src') ?> to your's project folder.
			You can find basic folder structure in <?= scx('/basic structure', 'html') ?> folder of PinPIE package.
		</p>
		<p>
			To run PinPIE it should be included in main entry point of your project,
			and all requests should be routed to that file.
			This can be done in web server config. You can find some examples of server configurations
			in <a href="/en/manual/server-configuration">server config manual</a>.
			Usually, main entry point is an <?= scx('/index.php') ?> file.
		</p>
		<p>To make PinPIE work in standalone mode, this line is required:</p>
		<?= pcx('include __DIR__."/pinpie/autoload.php";') ?>
		<p>
			You are not required to use exactly this path to store PinPIE files.
			You can put PinPIE files to any other folder you want.
			Just make sure to include <?= scx('/autoload.php') ?>.
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
			PinPIE requires some files to work properly. PinPIE will look for an index page at <?= scx('/pages/index.php') ?>
			and will need a default template located in <?= scx('/templates/default.php', 'html') ?>
			with a placeholder <?= scx('[[*content]]') ?> to draw a content of a page.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="launch" href="#launch">#</a>
				Launch
			</h1>
		</header>
		<p>In most cases, this code is enough to run PiPIE:</p>
		<?= pcx('\pinpie\pinpie\PinPIE::newInstance();', 'PHP') ?>
		<p>To make usage of PinPIE class more convenient, you can make it globally accessible with class_alias() function:</p>
		<?= pcx('class_alias("\pinpie\pinpie\PinPIE", "PinPIE");
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
			PinPIE have no obligatory settings and will work with an empty config, or even without it.
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