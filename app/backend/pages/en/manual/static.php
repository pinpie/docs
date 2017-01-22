[title[=Static content]]
[sidemenu[en/manual/sidemenu]]
[menu static[=
<ul>
	<li><a href="/en/manual/static#static-tags">Static tags</a></li>
	<li><a href="/en/manual/static#time-hash">Time hash</a></li>
	<li><a href="/en/manual/static#servers-sharding">Servers sharding</a></li>
	<li><a href="/en/manual/static#custom-types">Custom types</a></li>
	<li><a href="/en/manual/static#compression">Compression</a></li>
	<li><a href="/en/manual/static#minification">Minification</a></li>
	<li><a href="/en/manual/static#dimensions">Dimensions</a></li>
	<li><a href="/en/manual/static#turn-off">Turn off</a></li>
	<li><a href="/en/manual/static#templates">Templates</a></li>
</ul>
]]
<article>
	<header>
		<h1>
			<a name="" href="">#</a>
			Static content
		</h1>
	</header>
	<p>
		Static file means file, that will be sent to user from server's hard drive as is, without any modification or preprocessig.
		Usually, static files are images, client-side javascript files, css files, etc.
	</p>

	<section>
		<header>
			<h1>
				<a name="static-tags" href="#static-tags">#</a>
				Static tags
			</h1>
		</header>

		<p>
			Static tags are used to provide automatic using of static files features, such as <b>minification</b>, <b>gzipping</b>,
			and <b>server sharding</b> support.
		</p>
		<p>
			Static tag consists of: <b>%</b> symbol; static content type,
			which is not taken from the extension or type of the file, but from the tag type; and path to file.
			PinPIE currently support three types of static tags and draws them in corresponding way.
		</p>
		<h2>General usage</h2>
		<p> Syntax:</p>
		<?= pcx('[[%js=/javascript/jquery.js]]
[[%css=/css/main.css]]
[[%img=/images/avatar.png]]', 'html') ?>
		<p>This tags will be replaced by default with lines of html-code like this:</p>
		<?= pcx(h('<script type="text/javascript" src="//pinpie.ru/javascript/jquery.min.js?time=956603fa2e94d0321f5cf24a77702331"></script>
<link rel="stylesheet" type="text/css" href="//pinpie.ru/css/css.min.css?time=4ad3a55cc4b8e5ad0801d84959cde6b3">
<img src="//pinpie.ru/images/avatar.png?time=b17c93f172020c8c4c0f324b048b3434" width="64" height="64">'), 'html') ?>
		<h2>Path only</h2>
		<p>If you doesn't need a full html-tag, but the path only, just use exclamation mark:</p>
		<p> Syntax:</p>
		<?= pcx('[[!%js=/javascript/jquery.js]]
[[!%css=/css/main.css]]
[[!%img=/images/avatar.png]]', 'html') ?>
		<p>and this will give you only paths:</p>

		<?= pcx('//pinpie.ru/javascript/jquery.min.js?time=956603fa2e94d0321f5cf24a77702331
//pinpie.ru/css/css.min.css?time=4ad3a55cc4b8e5ad0801d84959cde6b3
//pinpie.ru/images/avatar.png?time=b17c93f172020c8c4c0f324b048b3434', 'html') ?>
		<p>So, yes, you can use static tags like this:</p>
		<?= pcx(h('<img class="avatar small" src="[[!%img=/images/avatar.png]]" title="nickname (online)">'), 'html') ?>
		<h2>And with templates</h2>

		<p> Syntax:</p>
		<?= pcx('[[!%img=/images/avatar.png]<b>template</b>]', 'html') ?>
		<p>Assuming template code is like this:</p>
		<?= pcx(h('<img class="avatar small" src="[[*content]]">'), 'html') ?>
		<p>you'll get this html:</p>
		<?= pcx(h('<img class="avatar small" src="//pinpie.ru/images/avatar.png?time=b17c93f172020c8c4c0f324b048b3434">'), 'html') ?>

		<p>Read more about <a href="/en/manual/static#templates">static tags templates</a> below.</p>

	</section>
	<section>
		<header>
			<h1>
				<a name="time-hash" href="#time-hash">#</a>
				Time hash
			</h1>
		</header>
		<p>
			To automate refreshing of browser cache of loaded files each file linked through
			<a href="/en/manual/tags#static-tags">static tags</a> will have "time" GET-parameter attached to URL.
			This is hash based on <a href="/en/manual/config#random_stuff">secret</a>, filename and file modification time.
			When file is modified, time changes, hash changes and browser receive different URL to load this file.
			So browser will load new version and you will never need to press Ctrl+F5 to reload page without cache.
		</p>
		<p>In case if file was not found on server, PinPIE will use general url path without hash.</p>
	</section>
	<section>
		<header>
			<h1>
				<a name="servers-sharding" href="#servers-sharding">#</a>
				Servers sharding
			</h1>
		</header>
		<p>
			Modern browsers can download content of page from one site in about 5 simultaneous threads.
			If your page have some amount of images, js scripts and css files, browser will start downloading the first 5-6 files,
			and will not try download other files while downloading this.
			If your page have plenty of files, even small files, it could take some seconds for browser to download them all.
		</p>
		<p>
			There are two main strategies to speed up page loading time. First is to stick all images to one big image to download
			it in one thread, and use css background offset for html elements to show corresponding images at this elements.
			Or put css files all together to one file. This is the best practice.
		</p>
		<p>
			Secondary &mdash; use HTTP/2. It's a great thing. Within single connection browser can requesta multiple files from server.
		</p>
		<p>
			If for some reason you can't do that, you have to increase the quantity of simultaneous download threads.
			The way to do that is to spread static content over more than one server, so the browser will have possibility
			to download in 5 threads from each server.
		</p>
		<p>
			PinPIE realise this strategy in the simplest way. It chose server randomly from the list, considering all servers have all files.
			Actually, it's not random, it's based on filename. For each file it will be always located at the same server.
			So browser caching will still work properly.
		</p>
		<p>
			List of static content servers is to be set in config file by <?= scx('$tags["%"]["servers"]', 'php') ?> variable
			and is accessible outside via <?= scx('PinPIE::$conf->tags["%"]["servers"]', 'php') ?>. Default value is an empty array.
		</p>
		<p>
			Server is chosen by <?= scx('Staticon::getServer($file)', 'php') ?> method, where $file is path to file inside
			<?= scx('$tags["%"]["folder"]') ?>. Currently there is no way to redefine this method in config file,
			but it have to be done one day to allow more control over server load and CDN balancing, etc.
		</p>
		<h3>Example</h3>
		<p>This config will spread static files request between three servers.</p>
		<?= pcx('$tags["%"]["servers"] = [
  "stat-1." . $pinpie["site url"],
  "stat-2." . $pinpie["site url"],
  "stat-3." . $pinpie["site url"],
];') ?>
		<p>And this tag</p>
		<?= pcx('[[%img=jpg.jpg]]', 'html') ?>
		<p>will be replaced with that html-code:</p>
		<?= pcx(h('<img src="//stat-2.somesite.com/jpg.jpg?time=30c1c523bed6d902df19d9637831e41c" width="800" height="600">'), 'html') ?>

		<p>
			Actually, it can be a single physical server handling all requests. Anyway, user will receive content much faster,
			than in case of single domain requests. Serving static files is very simple task for a web server, and user will do the same
			quantity of requests, so you don't have to worry about performance.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="custom-types" href="#custom-types">#</a>
				Custom static files types
			</h1>
		</header>
		<p>Static file type is defined in tag and can be used in pre-minification and pre-compressing process.</p>
		<p>Static tag syntax: <?= scx('[[%<b>type</b>=path]]', 'html') ?>.</p>
		<p>
			Currently there are three static types: js, css and img. By default js and css are allowed to be compressed and minified.
			Type img is not allowed to be minified or gzipped by default. Types to minify or to gzip are listed in
			<?= scx('$tags["%"]["minify types"]', 'php') ?> and <?= scx('$tags["%"]["gzip types"]', 'php') ?>
			arrays respectively.
		</p>
		<p>
			You can use any custom types to separate your minification options. Compression have only one option &mdash;
			compression level set in <?= scx('$tags["%"]["gzip level"]', 'php') ?>. By default it is 5.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="compression" href="#compression">#</a>
				Compression
			</h1>
		</header>
		<p>
			You can make your web-server <a href="https://www.google.com/search?q=pre-compressed+static" target="_blank">serve pre-compressed files</a>
			instead original ones. You can set compression level in <?= scx('$tags["%"]["gzip level"]', 'php') ?>.
		</p>
		<p>To be pre-compressed static file type have to be in array</p>
		<?= pcx('$tags["%"]["gzip types"]', 'php') ?>
		<p>which default value is</p>
		<?= pcx("['js', 'css']") ?>
		<p>
			If type is in array, than "filename.gz" will be created. If web server is configured properly, it will use already compressed
			file. But it is not guaranteed that server will use newest file. If original file have been changed, but was not recompressed,
			most likely web server will continue to serve compressed, but obsolete version. To prevent this, PinPIE will check if compressed
			version is older than original, and gzip the new one again if required. Checking file modification time is very fast, because is cached
			by OS itself. So you don't have to wary about performance, and browsers will always receive the newest version.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="minification" href="#minification">#</a>
				Minification
			</h1>
		</header>
		<p>
			Roughly, minification is a process of lowering a file size by removing all comments, spaces, newline chars,
			shortening functions and variables names, etc.
			PinPIE can check if minified version of the requested file exists in directory, and change the static tag path to the
			corresponding path to minified file. If minified version is older than a original file and tag type is in array
		</p>
		<?= pcx('$tags["%"]["minify types"]', 'php') ?>
		<p>than PinPIE will start minifier. By default this types are:</p>
		<?= pcx("['js', 'css']") ?>
		<p>If tag type is in this array, than PinPIE will try to call function, stored in:</p>
		<?= pcx('$tags["%"]["minify function"]', 'php') ?>
		<p>
			You have to write this function by your own. In that function you have to call your favorite minifier or
			schedule this operation. Minifier call <b>can be asynchronous</b>. Anyway the newer file will be used in tag URL.
		</p>
		<p>
			There are some protective measures to prevent overflow of multiple tries to compress new or changed file in first moments.
			PinPIE doesn't require to finish minification process at the same request it was started.
			In that case, after call to minify function PinPIE will check and use path to newer file.
			To make sure, that for single file only single minification is processed
			PinPIE will lock file for reading while minification function is called.
			It works for Linux environment, but not sure if it will for Windows.
			If PinPIE can't lock file, it will use unminified one.
			Anyway, to ensure only single minification per a file change, you should add file path to a list of planned minifications,
			and minifie them somehow, e.g. by cron call.
		</p>
		<p>You can set minifier function in the site config:</p>
		<?= pcx('/* like this */
$tags["%"]["minify function"] = "runMyMinifier";
/* or like this */
$tags["%"]["minify function"] = function(){/.../};') ?>
		<h2>Example</h2>
		<p>
			This example will process tag <?= scx('[[%css=/main.css]]') ?> and call
			<a href="http://yui.github.io/yuicompressor/" target="_blank">YUI Compressor</a> external java executable to minify it.
		</p>

		<?= pcx('$tags[\'%\'][\'minify function\'] = function (pinpie\pinpie\Tags\Staticon $tag) {
  exec("java -jar /var/www/yuic.jar \"{$tag->filename}\" -o \"{$tag->minifiedPath}\" --type {$tag->type}", $out, $err);
  return true;
}', 'php') ?>

		<p>Or you can use Matthias Mullie's <a href="https://github.com/matthiasmullie/minify" title="GitHub">Minifie</a>, written in PHP.</p>

		<?= pcx('$tags[\'%\'][\'minify function\'] = function (pinpie\pinpie\Tags\Staticon $tag) {
	if ($tag->type == \'css\') {
		$minifier = new MatthiasMullie\Minify\CSS($tag->filename);
		$minifier->minify($tag->minifiedPath);
		return $tag->minifiedPath;
	}
	if ($tag->type == \'js\') {
		$minifier = new MatthiasMullie\Minify\JS($tag->filename);
		$minifier->minify($tag->minifiedPath);
		return $tag->minifiedPath;
	}
	return false;
};', 'php') ?>
		<p>Where:</p>
		<ul>
			<li>
				<?= scx('$tag->filename') ?> is the file path from tag.
				Its value is <?= scx('$tags["%"]["folder"] . "/main.css"') ?>.
			</li>
			<li>
				<?= scx('$tag->minifiedPath') ?> is the file path to minified version to check.
				Value: <?= scx('$tags["%"]["folder"] . "/main.min.css"') ?>
			</li>
			<li>
				<?= scx('$tag->type') ?> here is "css". It is <b>not</b> taken from file extension. It is taken from %<b>css</b> tag type.
			</li>
			<li>
				<?= scx('$tags["%"]["minify types"]') ?> is array with default value <?= scx('["js", "css"]') ?>.
				You can change it in a config file.
			</li>
		</ul>
		<p>
			Remember that you can run minifier in background or just schedule this operation.
			The newest file will be provided anyway.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="dimensions" href="#dimensions">#</a>
				Dimensions
			</h1>
		</header>
		<p>PinPIE allow you to get images dimensions for some static tags. This tags types are listed in</p>
		<?= pcx('$tags["%"]["dimensions types"]', 'php') ?>
		<p>which is by default:</p>
		<?= pcx('["img"]', 'php') ?>
		<p>
			Dimensions are taken by <a href="http://php.net/manual/en/function.getimagesize.php">getimagesize()</a> function of GD library.
			If you don't want to use GD, set <?= scx('$tags["%"]["dimensions types"]', 'php') ?> to false or empty array.
		</p>
		<p>
			So, by default all images will get dimensions in their html-tags. This will allow to browser to know image dimensions before
			loading it, and decrease <a href="https://developers.google.com/speed/articles/reflow">reflow</a>
			and flickering on page loading.
		</p>
		<h3>Example</h3>
		<p>This simple static tag</p>
		<?= pcx('[[%img=jpg.jpg]]', 'html') ?>
		<p>will be replaced with this html-code:</p>
		<?= pcx(h('<img src="//s2.somesite.com/jpg.jpg?time=30c1c523bed6d902df19d9637831e41c" width="800" height="600">'), 'html') ?>
		<p>As you can see, width and height attributes are added to this tag.</p>
	</section>
	<section>
		<header>
			<h1>
				<a name="turn-off" href="#turn-off">#</a>
				Turn off that additional stuff
			</h1>
		</header>
		<p>Every time PinPIE finds static tag, it checks static tag type to exist in this arrays:</p>
		<ul>
			<li><?= scx('$tags["%"]["minify types"]', 'php') ?></li>
			<li><?= scx('$tags["%"]["gzip types"]', 'php') ?></li>
			<li><?= scx('$tags["%"]["dimensions types"]', 'php') ?></li>
		</ul>
		<p>
			If type is not in this arrays &mdash; PinPIE will not try to do corresponding tasks.
		</p>
		<?= pcx('$tags["%"]["minify types"] = [];     // disables minification
$tags["%"]["gzip types"] = [];       // disables gzip compression
$tags["%"]["dimensions types"] = []; // disables images dimensions gathering', 'php') ?>
		<p>If you want to use it with some images, but not all of them, you can use templates.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="templates" href="#templates">#</a>
				Templates
			</h1>
		</header>
		<p>
			In static tags like <?= scx('[[%static=file]<b>template</b>]', 'html') ?> template can use additional placeholders.
			Here is full list of placeholders, available in template of static tag:
		</p>
		<ul>
			<li><?= scx('[[*content]]', 'html') ?> &mdash; content is what you usually need</li>
			<li><?= scx('[[*url]]', 'html') ?> &mdash; url of file with host</li>
			<li><?= scx('[[*file path]]', 'html') ?> &mdash; path to file on server</li>
			<li><?= scx('[[*time]]', 'html') ?> &mdash; integer unix modification time of the file</li>
			<li><?= scx('[[*time hash]]', 'html') ?> &mdash; hash to prevent browser caching of modified files</li>
			<li><?= scx('[[*width]]', 'html') ?> &mdash; width of image, if applicable</li>
			<li><?= scx('[[*height]]', 'html') ?> &mdash; height of image, if applicable</li>
		</ul>

		<p>Let's see some examples.</p>
		<h3>Example 1</h3>
		<p>If you use exclamation mark &mdash; you'll get path only:</p>
		<?= pcx('[[%img=jpg.jpg]wrap]
[[<b>!</b>%img=jpg.jpg]wrap]', 'html') ?>
		<p>Template wrap.php with this code:</p>
		<?= pcx(h('<div class="wrapper">[[*content]]</div>')) ?>
		<p>you'll get that html:</p>
		<?= pcx(h('<div class="wrapper"><img src="//s2.somesite.com/jpg.jpg?time=30c1c523bed6d902df19d9637831e41c" width="800" height="600"></div>
<div class="wrapper">//s2.somesite.com/jpg.jpg?time=30c1c523bed6d902df19d9637831e41c</div>', 'html')) ?>
		<h3>Example 2</h3>
		<p>To use width and height information in your template, just put there suitable placeholders:</p>
		<?= pcx(h('<div
  class="unusual div"
  style="
    background-image: url(\'[[*url]]?time=[[*time hash]]\');
    width: [[*width]]px;
    height: [[*height]]px;
  ">
</div>')) ?>
		<p>This template with some image static tag</p>
		<?= pcx('[[%img=jpg.jpg]unusual]', 'html') ?>
		<p>will give you next html-code:</p>
		<?= pcx(h('<div
  class="unusual div"
  style="
    background-image: url(\'//s2.somesite.com/jpg.jpg?time=30c1c523bed6d902df19d9637831e41c\');
    width: 430px;
    height: 604px;
  ">
</div>'), 'html') ?>
		<p>Remember: to get only path, you have to use an exclamation mark.</p>

	</section>

</article>
