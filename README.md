--------------------
RunCloud Workspace
--------------------

Laravel Setup
---------------------------------------------------
```sh
composer i
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serv
```

Vite Setup
---------------------------------------------------
```sh
npm i
npm run dev
```

Docker (optional)
---------------------------------------------------
```sh
docker compose up --build 
```

.env for database 
1. DB_USERNAME must be other than root
2. DB_PASSWORD cannot be empty

.env database setup example
----------------------
```sh
DB_CONNECTION=mysql
DB_HOST=database # Docker database service
DB_PORT=3306
DB_DATABASE=runcloud
DB_USERNAME=runclouduser
DB_PASSWORD=runcloudpassword
```

if database have no data, seed it
```sh
docker exec -it runcloud-laravel php artisan migrate:fresh --seed
```

