[sidemenu[en/manual/sidemenu]]
<article>
  <header>
    <h1>PinPIE</h1>
    <p>PinPIE &mdash; when PHP is enough.</p>
  </header>

  <section>
    <header>
      <h1>About</h1>
    </header>
    <p>
      PinPIE is lightweight php-based engine for small sites.
      All pages and URL handlers are stored in <span><code>*.php</code></span> files.
      Caching also included, and cache control is simple and clear.
      Just include your favorite classes, functions, ORM, and start to write the funky code.
    </p>
  </section>

  <section>
    <header>
      <h1>Advantages</h1>
    </header>
    <ul>
      <li>Lightweight</li>
      <li>Quick</li>
      <li>Easy to learn</li>
      <li>Tags: chunks, snippets, constants and static files</li>
      <li>File-based content storage</li>
      <li>Edit your content using your favorite IDE or text editor with all that highlighting, autoformating, autosaving, autouploading features and familiar hotkeys</li>
      <li>Full debug support including exact line numbers and IDE code execution controls</li>
      <li>Accelerators support provides lightspeed response time</li>
      <li>Version control systems friendly &mdash; you can have versions of all your content to be safe and protected against loosing something while editing anything</li>
      <li>Deployment friendly</li>
      <li>Backup friendly</li>
      <li>Clear URL routing</li>
      <li>Server name based config &mdash; easy to develop with local config, and deploy to production with another one</li>
      <li>Controllable snippets caching: never (default), for exact time in seconds, and cache forever options</li>
      <li>Automatic cache refreshing of exact tag cached content if one of its files or files of it's children (all of them) have been changed</li>
      <li>HTTP-code and GET-params based caching rules to handle separately 200, 404 and any other situations</li>
      <li>Template support and plain text output support</li>
      <li>Optional template engines integration like Twig, Smarty, Mustache, etc</li>
      <li>Optional static content cookie-free servers sharding support for parallel loading</li>
      <li>Optional automatic pre-minification for static content files (images, css, js, etc.)</li>
      <li>Optional automatic gz pre-compression for static content files (images, css, js, etc.)</li>
    </ul>
  </section>
  <section>
    <header>
      <h1>Quick overview</h1>
    </header>
    <p>PinPIE is designed to handle about 100-150 pages per second at cheap $5 VPS/VDS hosting. It can be used at shared hosting as well.</p>
    <p>PinPIE stores content in \*.php files, located in /pages folder. This files are included before template is applied. So all page options could be set in the page code. Subdirectories are allowed. Pages can handle URLs longer, than a path to a file. See URL handling section.</p>
    <p>PinPIE uses tags. Tags have flexible caching mechanics, automatically refreshing expired tags, if its files or files of its children were changed.</p>
  </section>
  <section>
    <header>
      <h1>Starting</h1>
    </header>
    <p>Folder /sources of this project contains required files and folders to make PinPIE work properly. Copy its contents to your project. Also you have to create index.php to include PinPIE, default template and index page. You can find [minimal site example here](/examples/en/minimal/).</p>
  </section>
  <section>
    <header>
      <h1>Entry point</h1>
    </header>
    <p>PinPIE require to be included in main entry point of your project, and all requests have to be rerouted to that file. Generally, the main entry point for site code is `ROOT/index.php`. This file require to have `include 'pinpie/pinpie.php';` line to start PinPIE working.</p>
    <p>This, in fact, are the only things you have to do to start using PinPIE.</p>

    <h2>About preinclude.php and postinclude.php</h2>
    <p>For every request there are to files, that will be included if they exist. Before processing a page file `ROOT/preinclude.php` will be included. And `ROOT/postinclude.php` will be included after page is processed and assembled. If you will upgrade PinPIE with new version, this files will not be overwritten, because this
      files doesn't exist in PinPIE project. So feel free to modify them corresponding your needs.</p>
  </section>
  <section>
    <header>
      <h1>File-based content storage</h1>
    </header>
    <p>All content is stored in files. Pages are located at /pages folder, code snippets at /snippets folder, text chunks at /chunks, templates in /templates folder. Nested folders are allowed and could be used in tags and templates names.</p>
  </section>
  <section>
    <header>
      <h1>PinPIE tags</h1>
    </header>
    <p>PinPIE have tag-based parser. Tag syntax is inspired by ModX tag system.</p>
    <p>Basic tags are:</p>
    <ul>
      <li>Chunks &mdash; a pieces of plain text</li>
      <li>Snippets &mdash; a pieces of php code to execute</li>
    </ul>
    <p>Read more in <a href="/en/manual/tags">tags readme</a>.</p>
  </section>
  <section>
    <header>
      <h1>Caching</h1>
    </header>
    <p>PinPIE provide clear and controllable automatic snippet caching. Read more in <a href="/en/manual/cache">cache readme</a>.</p>
  </section>
  <section>
    <header>
      <h1>PinPIE file structure</h1>
    </header>
    <p>Current project file structure:</p>
    <?= pcx('/
├── chunks/                              folder is used to store text chunks
├── config/                              configuration files
├── filecache/                           used only if caching is file-based
├── pages/                               folder is used to store pages and URL handlers
├── pinpie/                              PinPIE files are located here
│   ├── classes/                         PinPIE entry point
│   │   ├── cachers/                     here are stored some caching classes,
│   │   │                                    one of it is included at start
│   │   │                                    according config option 
│   │   ├── cache.php                    class to control cache operations, load and change cacher 
│   │   ├── cacher.php                   cacher interface
│   │   ├── cfg.php                      config loader, default values can be found here
│   │   ├── pinpie.php                   main PinPIE code
│   │   └── staticon.php                 static content methods here
│   ├── pinpie.php                       PinPIE entry point
│   └── throw.php                        some functions used in PinPIE code
├── snippets/                            folder to store php-executable code pieces
└── templates/                           templates folder. Don\'t forget to create default.php template here.', 'html') ?>
    <p>All empty folders have empty 'dummy' file to make sure the folder will be created on upload.</p>
  </section>
</article>





