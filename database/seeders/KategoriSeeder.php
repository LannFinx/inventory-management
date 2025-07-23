<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        Kategori::insert([
            ['id' => 1, 'nama_kategori' => 'Elektronik'],
            ['id' => 2, 'nama_kategori' => 'Alat Tulis'],
            ['id' => 3, 'nama_kategori' => 'Pakaian'],
        ]);
    }
}


