<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        Supplier::insert([
            [
                'nama_supplier' => 'PT Sumber Jaya',
                'alamat' => 'Jl. Merdeka No.10, Jakarta'
            ],
            [
                'nama_supplier' => 'UD Maju Bersama',
                'alamat' => 'Jl. A. Yani No.20, Surabaya'
            ],
        ]);
    }
}

