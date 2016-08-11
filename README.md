# Code Education - Doctrine

## Install & Run

$ composer install

$ php -S localhost:8000 -t public

## Interface WEB

[http://localhost:8000](http://localhost:8000)

## API
|HTTP method | Route           | Params                 | Action         |
|------------|-----------------|------------------------|----------------|
|POST        | api/produto     | nome, descricao, valor | Insert produto |
|POST        | api/produto/{id}| nome, descricao, valor | produto update |
|DELETE      | api/produto/{id}| -                      | produto delete |
|POST        | api/cliente     | nome, email            | Insert cliente |
|POST        | api/cliente/{id}| nome, email            | cliente update |
|DELETE      | api/cliente/{id}| -                      |cliente delete  |