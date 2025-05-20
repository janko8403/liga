# Wymagania

composer 2  
php 8.0.17+  
node 17  
npm 8.1

# Instalacja

```
composer install

```

```
npm install
```

Kompilujemy 

```
npm run dev
```

W środowisku lokalnym 

```
npm run w
```

Generujemy klucze

```
php artisan key:generate
```

Podstawowa konfiguracja i ustawienia bazy danych
```
cp .env.example .env
```
```
vim .env
```
#Autoryzacja CAS
```
CAS_ENABLED=false
CAS_USE_CASMANAGER=false
CAS_HOST=https://zaloguj-pre.pzu.pl/
```

```
CAS_ENABLED
```
Włączanie wyłączanie autoryzacji CAS

```
CAS_USE_CASMANAGER
```
Przy wyłączonej autoryzacji CAS dodane środowiska mogą korzystać z ustawień pobranych z http://casmanager.dev.focusmedia.pl/

Gdy oba ustawienia są wyłączone serwis używa lokalnych ustawień domyślnych (brak autoryzacji/parametry ustalane lokalnie).

```
CAS_HOST
```

Środowisko PROD - https://zaloguj.pzu.pl
Środowisko UAT - https://zaloguj-pre.pzu.pl


Wybieramy początkowy zakres danych. Seed administratorów zawiera przykładowe hasła które nie powinny być używane w środowiskach produkcyjnych.

```
vim database/seeders/DatabaseSeeder.php
```
Uruchamiamy migracje

```
php artisan migrate --seed

```

Optymalizacja tras w cache

```
php artisan route:cache
```




PhpStorm
```
php artisan serve
```

# JS

npm run development -> kompilacja js,css
