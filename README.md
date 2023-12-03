# Simple Laragento

## Local deploy

### Requirements
- PHP 8.1
- docker + docker-compose

### Installation and first start
```shell
$ composer install
$ cp .env.exapmple .env
$ php artisan key:generate
$ docker-compose up -d
$ php artisan migrate
$ php artisan serve
```

### Simple launching
```shell
$ docker-compose up -d
$ php artian serve
```

### Console commands

- ***php artisan laragento:generate:products*** - generate 20 random products in database 
