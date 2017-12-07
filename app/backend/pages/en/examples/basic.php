[sidemenu[en/examples/sidemenu]]
[title[=Basic example]]
<article>
	<header>
		<h1>Basic example</h1>
	</header>

	<section>
		<header>
			<h1>Description</h1>
		</header>
		<p>Meet some basic things, like pages, chunks, snippets, templates, placeholders.</p>
		<h3>Goal</h3>
		<p>Become familiar with some PinPIE tags.</p>
		<h3>Code</h3>
		<p><a href="https://github.com/pinpie/example-basic" title="See the example code on GitHub">Available at GitHub</a></p>
	</section>

	<section>
		<header>
			<h1>Installation</h1>
		</header>
		<?= pcx('git clone https://github.com/pinpie/example-basic
cd example-basic
composer install', 'html') ?>
		<p>
			Or you can <a href="https://github.com/pinpie/example-basic/archive/master.zip" title="Download example code">download</a>
			it manually from the repo.
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
			<li>/css/css.css &mdash; some css</li>
			<li>/chunks/lorem/ipsum.php &mdash; some text chunk</li>
			<li>/snippets/rand.php &mdash; a snippet outputting a random number</li>
			<li>/templates/default.php &mdash; template with css in head and title with placeholder</li>
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


		<h2>/chunks/lorem/ipsum.php</h2>
		<p>A piece of text to be printed on the page. PHP code in chunks is not executed.</p>
		<?= pcx(h('<p>Lorem ipsum dolor sit amet...'), 'HTML') ?>

		<h2>/snippets/rand.php</h2>
		<p>A piece of PHP code. It will be executed and result will be outputed to the page.</p>
		<?= pcx('echo rand(1, 999);', 'PHP') ?>

		<h2>/templates/default.php</h2>
		<p>A wrapper for page output</p>
		<?= pcx(h('<html>
<head>
  <!-- A static tag to link css file in the head -->
  [[%css=/css/css.css]]
  <!-- A title placeholder to get a title from the page file and put into the page head -->
  <title>[[*title]]</title>
</head>
<body>
<article>
  <header>
    <!-- Title placeholder to draw the title on the page -->
    <h1>[[*title]]</h1>
  </header>
  <!-- A content placeholder is a place, where PinPIE will output the page file content -->
  [[*content]]
</article>
</body>
</html>', 'HTML')) ?>

		<h2>/pages/index.php</h2>
		<p><i>URL:</i> /</p>
		<p>Main page. Available at the <?= scx('/') ?> URL.</p>
		<p>It contains PinPIE tags: constant, snippet, static tag and chunk.</p>
		<?= pcx(h('<!-- A title text. It goes to placeholder in the template -->
[title[=Hello]]

<p>Hi!</p>

<!-- A snippet of PHP code, it outputs some random number each time page is rendered. -->
<p>The answer is [[$rand]].</p>

<!-- A static tag. It will be rendered as <img... with width and height (optional), see below -->
[[%img=/images/cat.jpg]]

<p>Now visit <a href="/about">another page</a>.</p>

<!-- A chunk tag. Piece of plain text which can be used anywhere. -->
[[lorem/ipsum]]'), 'HTML') ?>
		<p>After page is processed, its HTML code will look like that:</p>
				<?= pcx(h('...
<!-- Article and header are located in the template.
 Title was set in the template with a placeholder.
 You can find template code below. -->
<article>
  <header>
    <h1>Hello</h1>
  </header>
  
<!-- A title text. It is now above this line. -->

<p>Hi!</p>

<!-- A snippet of PHP code generated a number. -->
<p>The answer is 453.</p>

<!-- A static tag become an image with a hash preventing caching changed files.
  That hash will remain the same until file is changed. -->
<img src="//test.ru/images/cat-1.jpg?time=d9c8899d5833a0616ad2aef0bc2229cd" width="640" height="427">

<p>Now visit <a href="/about">another page</a>.</p>

<!-- A chunk tag. Piece of plain text which can be used anywhere. -->
<p>Lorem ipsum dolor sit amet...'), 'HTML') ?>



		<h2>/pages/about.php</h2>
		<p><i>URL:</i> /about</p>
		<p>Another simple page to see how PinPIE handles URLs like <?= scx('/about') ?> </p>

		<h2>/css/css.css</h2>
		<p>Just some styles to make sure file was loaded and affected the page view.</p>





	</section>
</article>