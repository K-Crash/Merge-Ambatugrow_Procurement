<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Supplier;
use App\Models\PurchaseOrder;

class PurchaseOrderTest extends TestCase
{
    use RefreshDatabase;

    private $supplier;
    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a default supplier for testing
        $this->supplier = Supplier::create([
            'name' => 'Test Vendor',
            'email' => 'vendor@example.com',
            'phone' => '09170000000',
        ]);

        $this->user = \App\Models\User::factory()->create();
    }

    public function test_procurement_dashboard_loads_correctly_authenticated()
    {
        // Act
        $response = $this->actingAs($this->user)->get('/order-management');

        // Assert
        $response->assertStatus(200);
        $response->assertSee('Procurement Overview');
    }

    public function test_can_create_purchase_order()
    {
        // Act
        $response = $this->actingAs($this->user)->post(route('purchase_orders.store'), [
            'supplier_id' => $this->supplier->id,
            'expected_delivery' => now()->addDays(7)->format('Y-m-d'),
            'items' => [
                [
                    'sku' => 'TEST-SKU-001',
                    'name' => 'Test Item 1',
                    'quantity' => 10,
                    'unit_price' => 150.00,
                ]
            ]
        ]);

        // Assert
        $response->assertRedirect(route('procurement.home'));
        $this->assertDatabaseHas('purchase_orders', [
            'supplier_id' => $this->supplier->id,
            'total' => 1500.00,
            'status' => 'draft',
        ]);
    }

    public function test_can_send_purchase_order()
    {
        // Arrange
        $po = PurchaseOrder::create([
            'po_number' => 'PO-2026-999',
            'supplier_id' => $this->supplier->id,
            'status' => 'draft',
            'total' => 500.00,
        ]);

        // Act
        $response = $this->actingAs($this->user)->post(route('purchase_orders.send', $po));

        // Assert
        $response->assertRedirect();
        $this->assertDatabaseHas('purchase_orders', [
            'id' => $po->id,
            'status' => 'sent',
        ]);
    }

    public function test_can_match_invoice_to_purchase_order()
    {
        // Arrange
        $po = PurchaseOrder::create([
            'po_number' => 'PO-2026-999',
            'supplier_id' => $this->supplier->id,
            'status' => 'sent',
            'total' => 1000.00,
        ]);

        // Act
        $response = $this->actingAs($this->user)->post(route('purchase_orders.match_invoice'), [
            'po_number' => 'PO-2026-999',
            'invoice_number' => 'INV-TEST-001',
            'amount' => 1000.00,
        ]);

        // Assert
        $response->assertRedirect();
        $this->assertDatabaseHas('invoices', [
            'invoice_number' => 'INV-TEST-001',
            'purchase_order_id' => $po->id,
            'amount' => 1000.00,
        ]);
    }
}
