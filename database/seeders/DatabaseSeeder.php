<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Pengguna untuk Pengujian Role-Based Access Control
        User::updateOrCreate(
            ['email' => 'manager@gudangsmart.com'],
            [
                'name' => 'Budi Santoso (Manager)',
                'password' => Hash::make('password'),
                'role' => 'manager',
            ]
        );

        User::updateOrCreate(
            ['email' => 'staff@gudangsmart.com'],
            [
                'name' => 'Siti Rahma (Staff)',
                'password' => Hash::make('password'),
                'role' => 'staff',
            ]
        );

        // 2. Data Awal Kategori Barang (Minimal 5 Kategori)
        $kategoriList = [
            ['kode_kategori' => 'KAT-LOGAM', 'nama_kategori' => 'Bahan Baku Logam & Kimia'],
            ['kode_kategori' => 'KAT-MESIN', 'nama_kategori' => 'Suku Cadang & Komponen Mesin'],
            ['kode_kategori' => 'KAT-ELEKTRO', 'nama_kategori' => 'Elektrikal & Instrumentasi'],
            ['kode_kategori' => 'KAT-APD', 'nama_kategori' => 'Alat Pelindung Diri (APD) & K3'],
            ['kode_kategori' => 'KAT-PACK', 'nama_kategori' => 'Material Packaging & Pengemasan'],
            ['kode_kategori' => 'KAT-ALAT', 'nama_kategori' => 'Peralatan & Perkakas Kerja'],
        ];

        foreach ($kategoriList as $kat) {
            KategoriBarang::updateOrCreate(
                ['kode_kategori' => $kat['kode_kategori']],
                ['nama_kategori' => $kat['nama_kategori']]
            );
        }

        // 3. Data Awal Supplier (Minimal 10 Supplier)
        $suppliers = Supplier::factory(10)->create();

        // 4. Data Awal Sampel Barang (Minimal 20 Barang)
        $kategoriIds = KategoriBarang::pluck('id')->toArray();
        $supplierIds = $suppliers->pluck('id')->toArray();

        for ($i = 0; $i < 25; $i++) {
            Barang::factory()->create([
                'kategori_id' => fake()->randomElement($kategoriIds),
                'supplier_id' => fake()->randomElement($supplierIds),
            ]);
        }

        // 5. Data Transaksi Mutasi Stok Awal
        $users = User::all();
        $barangAll = Barang::all();

        foreach ($barangAll->take(10) as $b) {
            \App\Models\MutasiStok::create([
                'barang_id' => $b->id,
                'user_id' => $users->random()->id,
                'jenis_mutasi' => 'masuk',
                'jumlah' => rand(20, 100),
                'keterangan' => 'Penerimaan barang awal dari supplier utama',
                'created_at' => now()->subDays(rand(1, 10)),
            ]);
        }
    }
}
