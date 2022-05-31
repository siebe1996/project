# Backend gotcha project
Final project web-mobile full-stack
## Links

* [Course slides wmfs-laravel](https://intern.ikdoeict.be/apps/leercentrum/courses/wmfs-laravel-course-materials/)
* [PHP Documentation](https://www.php.net/docs.php)
* [MySQL 5.7 Reference Manual](https://dev.mysql.com/doc/refman/5.7/en/)
* [Laravel 8 documentation](https://laravel.com/docs/8.x)
* [Odisee Hoge school](odisee.be)

## How to pull it from git

1. Create a new completely! empty project on gitlab.com/ikdoeict, for example my-project
2. Execute following commands on your system (pay attention !)
3. Best installed on ubuntu
```shell
mkdir my-project
cd my-project
git init
git pull https://gitlab.com/ikdoeict/siebe.vandevoorde/2122wmfs-backend
```

## Running and stopping the Docker MCE

* Make sure u have docker installed (best on ubuntu, WSL2)
* Run the environment, using Docker, from your terminal/cmd
```shell
cd <your-project>
docker-compose up
```
* Stop the environment in your terminal/cmd by pressing <code>Ctrl+C</code>
* In order to avoid conflicts with your lab/slides environment, run from your terminal/cmd
```shell
docker-compose down
```

## Quick configuration of the Laravel project

You still need to install the libraries in the vendor folder (because they are not on git) and do some basic configuration like generating the key, linking the storage &hellip;
* Run from your terminal/cmd
```shell
docker-compose exec -u 1000:1000 php-web bash
$ cp .env.example .env
$ composer install
$ php artisan key:generate
$ touch storage/logs/laravel.log
$ chmod 777 -R storage
$ php artisan storage:link
$ php artisan migrate:refresh --seed
$ exit
```

## Making api calls
### Open postman or insomnia
1. GET http://localhost:8080/sanctum/csrf-cookie
* in response cookie copy XSRF-TOKEN (not %3D)
2. POST http://localhost:8080/api/login
* HEADER -> Contenet-Type : application/json
* HEADER -> X-XSRF-TOKEN : <"the copied xsrf-token">
* HEADER -> Accept : application/json
* in response cookie copy laravel_session (niet %3D)
3. GET,POST,... all other routes
* HEADER -> Contenet-Type : application/json
* HEADER -> X-XSRF-TOKEN : <"the copied xsrf-token">
* HEADER -> Accept : application/json
* HEADER -> Referer: localhost:8080
* HEADER -> Cookie: laravel_session=<the copied laravel_sesion>


## Recipes and troubleshooting

### <code>docker-compose up</code> does not start one or more containers
* Look at the output of <code>docker-compose up</code>. When a container (fails and) exits, it is shown as the last line of the container output (colored tags by container)
* Alternatively, start another terminal/cmd and inspect the output of <code>docker-compose ps -a</code>. You can see which container exited, exactly when.
* Probably one of the containers fails because TCP/IP port 8000, 8080 or 3307 is already in use on your system. Stop the environment, change the port in <code>docker-compose.yml</code> en rerun <code>docker-compose up</code>.


