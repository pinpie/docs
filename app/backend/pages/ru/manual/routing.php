[title[=Роутинг]]
[sidemenu[ru/manual/sidemenu]]
[menu routing[=
<ul>
	<li><a href="/ru/manual/routing#route-to-parent">Route to parent</a></li>
	<li><a href="/ru/manual/routing#url-class">URL Class</a></li>
</ul>
]]
<article>
	<header>
		<h1>
			<a name="" href="">#</a>
			Роутинг
		</h1>
  </header>

  <section>
    <p>Обработка URL подчиняется простым правилам:</p>
    <ul>
      <li>
        Если был запрошен <span><code>/about</code></span>, то PinPIE попробует заинклудить файл
        <span><code>/pages/about.php</span></code>
      </li>
      <li>Если такого нет, то проверяется путь <span><code>/pages/about/index.php</span></code>.</li>
    </ul>
    <p>
      Если ничего не было найдено, то заинклудится путь из конфига <?= scx('$pinpie["page not found"]') ?>, и будет автоматически
      установлен 404 код ответа HTTP.
    </p>
    <p>
      По умолчанию значение <?= scx('$pinpie["page not found"]') ?> это <span><code class="html">index.php</span></code>.
	    PinPIE ожидает, что этот файл находится прямо в корне в папке со страницами и использует его, если для запрошенного URL не нашлось подходящего файла страницы.
      Но я крайне рекомендую создать специальную страницу для обработки ненайденных страниц.
      Она будет отображаться в ответ на эти запросы.
    </p>
		<p>
			Замечу, что в <a href="/ru/manual/config">конфиге</a> ты можешь изменить <a href="/ru/manual/config#index">файл индекса папки</a>.
			Эта настройка позволяет задать название файла индекса, который используется в роутинге.
			Если задать другое значение, то именно файл с таким названием будет использован, если запрошенный путь это папка.
			Например, если задашь его равным <span class="xml"><code>someothername.php</code></span>,
			а URL запроса <span><code>/about</code></span> ведёт в папку, то PinPIE будет искать именно
			<span><code>/pages/about/someothername.php</code></span>, а не <span><code>/pages/about/index.php</code></span> в случае если
			<span><code>/pages/about.php</code></span> не существует.
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
      Если в конфиге установлено значение <?= scx('PinPIE::$config->pinpie["route to parent"]') ?> и оно  больше нуля,
      то PinPIE будет пробовать найти другие файлы, сообразно запрошенному пути.
    </p>
    <p>
      Это значит что если для URL <span><code>/very/long/url</span></code> не будет найдено ни
      <span><code>/pages/very/long/url.php</span></code>, ни <span><code>/pages/very/long/url/index.php</span></code>,
      то тогда от искомого пути будет отрезан один шаг дабы проверить
      <span><code>/pages/very/long.php</span></code> и <span><code>/pages/very/long/index.php</span></code>.
    </p>
    <p>
      Эта операция будет повторяться максимум <?= scx('PinPIE::$config->pinpie["route to parent"]') ?> раз,
	    и если не будет найден подходящий файл &mdash; запрошенный URL будет считаться ненайденным.
    </p>
    <p>
      Если первая оставшаяся часть запроса "/very" не будет найдена, то запрос <b>не будет</b> направляться на
      <span><code>/pages/index.php</span></code>. Он будет расценён как ненайденный.
    </p>
    <p>Возможные значения:</p>
    <ul>
      <li>0 &mdash; url не будет никуда перенаправлен. Ссылки типа "site.com/url" и "site.com/url/" расцениваются, как <b>разные</b> адреса.</li>
      <li>
        1 &mdash; адреса "site.com/url" и "site.com/url/" будут считаться <b>одинаковым</b> адресом
        (<a href="/ru/manual/config#default-pinpie-settings">значение по умолчанию</a>)
      </li>
      <li>2 и более &mdash; перенаправляется выше по пути</li>
    </ul>
    <p>
      Эта механика позволяет обрабатывать запросы вроде <span><code>/news/42</span></code> или <span><code>/news/42/edit</span></code>
      в одном файле <span><code>/pages/news.php</span></code> или <span><code>/pages/news/index.php</span></code>.
    </p>
    <p>Например, я предпочитаю делать так:</p>
    <ul>
      <li><span><code>/pages/news/index.php</span></code> для списка новостей по адресу <span><code>/news/</span></code></li>
      <li>тот же <span><code>/pages/news/index.php</span></code> для отдельной новости по адресу <span><code>/news/42</span></code> если номер новости указан</li>
      <li><span><code>/pages/news/edit.php</span></code> чтобы редактировать новость по адресу <span><code>/news/edit/42</span></code></li>
    </ul>
    <p>В файле <?=scx('/pages/news/index.php')?> для отрисовки списка и отдельной новости можно использовать разные <a href="/ru/manual/tags#snippet">сниппеты</a>. Сниппеты удобно <a href="/ru/manual/cache">кешировать</a>.</p>
  </section>

	<section>

		<header>
			<h1>
				<a name="url-class" href="#url-class">#</a>
				Класс URL
			</h1>
		</header>

		<p>
			Информация о текущем URL хранится в переменной PinPIE::$url.
			Некоторые поля этого класса это просто заполенны значениями, которые возвращает функция
			<a href="http://php.net/manual/en/function.parse-url.php">parse_url()</a>: scheme, host, port, user, pass, path, query и fragment.
			Так же поле <?= scx('parsed') ?> содержит весь массив, кторый возвращает parse_url(), так что его можно использовать в
			функции <a href="http://php.net/manual/en/function.parse-str.php">parse_str()</a>.
			Другие же - переменные PinPIE. Они доступны глобально через PinPIE::$url, например  PinPIE::$url->path. Вот полный список:
		</p>

		<ul>
			<li>url &mdash; тот самый URL, который парсили.</li>
			<li>file &mdash; Найденный файл страницы. Если же файл не был найден &mdash; значение будет false.</li>
			<li>found &mdash; Этот флаг будет true если файл был найден или false, если не был.</li>
			<li>foundUrl &mdash; Массив. Та часть URL, которая была найдена на диске, см. <a href="#route-to-parent">route to parent</a>.</li>
			<li>params &mdash; Массив с частями URL после foundUrl.</li>
			<li>parsed &mdash; Содержит массив, который вернула функция parse_url().</li>
		</ul>

		<h2>Пример</h2>

		<p>
			Допустим, есть файл <?= scx('/pages/some/file.php') ?>,
			и если запрошенный URL это <?= scx('/some/file/and/something/else', 'HTML') ?>,
			то переменные будут такими:
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