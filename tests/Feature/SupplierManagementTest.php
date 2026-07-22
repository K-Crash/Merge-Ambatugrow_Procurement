<?php

namespace Tests\Feature;

use App\Models\BlacklistedSupplier;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SupplierManagementTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $supplier;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->supplier = Supplier::create([
            'slug' => 'test-agri-supplier',
            'supplier_name' => 'Test Agri Supplier',
            'name' => 'Test Agri Supplier',
            'supplier_id' => 'AGR-00999',
            'status' => 'Active',
            'location' => 'Manila',
            'rating' => 4.5,
            'since' => now(),
            'description' => 'A trusted agricultural produce supplier.',
        ]);
    }

    public function test_supplier_details_view_loads_correctly_with_high_contrast_name()
    {
        $response = $this->actingAs($this->user)->get(route('suppliers.show', $this->supplier->slug));

        $response->assertStatus(200);
        $response->assertSee('Test Agri Supplier');
        $response->assertSee('Block This Supplier');
    }

    public function test_cannot_block_supplier_without_a_reason()
    {
        $response = $this->actingAs($this->user)->post(route('suppliers.block', $this->supplier->slug), [
            'blacklist_reason' => '',
        ]);

        $response->assertSessionHasErrors('blacklist_reason');
        $this->assertEquals('Active', $this->supplier->fresh()->status);
    }

    public function test_can_block_supplier_with_valid_reason()
    {
        $response = $this->actingAs($this->user)->post(route('suppliers.block', $this->supplier->slug), [
            'blacklist_reason' => 'Repeated late deliveries and poor product quality',
            'risk_level' => 'High',
        ]);

        $response->assertRedirect();
        $fresh = $this->supplier->fresh();
        $this->assertEquals('Blacklisted', $fresh->status);
        $this->assertEquals('Repeated late deliveries and poor product quality', $fresh->blacklist_reason);
    }

    public function test_can_unblock_supplier()
    {
        $this->supplier->update([
            'status' => 'Blacklisted',
            'blacklist_reason' => 'Contract violation',
            'blacklisted_since' => now(),
        ]);

        $response = $this->actingAs($this->user)->post(route('suppliers.unblock', $this->supplier->slug));

        $response->assertRedirect();
        $fresh = $this->supplier->fresh();
        $this->assertEquals('Active', $fresh->status);
        $this->assertNull($fresh->blacklist_reason);
    }

    public function test_product_price_and_moq_are_hidden_for_blocked_suppliers()
    {
        $this->supplier->update(['status' => 'Blacklisted']);

        $category = \App\Models\Category::firstOrCreate(['category_name' => 'Grains']);
        $uom = \App\Models\UnitOfMeasure::firstOrCreate(['uom_code' => 'Sack'], ['uom_name' => '50kg Sack']);
        $currency = \App\Models\Currency::firstOrCreate(['currency_code' => 'PHP'], ['currency_name' => 'Philippine Peso', 'exchange_rate' => 1.0]);

        $product = \App\Models\Product::create([
            'sku' => 'TEST-RICE-01',
            'name' => 'Test Hybrid Rice',
            'description' => 'Test Rice Product',
            'category_id' => $category->id,
            'uom_id' => $uom->id,
            'currency_id' => $currency->id,
            'base_price' => 2500.00,
            'min_quantity_threshold' => 10,
            'lead_time_days' => 3,
        ]);

        $this->supplier->productsRelation()->attach($product->id, [
            'supplier_sku' => 'SUP-RICE-01',
            'unit_price' => 2500.00,
            'lead_time_days' => 3,
            'is_preferred' => true,
        ]);

        $response = $this->actingAs($this->user)->get(route('suppliers.products', $this->supplier->slug));

        $response->assertStatus(200);
        $response->assertSee('Hidden for blocked supplier');
    }

    public function test_blacklisted_page_risk_level_filter()
    {
        BlacklistedSupplier::create([
            'supplier_code' => 'AGR-00888',
            'name' => 'Critical Risk Vendor',
            'reason' => 'Fraudulent contract',
            'blacklisted_since' => '2026-01-01',
            'risk_level' => 'Critical',
        ]);

        // Query with Risk Level = Critical
        $response = $this->actingAs($this->user)->get(route('suppliers.blacklisted', ['risk' => 'Critical']));

        $response->assertStatus(200);
        $response->assertSee('Critical Risk Vendor');
        $response->assertDontSee('All Status');

        // Query with Risk Level = Low (none exist)
        $emptyResponse = $this->actingAs($this->user)->get(route('suppliers.blacklisted', ['risk' => 'Low']));
        $emptyResponse->assertSee('No blacklisted suppliers found for this risk level.');
    }
}
