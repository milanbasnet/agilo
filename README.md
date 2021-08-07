# Steps

1. Composer install
2. Create a file .env on root directory and copy .env.example to .env and set all variables on .env for database and emails and ffmpeg
3. run command 'php artisan key:generate'
4. run command 'php artisan jwt:secret'
5. run command 'php artisan migrate'
6. run command 'php artisan db:seed'
7. run command 'php artisan storage:link'
7. finally 'php artisan serve'
