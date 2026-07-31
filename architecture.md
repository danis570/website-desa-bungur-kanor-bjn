# Architecture

## Website Desa Bungur

Dokumen ini menjelaskan arsitektur aplikasi Website Desa Bungur yang dibangun menggunakan PHP Native dengan pola Repository, Service, Domain, dan MVC.

---

# Tujuan Arsitektur

Arsitektur ini dibuat agar:

* Memisahkan business logic dari tampilan.
* Mudah diuji menggunakan PHPUnit.
* Mudah dikembangkan ketika fitur bertambah.
* Memiliki tanggung jawab yang jelas pada setiap layer.
* Meminimalkan duplikasi kode.

---

# Struktur Folder

```text
src/
│
├── App/
│   ├── Auth.php
│   ├── Router.php
│   └── View.php
│
├── Config/
│   └── Database.php
│
├── Controller/
│   ├── AuthController.php
│   ├── HomeController.php
│   ├── ProfileController.php
│   ├── ArticleController.php
│   ├── Admin/
│   └── User/
│
├── Domain/
│
├── Exception/
│
├── Middleware/
│
├── Model/
│
├── Repository/
│
├── Service/
│
└── View/
    ├── Public/
    ├── Admin/
    └── User/
```

---

# Layer Architecture

```text
Browser
    │
    ▼
Router
    │
    ▼
Middleware
    │
    ▼
Controller
    │
    ▼
Service
    │
    ▼
Repository
    │
    ▼
Database
```

---

# Domain

Domain merepresentasikan tabel pada database.

Contoh:

```
users
sessions
articles
categories
gallery
```

Setiap tabel memiliki satu class Domain.

Contoh:

```text
Domain/
├── User.php
├── Session.php
├── Article.php
└── Category.php
```

Domain hanya berisi data.

Tidak memiliki business logic.

---

# Model

Model digunakan sebagai DTO (Data Transfer Object).

Contoh:

```text
UserCreateRequest
UserCreateResponse

UserLoginRequest
UserLoginResponse

ArticleCreateRequest
ArticleCreateResponse
```

Model digunakan untuk komunikasi antara Controller dan Service.

---

# Repository

Repository bertanggung jawab terhadap seluruh operasi database.

Contoh:

```php
save()

findById()

findByEmail()

update()

delete()

deleteAll()
```

Repository tidak memiliki business logic.

Repository hanya mengetahui SQL.

---

# Service

Service merupakan tempat seluruh business logic.

Contoh:

```text
Login User

Create User

Create Article

Update Profile

Change Password

Create Session
```

Service memanggil Repository.

Service tidak mengetahui HTTP.

Service tidak mengetahui View.

Service tidak mengetahui Cookie.

---

# Controller

Controller bertugas menerima Request HTTP.

Controller bertanggung jawab terhadap:

* membaca $_POST
* membaca $_GET
* membaca $_FILES
* membuat Request Model
* memanggil Service
* render View
* redirect
* set Cookie

Controller tidak memiliki business logic.

---

# Middleware

Middleware dijalankan sebelum Controller.

Digunakan untuk:

* autentikasi
* otorisasi
* validasi akses

Contoh:

```
MustLoginMiddleware

MustNotLoginMiddleware

AdminMiddleware
```

---

# Auth

Auth digunakan sebagai penyimpan user yang sedang login selama satu request.

```text
Auth::$user
```

Flow:

```
Cookie

↓

SessionService

↓

User

↓

Auth::$user
```

Controller cukup menggunakan:

```php
Auth::$user
```

tanpa melakukan query ulang.

---

# Session

Session terdiri dari dua bagian.

## Session Database

```text
sessions
```

Berisi:

* session id
* user id
* created_at
* expired_at

---

## Cookie

Browser hanya menyimpan:

```
session_id
```

Cookie digunakan untuk mencari session pada database.

---

# Authentication Flow

```text
Login Form

↓

AuthController

↓

UserService::login()

↓

UserRepository

↓

Password Verify

↓

SessionService::create()

↓

SessionRepository

↓

Cookie

↓

Redirect
```

---

# Authorization Flow

```text
Request

↓

MustLoginMiddleware

↓

AdminMiddleware

↓

Controller
```

MustLoginMiddleware memastikan user telah login.

AdminMiddleware memastikan role adalah admin.

---

# View

View hanya bertanggung jawab menampilkan halaman.

Tidak boleh terdapat query database.

Tidak boleh terdapat business logic.

View hanya menerima data dari Controller.

---

# Render View

Public

```php
View::renderPublic(...)
```

Admin

```php
View::renderAdmin(...)
```

User

```php
View::renderUser(...)
```

---

# Transaction

Business logic yang mengubah data menggunakan transaction.

Contoh:

```php
Database::beginTransaction();

...

Database::commitTransaction();
```

Jika terjadi error:

```php
Database::rollbackTransaction();
```

---

# Unit Test

Seluruh Repository dan Service diuji menggunakan PHPUnit.

Repository Test:

* save
* update
* delete
* findById
* findByEmail

Service Test:

* create success
* validation failed
* duplicate email
* login success
* wrong password
* session
* dan seluruh skenario lainnya

Controller tidak diuji menggunakan PHPUnit karena berhubungan langsung dengan HTTP, Cookie, Redirect, dan Render View.

---

# Prinsip Pengembangan

Setiap layer memiliki satu tanggung jawab.

```
Controller
↓
mengatur HTTP

Service
↓
mengatur business logic

Repository
↓
mengatur database

Domain
↓
merepresentasikan data

View
↓
menampilkan halaman
```

Setiap layer tidak boleh mengambil tanggung jawab layer lainnya.

Dengan prinsip ini aplikasi menjadi lebih mudah dipelihara, mudah diuji, dan mudah dikembangkan seiring bertambahnya fitur.
