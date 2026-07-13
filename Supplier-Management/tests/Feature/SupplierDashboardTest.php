<?php

namespace Tests\Feature;

use Tests\TestCase;

class SupplierDashboardTest extends TestCase
{
    public function test_dashboard_summary_cards_link_to_the_available_supplier_views(): void
    {
        $response = $this->get('/suppliers/dashboard');

        $response->assertOk();
        $response->assertSee(route('suppliers.index'), false);
        $response->assertSee(route('suppliers.active'), false);
        $response->assertSee(route('suppliers.pending'), false);
        $response->assertSee(route('suppliers.blacklisted'), false);
    }

    public function test_active_and_pending_supplier_pages_render(): void
    {
        $this->get('/suppliers/active')
            ->assertOk()
            ->assertSee('Active Suppliers');

        $this->get('/suppliers/pending')
            ->assertOk()
            ->assertSee('Pending Verification');
    }
}
