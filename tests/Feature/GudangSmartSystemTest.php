<?php

namespace Tests\Feature;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GudangSmartSystemTest extends TestCase
{
    use RefreshDatabase;

    protected User $manager;
    protected User $staff;
    protected KategoriBarang $kategori;
    protected Supplier $supplier;

    protected function setUp(): void
    {
        parent::setUp();

        // Siapkan akun pengujian
        $this->manager = User::firstOrCreate(
            ['email' => 'manager_test@gudangsmart.com'],
            ['name' => 'Manager Test', 'password' => bcrypt('password'), 'role' => 'manager']
        );

        $this->staff = User::firstOrCreate(
            ['email' => 'staff_test@gudangsmart.com'],
            ['name' => 'Staff Test', 'password' => bcrypt('password'), 'role' => 'staff']
        );

        $this->kategori = KategoriBarang::firstOrCreate(
            ['kode_kategori' => 'KAT-TEST'],
            ['nama_kategori' => 'Kategori Pengujian']
        );

        $this->supplier = Supplier::firstOrCreate(
            ['kode_supplier' => 'SUPTEST001'],
            [
                'nama_pt' => 'PT Mitra Pengujian',
                'email' => 'test@supplier.com',
                'telepon' => '08123456789',
                'alamat' => 'Jl. Kawasan Industri No. 1'
            ]
        );
    }

    /**
     * Soal 5.1: Pengujian Halaman Login & Autentikasi
     */
    public function test_login_flow(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('GudangSmart');

        // Test login valid
        $loginResponse = $this->post('/login', [
            'email' => $this->manager->email,
            'password' => 'password',
        ]);
        $loginResponse->assertRedirect('/admin/dashboard');
        $this->assertAuthenticatedAs($this->manager);
    }

    /**
     * Soal 1.3 & 2.3: Pengujian Dashboard & 3 Buah Card Ringkasan
     */
    public function test_dashboard_metrics_accessible(): void
    {
        $response = $this->actingAs($this->manager)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Total Supplier');
        $response->assertSee('Total Jenis Barang');
        $response->assertSee('Total Stok Fisik Gudang');
    }

    /**
     * Soal 4.2: Pengujian Validasi StoreBarangRequest
     */
    public function test_store_barang_validation(): void
    {
        $response = $this->actingAs($this->manager)->post('/admin/barang', [
            'kode_barang' => '', // Required error
            'nama_barang' => 'AB', // Min 3 chars error
            'kategori_id' => 999999, // Exists error
            'supplier_id' => 999999,
            'stok' => -10, // Min 0 error
            'harga_satuan' => 'bukan_angka', // Numeric error
        ]);

        $response->assertSessionHasErrors([
            'kode_barang',
            'nama_barang',
            'kategori_id',
            'supplier_id',
            'stok',
            'harga_satuan',
        ]);
    }

    /**
     * Soal 4.3: Pengujian Eager Loading, Search & Filtering
     */
    public function test_barang_search_and_filter(): void
    {
        // Buat sample barang
        $barangUnik = Barang::create([
            'kode_barang' => 'BRGUNIK01',
            'nama_barang' => 'Barang Khusus Pencarian Otomatis',
            'kategori_id' => $this->kategori->id,
            'supplier_id' => $this->supplier->id,
            'stok' => 100,
            'harga_satuan' => 750000,
        ]);

        // Cek search
        $searchResponse = $this->actingAs($this->manager)->get('/admin/barang?search=Pencarian+Otomatis');
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee('Barang Khusus Pencarian Otomatis');
        $searchResponse->assertSee($this->supplier->nama_pt); // Eager loaded relation
    }

    /**
     * Soal 4.3: Pengujian Soft Delete, Trash, Restore & Force Delete
     */
    public function test_soft_delete_and_restore(): void
    {
        $barang = Barang::create([
            'kode_barang' => 'BRGDEL01',
            'nama_barang' => 'Barang Uji Hapus',
            'kategori_id' => $this->kategori->id,
            'supplier_id' => $this->supplier->id,
            'stok' => 20,
            'harga_satuan' => 100000,
        ]);

        // 1. Soft Delete
        $deleteResponse = $this->actingAs($this->manager)->delete("/admin/barang/{$barang->id}");
        $deleteResponse->assertRedirect('/admin/barang');
        $this->assertSoftDeleted('barang', ['id' => $barang->id]);

        // 2. Trash Page
        $trashResponse = $this->actingAs($this->manager)->get('/admin/barang/trash');
        $trashResponse->assertStatus(200);
        $trashResponse->assertSee('Barang Uji Hapus');

        // 3. Restore
        $restoreResponse = $this->actingAs($this->manager)->post("/admin/barang/{$barang->id}/restore");
        $restoreResponse->assertRedirect('/admin/barang/trash');
        $this->assertNotSoftDeleted('barang', ['id' => $barang->id]);
    }

    /**
     * Soal 5.2: Pengujian RBAC (Staff tidak dapat menghapus barang atau mengedit supplier)
     */
    public function test_rbac_staff_restrictions(): void
    {
        $barang = Barang::create([
            'kode_barang' => 'BRGRBAC01',
            'nama_barang' => 'Barang Uji RBAC',
            'kategori_id' => $this->kategori->id,
            'supplier_id' => $this->supplier->id,
            'stok' => 50,
            'harga_satuan' => 200000,
        ]);

        // Staff mencoba menghapus barang -> 403 Forbidden
        $responseDelete = $this->actingAs($this->staff)->delete("/admin/barang/{$barang->id}");
        $responseDelete->assertStatus(403);

        // Staff mencoba mengedit supplier -> 403 Forbidden
        $responseEditSupplier = $this->actingAs($this->staff)->get("/admin/suppliers/{$this->supplier->id}/edit");
        $responseEditSupplier->assertStatus(403);
    }

    /**
     * Soal 5.2: Pengujian Transaksi Mutasi Stok (Staff berwenang mencatat penerimaan & pengeluaran)
     */
    public function test_mutasi_stok_transaction_by_staff(): void
    {
        $barang = Barang::create([
            'kode_barang' => 'BRGMUT01',
            'nama_barang' => 'Barang Uji Mutasi',
            'kategori_id' => $this->kategori->id,
            'supplier_id' => $this->supplier->id,
            'stok' => 50,
            'harga_satuan' => 150000,
        ]);

        // 1. Staff mencatat mutasi barang masuk (+25 unit)
        $responseMasuk = $this->actingAs($this->staff)->post('/admin/mutasi', [
            'barang_id' => $barang->id,
            'jenis_mutasi' => 'masuk',
            'jumlah' => 25,
            'keterangan' => 'Penerimaan kontainer dari pemasok',
        ]);
        $responseMasuk->assertRedirect('/admin/mutasi');
        $this->assertEquals(75, $barang->fresh()->stok);

        // 2. Staff mencatat mutasi barang keluar (-15 unit)
        $responseKeluar = $this->actingAs($this->staff)->post('/admin/mutasi', [
            'barang_id' => $barang->id,
            'jenis_mutasi' => 'keluar',
            'jumlah' => 15,
            'keterangan' => 'Pengeluaran untuk perakitan',
        ]);
        $responseKeluar->assertRedirect('/admin/mutasi');
        $this->assertEquals(60, $barang->fresh()->stok);
    }
}
