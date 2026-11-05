<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'suppliers';

    protected $fillable = [
        'kode_supplier',
        'nama_pt',
        'email',
        'telepon',
        'alamat',
    ];

    /**
     * Relasi ke model Barang: Satu supplier dapat memasok banyak barang.
     */
    public function barang(): HasMany
    {
        return $this->hasMany(Barang::class, 'supplier_id');
    }
}

