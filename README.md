# Simple Laragento

Small project implementing cart functional using Laravel.
Also available on https://small-laragento.onrender.com/

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

### Console commands for developing

- ***php artisan laragento:generate:products*** - seed database with 20 random products 
- ***php artisan laragento:generate:discount*** - seed database with 5 random discounts 
