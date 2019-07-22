# Influence4you Project
<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

This project based on [Laravel Project](https://github.com/laravel/laravel) 
dependencies with [Composer](https://getcomposer.org/).

## Installation

1. Clone repository from [Github](https://github.com/herman-bukarev-nov/influence4you)

``` bash
git clone https://github.com/herman-bukarev-nov/influence4you.git
```
2. Build the application
``` bash
make install app=influence4you
```

> Additional variables:\
> `port`: You may set web port from default 80 to 8080 or another, if 80 port is occupied on your host  \
> `no-interaction`: Do not ask any interactive question.

##### Examples
Install Project called *influence4you*
```bash
make install project=influence4you port=8080
```

##### Another Commands
You may find more useful commands by type
`make help`

inside the root directory of the project.

## Manual Installation
If you don't have `make` utill you may install it `apt-get install -y make` and execute command `make install` then.
Or if you using Windows platform
just copy `.env.example` file to `.env` and fill all required values and then
execute this commands:
``` bash
docker-compose up -d --build

docker-compose exec -T cli composer install --no-interaction --prefer-dist --optimize-autoloader

docker-compose exec -T cli artisan key:generate
```