<center>

[![logo](https://github.com/devxian96/phpExpress/blob/main/phpExpressLogo.png?raw=true)](https://github.com/devxian96/phpExpress)

</center>

<center>

[![GitHub stars](https://img.shields.io/github/stars/devxian96/phpExpress)](https://github.com/devxian96/phpExpress/stargazers)
[![GitHub forks](https://img.shields.io/github/forks/devxian96/phpExpress)](https://github.com/devxian96/phpExpress/network)
[![GitHub issues](https://img.shields.io/github/issues/devxian96/phpExpress)](https://github.com/devxian96/phpExpress/issues)
[![GitHub license](https://img.shields.io/github/license/devxian96/phpExpress)](https://github.com/devxian96/phpExpress/blob/main/LICENSE)

</center>

> Minimalist RestAPI web framework for [PHP](https://www.php.net/), Affected by [Express](https://github.com/expressjs/express)

```php
  require 'phpExpress.php';
  $app = new phpExpress();

  $app->get('/', function ($req, $res) {
      $res->send("Hello World");
  });

  $app->listen();
```

## Features

- Robust routing
- Focus on high performance and Minimalist
- HTTP helpers (redirection, caching, etc)
- Support many headers
- phpSequelize ORM, Affected by [Sequelize](https://github.com/sequelize/sequelize)

## Getting started

### Required

- php7 or higher

#### Standalone

1. [Download](https://github.com/devxian96/phpExpress/releases) Framework file.
2. Follow code sample.

```php
  require 'phpExpress.php';
  $app = new phpExpress();
```

Now you ready to use it

#### Composer

```

```

I not ready this way yet.
Coming soon.

## Examples

Please take a look at [Example](https://github.com/devxian96/phpExpress/tree/main/example) page.
