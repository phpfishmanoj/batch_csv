<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Upload with progress

- /c/xampp/htdocs/batch_csv/public/batch_csv_front 
- npm run dev

frontend start with local url ## http://localhost:3000/upload

![image](https://github.com/user-attachments/assets/9aedc868-732a-401c-a918-638183779811)

## Laravel
- Open the .env file and set the queue driver:
QUEUE_CONNECTION=database

This example uses the database driver, but you can also choose redis, beanstalkd, sqs, or others depending on your preference.
If you're using the database driver, you need to create a table for storing job data. You can create this table by running:

- php artisan queue:table
- php artisan migrate

- php artisan make:job JobBatchUploadFileDataProcess

- /c/xampp/htdocs/batch_csv 
- php artisan serve

backend start with local url ## http://localhost:8000/

- /c/xampp/htdocs/batch_csv
to start queue job 
- php artisan queue:work
To check the list of failed jobs:
- php artisan queue:failed
To retry failed jobs:
- php artisan queue:retry all
To delete all failed jobs:
- php artisan queue:flush
You can also specify a delay before the job is executed. For example:
$user = User::findOrFail($userId);
JobBatchUploadFileDataProcess::dispatch($user)->delay(now()->addMinutes(10));
or
JobBatchUploadFileDataProcess::bus($user)->delay(now()->addMinutes(10));

Controller: UploadFileChunkController
Method: BatchUploadFileProcess

![image](https://github.com/user-attachments/assets/bd8a2197-968f-421e-9f64-646dca978e9a)

![image](https://github.com/user-attachments/assets/2fe610c7-2001-448e-8365-0212185bee52)

![image](https://github.com/user-attachments/assets/1c74002d-d0cc-401f-bd73-fb569443ab1f)

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
