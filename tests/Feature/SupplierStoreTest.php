<?php

namespace Tests\Feature;

use App\Models\Supplier;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupplierStoreTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_store_new_supplier(): void
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->post(route('suppliers.store'), [
            'company_name' => 'Test Supplier Inc',
            'business_type' => 'Corporation',
            'address' => '123 Test St, Test City',
            'phone' => '1234567890',
            'email' => 'test@supplier.com',
            'contact_person' => 'John Doe',
            'position' => 'Manager',
            'contact_phone' => '0987654321',
            'contact_email' => 'johndoe@supplier.com',
            'lead_time' => '3 Days',
            'delivery_schedule' => 'Weekly',
            'moq' => '10 Units',
            'products' => ['Rice', 'Mango'],
            'payment_terms' => 'Net 30',
            'payment_method' => 'Bank Transfer',
            'description' => 'Test supplier description'
        ]);

        $response->assertRedirect(route('suppliers.index'));
        $this->assertDatabaseHas('suppliers', [
            'supplier_name' => 'Test Supplier Inc',
            'email' => 'test@supplier.com',
        ]);
    }
}
