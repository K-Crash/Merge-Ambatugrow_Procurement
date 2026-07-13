<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/dashboard');
        
        $this->get('/dashboard')->assertStatus(200);
    }

    public function test_purchase_and_requisition_redirects_guest_when_no_users_exist(): void
    {
        $response = $this->get('/purchase-and-requisition');
        $response->assertRedirect('/login');
    }

    public function test_purchase_and_requisition_auto_logs_in_guest_when_users_exist(): void
    {
        $user = User::factory()->create([
            'role' => 'department_head',
            'username' => 'johny.papa',
        ]);

        $response = $this->get('/purchase-and-requisition');
        $response->assertStatus(200);
        $this->assertAuthenticatedAs($user);
    }

    public function test_purchase_and_requisition_accessible_to_approver(): void
    {
        $user = User::factory()->create([
            'role' => 'manager',
            'username' => 'test.manager',
        ]);

        $response = $this->actingAs($user)->get('/purchase-and-requisition');
        $response->assertStatus(200);
    }
}
