[title[=Server configuration]]
[sidemenu[en/manual/sidemenu]]
[menu server configuration[=
<ul>
	<li><a href="#important"><span style="font-family: monospace;">!important;</span></a></li>
	<li><a href="#apache">Apache</a></li>
	<li><a href="#nginx">Nginx</a></li>
</ul>
]]
<article>
	<header>
		<h1>
			<a name="" href="">#</a>
			Server configuration for PinPIE
		</h1>
	</header>

	<section>
		<header>
			<h1>
				<a name="important" href="#important">#</a>
				<span style="font-family: monospace;">!important;</span>
			</h1>
		</header>
		<p>Provided configurations was not tested for security penetration and may contain security issues.</p>
	</section>

	<section>
		<header>
			<h1>
				<a name="apache" href="#apache">#</a>
				Apache
			</h1>
		</header>
		<h2>Simple config</h2>
		<?= pcx(h('<VirtualHost *:80>
	ServerName site.com
	DocumentRoot "/var/www/site.com"
	<Directory "/var/www/site.com">
	RewriteEngine On
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule . /index.php [L]
	</Directory>
</VirtualHost>'), 'apache') ?>

		<h2>Config with static servers sharding</h2>
		<?= pcx(h('<VirtualHost *:80>
	ServerName site.com
	DocumentRoot "/var/www/site.com/frontend"
	<Directory
	"/var/www/site.com/frontend">
	RewriteEngine On
	RewriteRule . /index.php [L]
	</Directory>
</VirtualHost>

<VirtualHost *:80>
	ServerName s0.site.com
	ServerAlias s1.site.com s2.site.com s3.site.com
	DocumentRoot "/var/www/site.com/backend"
	<Directory "/var/www/site.com/backend">
	Order Allow,Deny
	Allow From All
	Options -Indexes
	</Directory>
</VirtualHost>'), 'apache') ?>
	</section>

	<section>
		<header>
			<h1>
				<a name="nginx" href="#nginx">#</a>
				Nginx
			</h1>
		</header>
		<h2>Simple config</h2>
		<pre><code class="nginx">server {
  server_name     site.com;
  root     /var/www/site.com/;

  location / {
    include            /etc/nginx/fastcgi_params;
    fastcgi_pass       unix:/var/run/php-fpm.sock;
    fastcgi_param      SCRIPT_FILENAME  $document_root/index.php;
  }
}</code></pre>

		<h2>Config with static servers sharding</h2>
		<pre><code class="nginx">server {
  server_name     site.com;
  root     /var/www/site.com/backend;

  location / {
    include            /etc/nginx/fastcgi_params;
    fastcgi_pass       unix:/var/run/php-fpm.sock;
    fastcgi_param      SCRIPT_FILENAME  $document_root/index.php;
  }
}

server {
  server_name s0.site.com s1.site.com s2.site.com s3.site.com;
  root /var/www/site.com/frontend;
}</code></pre>

	</section>

</article>


