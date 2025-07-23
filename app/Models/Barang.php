<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_barang',
        'stok',
        'kategori_id',
        'supplier_id',
        'harga_beli',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class)
            ->withPivot('harga_beli')
            ->withTimestamps();
    }
}
