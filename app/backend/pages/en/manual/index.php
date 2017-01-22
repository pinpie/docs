[title[=About]]
[sidemenu[en/manual/sidemenu]]
<article>
	<header>
		<h1>
			<a name="" href="">#</a>
			PinPIE
		</h1>
		<p>PinPIE &mdash; when PHP is enough.</p>
	</header>
	<section>
		<header>
			<h1>
				<a name="about" href="#about">#</a>
				About
			</h1>
		</header>
		<p>
			PinPIE is lightweight php-based engine for small sites. All pages and URL handlers are stored in *.php files. Caching also included, and cache control is simple and clear.
		</p>
	</section>
	<section>
		<header>
			<h1>
				<a name="quick-overview" href="#quick-overview">#</a>
				Overview
			</h1>
		</header>
		<p>
			PinPIE is not a framework, nor it is a CMS. PinPIE is a site engine, designed to be quick and efficient even on cheap hostings.
		</p>
		<p>
			PinPIE stores all contend in php-files.
			If opcode cacher is used &mdash; it will cache this files.
			That allows PinPIE to include pages, snippets and chunks in the blink of an eye.
		</p>
		<p>
			Content stored in files allows you to edit your content using favorite IDE or text editor with all that highlighting, auto-formatting, auto-saving, auto-uploading features and familiar hotkeys. Also that allows to benefit from full debug support including exact line numbers and IDE code execution flow controls.
			This approach is friendly to version control systems — you can have versions of all your content to be safe and protected against loosing something while editing anything. Deployment friendly. Backup friendly.
		</p>
		<p>
			PinPIE have tag-based parser. Tag syntax is inspired by <a href="https://modx.com/">ModX</a> tag system.
			Basic tags are:</p>
		<ul>
			<li>Chunks — a pieces of plain text</li>
			<li>Snippets — a pieces of php code to execute</li>
		</ul>
		<p>Read more in <a href="/en/manual/tags">tags readme</a>.</p>
		<p>
			PinPIE provide clear and controllable automatic snippet caching.
			Caching can be enabled or disabled for each snippet tag separately.
			Caching control is predictable and simple.
			PinPIE will automatically recache only changed content.
			Read more in <a href="/en/manual/cache">cache readme</a>.
		</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="starting" href="#starting">#</a>
				Start using PinPIE
			</h1>
		</header>
		<p>
			You can install PinPIE with composer or download code from GitHub.
			You can find more detailed instructions in <a href="/en/manual/start">start unsing PinPIE docs</a>.
		</p>
	</section>
</article>





