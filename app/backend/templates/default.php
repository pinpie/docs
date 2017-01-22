<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
		/* reset */
		* { margin: 0; padding: 0; }
		html { font-family: "Segoe UI", "Helvetica Neue", Helvetica, Arial, sans-serif; background-color: #FDFFFC; }
		html { font-size: 18px; }
		/* hide skip navigation link */
		body.nooutline :focus { outline: none; }
		body.nooutline a.aria-skipnav { display: none; }
		body.nooutline a.aria-skipnav :focus { display: block; }
		/* Layout */
		.HolyGrail, .HolyGrail-body { display: -webkit-flex; display: flex; -webkit-flex-direction: column; flex-direction: column; }
		.HolyGrail-body { margin-top: 3rem; padding: 0 0.5rem; }
		.HolyGrail-nav { display: none; order: -1; height: calc(100% - 3rem); position: fixed; top: 3rem; overflow: auto; width: 100%; }
		.HolyGrail-content { padding-top: 2rem; }
		main { padding: 0 1vw; }
		header a[name] { padding-top: 5rem; }
		/* Style */
		main h1 { color: #565554; }
		main section h1, main section h2, main section h3, main section h4, main section h5, main section h6 { color: #52489C; }
		/* * Header */
		#site-header { color: #e74c3c; position: fixed; height: 3rem; width: 100%; background-color: #191516; z-index: 100; }
		#site-header .logo { width: 5rem; margin-bottom: -3rem; filter: drop-shadow(0 0 4px black); }
		#site-header h1 a { color: inherit; text-decoration: none; }
		#site-header .hp-2 { display: none; }
		/* * Nav menu */
		.HolyGrail-nav { background-color: #FDFFFC; font-size: 150%; }
		#menu > ul { margin: 2rem 0; }
		#menu ul { list-style: none; }
		#menu > ul > li > a { padding-left: 0; }
		#menu > ul > li > ul > li > a { padding-left: 1rem; }
		#menu > ul > li > ul > li > ul > li > a { padding-left: 2rem; }
		#menu ul > li > a { color: #6A4A3C; display: block; line-height: 1.75em; text-align: left; text-decoration: none; }
		#menu ul > li > a:hover { color: #4062BB; }
		#menu ul > li.active > a { color: #CC333F; }
		#menu > ul > li > ul > li.active > a { border-left: 0.1rem solid; padding-left: 0.9rem; }
		#menu > ul > li > ul > li > ul > li.active > a { border-left: 0.1rem solid; padding-left: 1.9rem; }
		#menu ul > li > ul > li > ul > li { font-size: 75%; }
		/* * * Trigger and displaying menu state */
		#body.menu-show { overflow: hidden; }
		.HolyGrail-nav.menu-show { display: block; }
		#menu-trigger { float: right; margin-top: -1.65rem; font-size: 200%; cursor: default; }
		/* * Article */
		article a { color: #4062BB; text-decoration: none; }
		article a:hover { color: #4062BB; text-decoration: underline; }
		article header a[name] { color: lightgrey; }
		article header a[name]:hover { color: grey; }
		article > header > h1 { font-size: 2rem; padding-bottom: 0.5rem; }
		article > header { padding-top: 0; padding-bottom: 0.1rem; margin-bottom: 1rem; border-bottom: 1px solid #eeeeee; }
		/* * * Section */
		section h1 { font-weight: 500; font-size: 1.5rem; margin-top: 3rem; margin-bottom: 0.5rem; }
		section h2 { font-weight: 500; font-size: 1.25rem; margin-top: 1rem; margin-bottom: 0.5rem; }
		section h3 { font-weight: 500; font-style: italic; font-size: 1rem; margin-top: 1rem; margin-bottom: 0.5rem; }
		section p { margin-bottom: 0.5rem; }
		section ol, section ul { padding-left: 1rem; margin-bottom: 0.5rem; }
		/* * Code blocks */
		span > code, span > code.hljs { display: inline; padding: 0 0.3rem; background: #f8f8f8; font-size: 90%; border-radius: 0.3rem; }
		span > code a { color: inherit; text-decoration: underline; }
		pre > code { display: block; overflow: auto; margin: 0 0 0.5rem; padding: 0.5em; border: 1px solid lightgrey; }
		pre > code.hljs { background: inherit; }
		pre > code a { color: inherit; text-decoration: underline; }
		/* Desktop layout */
		@media (min-width: 1281px) {
			html { font-size: 16px; }
			.HolyGrail-body { -webkit-flex-direction: row; -webkit-flex: 1; flex-direction: row; flex: 1; padding: 0; }
			.HolyGrail-content { -webkit-flex: 1; flex: 1; min-width: 1px; }
			.HolyGrail-nav, .HolyGrail-ads { -webkit-flex: 0 0 20vw; flex: 0 0 20vw; font-size: 110%; }
			.HolyGrail-nav { /* fix mobile settings back */ position: static; display: block; height: auto; }
			main { padding: 0 2vw; }
			#menu { position: fixed; overflow: auto; height: calc(100% - 3rem); padding: 0 2rem; }
			#menu > ul { margin: 2rem 0; }
			#site-header .hp-1 { margin-right: 5vw; }
			#site-header .hp-2 { display: inline; }
			#menu-trigger { display: none; }
		}
		footer { padding: 3rem 20% 1rem; }
		footer .logo { display: inline-block; float: left; padding-right: 3rem;}
		footer .logo img {margin-bottom: -5px;}
	</style>

	<style>
		/*

github.com style (c) Vasily Polovnyov <vast@whiteants.net>

*/

		.hljs {
			display: block;
			overflow-x: auto;
			padding: 0.5em;
			color: #333;
			background: #f8f8f8;
		}
		.hljs-comment,
		.hljs-quote {
			color: #998;
			font-style: italic;
		}
		.hljs-keyword,
		.hljs-selector-tag,
		.hljs-subst {
			color: #333;
			font-weight: bold;
		}
		.hljs-number,
		.hljs-literal,
		.hljs-variable,
		.hljs-template-variable,
		.hljs-tag .hljs-attr {
			color: #008080;
		}
		.hljs-string,
		.hljs-doctag {
			color: #d14;
		}
		.hljs-title,
		.hljs-section,
		.hljs-selector-id {
			color: #900;
			font-weight: bold;
		}
		.hljs-subst {
			font-weight: normal;
		}
		.hljs-type,
		.hljs-class .hljs-title {
			color: #458;
			font-weight: bold;
		}
		.hljs-tag,
		.hljs-name,
		.hljs-attribute {
			color: #000080;
			font-weight: normal;
		}
		.hljs-regexp,
		.hljs-link {
			color: #009926;
		}
		.hljs-symbol,
		.hljs-bullet {
			color: #990073;
		}
		.hljs-built_in,
		.hljs-builtin-name {
			color: #0086b3;
		}
		.hljs-meta {
			color: #999;
			font-weight: bold;
		}
		.hljs-deletion {
			background: #fdd;
		}
		.hljs-addition {
			background: #dfd;
		}
		.hljs-emphasis {
			font-style: italic;
		}
		.hljs-strong {
			font-weight: bold;
		}

	</style>

	[bottom[%js=/libs/highlight/highlight.pack.js]]

	[[*head]]
	<title>PinPIE - [[*title]]</title>
	<link rel="apple-touch-icon" sizes="57x57" href="//s0.pinpie.ru/favicon/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="//s0.pinpie.ru/favicon/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="//s0.pinpie.ru/favicon/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="//s0.pinpie.ru/favicon/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="//s0.pinpie.ru/favicon/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="//s0.pinpie.ru/favicon/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="//s0.pinpie.ru/favicon/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="//s0.pinpie.ru/favicon/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="//s0.pinpie.ru/favicon/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="36x36" href="//s0.pinpie.ru/favicon/android-icon-36x36.png">
	<link rel="icon" type="image/png" sizes="48x48" href="//s0.pinpie.ru/favicon/android-icon-48x48.png">
	<link rel="icon" type="image/png" sizes="72x72" href="//s0.pinpie.ru/favicon/android-icon-72x72.png">
	<link rel="icon" type="image/png" sizes="96x96" href="//s0.pinpie.ru/favicon/android-icon-96x96.png">
	<link rel="icon" type="image/png" sizes="144x144" href="//s0.pinpie.ru/favicon/android-icon-144x144.png">
	<link rel="icon" type="image/png" sizes="192x192" href="//s0.pinpie.ru/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="//s0.pinpie.ru/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="//s0.pinpie.ru/favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="//s0.pinpie.ru/favicon/favicon-16x16.png">
	<link rel="manifest" href="//s0.pinpie.ru/favicon/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="//s0.pinpie.ru/favicon/ms-icon-310x310.png">
	<meta name="theme-color" content="#ffffff">
	<!-- temporarily link is hidden, author of this icon is https://github.com/paomedia/small-n-flat -->

</head>

<body id="body" class="HolyGrail nooutline">
<a class="aria-skipnav" href="#main-content">Skip to main content</a>

<header id="site-header">
	<h1>
		<img class="logo" src="[[!%img=/1473470442_pin.svg]]">
		<span class="hp-1"><a href="//pinpie.ru/">PinPIE</a></span>
		<span class="hp-2"><a href="//pinpie.ru/">When PHP Is Enough</a></span>
		<span id="menu-trigger" onclick="menu.menuShow()">=</span>
	</h1>
</header>

<div class="HolyGrail-body">
	<div class="HolyGrail-nav">
		<nav id="menu" aria-label="Main Navigation">[[*sidemenu]]</nav>
	</div>
	<div class="HolyGrail-content">
		<main>
			<a name="main-content"></a>
			[[*content]]
			<br><br><br>
			<div id="disqus">[[$disqus]]</div>
		</main>
	</div>
	<aside class="HolyGrail-ads"></aside>
</div>
<footer>
	<div class="logo">[[%img=/1473470442_pin.svg]] PinPIE</div>
	<div class="links"><a href="/copyrights">Credits and Copyrights</a></div>
</footer>

[[stats/yandex]]
[[*bottom]]
<script>

	function MenuJS() {
		var self = this;
		self.navLinks = document.querySelectorAll('#menu a');
		self.navItems = document.querySelectorAll('#menu li');
		self.hllinks = function (href) {
			if (typeof href === 'undefined') {
				href = window.location.href;
			}
			var i = 0;
			for (i = self.navItems.length; i--;) {
				self.navItems[i].classList.remove('active');
			}
			var parentCounter = 0, parentLimit = 2;
			for (i = self.navLinks.length; i--;) {
				if (self.navLinks[i].href === href) {
					var el = self.navLinks[i];
					parentCounter = 0;
					while (el) {
						if (el.tagName == 'LI') {
							el.classList.add('active');
							parentCounter++;
							if (parentCounter > parentLimit) {
								break;
							}
						}
						el = el.parentNode;
					}
				}
			}
		};
		/**/

		self.navAnchors = document.querySelectorAll('header a[name]');
		self.navAnchorsMax = self.navAnchors.length;
		self.hllinks_scroll_timer = 0;
		self.hllinks_scroll = function () {
			window.cancelAnimationFrame(self.hllinks_scroll_timer);
			self.hllinks_scroll_timer = window.requestAnimationFrame(self.hllinks_scroll_real);
		};
		self.hllinks_scroll_real = function () {
			var el = null;
			var fringe = window.scrollY + window.innerHeight / 6;

			for (var i = 0; i < self.navAnchorsMax; i++) {
				if (self.navAnchors[i].offsetTop > fringe) {
					break;
				}
				for (var ii = self.navLinks.length; ii--;) {
					if (self.navLinks[ii].href === self.navAnchors[i].href) {
						el = self.navAnchors[i];
					}
				}
			}
			if (el) {
				self.hllinks(el.href);
			}
		};

		self.navBlock = document.getElementsByClassName("HolyGrail-nav")[0];
		self.menuTrigger = document.getElementById("menu-trigger");
		self.body = document.getElementById("body");
		self.menuVisible = false;
		self.menuShow = function () {
			if (self.navBlock.classList.contains('menu-show')) {
				self.menuVisible = false;
				self.navBlock.classList.remove("menu-show");
				self.menuTrigger.classList.remove("menu-show");
				self.body.classList.remove("menu-show");
			} else {
				self.menuVisible = true;
				self.navBlock.classList.add("menu-show");
				self.menuTrigger.classList.add("menu-show");
				self.body.classList.add("menu-show");
				for (var i = 0; i < self.navItems.length; i++) {
					if (self.navItems[i].classList.contains('active')) {
						self.navBlock.scrollTop = self.navItems[i].offsetTop - window.innerHeight / 3;
					}
				}
			}
		};

		window.addEventListener("hashchange", self.hllinks);
		window.addEventListener('scroll', self.hllinks_scroll);
		document.addEventListener('DOMContentLoaded', function () {
			self.hllinks_scroll_real();
			for (var i = self.navLinks.length; i--;) {
				self.navLinks[i].addEventListener('click', function () {
					if (self.navBlock.classList.contains('menu-show')) {
						self.navBlock.classList.remove("menu-show");
						self.menuTrigger.classList.remove("menu-show");
						self.body.classList.remove("menu-show");
					}
				});
			}
		})
	}

	var menu = new MenuJS();

	document.addEventListener('DOMContentLoaded', function () {
		/* catch {tab} key pressed and show "skip navigation" link */
		document.body.classList.add('nooutline');
		document.body.addEventListener('keydown', function (e) {
			if (e.keyCode == 9) {
				document.body.classList.remove('nooutline');
			}
		});
		/* highlight code blocks */
		var codeblocks = document.querySelectorAll('code');
		for (var i = codeblocks.length; i--;) {
			hljs.highlightBlock(codeblocks[i]);
		}
	});

</script>
</body>
</html>
