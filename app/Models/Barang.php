<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Barang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'barang';

    protected $fillable = [
        'kode_barang',
        'kategori_id',
        'supplier_id',
        'nama_barang',
        'stok',
        'harga_satuan',
    ];

    protected $casts = [
        'stok' => 'integer',
        'harga_satuan' => 'decimal:2',
    ];

    /**
     * Relasi ke model Supplier: Setiap barang dimiliki/disuplai oleh satu supplier.
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    /**
     * Relasi ke model KategoriBarang: Setiap barang termasuk dalam satu kategori.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_id');
    }

    /**
     * Relasi ke riwayat mutasi stok barang.
     */
    public function mutasi(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(MutasiStok::class, 'barang_id');
    }
}

