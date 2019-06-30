# Currency Rate ( Demo Project ) 

## Laravel + Vue Js

### Demo - [http://currency.truecodemedia.com ](http://currency.truecodemedia.com)

## Deployment guide

#### Step 1 : 

Clone the project in the directory where all your sites lives. here is the command to clone the project 

` git clone https://github.com/TrueCodeMedia/currency_exchange.git`


#### Step 2 : 

`cd /project directory path` and run following commands to get laravel dependancies

`composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev`


#### Step 3 : 

rename .env.example to .env using following command. 

`mv .env.example .env`  

`php artisan key:generate`


Change App url to your domain app url in `.env`

```
APP_URL=http://currency.truecodemedia.com
```


Put Database credentials in `.env`

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_name
DB_USERNAME=db_username
DB_PASSWORD=db_password
```

#### Step 4 : 

Create a database in mysql. 


#### Step 5 : 

Run database migration this will create all neccesary tables in the database

`php artisan migrate --force`


#### Step 6 : 
Add neccesary permissions 

```
sudo chown -R www-data:www-data /path/to/project/directory
sudo find /path/to/project/directory -type f -exec chmod 644 {} \; 
sudo find /path/to/project/directory -type d -exec chmod 755 {} \;
sudo chgrp -R www-data storage bootstrap/cache
sudo chmod -R ug+rwx storage bootstrap/cache

```


#### Step 7 : 

Add the cron entry on the server to schedule tasks 

`5 0 * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1`


This Cron will call the Laravel command scheduler five minutes after midnight, every day. When the  `schedule:run` command is executed, Laravel will evaluate your scheduled tasks and runs the tasks that are due.


#### Step 8 : 

Create a symlink between public and storage directory using following command 

`php artisan storage:link`



Thats it ! You can visit your domain url in the browser. 

