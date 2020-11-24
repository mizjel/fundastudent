Download the latest Thread Safe(x86 or 64-bit depends on machine specs) PHP binaries from php.net

Extract to a location of choice, copy this location and put in it your PATH environment variable
Copy the php.ini-Development file and rename it to php.ini

Open php.ini with editor of choice and edit the line:
;extension=php_openssl.dll
to
extension=%YOURPHPFOLDER%\ext\php_openssl.dll ;Change %YOURPHPFOLDER% to the location of your php folder

and
;extension=php_mbstring.dll
to
extension=%YOURPHPFOLDER%\ext\php_mbstring.dll ;Change %YOURPHPFOLDER% to the location of your php folder

and
;extension=php_pdo_mysql.dll
to
extension=%YOURPHPFOLDER%\ext\php_pdo_mysql.dll ;Change %YOURPHPFOLDER% to the location of your php folder

Download & install composer (https://getcomposer.org) when asked, use the php binary from the PATH folder
Open cmd.exe and test it by typing composer and hitting ENTER

Clone project
composer update in project root
Copy the .env.example and rename it to .env, open it with an editor and for the mysql db change the following:
DB_HOST=127.0.0.1
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
to
DB_HOST=YOURLOCALOREXTERNALIP
DB_DATABASE=fas_db
DB_USERNAME=YOURDBUSER
DB_PASSWORD=YOURDBUSERPASSWORD

create db named fas_db
for extra security create user that can only access this db and set it as the DB_USERNAME and DB_PASSWORD in the .env file
php artisan migrate
php artisan key:generate
install node.js voor npm package manager
npm install,ONLYIFNEEDED --> npm install moment ,npm run dev
php artisan serve to run the webserver
php artisan db:seed --class=UsersTableSeeder

Registrations steps:
Step 1 - Funder registration
Step 2 - Question student registration(Yes - GoTo Step 3, No - GoTo step 4)
Step 3 - Student registration
Step 4 - Question company registration(Yes - GoTo Step 5, No - GoTo step 6)
Step 5 - Company registration
Step 6 - End registration process

<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable, creative experience to be truly fulfilling. Laravel attempts to take the pain out of development by easing common tasks used in the majority of web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, yet powerful, providing tools needed for large, robust applications. A superb combination of simplicity, elegance, and innovation give you tools you need to build any application with which you are tasked.

## Learning Laravel

Laravel has the most extensive and thorough documentation and video tutorial library of any modern web application framework. The [Laravel documentation](https://laravel.com/docs) is thorough, complete, and makes it a breeze to get started learning the framework.

If you're not in the mood to read, [Laracasts](https://laracasts.com) contains over 900 video tutorials on a range of topics including Laravel, modern PHP, unit testing, JavaScript, and more. Boost the skill level of yourself and your entire team by digging into our comprehensive video library.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](http://laravel.com/docs/contributions).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell at taylor@laravel.com. All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
