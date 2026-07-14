<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ErDiagramIntegrationTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed the database to populate ERD data
        $this->seed();

        $this->user = User::where('role', 'admin')->first() ?: User::factory()->create(['role' => 'admin']);
    }

    public function test_database_schema_explorer_view_loads_for_authenticated_users()
    {
        $response = $this->actingAs($this->user)->get(route('erd.schema'));

        $response->assertStatus(200);
        $response->assertSee('Database Schema Explorer');
        $response->assertSee('Addresses');
        $response->assertSee('Suppliers');
        $response->assertSee('Products');
        $response->assertSee('product_suppliers');
        $response->assertSee('Purchase Orders');
        $response->assertSee('supplier_invoices');
    }

    public function test_suppliers_api_returns_json_data()
    {
        $response = $this->actingAs($this->user)->get('/api/suppliers');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'supplier_name',
                'category',
                'email',
                'phone',
                'address_id',
                'status',
                'products_relation_count',
            ]
        ]);
    }

    public function test_products_api_returns_json_data()
    {
        $response = $this->actingAs($this->user)->get('/api/products');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'sku',
                'name',
                'description',
                'category_id',
                'uom_id',
                'currency_id',
                'base_price',
                'min_quantity_threshold',
                'lead_time_days',
            ]
        ]);
    }

    public function test_purchase_orders_api_returns_json_data()
    {
        $response = $this->actingAs($this->user)->get('/api/purchase-orders');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'po_number',
                'supplier_id',
                'requisition_id',
                'status',
                'total',
                'expected_delivery',
                'issued_at',
                'payment_term_id',
                'currency_id',
                'order_date',
                'created_by',
            ]
        ]);
    }

    public function test_supplier_invoices_api_returns_json_data()
    {
        $response = $this->actingAs($this->user)->get('/api/supplier-invoices');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'id',
                'supplier_id',
                'po_id',
                'invoice_number',
                'invoice_date',
                'due_date',
            ]
        ]);
    }
}
