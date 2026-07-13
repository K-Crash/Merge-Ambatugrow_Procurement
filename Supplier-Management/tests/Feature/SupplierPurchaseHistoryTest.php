<?php

namespace Tests\Feature;

use Tests\TestCase;

class SupplierPurchaseHistoryTest extends TestCase
{
    public function test_purchase_history_page_shows_supplier_transactions(): void
    {
        $response = $this->get('/suppliers/abc-farms/purchase-history');

        $response->assertOk();
        $response->assertSee('Purchase History');
        $response->assertSee('Rice');
    }
}
