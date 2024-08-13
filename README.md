# URL Shortener

## Pre-requisites

- PHP 8.3
- Composer
- NodeJS 18.18.2
- MySQL or MariaDB

***"NOTE: you can use xampp"***

## Get the repo

```
git clone https://github.com/brayanibp/URLShortener.git
```

## Install dependencies

You need to be placed inside the project folder, if you don't then exec:

```
cd ./URLShortener
```

After being placed inside URLShortener folder then execute:

```
composer install
```

```
npm i--save
```

## Config the project

Once we did install dependencies then has to config the project

For that purpose we execute:

```
cp .env.example .env
```

This will copy a basic ENVIRONMENT config.

***"If you have setted up password or custom user for you MySQL installation then have to change 'DB_USERNAME' and 'DB_PASSWORD' with the rigth one credentials"***

After create the .env file we need to generate encryption app key so Laravel is able to run.

```
php artisan key:generate
```

In your database you need to create the project's database for that you could follow the next steps:

```
$ mysql -u root -p

>CREATE DATABASE url_shortener;
>exit;
```
Once created the database you have to run Laravel migrations:

```
php artisan migrate
```

***"If need to run migrations again, you could use `php artisan migrate:refresh` run it with caution since it will wipe up all your previous migrations for 'url_shortener' database"***

## Run application

### Development

```
php artisan serve --host 0.0.0.0
```

```
npm run dev
```

With the above command lines you will instanciate the project binding localhost, 0.0.0.0, 127.0.0.1, 192.168.*.*, depending on your network config. Using by default the port 8000, if you need a custom port for development purposes then add '--port' flag followed with with the port number to use.

### Production

To deploy the project in a production enviroment for a normal VPS you should config Apache2 or Nginx server to point directly in the '/public' directory inside URLShortener project and execute the JS bundle views with:

```
npm run build
```
