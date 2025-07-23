<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        Barang::insert([
            [
                'nama_barang' => 'Laptop Asus ROG',
                'stok' => 5,
                'kategori_id' => 1 // Elektronik
            ],
            [
                'nama_barang' => 'Buku Tulis Sinar Dunia',
                'stok' => 100,
                'kategori_id' => 2 // Alat Tulis
            ],
            [
                'nama_barang' => 'Kaos Oblong Polos',
                'stok' => 30,
                'kategori_id' => 3 // Pakaian
            ],
        ]);
    }
}

