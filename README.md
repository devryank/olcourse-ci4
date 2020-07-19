# Sistem Pendukung Keputusan Menggunakan Metode SAW
- CodeIgniter 4
- Bootstrap 4
- JQuery

## What is CodeIgniter?

CodeIgniter is a PHP full-stack web framework that is light, fast, flexible, and secure. 
More information can be found at the [official site](http://codeigniter.com).

## Server Requirements

PHP version 7.2 or higher is required, with the following extensions installed: 

- [intl](http://php.net/manual/en/intl.requirements.php)
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)
- xml (enabled by default - don't turn it off)

## Bootstrap 4

the world’s most popular framework for building responsive, mobile-first sites, with BootstrapCDN.
[getbootstrap](http://getbootstrap.com)


# Online Course ...

Sama seperti website online course lainnya, website olcourse-ci4 ini dapat digunakan sebagai media belajar mengajar secara daring. User dapat membeli 2 jenis pembelajaran: Paket dan Kelas. Paket terdiri dari beberapa kelas.

## How to Install
1. `git clone https://github.com/devryank/olcourse-ci4.git`
2. Buat database di local dengan nama olcourse atau yang lainnya.
3. Import olcourse.db
4. setting .env sesuai kebutuhan
 	- database.default.hostname = localhost
	- database.default.database = olcourse
	- database.default.username = root
	- database.default.password =
	- database.default.DBDriver = MySQLi
5. `php spark serve`

## Tahap Tambahan - Fitur Kirim E-mail
1. Buka Controller Auth, Admin, dan Home.
2. ubah smtpUser, smtpPass dan setFrom sesuai akun e-mail.

# Fitur

## User
1. Register (Kirim link verifikasi ke e-mail yang aktif) dan login
2. Cari paket dan kelas
3. Pembelian paket dan kelas
4. Redeem token kelas
5. Dashboard
6. Materi
7. Invoice
8. Daftar paket dan kelas yang sudah diselesaikan
9. Validasi paket yang belum dan sudah dibeli

## Admin
1. Grafik penjualan bulanan dan perbandingan penjualan paket dan kelas
2. Master Paket, Kelas, Topik, User, Diskon
3. Verifikasi Transaksi

# Akun
## Admin
e-mail = ryanolcourse@gmail.com
password = admin

## User
e-mail = ryansg41@gmail.com, ihsan@gmail.com
password = user

## SCREENSHOT
![Image 1](https://imgur.com/Aka6B0p.png)
![Image 2](https://imgur.com/fmVx2Tq.png)
![Image 3](https://imgur.com/UCmmukW.png)
![Image 4](https://imgur.com/J03PIIi.png)
![Image 5](https://imgur.com/3KAhEkh.png)
![Image 6](https://imgur.com/xa5fa0H.png)
![Image 7](https://imgur.com/nWgZubU.png)
![Image 8](https://imgur.com/9INPMPa.png)