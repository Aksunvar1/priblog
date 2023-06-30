Installation

<h1>For Backend</h1>
git clone https://github.com/Aksunvar1/priblog
<hr>
cd priblog-backend/
<hr>
cp .env.example .env 
<hr>
<h1>Docker and database</h1>
sail='[ -f sail ] && sh sail || sh vendor/bin/sail' sail up -d --build
<hr>
php artisan migrate:fresh --seed
<hr>
php artisan serve --port=8000

<h1>Composer shortcuts</h1>
composer test: runs the following scripts "@pint","@phpmd","@paratest"
<hr>
pint: wrapper around php code sniffer
<hr>
phpmd: mass detection
<hr>
paratest: tests the application in parallel
<hr>

<h1>For Frontend</h1>
npm install && npm run dev
<hr>

