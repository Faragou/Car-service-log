# Autószerviz napló rendszer

Ez a projekt egy Laravel alapú backend és egy Vue.js alapú frontend alkalmazás, amely lehetővé teszi ügyfelek és autóik nyilvántartását, valamint szerviznaplóik megtekintését

## 📌 Verzióinformációk

### **Backend**
- Laravel Framework: **12.3.0**
- Composer: **2.8.6 (2025-02-25)**
- Apache: **2.4.58**
- MariaDB: **10.4.32**
- PHP: **8.2.12 (VS16 X86 64bit thread safe) + PEAR**
- phpMyAdmin: **5.2.1**
- XAMPP: **8.2.12**
- XAMPP Control Panel: **3.3.0**

### **Frontend**
- Vue.js: **3.2.13**
- Axios: **1.8.4**
- Tailwind CSS: **3.4.17**
- AG Grid: **33.2.1**
- Vue Toastification: **2.0.0-rc.5**
- Vue CLI: **5.0.0**

---

## ⚙️ **Telepítési lépések**

### 1. XAMPP telepítése és konfigurálása

1. **Töltsd le és telepítsd a XAMPP-ot** [XAMPP letöltés](https://www.apachefriends.org/index.html)
2. **Indítsd el a XAMPP Control Panelt** és aktiváld az **Apache** és **MySQL** szolgáltatásokat.
3. **Nyisd meg a phpMyAdmin-t** böngészőben:  http://localhost/phpmyadmin
4. **Hozz létre egy új adatbázist** (például `carservice`).

---

### 2. Backend telepítése (Laravel)

1. **Klónozd a projektet**  
```sh
git clone https://github.com/felhasznalo/projekt-neve.git
cd projekt-neve/backend

### **Backend telepítése (Laravel)**

#### **1.1 Klónozd a projektet**
```sh
git clone https://github.com/felhasznalo/projekt-neve.git
cd projekt-neve/backend
```
Függőségek telepítése
```sh
composer install
```
Környezeti változók beállítása
Másold az .env.example fájlt és nevezd át .env-re:
```sh
cp .env.example .env
```
Majd generálj egy új alkalmazáskulcsot:
```sh
php artisan key:generate
```
Adatbázis beállítása
Nyisd meg az .env fájlt és állítsd be az adatbázis kapcsolatot:
```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=adatbazis_nev
DB_USERNAME=root
DB_PASSWORD=
```

Ezután futtasd a migrációkat és az alapadatok feltöltését ilyen sorrendben:
Migárciók:
```sh
php artisan migrate --path=database/migrations/2025_03_28_123102_create_sessions_table.php
php artisan migrate --path=database/migrations/2025_03_28_104339_create_clients_table.php
php artisan migrate --path=database/migrations/2025_03_28_104421_create_cars_table.php
php artisan migrate --path=database/migrations/2025_03_28_104359_create_services_table.php
```

Seedelés:
```sh
php artisan db:seed --class=JSONDataSeeder 
```
Szerver elindítása
```sh
php artisan serve
```
### **Backend telepítése (Vue.js)**

Lépj be a frontend mappába:
```sh
cd ../my-project
```
Függőségek telepítése:
```sh
npm install
```
Környezeti változók beállítása
Hozz létre egy .env fájlt a frontend gyökérkönyvtárában, és add hozzá:
```sh
VITE_API_BASE_URL=http://127.0.0.1:8000/api
```

Fejlesztői szerver indítása
```sh
npm run serve
```








