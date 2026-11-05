<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriBarang extends Model
{
    use HasFactory;

    protected $table = 'kategori_barang';

    protected $fillable = [
        'kode_kategori',
        'nama_kategori',
    ];

    /**
     * Relasi ke model Barang: Satu kategori memiliki banyak barang.
     */
    public function barang(): HasMany
    {
        return $this->hasMany(Barang::class, 'kategori_id');
    }
}

