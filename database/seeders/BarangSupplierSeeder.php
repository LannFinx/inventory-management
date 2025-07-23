<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSupplierSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('barang_supplier')->insert([
            [
                'barang_id' => 1, // Laptop Asus ROG
                'supplier_id' => 1, // PT Sumber Jaya
                'harga_beli' => 15000000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'barang_id' => 2, // Buku Tulis
                'supplier_id' => 2, // UD Maju Bersama
                'harga_beli' => 3500,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'barang_id' => 3, // Kaos
                'supplier_id' => 2,
                'harga_beli' => 25000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
