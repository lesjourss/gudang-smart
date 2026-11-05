<?php

namespace Database\Factories;

use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Barang>
 */
class BarangFactory extends Factory
{
    protected $model = Barang::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $items = [
            'Baut Baja Hexagonal M12',
            'Pelumas Sintetis Mesin 5L',
            'Bearing Ball 6205-2RS',
            'Pipa Baja Seamless 2 Inch',
            'Valve Kuningan 1/2 Inch',
            'Kabel Tembaga NYA 2.5mm 100m',
            'Saklar Industri 3 Phase',
            'Sensor Ultrasonik Proximity',
            'Filter Udara Kompresor',
            'Gasket Silikon Tahan Panas',
            'Rantai Transmisi Baja RS50',
            'O-Ring Karet Nitril Set',
            'Rel Sliding Presisi CNC',
            'Helm Keselamatan Proyek ANSI',
            'Sarung Tangan Nitril Tebal',
            'Kacamata Pelindung Polikarbonat',
            'Karton Gelombang Kemasan 50x40',
            'Plastik Wrapping Stretch Film',
            'Lakban Industri Coklat 2 Inch',
            'Pita Pengikat Strapping Band'
        ];

        return [
            'kode_barang' => 'BRG' . str_pad((string) fake()->unique()->numberBetween(1, 9999999), 7, '0', STR_PAD_LEFT),
            'kategori_id' => KategoriBarang::inRandomOrder()->first()?->id ?? KategoriBarang::factory(),
            'supplier_id' => Supplier::inRandomOrder()->first()?->id ?? Supplier::factory(),
            'nama_barang' => fake()->randomElement($items) . ' ' . fake()->bothify('Type-##'),
            'stok' => fake()->numberBetween(10, 500),
            'harga_satuan' => fake()->numberBetween(25000, 2500000),
        ];
    }
}

