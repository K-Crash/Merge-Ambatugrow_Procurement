<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['sku' => 'SVC-001', 'name' => 'Premium SaaS License', 'category' => 'Software', 'price' => 1200, 'unit' => 'service'],
            ['sku' => 'SVC-002', 'name' => 'Onboarding & Training', 'category' => 'Software', 'price' => 100, 'unit' => 'service'],
            ['sku' => 'SVC-003', 'name' => 'Graphic Design Services', 'category' => 'Creative', 'price' => 450, 'unit' => 'service'],
            ['sku' => 'SVC-004', 'name' => 'Social Media Ad Boost', 'category' => 'Marketing', 'price' => 300, 'unit' => 'service'],
            ['sku' => 'SVC-005', 'name' => 'Office Supplies Bundle', 'category' => 'Office', 'price' => 85, 'unit' => 'service'],
            ['sku' => 'SVC-006', 'name' => 'IT Support Retainer', 'category' => 'IT', 'price' => 600, 'unit' => 'service'],
            ['sku' => 'SVC-007', 'name' => 'Cloud Hosting Plan', 'category' => 'IT', 'price' => 250, 'unit' => 'service'],
            ['sku' => 'SVC-008', 'name' => 'Event Catering Package', 'category' => 'Events', 'price' => 950, 'unit' => 'service'],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['sku' => $service['sku']], $service);
        }
    }
}
