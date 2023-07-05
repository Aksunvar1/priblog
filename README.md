Installation

<h1>For Backend</h1>
git clone https://github.com/Aksunvar1/priblog
<hr>
cd priblog-backend/
<hr>
cp .env.example .env 
<hr>
<h1>Docker and database</h1>
sail= ./vendor/bin/sail up -d --build
<hr>
php artisan migrate:fresh --seed
<hr>
php artisan serve --port=8000

<h1>Composer shortcuts</h1>
composer test: runs all the following scripts "@pint","@phpmd","@paratest"
<hr>
composer pint: laravel code style fixer
<hr>
composer phpmd: Mess detection
<hr>
composer paratest: tests the application in parallel
<hr>

<h1>For Frontend</h1>
npm install && npm run dev
<hr>

Application authorization system runs on laravel sanctum. It provides a similar token to example below
<hr>
4|PjVhSTiTDUfhOJddKMrWoR7Ak0CV9HG01G8DtahV
<hr>
Postman Collection link:
<hr>
https://documenter.getpostman.com/view/8483728/2s93zB627o#929b15d4-05ec-446c-bc8d-a3c0ad0f06e0
<hr>

<h2> Development will continue in develop branch</h2>

