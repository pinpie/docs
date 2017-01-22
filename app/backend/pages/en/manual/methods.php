[title[=Methods]]
[sidemenu[en/manual/sidemenu]]
[menu methods[=
<ul>
	<li><a href="/en/manual/methods#cacherGet">cacherGet</a></li>
	<li><a href="/en/manual/methods#cacherSet">cacherSet</a></li>
	<li><a href="/en/manual/methods#checkPathIsInFolder">checkPathIsInFolder</a></li>
	<li><a href="/en/manual/methods#getUrlInfo">getUrlInfo</a></li>
	<li><a href="/en/manual/methods#newInstance">newInstance</a></li>
	<li><a href="/en/manual/methods#newPage">newPage</a></li>
	<li><a href="/en/manual/methods#parseString">parseString</a></li>
	<li><a href="/en/manual/methods#report">report</a></li>
	<li><a href="/en/manual/methods#reportTags">reportTags</a></li>
	<li><a href="/en/manual/methods#templateGet">templateGet</a></li>
	<li><a href="/en/manual/methods#templateSet">templateSet</a></li>
	<li><a href="/en/manual/methods#varPut">varPut</a></li>
</ul>
]]
<article>
	<header>
		<h1>
			<a name="" href="">#</a>
			Methods
		</h1>
	</header>
	<p>
		Here is the list of methods to interact with PinPIE engine.
		However, in most cases any direct interaction with PinPIE is not required.
	</p>

	<section>
		<header>
			<h1>
				<a name="cacherGet" href="#cacherGet">#</a>
				PinPIE::cacherGet<wbr>()
			</h1>
		</header>
		<p>Provides access to current cacher object.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="cacherSet" href="#cacherSet">#</a>
				PinPIE::cacherSet<wbr>(pinpie\pinpie\Cachers\Cacher $cacher)
			</h1>
		</header>
		<p>
			Allows to set <a href="/en/manual/cache#cacher-custom">custom cacher</a> object.
			Usually cacher is set in <a href="/en/manual/config#pinpie-cache">config</a>. This way allows to change it in runtime.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="checkPathIsInFolder" href="#checkPathIsInFolder">#</a>
				PinPIE::checkPathIsInFolder<wbr>($path, $folder)
			</h1>
		</header>
		<p>
			Checks if path really belongs to other path.
			Uses <a href="http://php.net/manual/en/function.realpath.php">realpath()</a>
			function, so symlinks will be translated to real system path.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="getUrlInfo" href="#getUrlInfo">#</a>
				PinPIE::getUrlInfo<wbr>($template)
			</h1>
		</header>
		<p>Looks for page file corresponding provided url path. Returns URL instance or false on fail.</p>
		<p>In case of no page file were found, you can use config value:</p>
		<?= pcx('PinPIE::$conf->pinpie["page not found"]') ?>
	</section>

	<section>
		<header>
			<h1>
				<a name="newInstance" href="#newInstance">#</a>
				PinPIE::newInstance<wbr>($settings)
			</h1>
		</header>
		<p>
			Creates engine instance. Used in general environment, where PHP is instantiated for each request.
			<a href="/en/manual/config#config-direct">Read more..</a>
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="newPage" href="#newPage">#</a>
				PinPIE::newPage<wbr>($page)
			</h1>
			<b><i>experimental</i></b>
		</header>
		<p>
			Switches a page instead of current. Experimental, but works fine.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="parseString" href="#parseString">#</a>
				PinPIE::parseString<wbr>($string)
			</h1>
		</header>
		<p>Parses string and returns rendered result.</p>
		<h2>Example</h2>
		<?= pcx('echo PinPIE::parseString(\'Answer: [[5$rand]]\');') ?>
		<p>Output:</p>
		<?= pcx('Answer: 42', 'html') ?>
	</section>

	<section>
		<header>
			<h1>
				<a name="report" href="#report">#</a>
				PinPIE::report()
			</h1>
		</header>
		<p>
			Shows debug report: tag execution time; from cache or not; errors; full tags list with their internal fields.
			To be used for debug purposed. Set $debug = true in config to enable debug output. By default will do nothing and return false.
		</p>
		<p>
			Some reports are generated using var_dump(), so xDebug is recommended &mdash; it will do everything beautiful.
			Don't forget to disable xDebug in production because of its huge impact to performance.
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
			Dumps tags and their params. To be used for debug purposed.
			Set $debug = true in config to enable debug output. By default will do nothing and return false.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="templateGet" href="#templateGet">#</a>
				PinPIE::templateGet()
			</h1>
		</header>
		<p>Returns current <a href="/en/manual/templates#page-templates">page template</a> or false.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="templateSet" href="#templateSet">#</a>
				PinPIE::templateSet($template)
			</h1>
		</header>
		<p>Sets <a href="/en/manual/templates#page-templates">page template</a>. May be a string or false.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="varPut" href="#varPut">#</a>
				PinPIE::varPut($name, $content)
			</h1>
		</header>
		<p>Puts string into the placeholder.</p>
		<h2>Example</h2>
		<p>PHP-code:</p>
		<?= pcx('PinPIE::varPut("pltest", "some text");') ?>
		<p>Placeholder:</p>
		<?= pcx('[[*pltest]]') ?>
		<p>Output:</p>
		<?= pcx('some text', 'html') ?>
	</section>

</article>