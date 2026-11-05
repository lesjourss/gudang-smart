# 📦 GudangSmart — Sistem Manufaktur & Inventory Gudang
> **Laporan & Dokumentasi Lengkap Ujian Tengah Semester (UTS) Praktik Pemrograman Web (PWTM)**  
> **Studi Kasus:** Sistem Informasi Pergudangan & Manufaktur Berbasis Framework Laravel 12 (PHP 8.2 & MariaDB)

---

## 📋 DAFTAR ISI
1. [Deskripsi Skenario Utama](#-deskripsi-skenario-utama)
2. [Kredensial Pengujian Akun (RBAC)](#-kredensial-pengujian-akun-rbac)
3. [Panduan Instalasi & Menjalankan Aplikasi](#-panduan-instalasi--menjalankan-aplikasi)
4. [Soal & Jawaban Lengkap UTS PWTM](#-soal--jawaban-lengkap-uts-pwtm)
   - [Nomor 1: Fondasi, Arsitektur & Routing (Bobot 15%)](#-nomor-1-fondasi-arsitektur--routing-bobot-15)
   - [Nomor 2: Blade Templating & Reusable Components (Bobot 20%)](#-nomor-2-blade-templating--reusable-components-bobot-20)
   - [Nomor 3: Skema Basis Data, Model ORM & Seeder (Bobot 20%)](#-nomor-3-skema-basis-data-model-orm--seeder-bobot-20)
   - [Nomor 4: Relasi, Form Request & Controller Kompleks (Bobot 25%)](#-nomor-4-relasi-form-request--controller-kompleks-bobot-25)
   - [Nomor 5: Autentikasi & Role-Based Access Control (Bobot 20%)](#-nomor-5-autentikasi--role-based-access-control-bobot-20)
5. [Hasil Uji Otomatis (Automated Testing)](#-hasil-uji-otomatis-automated-testing)
6. [Struktur Direktori Proyek](#-struktur-direktori-proyek)

---

## 🏢 DESKRIPSI SKENARIO UTAMA
Sebuah perusahaan manufaktur berskala menengah membutuhkan aplikasi **Sistem Manufaktur & Inventory Gudang ("GudangSmart")** untuk mencatat pergudangan, pemasok (*supplier*), katalog barang, serta mutasi penerimaan dan pengeluaran barang secara terstruktur, aman, dan efisien berbasis framework Laravel.

Aplikasi ini dikembangkan dengan arsitektur **MVC murni**, antarmuka terinspirasi dari gaya **minimalis iOS & shadcn/ui** berbasis Tailwind CSS, dilengkapi pengamanan hak akses berjenjang (Role-Based Access Control), validasi form ketat, pencegahan *N+1 Query*, serta mekanisme *Soft Deletes*.

---

## 🔑 KREDENSIAL PENGUJIAN AKUN (RBAC)

Basis data telah dilengkapi akun default hasil seeder untuk menguji kedua peran (*role*):

| Peran (*Role*) | Email Akun | Kata Sandi | Deskripsi Hak Akses & Pembatasan |
|---|---|---|---|
| **Manager Gudang** | `manager@gudangsmart.com` | `password` | **Wewenang Penuh**: Mengelola Supplier, Katalog Barang, Kategori, Mutasi Stok, Hapus Data Barang, serta akses Kotak Sampah / Trash (*Restore* & *Force Delete*). |
| **Staff Gudang** | `staff@gudangsmart.com` | `password` | **Akses Terbatas**: Melihat dashboard & katalog, menambah barang, mencatat mutasi stok. **Dilarang** menghapus barang atau mengedit/menghapus data supplier (HTTP 403 Forbidden). |

---

## 🚀 PANDUAN INSTALASI & MENJALANKAN APLIKASI

### 1. Prasyarat Lingkungan
- PHP $\ge$ 8.2
- Composer
- MariaDB / MySQL Server (XAMPP / Standalone) pada port `3306`

### 2. Langkah-Langkah Menjalankan
1. **Clone / Buka Proyek**:
   ```bash
   cd c:\Users\dhika\Documents\antigravity\gudang-smart
   ```
2. **Konfigurasi Environment**:
   Salin `.env.example` ke `.env` dan pastikan konfigurasi database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=db_gudang_smart
   DB_USERNAME=root
   DB_PASSWORD=
   ```
3. **Migrasi Database & Seeding Data**:
   ```bash
   php artisan migrate:fresh --seed
   ```
4. **Jalankan Server Lokal**:
   ```bash
   php artisan serve
   ```
5. **Akses Aplikasi**:
   Buka peramban pada [http://127.0.0.1:8000](http://127.0.0.1:8000) dan masuk menggunakan kredensial di atas.

---

## 📝 SOAL & JAWABAN LENGKAP UTS PWTM

```
========================================================================================
                              SOAL & JAWABAN NOMOR 1
========================================================================================
```

### 📌 NOMOR 1: FONDASI, ARSITEKTUR & ROUTING (BOBOT 15%)
> **CPL01**: Memiliki kompetensi yang baik dalam bidang komputasi dan mampu mengaplikasikan berbagai algoritma untuk menyelesaikan permasalahan organisasi.  
> **CPMK01B**: Memahami konsep dasar algoritma dan arsitektur aplikasi web modern sebagai langkah-langkah terstruktur untuk menyelesaikan suatu masalah secara sistematis, serta memahami pentingnya arsitektur dalam pengembangan perangkat lunak.

#### 1. Penjelasan Arsitektur: Alur Request-Response MVC Saat Akses Dashboard Inventory
Alur kerja komputasi saat pengguna meminta halaman `http://localhost:8000/admin/dashboard`:
1. **HTTP Request Phase**:
   - Browser mengirimkan HTTP Request `GET /admin/dashboard`.
   - Permintaan diterima oleh entry point `public/index.php` dan diteruskan ke HTTP Kernel Laravel.
2. **Routing & Middleware Pipeline Layer (`routes/web.php`)**:
   - Router mencocokkan URI ke rute grup `prefix('admin')` dengan nama `admin.dashboard`.
   - Melewati pipeline middleware:
     - `auth`: Memastikan session pengguna aktif.
     - `CheckRole:manager,staff`: Memverifikasi role pengguna terdaftar di sistem.
3. **Controller Execution Layer (`DashboardController@index`)**:
   - Controller mengeksekusi logika agregasi data inventaris:
     - `Supplier::count()`: Menghitung total supplier aktif.
     - `Barang::count()`: Menghitung total varian SKU barang.
     - `Barang::sum('stok')`: Akumulasi kuantitas stok fisik seluruh barang.
     - `Barang::with(['supplier', 'kategori'])->latest()->take(5)->get()`: Mengambil 5 barang terbaru via Eager Loading untuk mencegah *N+1 query*.
4. **Model & Database Layer (`App\Models\*`)**:
   - Model Eloquent mengeksekusi query SQL yang dioptimalkan ke MariaDB `db_gudang_smart` dan mengembalikan objek koleksi Eloquent.
5. **View Rendering Layer (`resources/views/dashboard.blade.php`)**:
   - Data dikirim ke view Blade, meng-extend master layout `layouts/app.blade.php`, merender komponen reusable (`<x-navbar>`, `<x-sidebar>`), dan menghasilkan 3 metric cards.
6. **HTTP Response Phase**:
   - HTML terkompilasi dikembalikan ke browser dengan kode status `200 OK`.

#### 2. Setup & Konfigurasi Environment
- Proyek dibuat bernama `gudang-smart`.
- Konfigurasi berkas `.env` tersambung ke database MariaDB `db_gudang_smart`:
  ```env
  APP_NAME="GudangSmart"
  APP_ENV=local
  APP_KEY=base64:Bph6rXNc8jgt0PeMLbQhIPRMpn5k46UIJraFvMTznj0=
  APP_DEBUG=true
  APP_URL=http://localhost:8000

  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=db_gudang_smart
  DB_USERNAME=root
  DB_PASSWORD=
  ```

#### 3. Perancangan Routing Fundamental (`routes/web.php`)
- **Rute Konvensional**:  
  `Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');`
- **Resource Route**:  
  - `Route::resource('suppliers', SupplierController::class);` (Named: `admin.suppliers.*`)
  - `Route::resource('barang', BarangController::class);` (Named: `admin.barang.*`)
- **Route Group & Named Routes**:  
  Semua rute terproteksi dikelompokkan dengan prefix `admin` dan alias rute `admin.`:
  ```php
  Route::middleware(['auth', 'role:manager,staff'])->prefix('admin')->name('admin.')->group(function () {
      Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
      Route::resource('suppliers', SupplierController::class);
      Route::resource('barang', BarangController::class);
      Route::resource('kategori', KategoriBarangController::class);
      Route::resource('mutasi', MutasiStokController::class)->only(['index', 'create', 'store']);
      // Manager Only
      Route::get('barang-trash', [BarangController::class, 'trash'])->name('barang.trash');
      Route::post('barang/{id}/restore', [BarangController::class, 'restore'])->name('barang.restore');
      Route::delete('barang/{id}/force-delete', [BarangController::class, 'forceDelete'])->name('barang.forceDelete');
  });
  ```

---

```
========================================================================================
                              SOAL & JAWABAN NOMOR 2
========================================================================================
```

### 🎨 NOMOR 2: BLADE TEMPLATING & REUSABLE COMPONENTS (BOBOT 20%)
> **CPL04**: Memiliki kemampuan untuk menganalisis, merancang, mengembangkan, dan mengevaluasi antarmuka pengguna serta aplikasi interaktif dengan mempertimbangkan kebutuhan pengguna dan tren teknologi terkini.  
> **CPMK04A**: Mampu menganalisis dan merancang antarmuka pengguna serta aplikasi interaktif menggunakan modul template engine yang reusable dan konsisten.

#### 1. Master Layout Inheritance (`resources/views/layouts/app.blade.php`)
- Dirancang menggunakan standar **modern minimalist iOS & shadcn/ui** berbasis Tailwind CSS CDN dan font Inter.
- Memiliki 4 blok struktur utama:
  - **Header**: Sticky bar dengan efek `backdrop-blur-xl`, memuat komponen `<x-navbar>`.
  - **Sidebar Navigation**: Menu samping vertikal sticky memuat komponen `<x-sidebar>`.
  - **Content Area**: Wadah konten dinamis `@yield('content')`, penampung flash message alert `<x-alert>`, serta stack styling/script (`@stack('styles')`, `@stack('scripts')`).
  - **Footer**: Area catatan hak cipta sistem di bagian bawah konten.

#### 2. Tiga Reusable Blade Components
1. **`<x-navbar>` (`resources/views/components/navbar.blade.php`)**:
   - Menampilkan logo GudangSmart.
   - Indikator status sistem interaktif (`Online` dengan animasi ping hijau).
   - Inisial avatar pengguna, nama lengkap, badge role (`manager`/`staff`), dropdown rincian akun, dan tombol Logout.
2. **`<x-sidebar>` (`resources/views/components/sidebar.blade.php`)**:
   - Menu navigasi bersih: *Dashboard*, *Supplier*, *Katalog Barang*, *Kategori Barang*, dan *Mutasi Stok*.
   - Deteksi menu aktif secara otomatis via `request()->routeIs(...)`.
   - Menu proteksi khusus Manager: *Data Sampah (Trash)* dengan penanda warna merah lembut.
   - Profil mini pengguna di bagian bawah sidebar.
3. **`<x-alert>` (`resources/views/components/alert.blade.php`)**:
   - Komponen pesan notifikasi reusable berbasis props: `:type="success|danger|warning|info"` dan `:message="..."`.
   - Dilengkapi icon SVG kontekstual dan tombol tutup (*dismissible*).

#### 3. Implementasi Halaman Dashboard (`resources/views/dashboard.blade.php`)
Menampilkan **3 Buah Card Ringkasan Metrik**:
1. **Total Supplier**: Menampilkan jumlah mitra pemasok terdaftar.
2. **Total Jenis Barang**: Menampilkan jumlah jenis/SKU barang dalam katalog.
3. **Total Stok Fisik Gudang**: Menampilkan akumulasi seluruh stok fisik (`SUM(stok)`).

Dilengkapi area pintasan aksi cepat (*Quick Actions*), status otorisasi role pengguna, dan tabel **Barang Baru Ditambahkan** secara responsif.

---

```
========================================================================================
                              SOAL & JAWABAN NOMOR 3
========================================================================================
```

### 🗄️ NOMOR 3: SKEMA BASIS DATA, MODEL ORM & SEEDER (BOBOT 20%)
> **CPL03**: Menguasai pengetahuan teoritis di bidang ilmu komputer dan mampu menerapkannya dalam perancangan dan pengembangan aplikasi multi-platform untuk memenuhi kebutuhan industri.  
> **CPMK03B**: Mampu menerapkan pengetahuan teoritis di bidang ilmu komputer dalam perancangan basis data relasional berbasis ORM (Object-Relational Mapping).

#### 1. Perancangan Skema Migration
Berkas migrasi dibuat terstruktur dengan foreign key cascades dan soft deletes:
- **Tabel `suppliers`** (`database/migrations/2024_01_01_000001_create_suppliers_table.php`):
  ```php
  Schema::create('suppliers', function (Blueprint $table) {
      $table->id();
      $table->string('kode_supplier', 10)->unique();
      $table->string('nama_pt');
      $table->string('email');
      $table->string('telepon');
      $table->text('alamat');
      $table->timestamps();
      $table->softDeletes();
  });
  ```
- **Tabel `kategori_barang`** (`database/migrations/2024_01_01_000002_create_kategori_barang_table.php`):
  ```php
  Schema::create('kategori_barang', function (Blueprint $table) {
      $table->id();
      $table->string('kode_kategori')->unique();
      $table->string('nama_kategori');
      $table->timestamps();
  });
  ```
- **Tabel `barang`** (`database/migrations/2024_01_01_000003_create_barang_table.php`):
  ```php
  Schema::create('barang', function (Blueprint $table) {
      $table->id();
      $table->string('kode_barang')->unique();
      $table->foreignId('kategori_id')->constrained('kategori_barang')->cascadeOnDelete();
      $table->foreignId('supplier_id')->constrained('suppliers')->cascadeOnDelete();
      $table->string('nama_barang');
      $table->integer('stok')->default(0);
      $table->decimal('harga_satuan', 15, 2);
      $table->timestamps();
      $table->softDeletes();
  });
  ```
- **Tabel Tambahan `mutasi_stok`** (`database/migrations/2024_01_01_000004_create_mutasi_stok_table.php`):
  Mencatat riwayat transaksi barang masuk/keluar, referensi `barang_id`, `user_id`, jenis mutasi (`masuk`/`keluar`), jumlah, dan keterangan.

#### 2. Model Eloquent & Trait SoftDeletes
- **`App\Models\Supplier`**: Menggunakan trait `SoftDeletes`, field fillable lengkap.
- **`App\Models\KategoriBarang`**: Manajemen entitas master kategori.
- **`App\Models\Barang`**: Menggunakan trait `SoftDeletes`, `$casts` untuk tipe data `stok` (integer) dan `harga_satuan` (decimal:2).

#### 3. Seeder & Factory Realistis
- **`SupplierFactory`**: Menghasilkan entitas PT industri resmi dengan format kode supplier 10 karakter unik (`SUP0000001` - `SUP0000010`), email perusahaan, no telepon, dan alamat Indonesia.
- **`BarangFactory`**: Menghasilkan suku cadang/komponen manufaktur riil (Bearing Roda, Baut Hexagonal, Pelumas Hidrolik, Pipa Baja, dsb.) dengan stok 10 - 500 dan harga realistis.
- **`DatabaseSeeder`**:
  - 2 Akun Pengguna (`manager@gudangsmart.com` dan `staff@gudangsmart.com`).
  - **6 Kategori Barang** (*Memenuhi syarat minimal 5 data*).
  - **10 Data Mitra Supplier** (*Memenuhi syarat minimal 10 data*).
  - **25 Sampel Komponen Barang** (*Memenuhi syarat minimal 20 data*).

---

```
========================================================================================
                              SOAL & JAWABAN NOMOR 4
========================================================================================
```

### ⚡ NOMOR 4: RELASI, FORM REQUEST & CONTROLLER KOMPLEKS (BOBOT 25%)
> **CPL02**: Menguasai keahlian dalam menganalisis masalah kompleks di bidang informatika dan mampu mengelola proyek teknologi dengan mempertimbangkan perkembangan ilmu lintas disiplin.  
> **CPMK02B**: Mampu mengelola proyek teknologi dan mengembangkan fitur pemrosesan data kompleks (Advanced CRUD, relasi multi-tabel, pencarian, dan validasi).

#### 1. Deklarasi Eloquent Relationship
- **Pada `Supplier`**:
  ```php
  public function barang(): HasMany {
      return $this->hasMany(Barang::class, 'supplier_id');
  }
  ```
- **Pada `KategoriBarang`**:
  ```php
  public function barang(): HasMany {
      return $this->hasMany(Barang::class, 'kategori_id');
  }
  ```
- **Pada `Barang`**:
  ```php
  public function supplier(): BelongsTo {
      return $this->belongsTo(Supplier::class, 'supplier_id');
  }

  public function kategori(): BelongsTo {
      return $this->belongsTo(KategoriBarang::class, 'kategori_id');
  }
  ```

#### 2. Advanced Form Request Validation
- **`StoreBarangRequest` (`app/Http/Requests/StoreBarangRequest.php`)**:
  ```php
  public function rules(): array {
      return [
          'kode_barang'  => 'required|string|max:10|unique:barang,kode_barang',
          'nama_barang'  => 'required|string|min:3',
          'kategori_id'  => 'required|exists:kategori_barang,id',
          'supplier_id'  => 'required|exists:suppliers,id',
          'stok'         => 'required|numeric|min:0',
          'harga_satuan' => 'required|numeric|min:0',
      ];
  }
  ```
- **`UpdateBarangRequest` (`app/Http/Requests/UpdateBarangRequest.php`)**:
  Mengabaikan ID barang saat ini pada validasi unique agar tidak memicu error saat data disimpan kembali:
  ```php
  $barangId = $this->route('barang')?->id ?? $this->route('barang');
  return [
      'kode_barang'  => ['required', 'string', 'max:10', Rule::unique('barang', 'kode_barang')->ignore($barangId)],
      'nama_barang'  => 'required|string|min:3',
      'kategori_id'  => 'required|exists:kategori_barang,id',
      'supplier_id'  => 'required|exists:suppliers,id',
      'stok'         => 'required|numeric|min:0',
      'harga_satuan' => 'required|numeric|min:0',
  ];
  ```

#### 3. Logika Kompleks `BarangController`
- **Eager Loading**:
  `Barang::with(['supplier', 'kategori'])` dipanggil pada listing index untuk mencegah masalah **N+1 Query**.
- **Search & Filter Dinamis**:
  Mendukung filter teks nama/kode serta dropdown ID kategori:
  ```php
  $query = Barang::with(['supplier', 'kategori']);

  if ($request->filled('search')) {
      $query->where(function ($q) use ($request) {
          $q->where('nama_barang', 'like', "%{$request->search}%")
            ->orWhere('kode_barang', 'like', "%{$request->search}%");
      });
  }

  if ($request->filled('kategori_id')) {
      $query->where('kategori_id', $request->kategori_id);
  }
  ```
- **Pagination**:
  `$query->latest()->paginate(10)->withQueryString()` membatasi 10 data per halaman dengan mempertahankan parameter URL query filter.
- **Operasi Soft Deletes (Trash, Restore, Force Delete)**:
  - `trash()`: Menampilkan data terhapus via `Barang::onlyTrashed()->with(['supplier', 'kategori'])->paginate(10)`.
  - `restore($id)`: Memulihkan status aktif via `Barang::onlyTrashed()->findOrFail($id)->restore()`.
  - `forceDelete($id)`: Menghapus permanen dari basis data via `Barang::onlyTrashed()->findOrFail($id)->forceDelete()`.

---

```
========================================================================================
                              SOAL & JAWABAN NOMOR 5
========================================================================================
```

### 🛡️ NOMOR 5: AUTENTIKASI & ROLE-BASED ACCESS CONTROL (BOBOT 20%)
> **CPL02**: Menguasai keahlian dalam menganalisis masalah kompleks di bidang informatika dan mampu mengelola proyek teknologi dengan mempertimbangkan perkembangan ilmu lintas disiplin.  
> **CPMK02C**: Mampu menerapkan pengamanan hak akses (Authentication & Authorization) dan proteksi rute berbasis peran pengguna (Role-based Middleware).

#### 1. Fitur Authentication Lengkap (`app/Http/Controllers/AuthController.php`)
- **Login (`GET /login`)**: Menampilkan formulir masuk dengan visual elegan dan tombol isi otomatis (*One-Click Demo Fill*) untuk Manager & Staff.
- **Authenticate Process (`POST /login`)**: Memvalidasi email & password, menjalankan `Auth::attempt()`, serta melakukan regenerasi sesi (`$request->session()->regenerate()`) untuk mencegah serangan *Session Fixation*.
- **Logout & Session Invalidation (`POST /logout`)**:
  ```php
  Auth::logout();
  $request->session()->invalidate();
  $request->session()->regenerateToken();
  return redirect()->route('login')->with('info', 'Anda telah keluar dari sesi kerja.');
  ```

#### 2. Penerapan Custom Middleware `CheckRole` (`app/Http/Middleware/CheckRole.php`)
Middleware bertugas memverifikasi peran user yang sedang login:
```php
public function handle(Request $request, Closure $next, ...$roles): Response
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu.');
    }

    $user = Auth::user();
    if (!in_array($user->role, $roles)) {
        abort(403, 'Akses Ditolak: Anda tidak memiliki otoritas untuk fitur ini.');
    }

    return $next($request);
}
```
**Pembagian Peran Sesuai Soal**:
- **Manager Gudang (`manager`)**: Memiliki wewenang penuh atas seluruh fitur sistem (Data Master Supplier & Barang, Mutasi Stok, Edit/Hapus, Kotak Sampah/Trash, Restore, & Force Delete).
- **Staff Gudang (`staff`)**: Hanya memiliki hak akses untuk melihat katalog barang dan mencatat transaksi mutasi stok. Tindakan menghapus data barang (`DELETE /admin/barang/{id}`) atau mengedit/menghapus data supplier ditolak dengan respon **HTTP 403 Forbidden**.

#### 3. Proteksi Route Group
Seluruh rute sistem diproteksi di `routes/web.php` dengan kombinasi middleware:
- Jika belum login $\rightarrow$ dialihkan otomatis ke `/login` disertai pesan peringatan.
- Jika login sebagai `staff` lalu mengakses fitur Manager $\rightarrow$ diblokir oleh middleware dengan `403 Forbidden`.

---

## 🧪 HASIL UJI OTOMATIS (AUTOMATED TESTING)

Pengujian end-to-end dan unit fungsional dibuat pada `tests/Feature/GudangSmartSystemTest.php`. Semua skenario lulus dengan status **100% PASS**:

```bash
$ php artisan test

   PASS  Tests\Unit\ExampleTest
  ✓ that true is true                                                    0.03s  

   PASS  Tests\Feature\ExampleTest
  ✓ the application returns a successful response                        0.38s  

   PASS  Tests\Feature\GudangSmartSystemTest
  ✓ login flow (Autentikasi & Session Invalidation)                     0.60s  
  ✓ dashboard metrics accessible (3 Buah Card Ringkasan)                 2.10s  
  ✓ store barang validation (Validasi Form Request Ketat)                0.20s  
  ✓ barang search and filter (Eager Loading & Filter Kategori)           0.94s  
  ✓ soft delete and restore (Operasi Trash & Pemulihan)                  0.50s  
  ✓ rbac staff restrictions (Proteksi Hak Akses Manager vs Staff)        0.23s  
  ✓ mutasi stok transaction by staff (Pencatatan Mutasi Masuk & Keluar)  0.17s  

  Tests:    9 passed (40 assertions)
  Duration: 5.63s
```

---

## 📁 STRUKTUR DIREKTORI PROYEK

```
gudang-smart/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php          # Login, Auth Attempt, Logout Invalidation
│   │   │   ├── BarangController.php        # Eager Loading, Search, Filter, Soft Deletes
│   │   │   ├── DashboardController.php     # 3 Metric Cards Ringkasan Inventaris
│   │   │   ├── KategoriBarangController.php# Master Data Kategori
│   │   │   ├── MutasiStokController.php    # Transaksi Barang Masuk & Keluar
│   │   │   └── SupplierController.php      # Master Data Supplier & RBAC Protection
│   │   ├── Middleware/
│   │   │   └── CheckRole.php               # Custom Middleware Proteksi Role
│   │   └── Requests/
│   │       ├── StoreBarangRequest.php      # Validasi Tambah Barang Ketat
│   │       └── UpdateBarangRequest.php     # Validasi Update Barang + Unique Ignore
│   └── Models/
│       ├── Barang.php                      # Model Barang + SoftDeletes + Casts
│       ├── KategoriBarang.php              # Model Kategori + Relasi HasMany
│       ├── MutasiStok.php                  # Model Mutasi Stok Log
│       ├── Supplier.php                    # Model Supplier + SoftDeletes
│       └── User.php                        # Model User + Role Column
├── database/
│   ├── factories/
│   │   ├── BarangFactory.php               # Generator Komponen Manufaktur Realistis
│   │   └── SupplierFactory.php             # Generator PT Supplier Resmi
│   ├── migrations/
│   │   ├── ..._create_suppliers_table.php
│   │   ├── ..._create_kategori_barang_table.php
│   │   ├── ..._create_barang_table.php
│   │   └── ..._create_mutasi_stok_table.php
│   └── seeders/
│       └── DatabaseSeeder.php              # Seed 2 Users, 6 Kategori, 10 Supplier, 25 Barang
├── resources/
│   └── views/
│       ├── auth/
│       │   └── login.blade.php             # Halaman Login iOS/shadcn Style
│       ├── components/
│       │   ├── alert.blade.php             # Reusable Component <x-alert>
│       │   ├── navbar.blade.php            # Reusable Component <x-navbar>
│       │   └── sidebar.blade.php           # Reusable Component <x-sidebar>
│       ├── layouts/
│       │   └── app.blade.php               # Master Layout App (Minimalist iOS Style)
│       ├── barang/                         # Index, Create, Edit, Show, Trash
│       ├── suppliers/                      # Index, Create, Edit, Show
│       ├── kategori/                       # Index Kategori
│       ├── mutasi/                         # Index & Form Mutasi Stok
│       └── dashboard.blade.php             # Dashboard 3 Metric Cards + Quick Actions
├── routes/
│   └── web.php                             # Perancangan Route Group, Resource, & Middleware
└── tests/
    └── Feature/
        └── GudangSmartSystemTest.php       # Suite Pengujian Otomatis 9 Test 40 Assertions
```

---
*Dokumentasi ini disusun secara terstruktur untuk memenuhi seluruh capaian pembelajaran (CPL & CPMK) pada Ujian Tengah Semester (UTS) Praktik Pemrograman Web.*
