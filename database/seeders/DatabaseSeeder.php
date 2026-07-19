<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ServiceSeeder::class,
            RequisitionDemoSeeder::class,
            SupplierSeeder::class,
            PurchaseOrderSeeder::class,
            MassProcurementSeeder::class,
        ]);
    }
}
