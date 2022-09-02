# Router Library

[![Maintainer](http://img.shields.io/badge/maintainer-@marcolamr-blue.svg?style=flat-square)](https://github.com/marcolamr)
[![Source Code](http://img.shields.io/badge/source-marcolamr/router-blue.svg?style=flat-square)](https://github.com/marcolamr/router)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/marcolamr/router.svg?style=flat-square)](https://packagist.org/packages/marcolamr/router)
[![Latest Version](https://img.shields.io/github/release/marcolamr/router.svg?style=flat-square)](https://github.com/marcolamr/router/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build](https://img.shields.io/scrutinizer/build/g/marcolamr/router.svg?style=flat-square)](https://scrutinizer-ci.com/g/marcolamr/router)
[![Quality Score](https://img.shields.io/scrutinizer/g/marcolamr/router.svg?style=flat-square)](https://scrutinizer-ci.com/g/marcolamr/router)
[![Total Downloads](https://img.shields.io/packagist/dt/marcolamr/router.svg?style=flat-square)](https://packagist.org/packages/marcolamr/router)

###### Small, simple and uncomplicated. The router is a PHP routing component with abstraction for MVC. Prepared with RESTfull verbs (GET, POST, PUT and DELETE), it works in its own layer in isolation and can be seamlessly integrated into your application.

Pequeno, simples e descomplicado. O router é um componente de rotas PHP com abstração para MVC. Preparado com verbos RESTfull (GET, POST, PUT e DELETE), trabalha em sua própria camada de forma isolada e pode ser integrado sem segredos a sua aplicação.

### Highlights

- Simple installation (Instalação simples)
- Works with standard php server: php -S localhost:8000 (Funciona com php server padrão)
- Composer ready and PSR-2 compliant (Pronto para o composer e compatível com PSR-2)

## Installation

Router is available via Composer:

```bash
"marcolamr/router": "^1.0"
```

or run

```bash
composer require marcolamr/router
```

## Documentation

#### Getting Started:

```php
<?php

require __DIR__ . "/vendor/autoload.php";

use MarcolaMr\Router\Response;
use MarcolaMr\Router\Router;

define("URL", "http://localhost:8000");

$router = new Router(URL);

$router->get("/", [
    function() {
        return new Response(200, "Hello World");
    }
]);

$router->get("/controller", [
    function() {
        return new Response(200, Controller::method());
    }
]);

$router->get("/{id}", [
    function($id) {
        return new Response(200, var_dump($id));
    }
]);

$router->run()->sendResponse();
```
