<!DOCTYPE html>
<html>
<head>
	<meta name=viewport content="width=device-width, initial-scale=1">
	<style>
		html { font-size: calc((100vw - 300px) / (1920 - 300) * (20 - 14) + 14px); font-family: "Segoe UI", "Helvetica Neue", Helvetica, Arial, sans-serif; }
		body.nooutline :focus { outline: none; }
		.HolyGrail, .HolyGrail-body { display: flex; flex-direction: column; }
		.HolyGrail-nav { order: -1; font-size: 200%; }
		@media (min-width: 768px) {
			.HolyGrail-body { flex-direction: row; flex: 1; }
			.HolyGrail-content { flex: 1; }
			.HolyGrail-nav, .HolyGrail-ads { flex: 0 0 auto; font-size: 100%; }
		}
		main { padding: 0 1rem; }
		#site-header { color: grey; }
		#site-header > h1 > a { color: inherit; text-decoration: inherit; }
		#site-header > h1 > a:hover { text-decoration: underline; }
		#menu ul { list-style: none; }
		#menu > ul { padding-left: 0; }
		#menu > ul ul { padding-left: 1rem; }
		#menu ul > li > a { color: #767676; display: block; width: 100%; line-height: 1.75em; text-align: left; text-decoration: none; }
		#menu > ul > li > a { color: #565656; }
		#menu > ul > li > ul > li > a { color: #565656; }
		#menu ul > li > a:hover { color: #23527c; }
		#menu ul > li > a.active { color: #337ab7; }
		#menu ul > li > ul > li > ul > li { font-size: 0.75rem; }
		article a { color: #337ab7; text-decoration: none; }
		article a:hover { color: #23527c; text-decoration: underline; }
		span > code, span > code.hljs { display: inline; margin: 0; padding: 0 0.3rem; background: #f8f8f8; font-size: 90%; border-radius: 0.3rem; }
		span > code a { color: inherit; text-decoration: underline; }
		pre > code { display: block; margin: 0 0 0.5rem; padding: 0.5em; border: 1px solid lightgrey; white-space: pre-wrap; overflow: hidden;}
		pre > code.hljs { background: inherit; }
		pre > code a { color: inherit; text-decoration: underline; }
		article > header > h1 { font-size: 2rem; padding-bottom: 0.5rem; }
		article > header { padding-top: 0; padding-bottom: 0.1rem; margin-bottom: 1rem; border-bottom: 1px solid #eeeeee; }
		section > header a[name] { color: lightgrey; }
		section > header a[name]:hover { color: grey; }
		section h1 { font-weight: 500; font-size: 1.5rem; margin-top: 3rem; margin-bottom: 0.5rem; }
		section h2 { font-weight: 500; font-size: 1.25rem; margin-top: 1rem; margin-bottom: 0.5rem; }
		section h3 { font-weight: 500; font-style: italic; font-size: 1rem; margin-top: 1rem; margin-bottom: 0.5rem; }
		section p { margin-bottom: 0.5rem; }
		section ol, section ul { padding-left: 1rem; margin-top: 0; margin-bottom: 0.5rem; }
	</style>

	[[%css=/libs/highlight/styles/github.css]]
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
	<link rel="icon" type="image/png" sizes="192x192" href="//s0.pinpie.ru/favicon/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="//s0.pinpie.ru/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="//s0.pinpie.ru/favicon/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="//s0.pinpie.ru/favicon/favicon-16x16.png">
	<link rel="manifest" href="//s0.pinpie.ru/favicon/manifest.json">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="msapplication-TileImage" content="//s0.pinpie.ru/favicon/ms-icon-144x144.png">
	<meta name="theme-color" content="#ffffff">
	<!-- temporarily link is hidden, author of this icon is https://github.com/paomedia/small-n-flat -->
</head>

<body class="HolyGrail">
<header id="site-header"><h1><a href="//pinpie.ru/">PinPIE - when PHP Is Enough</a></h1></header>
<div class="HolyGrail-body">
	<nav class="HolyGrail-nav" id="menu">[[*sidemenu]]</nav>
	<main class="HolyGrail-content">
		[[*content]]
		<div id="disqus">[[$disqus]]</div>
	</main>
	<aside class="HolyGrail-ads"></aside>
</div>

<footer>…</footer>
[[stats/yandex]]
[[*bottom]]
<script>
	function hllinks() {
		var links = document.querySelectorAll('#menu a');
		for (var i = links.length; i--;) {
			links[i].classList.remove('active');
			if (links[i].href === window.location.href) {
				links[i].classList.add('active');
			}
		}
	}

	window.addEventListener("hashchange", function () {
		hllinks();
	});

	document.addEventListener('DOMContentLoaded', function () {
		document.body.classList.add('nooutline');
		document.body.addEventListener('keydown', function (e) {
			if (e.keyCode == 9) {
				document.body.classList.remove('nooutline');
			}
		});

		hllinks();
		var codeblocks = document.querySelectorAll('code');
		for (var i = codeblocks.length; i--;) {
			hljs.highlightBlock(codeblocks[i]);
		}
	});
</script>
</body>
</html>
