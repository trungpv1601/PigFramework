# Pig Framework

### Custom framework with PHP packages

<b>Notice: This project not Good. So, I use it for myself ;)</b>

## 1. How to setup this project 

- Just create database and import file database.sql
```
Username: admin
Password: admin
```
- Change correct infomation about Username & Password MYSQL in file .env
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=PigFramework
DB_USERNAME=root
DB_PASSWORD=secret
```
- Change APP_URL and APP_NAME in file .env, 
```
APP_NAME='Pig Framework'
APP_DEBUG=true
APP_URL=http://localhost:8000
```
- APP_DEBUG above true if you want show error, false if not.


## 2. Some package I use in this project:
- [nikic/fast-route](https://github.com/nikic/FastRoute): Route
- [league/container](https://github.com/thephpleague/container): Manage container
- [symfony/http-foundation](https://github.com/symfony/http-foundation): Request, Response
- [filp/whoops](https://github.com/filp/whoops): Manage error message
- [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv): .env file
- [league/plates](https://github.com/thephpleague/plates): Native PHP template
- [illuminate/database](https://github.com/illuminate/database): Database Eloquent like Laravel
- [rakit/validation](https://github.com/rakit/validation): Validate Input
- [jasongrimes/paginator](https://github.com/jasongrimes/php-paginator): Paginator ;)

### I use [AdminLTE](https://adminlte.io/themes/AdminLTE/index2.html) for UI. I Love this UI.

Thanks

I'm lazy. So, Just use package :D

Have a great day ;)