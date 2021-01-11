# todotest
Todo laravel/vue test feladat

Futtatáshoz szükséges parancsok:

`git clone https://github.com/Dini108/todotest.git`
(A projekt klónozása)

`cd todotest` 
(Projekt győkér mappájába jutás)

`composer install`
(Composer dependenciák telepítése)

`npm i`
(NPM dependenciák telepítése)

`cp .env.example .env`
(Példa config fájl másolása és átnevezése)

`php artisan key:generate`
(Projekt kulcs generálása)

`npm run dev`
(app.js,app.css fájlok generálása)

A .env fájlban megadott adatbázis nevével készíteni kell egy adatbázist a .env fájlban tárolt host-ra.

`php artisan migrate`
(Adatbázis struktúra migrálása a config fájlban megadott adatbázisba)

Ezek után a projekt a http://localhost/todotest/public/ címen lesz elérhető.