# United Tractors
## Simple CRUD Product Application

### Setting ENV
Atur env untuk konfigurasi database, sesuaikan dengan konfigurasi database masing-masing.

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=united_tractor
DB_USERNAME=root
DB_PASSWORD=

Buat database, lalu jalankan perintah
```json
php artisan migrate:fresh
```

### Caution
Aplikasi dijalankan dengan asumsi bahwa setiap test berjalan dengan request yang baik dan benar