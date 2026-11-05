# LAPORAN & DOKUMENTASI LENGKAP UTS PRAKTIK PEMROGRAMAN WEB (PWTM)
## SISTEM MANUFAKTUR & INVENTORY GUDANG ("GudangSmart")

Aplikasi Sistem Informasi Pergudangan dan Manufaktur berbasis **Laravel 12 (PHP 8.2 & MariaDB)** yang menerapkan pola arsitektur MVC, Blade Templating reusable components, database migrations dengan Soft Deletes, Eloquent ORM relationships, Advanced Form Request Validation, Eager Loading (bebas N+1 query), serta Role-Based Access Control (RBAC).

---

## 🔑 KREDENSIAL UJI COBA APLIKASI

| Peran (Role) | Alamat Email | Kata Sandi | Batasan Hak Akses |
|---|---|---|---|
| **Manager Gudang** | `manager@gudangsmart.com` | `password` | **Akses Penuh**: Master Data Supplier, Katalog Barang, Mutasi Stok, Hapus Barang, dan Kotak Sampah (Restore & Force Delete). |
| **Staff Gudang** | `staff@gudangsmart.com` | `password` | **Akses Terbatas**: Melihat dashboard, melihat katalog barang, menambah barang, mencatat stok. **Dilarang** menghapus data barang atau mengedit data supplier (HTTP 403 Forbidden). |

---

## 📌 JAWABAN SOAL 1: FONDASI, ARSITEKTUR & ROUTING (BOBOT 15%)

### 1.1 Penjelasan Arsitektur: Alur Request-Response MVC pada Dashboard Inventory
Saat pengguna mengakses URL `http://localhost:8000/admin/dashboard`:
1. **HTTP Request Phase**:
   Browser mengirimkan permintaan HTTP GET ke alamat `/admin/dashboard`.
2. **Routing & Middleware Pipeline Layer (`routes/web.php`)**:
   Laravel memetakan permintaan ke rute grup ber-prefix `admin` dengan nama `admin.dashboard`. Permintaan melewati serangkaian middleware:
   - `auth`: Memastikan user memiliki sesi aktif (jika belum, diredirect ke `/login`).
   - `CheckRole:manager,staff`: Memvalidasi peran akun pengguna pada tabel `users`.
3. **Controller Execution Layer (`DashboardController@index`)**:
   Controller dipanggil untuk mengolah logika bisnis. Controller memanggil Model Eloquent untuk mengambil ringkasan data inventaris:
   - `Supplier::count()` menghitung total mitra supplier.
   - `Barang::count()` menghitung total SKU katalog barang.
   - `Barang::sum('stok')` menghitung total unit fisik di gudang.
   - `Barang::with(['supplier', 'kategori'])->latest()->take(5)->get()` mengambil 5 barang terbaru secara *Eager Loading* untuk mencegah masalah *N+1 query*.
4. **Model & Database Layer (`App\Models\*`)**:
   Model mengeksekusi query SQL yang efisien ke basis data MariaDB `db_gudang_smart` dan mengembalikan koleksi objek Eloquent.
5. **View Rendering Layer (`resources/views/dashboard.blade.php`)**:
   Controller mengirimkan variabel metrik ke view Blade. View meng-extend master layout (`layouts/app.blade.php`), menyisipkan komponen navigasi (`<x-navbar>`, `<x-sidebar>`), serta merender 3 buah kartu ringkasan.
6. **HTTP Response Phase**:
   Server mengompilasi template Blade menjadi dokumen HTML murni dengan status kode `200 OK` dan mengirimkannya kembali ke peramban web pengguna.

### 1.2 Setup & Konfigurasi Lingkungan
- Proyek dibuat dengan framework Laravel dan terkonfigurasi pada basis data MariaDB/MySQL `db_gudang_smart`.
- Berkas `.env`:
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

### 1.3 Perancangan Routing Fundamental (`routes/web.php`)
- **Rute Konvensional**: `GET /admin/dashboard` mengarah ke `DashboardController@index` (Named Route: `admin.dashboard`).
- **Resource Routes**:
  - `admin/suppliers` $\rightarrow$ `SupplierController` (Named Route: `admin.suppliers.*`).
  - `admin/barang` $\rightarrow$ `BarangController` (Named Route: `admin.barang.*`).
- **Pengelompokan Rute**: Prefix `admin`, named route prefix `admin.`, serta proteksi middleware gabungan `['auth', 'role:manager,staff']`.

---

## 🎨 JAWABAN SOAL 2: BLADE TEMPLATING & REUSABLE COMPONENTS (BOBOT 20%)

### 2.1 Master Layout Inheritance (`resources/views/layouts/app.blade.php`)
Menggunakan tata letak baku yang dirancang dengan **Desain Minimalis Modern ala iOS & shadcn/ui berbasis Tailwind CSS**:
- **Desain & Tipografi**: Menggunakan font Inter, palet warna netral *zinc*, kartu dengan radius melengkung halus (`rounded-2xl`), border tipis (`border-zinc-200/60`), dan efek *backdrop blur* navigasi atas (`bg-white/80 backdrop-blur-xl`).
- **Header**: Terhubung ke navigasi utama sistem dengan logo modern dan indikator koneksi online.
- **Sidebar Navigation**: Menu di sisi samping kiri dengan highlight aktif yang jelas.
- **Content Area**: Memanfaatkan directive Blade `@yield('content')` serta `@stack('styles')` dan `@stack('scripts')`.
- **Footer**: Hak cipta sistem GudangSmart di bagian bawah.

### 2.2 Tiga Reusable Blade Components
1. **`<x-navbar>` (`resources/views/components/navbar.blade.php`)**:
   - Menampilkan logo/identitas brand GudangSmart berdesain minimalis.
   - Indikator koneksi sistem: `Online` dengan animasi pulsing ring hijau.
   - Menampilkan profil pengguna yang sedang login, avatar inisial, badge peran (`manager` / `staff`), dropdown info akun, dan tombol logout.
2. **`<x-sidebar>` (`resources/views/components/sidebar.blade.php`)**:
   - Menu navigasi bersih: *Dashboard*, *Supplier*, *Katalog Barang*, *Kategori Barang*, dan *Mutasi Stok*.
   - Menampilkan item menu khusus peran Manager (*Data Sampah / Trash*).
   - Menandai menu aktif secara dinamis (`request()->routeIs()`).
3. **`<x-alert>` (`resources/views/components/alert.blade.php`)**:
   - Komponen notifikasi serbaguna berbasis prop: `type="success"`, `type="danger"`, `type="warning"`, `type="info"`.
   - Dilengkapi tombol penutup (dismissible) dan ikon SVG Lucide-style yang elegan.

### 2.3 Implementasi Halaman Dashboard (`resources/views/dashboard.blade.php`)
Menampilkan **3 Buah Card Ringkasan**:
1. **Card Total Supplier**: Jumlah seluruh mitra supplier aktif.
2. **Card Total Jenis Barang**: Total varian SKU barang yang tercatat pada katalog.
3. **Card Total Stok Fisik Gudang**: Akumulasi total unit fisik barang yang tersedia (`SUM(stok)`).

---

## 🗄️ JAWABAN SOAL 3: SKEMA BASIS DATA, MODEL ORM & SEEDER (BOBOT 20%)

### 3.1 Perancangan Skema Migration
1. **Tabel `suppliers`** (`2024_01_01_000001_create_suppliers_table.php`):
   - `id` (Primary Key, auto increment)
   - `kode_supplier` (VARCHAR 10, UNIQUE)
   - `nama_pt` (VARCHAR)
   - `email` (VARCHAR)
   - `telepon` (VARCHAR)
   - `alamat` (TEXT)
   - `created_at`, `updated_at` (Timestamps)
   - `deleted_at` (Soft Deletes)
2. **Tabel `kategori_barang`** (`2024_01_01_000002_create_kategori_barang_table.php`):
   - `id` (Primary Key)
   - `kode_kategori` (VARCHAR, UNIQUE)
   - `nama_kategori` (VARCHAR)
   - `created_at`, `updated_at`
3. **Tabel `barang`** (`2024_01_01_000003_create_barang_table.php`):
   - `id` (Primary Key)
   - `kode_barang` (VARCHAR, UNIQUE)
   - `kategori_id` (Foreign Key ke `kategori_barang.id`, cascade on delete)
   - `supplier_id` (Foreign Key ke `suppliers.id`, cascade on delete)
   - `nama_barang` (VARCHAR)
   - `stok` (INTEGER, default: 0)
   - `harga_satuan` (DECIMAL 15,2)
   - `created_at`, `updated_at`
   - `deleted_at` (Soft Deletes)

### 3.2 Model Eloquent & SoftDeletes
- `App\Models\Supplier`: Mengaktifkan trait `SoftDeletes`.
- `App\Models\KategoriBarang`: Pengelolaan relasi kategori.
- `App\Models\Barang`: Mengaktifkan trait `SoftDeletes` dan `$casts` untuk numerik.

### 3.3 Seeder & Factory
- `SupplierFactory`: Menghasilkan nama PT realistis via Faker, kode supplier 10 karakter (`SUP0000001`), email, telepon, dan alamat.
- `BarangFactory`: Menghasilkan katalog komponen manufaktur realistis (Bearing, Baut Hexagonal, Pelumas Sintetis, Pipa Baja, dsb.) dengan stok 10 - 500 dan harga satuan Rp 25.000 - Rp 2.500.000.
- `DatabaseSeeder`:
  - 2 Akun Pengguna (`manager@gudangsmart.com` dan `staff@gudangsmart.com`).
  - **6 Kategori Barang** ($\ge$ 5 kategori).
  - **10 Data Mitra Supplier** ($\ge$ 10 supplier).
  - **25 Sampel Barang Manufaktur** ($\ge$ 20 barang).

---

## ⚡ JAWABAN SOAL 4: RELASI, FORM REQUEST & CONTROLLER KOMPLEKS (BOBOT 25%)

### 4.1 Deklarasi Eloquent Relationship
- **Model `Supplier`**:
  ```php
  public function barang(): HasMany {
      return $this->hasMany(Barang::class, 'supplier_id');
  }
  ```
- **Model `KategoriBarang`**:
  ```php
  public function barang(): HasMany {
      return $this->hasMany(Barang::class, 'kategori_id');
  }
  ```
- **Model `Barang`**:
  ```php
  public function supplier(): BelongsTo {
      return $this->belongsTo(Supplier::class, 'supplier_id');
  }

  public function kategori(): BelongsTo {
      return $this->belongsTo(KategoriBarang::class, 'kategori_id');
  }
  ```

### 4.2 Advanced Form Request Validation
1. **`StoreBarangRequest` (`app/Http/Requests/StoreBarangRequest.php`)**:
   - `kode_barang`: `required|string|max:10|unique:barang,kode_barang`
   - `nama_barang`: `required|string|min:3`
   - `kategori_id`: `required|exists:kategori_barang,id`
   - `supplier_id`: `required|exists:suppliers,id`
   - `stok`: `required|numeric|min:0` (tidak boleh bernilai negatif)
   - `harga_satuan`: `required|numeric|min:0`
2. **`UpdateBarangRequest` (`app/Http/Requests/UpdateBarangRequest.php`)**:
   - Menerapkan pengecualian ID barang yang sedang diupdate agar tidak memicu duplikasi unik:
     `Rule::unique('barang', 'kode_barang')->ignore($barangId)`

### 4.3 Logika Kompleks `BarangController`
- **Eager Loading**: `Barang::with(['supplier', 'kategori'])` dieksekusi secara otomatis untuk mengeliminasi masalah *N+1 Query*.
- **Search & Filter**:
  ```php
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
- **Pagination**: `paginate(10)->withQueryString()` membatasi 10 data per halaman dengan mempertahankan parameter URL filter.
- **Soft Delete Operations**:
  - `trash()`: Menampilkan data terhapus sementara via `Barang::onlyTrashed()->with(['supplier', 'kategori'])->paginate(10)`.
  - `restore($id)`: Memulihkan barang via `Barang::onlyTrashed()->findOrFail($id)->restore()`.
  - `forceDelete($id)`: Menghapus data permanen via `Barang::onlyTrashed()->findOrFail($id)->forceDelete()`.

---

## 🛡️ JAWABAN SOAL 5: AUTENTIKASI & ROLE-BASED ACCESS CONTROL (BOBOT 20%)

### 5.1 Fitur Autentikasi (`AuthController`)
- **Login (`GET /login`)**: Menampilkan formulir masuk dengan visual modern dan tombol pengisian cepat akun uji coba.
- **Authenticate Process (`POST /login`)**: Validasi input email & password, eksekusi `Auth::attempt()`, serta regenerasi sesi (`session()->regenerate()`).
- **Logout & Invalidation (`POST /logout`)**: Pembersihan sesi penuh menggunakan `Auth::logout()`, `session()->invalidate()`, dan `session()->regenerateToken()`.

### 5.2 Penerapan Custom Middleware `CheckRole`
Berkas: `app/Http/Middleware/CheckRole.php`
- Memeriksa apakah user telah terautentikasi (`Auth::check()`).
- Membandingkan `Auth::user()->role` terhadap parameter yang diizinkan pada rute (`CheckRole:manager,staff`).
- Mengembalikan penolakan terarah (*Redirect* dengan pesan kesalahan atau status *403 Forbidden*).
- **Pembagian Peran Sesuai Soal**:
  - **Manager**: Memiliki wewenang penuh atas seluruh modul (Data Master, Transaksi, Edit/Hapus, Restore Data, dan Laporan).
  - **Staff**: Hanya memiliki hak akses melihat katalog dan menginputkan transaksi barang. Tindakan menghapus barang atau mengedit data supplier diblokir dengan respon `403 Forbidden`.

---

## 🧪 HASIL PENGUJIAN OTOMATIS (TEST SUITE)

Pengujian otomatis telah dibuat pada `tests/Feature/GudangSmartSystemTest.php` dan seluruh skenario dinyatakan **PASS**:

```
PASS  Tests\Unit\ExampleTest
✓ that true is true

PASS  Tests\Feature\ExampleTest
✓ the application returns a successful response

PASS  Tests\Feature\GudangSmartSystemTest
✓ login flow (Autentikasi & Session Invalidation)
✓ dashboard metrics accessible (3 Buah Card Ringkasan)
✓ store barang validation (Validasi Form Request Ketat)
✓ barang search and filter (Eager Loading & Filter Kategori)
✓ soft delete and restore (Operasi Trash & Pemulihan)
✓ rbac staff restrictions (Proteksi Hak Akses Manager vs Staff)
✓ mutasi stok transaction by staff (Pencatatan Masuk & Keluar Stok)

Tests: 9 passed (40 assertions)
```

---

## 🚀 CARA MENJALANKAN APLIKASI SECARA LOKAL

1. Pastikan server MariaDB / MySQL berjalan pada port `3306`.
2. Jalankan server lokal Laravel:
   ```bash
   php artisan serve
   ```
3. Buka peramban (browser) ke:
   ```
   http://localhost:8000
   ```
4. Masuk menggunakan akun **Manager** atau **Staff** yang tertera di bagian atas dokumen ini.
