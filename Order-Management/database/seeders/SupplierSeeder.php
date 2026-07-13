<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    public function run()
    {
        DB::table('suppliers')->insert([
            ['name' => 'TechVend Solutions', 'email' => 'sales@techvend.example', 'phone' => '09171234567', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'OfficeMax PH', 'email' => 'orders@officemax.example', 'phone' => '09179876543', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Green Harvest Co.', 'email' => 'procure@greenharvest.example', 'phone' => '09171112222', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
