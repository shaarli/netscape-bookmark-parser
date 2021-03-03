[![GH release](https://img.shields.io/github/v/release/shaarli/netscape-bookmark-parser)](https://github.com/shaarli/netscape-bookmark-parser/releases)
![GH license](https://img.shields.io/github/license/shaarli/netscape-bookmark-parser)
![GH stars](https://img.shields.io/github/stars/shaarli/netscape-bookmark-parser)
![Build Status](https://github.com/shaarli/netscape-bookmark-parser/workflows/PHP%20CI/badge.svg)

Shaarli Netscape Bookmark Parser
================================

This library provides a decoder that is able of parsing Netscape bookmarks (as exported by common Web browsers and bookmarking services), and an encoder that is able to export data to bookmarks format.

🚀 Installation
---------------

Using [Composer](https://getcomposer.org/) ([package](https://packagist.org/packages/shaarli/netscape-bookmark-parser)):

```bash
$ composer require shaarli/netscape-bookmark-parser
```

🔥 Usage
--------

### Import from Bookmark file

```php
<?php
// parse.php
require_once 'vendor/autoload.php';

use Shaarli\NetscapeBookmarkParser\NetscapeBookmarkParser;

$parser = new NetscapeBookmarkParser();
$bookmarks = $parser->parseFile('./tests/Fixtures/Encoder/input/netscape_basic.htm');
var_dump($bookmarks);
```

Above example will return following array:

```
array(2) {
  [0] => array(7) {
    ["name"] => string(12) "Secret stuff"
    ["image"] => NULL
    ["url"] => string(19) "https://private.tld"
    ["tags"] => array(2) {
      [0] => string(7) "private"
      [1] => string(6) "secret"
    }
    ["description"] => string(52) "Super-secret stuff you're not supposed to know about"
    ["dateCreated"] => int(971175336)
    ["public"] => bool(false)
  }
  [1] => array(7) {
    ["name"] => string(12) "Public stuff"
    ["image"] => NULL
    ["url"] => string(17) "http://public.tld"
    ["tags"] => array(3) {
      [0] => string(6) "public"
      [1] => string(5) "hello"
      [2] => string(5) "world"
    }
    ["description"] => NULL
    ["dateCreated"] => int(1456433748)
    ["public"] => bool(true)
  }
}
```

### Export to file

```php
<?php
// export.php
require_once 'vendor/autoload.php';

use Shaarli\NetscapeBookmarkParser\NetscapeBookmarkParser;

$data = [
    [
        'name'        => 'shaarli/Shaarli',
        'url'         => 'https://github.com/shaarli/Shaarli',
        'image'       => 'data:image/png;base64, ...'
        'description' => 'The personal, minimalist, super-fast, database free, bookmarking service',
        'public'      => true,
        'tags'        => ['shaarli'],
    ],
    [
        'name'         => 'shaarli/netscape-bookmark-parser',
        'url'          => 'https://github.com/shaarli/netscape-bookmark-parser',
        'public'       => false,
        'dateCreated'  => '1612572000',
        'dateModified' => '1612572000',
        'tags'         => ['shaarli'],
    ],
];

$parser = new NetscapeBookmarkParser();

$parser->export($data, './export.htm');
```

Above example will write following string into file:

```xml
<!DOCTYPE NETSCAPE-Bookmark-file-1>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<TITLE>Bookmarks</TITLE>
<H1>Bookmarks</H1>
<DL><p>
<DT><H3>shaarli</H3>
<DL><p>
<DT><A HREF="https://github.com/shaarli/Shaarli" PRIVATE="0" ICON="data:image/png;base64, ...">shaarli/Shaarli</A>
<DD>The personal, minimalist, super-fast, database free, bookmarking service
<DT><A HREF="https://github.com/shaarli/netscape-bookmark-parser"> ADD_DATE="1612572000" LAST_MODIFIED="1612572000">shaarli/netscape-bookmark-parser</A>
<\DL><p>
<\DL><p>
```

💻 Dependencies
---------------

**Shaarli Netscape Bookmark Parser** requires the following dependencies:

- PHP
- Composer
- Make (optional)

---

### 🐘 PHP

Learn how to install PHP from official documentation [here](https://www.php.net/manual/en/install.php)

---

### 📦 Composer

Learn how to install Composer from official documentation [here](https://getcomposer.org/download/)

---

### 🛠 Make

#### 🐧 Install Make (Linux)

On linux machine enter following command

```bash
$ sudo apt-get install --assume-yes make
```

#### 🏁 Install Make (Windows)

On windows machine you will need to install [cygwin](http://www.cygwin.com/) or [GnuWin make](http://gnuwin32.sourceforge.net/packages/make.htm) first to execute make script.

#### 🍎 Install Make (OSX)

Make should be available by default on OSX system, but you can upgrade make version with following command

```bash
$ brew install make
```

---

📑 About
--------

### ⚡ A word from Kafene

The motivations behind developing this parser are the following:
- the [Netscape format](https://msdn.microsoft.com/en-us/library/aa753582%28v=vs.85%29.aspx) has a very loose specification: no [DTD](https://en.wikipedia.org/wiki/Document_type_definition) nor [XSL stylesheet](https://en.wikipedia.org/wiki/XSL) to constrain how data is formatted.
- software and web services export bookmarks using a wild variety of attribute names and values.
- using standard SAX or DOM parsers is thus not straightforward.

How it works:
- the input bookmark file is trimmed and sanitized to improve parsing results
- the resulting data is then parsed using [PCRE](http://www.pcre.org/) patterns to match attributes and values corresponding to the most likely:
    - attribute names: `description` vs. `note`, `tags` vs. `labels`, `date` vs. `time`, etc.
    - data formats: `comma,separated,tags` vs. `space separated labels`, UNIX epochs vs. human-readable dates, newlines & carriage returns, etc.
- an associative array containing all successfully parsed links with their attributes is returned

### ⚡ Shaarli community fork

This friendly fork is maintained by the Shaarli community at https://github.com/shaarli/netscape-bookmark-parser and is used by the open-source [Shaarli](https://github.com/shaarli/Shaarli) bookmarking service. This is a community fork of the original [netscape-bookmark-parser](https://github.com/kafene/netscape-bookmark-parser) project by [Kafene](http://kafene.org/).

🤝 Contributing
---------------

Thank you for your interrest in contributing to **Shaarli Netscape Bookmark Parser**.

Please review the [code of conduct](./CODE_OF_CONDUCT.md) and [contribution guidelines](./CONTRIBUTING.md) before starting to work on any features.

If you want to open an issue, please check first if it was not [reported already](https://github.com/shaarli/netscape-bookmark-parser/issues) before creating a new one.

📜 License
----------

Copyrights (c) 2021 &quot;Shaarli community&quot;

[![License](https://img.shields.io/badge/Licence-MIT-green.svg)](LICENSE)
Distributed under the MIT license.

If you like **Shaarli Netscape Bookmark Parser** please star or tweet about it:

[![GitHub stars](https://img.shields.io/github/stars/shaarli/netscape-bookmark-parser?style=social)](https://github.com/shaarli/netscape-bookmark-parser/stargazers)
[![Twitter](https://img.shields.io/twitter/url?style=social&url=https%3A%2F%2Fgithub.com%2Fshaarli%2Fnetscape-bookmark-parser)](https://twitter.com/intent/tweet?text=Wow:&url=https%3A%2F%2Fgithub.com%2Fshaarli%2Fnetscape-bookmark-parser)

🙏 Acknowledgements
-------------------

- [Shaarli Community](https://github.com/shaarli)
- [Kafene](https://github.com/kafene)
- [VirtualTam](https://github.com/virtualtam)
- [TangoMan75](https://github.com/TangoMan75)
