[title[=Кэш]]
[sidemenu[ru/manual/sidemenu]]
[menu cache[=
<ul>
  <li><a href="/ru/manual/cache#simple">Просто</a></li>
  <li><a href="/ru/manual/cache#usage">Использование</a></li>
  <li><a href="/ru/manual/cache#separate-caching">Раздельное кэширование</a></li>
  <li><a href="/ru/manual/cache#hash">Хэш</a></li>
  <li><a href="/ru/manual/cache#cache-storage">Где хранится</a></li>
  <li><a href="/ru/manual/cache#cacher-disabled">Кэшер Disabled</a></li>
  <li><a href="/ru/manual/cache#cacher-files">Кэшер Files</a></li>
  <li><a href="/ru/manual/cache#cacher-memcached">Кэшер Memcached</a></li>
  <li><a href="/ru/manual/cache#cacher-custom">Свой кэшер</a></li>
  <li><a href="/ru/manual/cache#cache-rules">Правила кэша</a></li>
</ul>
]]

<article>
  <header><h1>Кэш</h1></header>
  <p>
    PinPIE автоматически прозрачно и управляемо кеширует сниппеты.
  </p>
  <p>
    А вот чанки никогда не кэшируются. Предполагается, что чанки это просто кусочки текста.
    Чанки хранятся в "*.php" файлах, и обычно кешируются опкод кешерами, такими как APC, XCache, eAccelerator и т.п.
    С версии 5.5.0 PHP идёт вместе с кэшером опкодов Zend.
    Поэтому чанки никак дополнительно не кэшируются. Если кэширование всё же требуется &mdash; используйте сниппет.
  </p>
  <p>
    Код страниц исполняется каждый раз. Если требуется кэшировать некий тяжёлый код &mdash; используйте сниппет.
    Если не требуется выполнять php-код каждый раз &mdash; используйте
    <a href="https://www.yandex.ru/yandsearch?text=генератор%20статических%20сайтов" target="_blank" title="yandex">генератор статических сайтов</a>.
  </p>
  <p>
    При записи в кэш также сохраняется информация о путях всех дочерних тегов (и их детей тоже).
    Соответственно, все эти файлы будут проверены на существование и время изменения.
    Если любой из них изменился после кэширования, то сниппет будет перерисован, и кэш будет обновлён.
  </p>

  <section>
    <header>
      <h1>
        <a name="simple" href="#simple">#</a>
        Просто
      </h1>
    </header>
    <p>
      Основная идея PinPIE &mdash; это простота.
      Именно поэтому, кэширование в PinPIE носит очевидный и предсказуемый характер.
      Одновременно с этим, оно весьма удобно.
      Для лучшего представления о том, как работает кэш, нужно знать вот эти простые вещи:
    </p>
    <ul>
      <li>Если сниппет закэшировался &mdash; он закешировался так, как был нарисован.</li>
      <li>Если файл сниппета изменился &mdash; он будет перерисован.</li>
      <li>Если в сниппете есть дочерние теги &mdash; они будут отрисованы единожды, и будут закешированы в выводе этого сниппета.</li>
      <li>Если у сниппета есть дочерние теги (на любой глубине) и один из их файлов изменился &mdash; сниппет будет перерисован.</li>
    </ul>
    <p>
      Это означает, что вам больше не нужно как-то управляться с кэшем, когда вы хоть что-либо где-то немного поменяли.
      <b>PinPIE обнаружит изменения, перерисует и перекеширует всё сам автоматически.</b>
    </p>
    <p>
      Если вы хотите очистить кэш &mdash; просто удалите все файлы из папки "/filecache", или перезапустите Memcached, и т.п.
    </p>
  </section>

  <section>
    <header>
      <h1>
        <a name="usage" href="#usage">#</a>
        Использование
      </h1>
    </header>
    <p>Чтобы закешировать сниппет, нужно выставить в теге желаемое время в секундах: <?= scx('[[<b>тут</b>$snippet]]') ?>.</p>
    <p>На текущий момент есть три варианта:</p>
    <ul>
      <li><?= scx('[[$some_snippet]]') ?> &mdash; кеширование отключено, сниппет будет выполняться каждый раз</li>
      <li><?= scx('[[<b>3600</b>$some_snippet]]') ?> &mdash; сниппет закеширован на один час</li>
      <li>
        <?= scx('[[!$some_snippet]]') ?> &mdash; закэширован навечно. Сниппет кэшируется на
        <span><code>CFG::$pinpie['cache forever time']</code></span> секунд,
        что по-умолчанию равно <a href="http://php.net/manual/ru/reserved.constants.php#constant.php-int-max" target="_blank">PHP_INT_MAX</a>. Для 32-битных систем это около 68 лет, а для 64-битных это ещё дольше.
        Если потребуется, вы можете установить ваше собственное значение <a href="/ru/manual/cfg#cache_forever_time" title="Read more">времени вечного кэширования</a>
        в вашем <a href="/ru/manual/config" title="Read config manual">конфиге</a>.
      </li>
    </ul>
  </section>

  <section>
    <header>
      <h1>
        <a name="separate-caching" href="#separate-caching">#</a>
        Раздельное кэширование
      </h1>
    </header>
    <p>
      Все сниппеты, даже одинаковые, кэшируются отдельно друг от друга.
      Вот, взгляните на примеры.
    </p>
    <h2>Примеры</h2>
    <h3>Пример 1</h3>
    <p>Предположим, у вас есть сниппет <?= scx('[[$rand]]') ?> с таким кодом:</p>
    <?= pcx(h('<?php
echo rand(1, 100);')); ?>
    <p>
      Если на странице вы его используете несколько раз, то каждый раз будете получать разные числа.
      Если вы его закэшируете, то именно разные числа закэшируются.
      Так что если вы его используете несколько раз в коде одной страницы,
    </p>
    <?= pcx('[[5$rand]]
[[5$rand]]
[[5$rand]]'); ?>
    <p>то вы получите числа, которые будут меняться каждые пять секунд:</p>
    <pre><code>[[5$rand]]<br>[[5$rand]]<br>[[5$rand]]</code></pre>

    <p>
      Эти не просто примеры, а рабочие сниппеты. Так что <b>прямо сейчас обновите эту страницу</b> и вы увидите изменения.
      Кстати, иногда с вероятностью 1 к 1000000 оно выдаёт "42 42 42" (и однажды так и вышло, из-за чего я
      какое-то время в ночи безнадёжно пытался победить этот <i>баг</i>), так что не удивляйтесь.
    </p>
    <h3>Пример 2</h3>
    <p>This example will make you better understand caching.</p>
    <p>Этот пример позволит вам лучше понять кэширование.</p>
    <?= pcx('[[$rand]]
[[5$rand]]
[[!$rand]]') ?>
    <p>
      Если вы будете обновлять страницу, то увидите, что первое число меняется каждый раз, второе &mdash; каждые пять секунд,
      а последнее не меняется никогда.
    </p>
    <pre><code>[[$rand]]<br>[[5$rand]]<br>[[!$rand]]</code></pre>
  </section>

  <section>
    <header>
      <h1>
        <a name="hash" href="#hash">#</a>
        Хэш
      </h1>
    </header>
    <p>Каждая запись в кэше сохраняется с хэшем, основанным на параметрах сниппета и страницы. Они включают:</p>
    <ul>
      <li>имя сниппета</li>
      <li>дата и время изменения файла сниппета</li>
      <li>запрошенный URL</li>
      <li>параметры URL query (если <a href="/ru/manual/cache#cache-rules" title="See below on this page">возможно</a>)</li>
      <li>имена всех родительских тегов</li>
      <li>имя сервера</li>
      <li>соль <?= scx('CFG::$random_stuff') ?></li>
      <li>некоторые другие параметры</li>
    </ul>
    <p>
      При изменении любого из этих параметров будет изменён и хэш.
      А так как PinPIE не сможет найти сниппет в кеше, то будет вынужден выполнить его ещё раз.
      Таким образом, если изменится файл сниппета &mdash; он будет перекэширован.
    </p>

    <p>
      Алгоритм хэширования может быть установлен в конфиге
      <?= scx('CFG::$pinpie["cache hash algo"]', 'php') ?>. По умолчанию это "sha1".
      Список доступных алгоритмов может быть найден с помощью функции
      <a href="http://php.net/manual/ru/function.hash-algos.php" target="_blank">hash_algos()</a>.
    </p>
  </section>

  <section>
    <header>
      <h1>
        <a name="cache-storage" href="#cache-storage">#</a>
        Где хранится
      </h1>
    </header>
    <p>На текущий момент есть четыре варианта места хранения кэша:</p>
    <ul>
      <li>disabled &mdash; каждый сниппет будет выполняться каждый раз</li>
      <li>files &mdash; кеш хранится в файлах (по умолчанию)</li>
      <li>memcached &mdash; это memcached</li>
      <li>apc &mdash; хранение в хранилище переменных APC</li>
    </ul>
    <p>
      Место хранения кэша может быть задано в конфиге в <?= scx('CFG::$pinpie["cache type"]') ?>.
      Эта переменная отвечает за то, какой класс кешера будет использован.
      Значение по умолчанию это "filecache".
    </p>
  </section>

  <section>
    <header>
      <h1>
        <a name="cacher-disabled" href="#cacher-disabled">#</a>
        Кэшер Disabled
      </h1>
      <p><?= scx('$pinpie["cache type"] = "disabled";') ?></p>
    </header>
    <p>Это простейший класс кэшера:</p>
    <?= pcx('namespace PinPIE;

class CacherDisabled implements Cacher {

  public function get($hash) {
    return false;
  }

  public function set($hash, $content, $time) {
    return true;
  }

}', 'php') ?>
    <p>
      Этот класс состоит из двух методов-заглушек, которые заставляют PinPIE думать, что любая запись в кэш всегда
      проходит удачно, а любое чтение &mdash; не удачно. Таким образом всегда, когда PinPIE запрашивает данные,
      он получает "false". Это заставляет его выполнить сниппет в любом случае.
    </p>
  </section>

  <section>
    <header>
      <h1>
        <a name="cacher-files" href="#cacher-files">#</a>
        Кэшер Files
      </h1>
      <p><?= scx('$pinpie["cache type"] = "files";') ?></p>

    </header>
    <p>
      Кэшер "files" хранит кэш в файлах, названных по их хэшу, в этой вот папке:
    </p>
    <?= scx('CFG::$pinpie["working folder"] . DS . "filecache" . DS') ?>
    <p>По умолчанию это:</p>
    <?= pcx('ROOT/filecache') ?>
    <p>
      Это просто, но весьма быстрый способ кэширования сниппетов. Пока в вашей ОС есть <b>свободная</b> память, у вас будет и
      очень быстрое кэширование, порой быстрее даже memcached. Неудобство состоит в том, что файлы чистить придётся
      вручную, так как PinPIE сам не этого не умеет.
    </p>
    <p>
      Каждый раз, когда PinPIE генерирует новый хэш для тега, он будет создавать новый файл.
      Это не проблема, потому что большую часть времени размер кэша довольно стабилен, и будет прирастать только
      при изменении или создании новых сниппетов. Из-за того, что хэш основан на времени изменения файла,
      PinPIE не может догадаться, какой был хэш у сниппета раньше, а соответственно, не может удалить старый файл.
    </p>
    <p>Преимущества этого метода такие:</p>
    <ul>
      <li>Очень быстрый.</li>
      <li>Работает везде. Единственное требование это право писать в папку "filecache".</li>
    </ul>
    <p>
      Этот тип кэша быстр, потому, что современные ОС хранят недавние файлы в свободной памяти.
      Все файловые операции крайне оптимизированы. Поэтому производительность кэширования в файлах может быть
      выше, чем даже у Memcached через юникс-сокет.
    </p>
  </section>

  <section>
    <header>
      <h1>
        <a name="cacher-memcached" href="#cacher-memcached">#</a>
        Кэшер Memcached
      </h1>
      <p><?= scx('$pinpie["cache type"] = "memcached";') ?></p>
    </header>
    <p>
      Кэширование на основе Memcached использует для работы объект Memcache.
      Естественно с поддержкой подключения к нескольким серверам.
      Пул серверов задаётся в переменной конфига <?= scx('CFG::$pinpie["cache servers"]') ?> в виде массива пар хост и порт.
      Вот код:
    </p>
    <?= pcx('$pinpie["cache servers"] = [
  ["host" => "localhost", "port" => 11211],
]', 'php') ?>
    <p>Если хотите, вы можете использовать этот массив для хранения конфигруации вашего собственного кэшера.</p>
    <p>
      Обязательно проверьте, что вы установили уникальную соль для каждого сайта в переменной <?= scx('CFG::$random_stuff') ?>.
      Это предотвратит совпадения хэша для разных сниппетов.
    </p>
  </section>

  <section>
    <header>
      <h1>
        <a name="cacher-custom" href="#cacher-custom">#</a>
        Свой кэшер
      </h1>
      <p><?= scx('$pinpie["cache type"] = "custom";') ?></p>
    </header>
    <p>
      PinPIE позволяет использовать и ваш собственный кэшер. Вам нужно <b>наследоваться от интерфейса \PinPIE\Cacher</b>,
      который можно найти в файле "/pinpie/classes/cacher.php". Он автоматически иклюдится при загрузке.
    </p>
    <p>Интерфейс кэшера состоит из двух методов:</p>
    <?= pcx('namespace PinPIE;

interface Cacher {
  public function get($hash);

  public function set($hash, $content, $time);
}', 'php') ?>
    <p>Для инъекции кэшера используйте эту функцию:</p>
    <?= pcx('PinPIE::injectCacher($cacher);') ?>
    <p>где <b>$cacher</b> это ваш объект, унаследованный от интерфейса <b>\PinPIE\Cacher</b></p>
    <p>
      Не обязательно, но желательно установить <?= scx('CFG::$pinpie["cache type"]') ?> равным "custom" или "disabled",
      ибо по умолчанию загружается кэшер "files", даже если не используется.
    </p>
    <p>
      Если установлен тип кэша "custom", но $cacher пустая, то будет использован "disabled" кэшер.
      В любом случае, PinPIE не обязывает вас устанавливать кэшер при запуске. Вы можете установить ваш кэшер и позднее,
      но лучше не слишком затягивать.
    </p>
    <p>
      На заметку: PinPIE предоставляет результат функции hash() в сыром бинарном виде.
      Возможно вам может понадобиться функция <a href="http://php.net/manual/ru/function.bin2hex.php" target="_blank">bin2hex()</a>.
    </p>

  </section>

  <section>
    <header>
      <h1>
        <a name="cache-rules" href="#cache-rules">#</a>
        Правила кэша
      </h1>
    </header>
    <p>
      PinPIE даёт вам дополнительный контроль над процессом кэширования совершенно бесплатно. Все страницы 404 имеют разный URL, и из-за
      этого может расплодиться слишком много нежелательного кэша, который никогда не используется. Или могут быть некие
      GET-параметры, которые не влияют на страницу, и вы бы не хотели, чтобы они использовались при генерации хэша, так как это
      опять же породит дополнительный кэш. Чтобы предотвратить это безобразие были созданы правила кэширования, позволяющие
      всё это дело контролировать.
    </p>
    <p>
      PinPIE позволяет вам игнорировать URL или GET-параметры, и задать правила генерации хэша.
      Правила кэширования можно установить в конфиге в <?= scx('CFG::$pinpie["cache rules"]') ?>. Вот дефолтные правила:
    </p>
    <?= pcx('"cache rules" => [
  "default" => ["ignore url" => false, "ignore query params" => false],
  200 => ["ignore url" => false, "ignore query params" => false],
  404 => ["ignore url" => true, "ignore query params" => true]
],', 'php') ?>
    <p>
      Правила кэширования применяются согласно текущему коду ответа HTTP. Для всех обычных страниц это 200.
      Для не найденных страниц это 404. Для всех остальных случаев будет использовано правило "default".
    </p>
    <p>
      Для случая 404 можно игнорировать весь URL и все GET-параметры, дабы предотвратить раздельное кеширование для неправильных
      ненайденных страниц.
    </p>
    <p>Можно установить свои собственные правила для любых HTTP-кодов.</p>
    <h2>Параметры</h2>
    <h3>ignore url</h3>
    <p>
      Этот параметр позволяет вам игнорировать url при генерации хэша. Это приведёт к тому, что все страницы с этим правилом
      будут иметь одинаковый кеш при одинаковых GET-параметрах.
    </p>
    <p>Можно установить false или true.</p>
    <h3>ignore query params</h3>
    <p>
      Позволяет игнорировать все или некоторые GET-параметры при генерации хэша.
      Может быть false, true или массив ключей $_GET которые надо проигнорировать.
      Удобно, если у вас есть параметры трекинга пользователей в ссылках с других сайтов на ваш.
    </p>
    <?= pcx('$pinpie["cache rules"][200] = [
  "ignore query params" => ["XDEBUG_SESSION_START", "_openstat", "yclid"],
];') ?>
  </section>
</article>