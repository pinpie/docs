[sidemenu[en/examples/sidemenu]]
[title[=Simplest site]]
<article>
	<header>
		<h1>Simplest site</h1>
	</header>

	<section>
		<header>
			<h1>Description</h1>
		</header>
		<p>Here is the simplest PinPIE site: two pages, no config, but it works fine. Check it out.</p>
		<h3>Goal</h3>
		<p>Make sure it works.</p>
		<h3>Code</h3>
		<p><a href="https://github.com/pinpie/example-simplest" title="See the example code">Available at GitHub</a></p>
	</section>

	<section>
		<header>
			<h1>Installation</h1>
		</header>
		<?= pcx('git clone https://github.com/pinpie/example-simplest
cd example-simplest
composer install', 'html') ?>
		<p>
			Or you can <a href="https://github.com/pinpie/example-simplest/archive/master.zip" title="Download example code">download</a>
			it manually from repo.
		</p>
	</section>

	<section>
		<header>
			<h1>Files</h1>
		</header>
		<ul>
			<li>/index.php &mdash; an entry point</li>
			<li>/pages/index.php &mdash; a page</li>
			<li>/pages/about.php &mdash; another page</li>
		</ul>

		<h2>/index.php</h2>
		<p>
			The main entry point to include composer autoload or PinPIE standalone autoload
			and create PinPIE instance. It will detect requested page, check it exists
			and execute its code to serve requested content.
		</p>
		<?= pcx('include __DIR__ . \'/vendor/autoload.php\';
// include __DIR__ . \'/pinpie/autoload.php\';
\pinpie\pinpie\PinPIE::renderPage();', 'PHP') ?>

		<h2>/pages/index.php</h2>
		<p><i>URL:</i> /</p>
		<p>Simplest main page, just to make sure PinPIE works fine. Available at the <?= scx('/') ?> URL.</p>
		<?= pcx(h('<h1>Hello</h1>
<p>It works!</p>
<p>Now visit <a href="/about">another page</a>.</p>'), 'HTML') ?>

		<h2>/pages/about.php</h2>
		<p><i>URL:</i> /about</p>
		<p>Another simple page to see how PinPIE handles URLs like <?= scx('/about') ?> </p>
		<?= pcx(h('<h1>About</h1>
<p>Lorem Ipsum is simply dummy text of the printing and...'), 'HTML') ?>
	</section>

</article>