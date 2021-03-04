# phpExpress [![HitCount](http://hits.dwyl.com/DevXian/https://githubcom/devxian96/phpExpress.svg)](http://hits.dwyl.com/DevXian/https://githubcom/devxian96/phpExpress)

Minimalist web framework for [PHP](https://www.php.net/)

[![GitHub stars](https://img.shields.io/github/stars/devxian96/phpExpress)](https://github.com/devxian96/phpExpress/stargazers)
[![GitHub forks](https://img.shields.io/github/forks/devxian96/phpExpress)](https://github.com/devxian96/phpExpress/network)
[![GitHub issues](https://img.shields.io/github/issues/devxian96/phpExpress)](https://github.com/devxian96/phpExpress/issues)
[![GitHub license](https://img.shields.io/github/license/devxian96/phpExpress)](https://github.com/devxian96/phpExpress/blob/main/LICENSE)

```php
  require '../lib/phpExpress.php';
  $app = new phpExpress();

  $app->get('/', function ($req) {
      return "Hello World";
  });
  
  $app->listen();
```
