# Aplikasi Peresepan obat


### Requirements
- PHP versi ^8.2
- Laravel Framework ^11.9
- Database MySQL

### Installation

Buat database dengan nama dbperesepan
Lalu Jalankan command berikut 

```sh
composer setup
```
command tersebut akan membuat file .env dan menjalankan composer install, key generate, migration serta databaseSeeder

untuk config database dapat disesuaikan di file .env anda yang sudah dibuat oleh command di atas.

### Akun Admin

Untuk membuat akun dokter dan apoteker bisa langsung pakai dari hasil generate seeder bisa juga melalui admin.
berikut login admin : 

```sh
email 		: admin@rsam.com
password 	: admin123
```

### Akun Dokter

Berikut untuk login akun dokter

```sh
email 		: tirta@rsam.com
password 	: dokter123
```

### Akun Apoteker

Berikut untuk login akun apoteker

```sh
email 		: anggun@rsam.com
password 	: apoteker123
```