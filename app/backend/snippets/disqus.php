<div id="disqus_thread" style="min-height: 324px;"></div>
<script>
	<?php
	$path = json_encode(h(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)));

	echo '
  var disqus_config = function () {
    this.page.url = "http:\/\/pinpie.rocks" + ' . $path . ';
    this.page.identifier = ' . $path . ';
  };';
	?>

	(function () { // DON'T EDIT BELOW THIS LINE
		var d = document, s = d.createElement('script');
		s.src = '//pinpie.disqus.com/embed.js';
		s.setAttribute('data-timestamp', +new Date());
		(d.head || d.body).appendChild(s);
	})();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
