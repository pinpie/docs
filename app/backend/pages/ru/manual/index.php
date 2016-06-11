[sidemenu[ru/manual/sidemenu]]
<article>
  <header>
    <h1>PinPIE</h1>
    <p>PinPIE &mdash; when PHP is enough.</p>
  </header>
  <section>
    <header>
      <h1><a name="about" href="#about">#</a>
        О</h1>
    </header>
    <p>
      PinPIE это лёгкий движок для небольших сайтов.
      Все страницы и обработчики url'ов хранятся в php-файлах.
      Присутствует прозрачный и предсказуемый механизм кэширования только тех частей страницы, которые вы сами хотите
      кэшировать.
      Просто подключите свои любимые классы, функции, ORM, и можно начинать писать код.
    </p>
  </section>

  <section>
    <header>
      <h1>
        <a name="advantages" href="#advantages">#</a>
        Плюшки
      </h1>
    </header>
    <ul>
      <li>Лёгкий</li>
      <li>Быстрый</li>
      <li>Легко понять</li>
      <li>Теги: чанки, сниппеты, константы и для статик файлов</li>
      <li>Всё хранится в файлах, из чего следует:</li>
      <ul>
        <li>
          Редактируйте весь контент в своей любимой IDE или текстовом редакторе, со всеми плюшками: подсветкой,
          автоформатированием, автосохранением, автозагрузкой и привычными хоткеями
        </li>
        <li>Полная поддержка дебага включая конкретные номера строк и контроль выполнения скрипта из IDE</li>
        <li>Поддержка акселераторов даёт сверхнизкое время отклика</li>
        <li>
          Дружит с системами контроля версий &mdash; все версии вашего контента защищены от потери при
          редактировании и в любых других случаях
        </li>
        <li>Удобно деплоить</li>
        <li>Удобно бэкапить</li>
      </ul>
      <li>Прозрачный роутинг урлов</li>
      <li>
        Конфиг выбирается в зависимосте от имени сервера &mdash; удобно разрабатывать с локальным конфигом, деплоить
        с другим, всё это живёт в проекте и в системе версий
      </li>
      <li>
        Кеширование сниппетов прозрачно контролируется: не кэшировать (дефолтно), кешировать на точное время в секундах
        и кешировать навсегда
      </li>
      <li>Кэшированные сниппеты обновляют своё содержимое автоматически если их файл или файл их детей любого уровня поменялся</li>
      <li>
        Управляемые правила кэширования, основанные на HTTP-коде ответа и GET-параметрах чтобы раздельно контролировать
        кэширование для 200, 404 и других ситуаций
      </li>
      <li>Поддержка темплейтов или вывод текста как есть</li>
      <li>Возможна интеграция с темплейт-движками типа Twig, Smarty, Mustache и др.</li>
      <li>Поддержка cookie-free серверного шардинга для параллельной загрузки статик контента</li>
      <li>Автоматическая преминификация для статик файлов (картинки, css, js, и др.)</li>
      <li>Автоматическая прекомпрессия (gz) для статик файлов (картинки, css, js, и др.)</li>
      <li>Требует минимального знакомства с PHP и HTML ;)</li>

    </ul>
  </section>
  <section>
    <header>
      <h1>
        <a name="quick-overview" href="#quick-overview">#</a>
        Краткий обзор
      </h1>
    </header>
    <p>
      PinPIE спроектирован так чтобы выдавать 100-150 страниц в секунду даже на дешёвом VPS/VDS хостинге.
      Но его можно использовать и на шаред хостинге.
    </p>
    <p>
      PinPIE хранит весь контент в файлах "*.php", которые кэшируются опкод-кэшером, что позволяет инклудить страницы,
      сниппеты и чанки просто молниеносно.
    </p>
    <p>
      В PinPIE используются теги. Теги можно кэшировать. Кэширование легко включается и выключается отдельно для каждого тега.
      Управление кэшированием тегов очень понятное и простое. При обновлении файлов PinPIE автоматически перекэширует то,
      что изменилось.
    </p>
    <p>Ниже можно чуть подробнее прочесть об этом всём.</p>
  </section>
  <section>
    <header>
      <h1>
        <a name="starting" href="#starting">#</a>
        Как начать использовать PinPIE
      </h1>
    </header>
    <p>
      Чтобы начать использовать PinPIE достаточно просто закинуть файлы и папки из архива в корень сайта, заинклудить
      <?= scx('/pinpie/pinpie.php', 'html') ?>, и создать страницу <?= scx('/pages/index.php', 'html') ?>,
      которая по&#8209;дефолту использует <?= scx('/templates/default.php', 'html') ?>,
      который тоже нужно создать с содержимым <?= scx('[[*content]]', 'html') ?>, но работать будет и без него.
      И всё! Должно работать!
    </p>
    <p>Более подробные инструкции по настройке и запуску PinPIE <a href="/ru/manual/start">читайте тут</a>.</p>
  </section>
  <section>
    <header>
      <h1><a name="advantages" href="#advantages">#</a>
        Контент хранится в файлах</h1>
    </header>
    <p>
      Весь контент хранится в файлах. Страницы живут в папке /pages, сниппеты кода в /snippets, чанки в /chunks,
      темплейты соотв. в /templates. Можно создавать папки в папках.
    </p>
  </section>
  <section>
    <header>
      <h1><a name="tags" href="#tags">#</a>
        Теги PinPIE</h1>
    </header>
    <p>Парсер PinPIE работает с тегами. Синтакс тегов вдохновлён системой тегов <a href="http://modx.com">CMS ModX</a>. Она мне очень нравится.</p>
    <p>Основные типы тегов:</p>
    <ul>
      <li>Чанки &mdash; кусочки простого текста</li>
      <li>Сниппеты &mdash; кусочки php-кода, который надо выполнять</li>
    </ul>
    <p>Более подробно можно прочесть в <a href="/ru/manual/tags">доке по тегам</a>.</p>
  </section>
  <section>
    <header>
      <h1><a name="cache" href="#cache">#</a>
        Кэширование</h1>
    </header>
    <p>
      PinPIE позволяет контролировать автоматическое кэширование сниппетов. Из коробки поддерживается кэширование в:
    </p>
    <ul>
      <li>Memcache &mdash; привычный способ</li>
      <li>APC &mdash; самый быстрый</li>
      <li>файлики &mdash; работает везде, и при небольшом размере сидит в кэше ОС и порой выходит быстрее Мемкеша</li>
      <li>можно вообще отключить</li>
    </ul>
    <p>
      Более подробно можно прочесть в <a href="/ru/manual/cache">доке по кэшу</a>.
    </p>
  </section>
  <section>
    <header>
      <h1><a name="file-structure" href="#file-structure">#</a>
        Файловая структура PinPIE</h1>
    </header>
    <p>Текущая структура всех файлов и папок:</p>
    <?= pcx('/
├── chunks/                              папка для чанков
├── config/                              папка для конфигов
├── filecache/                           используется только если выбрано кэширование в файлах
├── pages/                               обработчики урлов, т.е. страницы
├── pinpie/                              собственные файлы PinPIE живут именно в этой папке
│   ├── classes/                         основные файлы PinPIE
│   │   ├── cachers/                     несколько файлов классов кэшеров
│   │   │                                    один из которых согласно конфигу
│   │   │                                    подключается на старте
│   │   ├── cache.php                    класс, контролирующий операции кэширования 
│   │   ├── cacher.php                   интерфейс кэшера
│   │   ├── cfg.php                      загрузчик конфига, дефолтные значения живут тут
│   │   ├── pinpie.php                   основной код PinPIE
│   │   └── staticon.php                 методы работы со статик файлами
│   ├── pinpie.php                       точка входа PinPIE
│   └── throw.php                        несколько функций, используемых в коде PinPIE
├── snippets/                            папка для хранения сниппетов - кусочков исполняемого кода
└── templates/                           папка темплейтов. Не забудьте создать default.php.', 'html') ?>
    <p>Во всех пустых папках есть файлик 'dummy' который нужен, чтобы папка точно создалась при заливке.</p>
  </section>
</article>




