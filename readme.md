# Dataset Management Platform

## Description

Project ini dibuat menggunakan frameworok [laravel 5.8](https://laravel.com/docs/5.8). Dalam project ini terdapat berberapa fitur yaitu authentikasi, CRUD annotator, penggelolaan Dataset baik itu upload dataset, download dataset,  booking task dan revoke task. 

Terdapat 2 user yang dapat mengakses aplikasi ini yaitu :
* Admin
* Annotator

Admin adalah yang mengelola data annotator dan task

Annotator adalah yang mem-booking task

## Packages

* [Laravel Datatables](https://github.com/yajra/laravel-datatables)
* [Laravel Sweetalert](https://github.com/realrashid/sweet-alert
)



## Requirements

* PHP >= 7.1.3
* [Composer](https://getcomposer.org)
* Database (Mysql, Postgre, Sqlite, dll)

## Installation

1. Download atau clone project
```
git clone https://github.com/vikicta/dataset-management-platform.git
```

2. Masuk kedalam folder project menggunakan ***command line*** atau ***terminal***

3. Ketik *command* di bawah untuk menginstal *packages* yang digunakan
```
composer install
```
4. Buat file **.env** dan copy isi yang ada di **.env.example** ke file **.env** atau bisa mengetikan *command* ini
```
cp .env.example .env
```
5. Buka file **.env** kemudian ubah konfigurasi database, contoh :
```
DB_CONNECTION=sqlite
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=/Folder/Database/database.sqlite
DB_USERNAME=root
DB_PASSWORD=
```

6. *Generate key*
```
php artisan key:generate
```
7. Migrasi **file database** dan ***run seeder*** yang sudah tersedia di repo ini dengan mengetikan
```
php artisan migrate --seed
```

## Notes

Login admin  :
* Username : admin
* Password : admin

Login annotator :
* Username : annotator1
* Password : annotator1
---

* Username : annotator2
* Password : annotator2



