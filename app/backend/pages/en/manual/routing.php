[title[=Routing]]
[sidemenu[en/manual/sidemenu]]
[menu routing[=
<ul>
	<li><a href="/en/manual/routing#route-to-parent">Route to parent</a></li>
	<li><a href="/en/manual/routing#url-class">URL Class</a></li>
</ul>
]]
<article>
	<header>
		<h1>
			<a name="" href="">#</a>
			Routing
		</h1>
	</header>

	<section>
		<p>URL processing is quite simple:</p>
		<ul>
			<li>
				If requested URL is <span><code>/about</code></span>, then PinPIE will try to include
				<span><code>/pages/about.php</code></span> file
			</li>
			<li>If it doesn't exist, path <span><code>/pages/about/index.php</code></span> will be checked and used</li>
		</ul>
		<p>
			If none of this was found, then config value <?= scx('$pinpie["page not found"]') ?> will be included,
			and HTTP response code will be set to 404.
		</p>
		<p>
			Default value of <?= scx('$pinpie["page not found"]') ?> is <span><code class="html">index.php</code></span>.
			PinPIE will look for that file in the root of pages folder and use it when required file was not located.
			And I strongly recommend you to create a special page to handle "not found" requests.
			The "not found" page will be shown at requested URL.
		</p>
		<p>
			Also in <a href="/en/manual/config">config</a> you can change <a href="/en/manual/config#index">index file name</a>.
			This option allow to set directory index file name, used in routing process.
			If you change it to any other value, this value will be used while checking directory path. E.g. if you set it to
			<span class="xml"><code>someothername.php</code></span>, PinPIE will look for <span><code>/pages/about/someothername.php</code></span>
			instead of <span><code>/pages/about/index.php</code></span> in case if <span><code>/pages/about.php</code></span> doesn't exist.
		</p>

	</section>
	<section>
		<header>
			<h1>
				<a name="route-to-parent" href="#route-to-parent">#</a>
				Route to parent
			</h1>
		</header>
		<p>
			If option <?= scx('PinPIE::$conf->pinpie["route to parent"]') ?> is defined in config and is greater than zero,
			then PinPIE will try to find some file, according to requested path.
		</p>
		<p>
			That means if for URL <span><code>/very/long/url</code></span> there will be not found both <span><code>/pages/very/long/url.php</code></span>
			and <span><code>/pages/very/long/url/index.php</code></span> paths, then searching path will be shortened
			for one step to check <span><code>/pages/very/long.php</code></span> and <span><code>/pages/very/long/index.php</code></span> respectively.
		</p>
		<p>
			This operation will be repeated for maximum <?= scx('PinPIE::$conf->pinpie["route to parent"]') ?> times,
			and if no existing file will be found &mdash; the requested URL will be considered as "not found".
		</p>
		<p>
			If the first part of request URL "/very" is not found, request will <b>not</b> be routed to <span><code>/pages/index.php</code></span>.
			It will be also considered as "not found".
		</p>
		<p>Possible values:</p>
		<ul>
			<li>0 &mdash; exact match required, url "site.com/url" and "site.com/url/" are treated as different</li>
			<li>1 &mdash; urls like "site.com/url" and "site.com/url/" will be handled as the same (<a href="/en/manual/config#default-pinpie-settings">default</a>)</li>
			<li>&gt; 1 &mdash; routed up this many times maximum</li>
		</ul>
		<p>
			This mechanics allow you to handle requests like <span><code>/news/42</code></span> or <span><code>/news/42/edit</code></span> in one file
			located at <span><code>/pages/news.php</code></span> or <span><code>/pages/news/index.php</code></span>.
		</p>
		<p>But I prefer to have:</p>
		<ul>
			<li><span><code>/pages/news/index.php</code></span> for news listing at url <span><code>/news/</code></span></li>
			<li>the same <span><code>/pages/news/index.php</code></span> as news entry page at url <span><code>/news/42</code></span> if entry id were provided</li>
			<li><span><code>/pages/news/edit.php</code></span> to edit one at url <span><code>/news/42/edit</code></span></li>
		</ul>
		<p>Your code will remain clean, if you will use <a href="/en/manual/tags#snippet">snippets</a>.</p>
	</section>

	<section>

		<header>
			<h1>
				<a name="url-class" href="#url-class">#</a>
				URL class and info
			</h1>
		</header>

		<p>
			Current URL info is stored in PinPIE::$url variable. Some fields of this class are just shortcuts to info, provided by
			<a href="http://php.net/manual/en/function.parse-url.php">parse_url()</a> function: scheme, host, port, user, pass, path, query and fragment.
			Also field <?= scx('parsed') ?> contains array returned by parse_url(), so you can use it in
			<a href="http://php.net/manual/en/function.parse-str.php">parse_str()</a> function.
			Some others are PinPIE variables. They are available through PinPIE::$url, e.g. PinPIE::$url->path. Here is the list:
		</p>

		<ul>
			<li>url &mdash; URL string which one was parsed.</li>
			<li>file &mdash; Found file. If file was not found &mdash; will be false.</li>
			<li>found &mdash; Flag value, will be true if file were found, or false if not.</li>
			<li>foundUrl &mdash; Array, found part of URL, see <a href="#route-to-parent">route to parent</a>.</li>
			<li>params &mdash; Array with parts of URL after foundUrl.</li>
			<li>parsed &mdash; Contains array returned by parse_url() function.</li>
		</ul>

		<h2>Example</h2>

		<p>
			Assuming, there is file <?= scx('/pages/some/file.php') ?>,
			and if requested URL is <?= scx('/some/file/and/something/else', 'HTML') ?>,
			so the values will be:
		</p>
		<ul>
			<li>PinPIE::$url->url &mdash; (string) <?= scx('/some/file/and/something/else', 'HTML') ?></li>
			<li>PinPIE::$url->file &mdash; (string) <?= scx('/pages/some/file.php') ?></li>
			<li>PinPIE::$url->found &mdash; (boolean) <?= scx('true') ?></li>
			<li>PinPIE::$url->foundUrl &mdash; (array) <?= scx('["some", "file"]') ?></li>
			<li>PinPIE::$url->params &mdash; (array) <?= scx('["and", "something", "else"]') ?></li>
		</ul>
	</section>
</article>