[title[=All PinPIE Tags]]
[sidemenu[en/manual/sidemenu]]
[menu tags[=
<ul>
	<li><a href="#chunk">Chunk</a></li>
	<li><a href="#snippet">Snippet</a></li>
	<li><a href="#snippet-caching">Snippet caching</a></li>
	<li><a href="#page">PAGE</a></li>
	<li><a href="#constant">Constant</a></li>
	<li><a href="#placeholder">Placeholder</a></li>
	<li><a href="#command">Command</a></li>
	<li><a href="#static-tags">Static tags</a></li>
	<li><a href="#tag-templates">Tag templates</a></li>
</ul>
]]
<article>
	<header>
		<h1>
			<a name="" href="">#</a>
			Tags
		</h1>
	</header>
	<p>PinPIE have tag-based parser. Tag syntax is inspired by ModX tag system. All tags are described below.</p>
	<section>
		<header>
			<h1>
				<a name="chunk" href="#chunk">#</a>
				Chunk
			</h1>
			<p>Syntax: <?= scx('[[chunk]]', 'html') ?></p>
			<p>Settings: <?= scx('$tags[""]', 'php') ?></p>
			<p>Class: <?= scx('\pinpie\pinpie\Tags\Chunk') ?></p>
		</header>
		<p>
			Chunk is plain text located in file in /chunks folder,
			which can be set in config with <?= scx('$tags[""]["folder"]') ?>.
		</p>
		<p>This code</p>
		<?= pcx('[[some_chunk]]', 'html') ?>
		<p>will make PinPIE locate file</p>
		<?= pcx('$tags[""]["folder"] . DIRECTORY_SEPARATOR . "some_chunk.php"') ?>
		<p>
			and load its content as plain text.
			It will be parsed by PinPIE engine to find other tags inside, but no php code will be executed.
		</p>
		<p>
			Chunks could be located inside subfolders to keep it all more organised:
			<?= scx('[[some/chunk]]') ?> or <?= scx('[[some/long/path/chunk]]') ?>.
		</p>

		<h2>Settings</h2>
		<h3>Defaults</h3>
		<?= pcx('$tags[""] => [
    "class" => "\pinpie\pinpie\Tags\Chunk",
    "folder" => $this->pinpie->root . DIRECTORY_SEPARATOR . "chunks",
    "realpath check" => true,
]') ?>
		<h3>Description</h3>
		<ul>
			<li>class &mdash;
				Defines which class will be used to create tag instance.
				You can set your own class.
			</li>
			<li>
				folder &mdash;
				The folder where chunk files are stored.
			</li>
			<li>
				realpath check &mdash;
				Checks that tag file belongs exactly that path it have to be in.
				Used to protect from paths like <?= scx('..\\..\\..\\file.php', 'xml') ?>.
				It can be disabled in case of symlink usage or for any other purposed.
			</li>
		</ul>
		<p>You can see some examples of tags usage in <a href="/en/examples/tags">tag examples</a>.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="snippet" href="#snippet">#</a>
				Snippet
			</h1>
			<p>Syntax: <?= scx('[[$snippet]]') ?></p>
			<p>Settings: <?= scx('$tags[\'$\']') ?></p>
			<p>Class: <?= scx('\pinpie\pinpie\Tags\Snippet') ?></p>
		</header>
		<p>
			Snippet is php file, that will be included, executed and parsed for other tags.
			Snippet tag starts with <b>$</b> symbol: <?= scx('[[$some_snippet]]') ?>.
		</p>
		<h2>Params</h2>
		<p>
			Snippet allow to transfer GET-like parameters inside its code.
			Just like in URL you can add variables to a snippet name:
		</p>
		<?= pcx('[[$snippet?foo=bar&cat=dog]]') ?>
		<p>
			Inside snippet they will be available in PHP as variables <span><code>$foo</code></span> and <span><code>$cat</code></span>.
			If variables or values are changed, snippet is forced to be parsed again.
			So you don't have to worry about cache while in development.
		</p>

		<h2>Settings</h2>
		<h3>Defaults</h3>
		<?= pcx('$tags[""] => [
    "class" => "\pinpie\pinpie\Tags\Snippet",
    "folder" => $this->pinpie->root . DIRECTORY_SEPARATOR . "snippets",
    "realpath check" => true,
]') ?>
		<h3>Description</h3>
		<ul>
			<li>class &mdash;
				Defines which class will be used to create tag instance.
				You can set your own class.
			</li>
			<li>
				folder &mdash;
				The folder where snippet files are stored.
			</li>
			<li>
				realpath check &mdash;
				Checks that tag file belongs exactly that path it have to be in.
				Used to protect from paths like <?= scx('..\\..\\..\\file.php') ?>.
				It can be disabled in case of symlink usage or for any other purposed.
			</li>
		</ul>

		<p>You can see some examples of tags usage in <a href="/en/examples/tags">tag examples</a>.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="snippet-caching" href="#snippet-caching">#</a>
				Snippet caching
			</h1>
			<p></p>
		</header>
		<p>
			By default, snippet is executed every time, but you can use caching.
			Set cache expiration time in seconds, or use exclamation mark to cache forever
			(until snippet file or file of its children is changed).
		</p>
		<h2>Usage examples:</h2>
		<ul>
			<li><?= scx('[[$some_snippet]]') ?> &mdash; caching disabled, snippet will be executed every time</li>
			<li><?= scx('[[<b>3600</b>$some_snippet]]') ?> &mdash; snippet is cached for one hour</li>
			<li>
				<?= scx('[[!$some_snippet]]') ?> &mdash; snippet is cached for
				<span><code>PinPIE::$config->pinpie['cache forever time']</code></span> seconds,
				which by default is about ten years (315360000 seconds). You can set your own <a href="/en/manual/cfg#cache_forever_time">cache forever time</a>
				option value in <a href="/en/manual/config">config</a>.
			</li>
		</ul>
		<p>For further info please read <a href="/en/manual/cache">cache</a> readme.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="page" href="#page">#</a>
				PAGE
			</h1>
			<p>Syntax: none</p>
			<p>Settings: <?= scx('$tags["PAGE"]') ?></p>
			<p>Class: <?= scx('\pinpie\pinpie\Tags\Page') ?></p>
		</header>
		<p>In PinPIE page exist as tag <?= scx('PAGE') ?>, which one is created at PinPIE start and is a root for all other tags.</p>
		<h2>Settings</h2>
		<h3>Defaults</h3>
		<?= pcx('$tags["PAGE"] => [
    "class" => "\pinpie\pinpie\Tags\Page",
    "folder" => $this->pinpie->root . DIRECTORY_SEPARATOR . "pages",
    "realpath check" => true,
]') ?>
		<h3>Description</h3>
		<ul>
			<li>class &mdash;
				Defines which class will be used to create tag instance.
				You can set your own class.
			</li>
			<li>
				folder &mdash;
				The folder where page files are stored.
			</li>
			<li>
				realpath check &mdash;
				Checks that tag file belongs exactly that path it have to be in.
				Used to protect from paths like <?= scx('..\\..\\..\\file.php') ?>.
				It can be disabled in case of symlink usage or for any other purposed.
			</li>
		</ul>

		<p>You can see some examples of tags usage in <a href="/en/examples/tags">tag examples</a>.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="constant" href="#constant">#</a>
				Constant
			</h1>
			<p>Syntax: <?= scx('[[=constant]]') ?></p>
			<p>Settings: none</p>
			<p>Class: <?= scx('\pinpie\pinpie\Tags\Constant') ?></p>
		</header>
		<p>
			Constant is just a line of text, that will go to output. It have no use without using placeholder.
			Because all pages are stored in files, constant is convenient way to put some small text from a page file to the template.
			Please see variable <a href="#placeholder">placeholder</a> section.
		</p>
		<p>Constant tag starts with equals symbol. Here is a constant example: <?= scx('[[=simple constant text]]') ?> </p>
		<p>Constant text can be multiline:</p>
		<?= pcx('[[=some
multiline
text]]') ?>
		<p>You can see some examples of tags usage in <a href="/en/examples/tags">tag examples</a>.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="placeholder" href="#placeholder">#</a>
				Placeholder
			</h1>
			<p>Syntax: <?= scx('[[*placeholder]]', 'html') ?></p>
			<p>Syntax: <?= scx('[[*placeholder=default value]]', 'html') ?></p>
			<p>It's not a real tag and it have no settings.</p>
		</header>
		<p>
			Every chunk, snippet or constant output can be assigned to a placeholder.
			This placeholder can be used in the page, in tags, or certainly in the template.
			Placeholder tag starts with asterisk.
			Here is syntax example: <?= scx('[[*placeholder]]', 'html') ?>
		</p>
		<?= pcx(h('[foobar[$some_snippet]]
...
<span>[[*foobar]]</span>'), 'html') ?>
		<p>
			The output of snippet <?= scx('some_snippet', 'html') ?> will not be used in the place where snippet is.
			It goes to the <?= scx('foobar', 'html') ?> placeholder and will be printed there.
		</p>
		<p>
			Placeholder supports default value. You can set default value to the placeholder and it is used
			if no other value is assigned to that placeholder.
		</p>
		<?= pcx(h('<span>[[*var=some default text]]</span>')) ?>
		<p>Will produce that HTML:</p>
		<?= pcx(h('<span>some default text</span>')) ?>
		<p>
			If somewhere some content is assigned to that placeholder, e.g. <?= scx('[var[$rand]]') ?>,
			that will replace placeholder's default value with snippet output:
		</p>
		<?= pcx(h('<span>42</span>')) ?>
		<p>
			Placeholder contents could be used in external template engine by applying your custom function.
			This data is passed to function as an array. See external template section.
		</p>
		<p>
			Placeholder contents are cached within its parents cache, so you don't have to worry
			when placeholder contents are set inside cached snippet, but used somewhere outside of that snippet.
			They will be cached and used outside this tags. See cache section.
		</p>
		<p>
			Placeholder tags are removed from output.
			So, any placeholder will be replaced with some content or it will be replaced with empty strings.
			No placeholders go to the rendered page.
			But if debug mode is enabled &mdash; they remain and you can see them.</p>
		<h3>Important</h3>
		<p>
			There is a reserved placeholder <?= scx('[[*content]]') ?> for a page or tag output in a template.
			See <a href="/en/manual/templates">templates readme</a>.
		</p>
		<h2>Examples</h2>
		<h3>Example 1</h3>
		<p>
			To put a page title to a template inside &lt;title&gt; tag, you can put the page title into the placeholder
			using constant <?= scx('[var[=About]]') ?> in your page, and placeholder tag <?= scx(h('<title>[[*var]]</title>')) ?>
			in your template.
		</p>
		<h3>Example 2</h3>
		<p>
			You can use placeholder even before it is set, because placeholders are replaced with variable content after page or tag have been processed.
		</p>

		<p>This example</p>
		<?= pcx(h('<span>[[*var]]</span>
[var[=pinpie]]')) ?>
		<p>or this</p>
		<?= pcx(h('[var[=pinpie]]
<span>[[*var]]</span>')) ?>
		<p>will provide you same HTML code:</p>
		<?= pcx(h('<span>pinpie</span>')) ?>

		<h3>Example 3</h3>
		<p>You can use placeholders with snippets or chunks.</p>
		<?= pcx(h('[var[some_chunk]]
<span>[[*var]]</span>'), 'html') ?>

		<p>having /chunks/some_chunk.php file with code</p>
		<?= pcx("pinpie") ?>
		<p>or</p>
		<?= pcx(h('[var[$some_snippet]]
<span>[[*var]]</span>'), 'html') ?>
		<p>having /snippets/some_snippet.php file with code</p>
		<?= pcx(h('<?php echo "pinpie"; ?>')) ?>
		<p>or just</p>
		<?= pcx('pinpie') ?>
		<p>will provide you the same HTML code:</p>
		<?= pcx(h('<span>pinpie</span>')) ?>
	</section>

	<section>
		<header>
			<h1>
				<a name="command" href="#command">#</a>
				Command
			</h1>
			<p>Syntax: <?= scx('[[@template=main]]') ?> or <?= scx('[[#template=main]]', 'html') ?></p>
			<p>Settings: none</p>
			<p>Class: <?= scx('\pinpie\pinpie\Tags\Command') ?></p>
		</header>
		<p>
			To provide control over some PinPIE engine functions inside page or tag file, use commands.
			Command tag starts with <b>@</b> to suppress command output, or with <b>#</b> to show the return value.
			Currently only one command is supported, and it's better to use it like this: <?= scx('[[@template=wide]]') ?>.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="static-tags" href="#static-tags">#</a>
				Static content tags
			</h1>
			<p>Syntax: <?= scx('[[%type=path]]') ?> </p>
			<p>Settings: <?= scx('$tags["%"]') ?></p>
			<p>Class: <?= scx('\pinpie\pinpie\Tags\Staticon') ?></p>
		</header>

		<p>
			Static tags are used to provide automatic using of static files features, such as <b>minification</b>, <b>gzipping</b>,
			and <b>server sharding</b> support. Static tag starts with <b>%</b> symbol and static content type,
			which is not the file extension or type.
		</p>

		<p>
			For more detailed information about static tags, pre-minification and gzip pre-compression,
			please see <a href="/en/manual/static">static readme</a>.
		</p>

		<p>
			Currently three types of static content are supported:
		<ul>
			<li>js &mdash; for javascript files</li>
			<li>css &mdash; for cascading style sheets</li>
			<li>img &mdash; for any images</li>
		</ul>
		</p>
		<p>
			This tags are replaced with corresponding HTML tags, where URL is leading to some static server
			(if sharding is enabled) from a list,
			and have GET-parameter <?= scx('time') ?> with salted hash of the name and the modification time of a file.
			This provides <b>automatic browser cache refreshing</b>. That means, you don't have to hit
			Ctrl+F5 while developing your site, and all users will get fresh content in time.
		</p>
		<p>
			For more detailed information about static tags, pre-minification and gzip pre-compression,
			please see <a href="/en/manual/static">static readme</a>.
		</p>
		<h2>Example</h2>

		<p>This code</p>
		<?= pcx('[[%js=/javascript/jquery.js]]', 'html') ?>
		<p>by default will create a html tag</p>
		<?= pcx(h('<script type="text/javascript" src="/javascript/jquery.js?time=hash"></script>'), 'html') ?>
		<p>
			Static files could be located outside the site root folder.
			Set <?= scx('PinPIE::$config->pinpie["static folder"]') ?> to path to your static files folder.
			Default value is <?= scx('ROOT') ?> (see <a href="/en/manual/constants#root">constants</a>).
		</p>

		<h2>Settings</h2>
		<h3>Defaults</h3>
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

		<h3>Description</h3>
		<ul>
			<li>class &mdash;
				Defines which class will be used to create tag instance.
				You can set your own class.
			</li>
			<li>
				folder &mdash;
				The folder where snippet files are stored.
			</li>
			<li>
				realpath check &mdash;
				Checks that tag file belongs exactly that path it have to be in.
				Used to protect from paths like <?= scx('..\\..\\..\\file.php') ?>.
				It can be disabled in case of symlink usage or for any other purposed.
			</li>
		</ul>

		<p>
			For more detailed information about static tags, pre-minification and gzip pre-compression,
			please see <a href="/en/manual/static">static readme</a>.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="tag-templates" href="#tag-templates">#</a>
				Tag templates
			</h1>
		</header>
		<p>
			Template can be applied to any tag except placeholder.
			This is not templates like <a href="http://twig.sensiolabs.org/">twig</a> or <a href="http://mustache.github.io/">mustache</a>.
			It's a kind of simple wrappers for tag output. Template code is always executed, in contrast to tag content, that could be loaded from cache.
		</p>
		<h3>Example</h3>
		<p>To wrap snippet output to a div you need create template named e.g. "wrap" with code:</p>
		<?= pcx(h('<div>[[*content]]</div>')) ?>
		<p>And now you can apply this template to a snippet like this:</p>
		<?= scx('[[$snippet]wrap]') ?>
		<p>Assuming snippet have this code:</p>
		<?= pcx(h('<?php echo rand(1, 100); ?>'), 'php') ?>
		<p>So we will get this output:</p>
		<?= pcx(h('<div>42</div>'), 'html') ?>
		<p>As in snippet, in templates parameters could be transferred.</p>
		<?= pcx('[[$snippet]wrap?foo=bar]') ?>
		<p>They will be available inside template like PHP variables:</p>
		<?= pcx('var_dump($foo); // bar', 'PHP') ?>
		<p>
			Please read more in <a href="/en/manual/templates#tag-templates">templates</a> readme.
			You can see some examples of tags templates usage in <a href="/en/examples/templates">templates examples</a>.
		</p>
	</section>
</article>