mysql -u root fiber_report < c:\xampp\htdocs\fiber-report\database\migrations\sql.sql && cd ../.. & php artisan migrate && php artisan db:seed --class=UserSeeder && php artisan db:seed --class=BlowingsSeeder && php artisan db:seed --class=BlowdatasSeeder && php artisan db:seed --class=ClientsSeeder && cd database/migrations


