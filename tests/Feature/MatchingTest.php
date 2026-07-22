<?php

namespace Tests\Feature;

use App\Models\DeliveryReceipt;
use App\Models\Invoice;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MatchingTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $supplier;
    private $po;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->supplier = Supplier::create([
            'name' => 'Savanna Grain Co.',
            'email' => 'savanna@example.com',
            'phone' => '09171112222',
        ]);

        $this->po = PurchaseOrder::create([
            'po_number' => 'PO-2024-00041',
            'supplier_id' => $this->supplier->id,
            'status' => 'sent',
            'total' => 204500.00,
        ]);
        $this->po->items()->create([
            'name' => 'White Maize',
            'quantity' => 100,
            'unit_price' => 2045.00,
            'line_total' => 204500.00,
        ]);
    }

    public function test_matching_dashboard_loads_correctly()
    {
        $response = $this->actingAs($this->user)->get(route('matching.index'));

        $response->assertStatus(200);
        $response->assertSee('Goods Receipt &amp; Invoice Matching', false);
        $response->assertSee('Record GRN');
        $response->assertSee('More Filters');
    }

    public function test_can_fetch_po_items()
    {
        $response = $this->actingAs($this->user)->get(route('matching.po_items', ['purchaseOrder' => $this->po->po_number]));

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'po_number' => 'PO-2024-00041',
            'supplier' => 'Savanna Grain Co.',
        ]);
    }

    public function test_can_record_grn_and_match_invoice_matched_status()
    {
        $response = $this->actingAs($this->user)->post(route('matching.store_grn'), [
            'po_number' => 'PO-2024-00041',
            'grn_number' => 'GRN-2024-03201',
            'received_at' => now()->format('Y-m-d H:i:s'),
            'receiving_location' => 'Harare Central Depot',
            'invoice_number' => 'INV-SG-8821',
            'invoice_amount' => 204500.00,
            'invoice_date' => now()->format('Y-m-d'),
            'matching_notes' => 'Full delivery verified',
            'lines' => [
                [
                    'name' => 'White Maize',
                    'qty_received' => 100,
                    'qty_accepted' => 100,
                    'unit_price' => 2045.00,
                    'condition' => 'OK',
                ]
            ]
        ]);

        $this->assertDatabaseHas('delivery_receipts', [
            'dr_number' => 'GRN-2024-03201',
            'purchase_order_id' => $this->po->id,
        ]);

        $this->assertDatabaseHas('invoices', [
            'invoice_number' => 'INV-SG-8821',
            'purchase_order_id' => $this->po->id,
            'amount' => 204500.00,
        ]);
    }
}
