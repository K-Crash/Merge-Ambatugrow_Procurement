<?php

namespace Tests\Feature;

use App\Models\Requisition;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RequisitionTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'role' => 'manager',
            'department' => 'Engineering',
        ]);
    }

    public function test_can_create_requisition_as_draft()
    {
        $response = $this->actingAs($this->user)->post(route('requisitions.store'), [
            'title' => 'Test Requisition',
            'needed_by' => now()->addDays(7)->format('Y-m-d'),
            'purpose' => 'For testing',
            'urgency' => 'High',
            'action' => 'draft',
            'items' => [
                [
                    'name' => 'Server Memory Upgrade',
                    'qty' => 2,
                    'unit' => 'pcs',
                    'unit_price' => 5000,
                ]
            ]
        ]);

        $response->assertRedirect(route('requisitions.tracking'));
        $this->assertDatabaseHas('requisitions', [
            'title' => 'Test Requisition',
            'urgency' => 'High',
            'status' => 'draft',
            'subtotal' => 10000,
            'total' => 10000,
        ]);
    }

    public function test_requisition_code_generation_handles_deletion_correctly()
    {
        // 1. Create first requisition
        $this->actingAs($this->user)->post(route('requisitions.store'), [
            'title' => 'First Requisition',
            'action' => 'draft',
            'items' => [
                ['name' => 'Item A', 'qty' => 1, 'unit_price' => 100]
            ]
        ]);

        $first = Requisition::first();
        $firstCode = $first->code;
        $this->assertStringContainsString('PR-' . now()->format('Y') . '-', $firstCode);

        // 2. Create second requisition
        $this->actingAs($this->user)->post(route('requisitions.store'), [
            'title' => 'Second Requisition',
            'action' => 'draft',
            'items' => [
                ['name' => 'Item B', 'qty' => 1, 'unit_price' => 100]
            ]
        ]);

        $second = Requisition::orderBy('id', 'desc')->first();
        $secondCode = $second->code;

        // Verify the code sequence increments
        $firstNum = (int) substr($firstCode, -5);
        $secondNum = (int) substr($secondCode, -5);
        $this->assertEquals($firstNum + 1, $secondNum);

        // 3. Delete the second requisition
        $second->delete();

        // 4. Create a third requisition - it should reuse the suffix of the second (which was deleted) or higher,
        // without causing a duplicate key violation.
        $response = $this->actingAs($this->user)->post(route('requisitions.store'), [
            'title' => 'Third Requisition',
            'action' => 'draft',
            'items' => [
                ['name' => 'Item C', 'qty' => 1, 'unit_price' => 100]
            ]
        ]);

        $response->assertRedirect(route('requisitions.tracking'));
        $third = Requisition::orderBy('id', 'desc')->first();
        $this->assertEquals($secondCode, $third->code);
    }

    public function test_requisition_code_generation_handles_out_of_order_ids()
    {
        // Create a requisition with code PR-2026-00010 but lower ID
        Requisition::create([
            'id' => 10,
            'code' => 'PR-' . now()->format('Y') . '-00010',
            'title' => 'Older Requisition with High Code',
            'requestor_id' => $this->user->id,
            'status' => 'draft',
        ]);

        // Create a requisition with code PR-2026-00009 but higher ID
        Requisition::create([
            'id' => 15,
            'code' => 'PR-' . now()->format('Y') . '-00009',
            'title' => 'Newer Requisition with Low Code',
            'requestor_id' => $this->user->id,
            'status' => 'draft',
        ]);

        // Now trigger Requisition creation
        $response = $this->actingAs($this->user)->post(route('requisitions.store'), [
            'title' => 'Next Requisition',
            'action' => 'draft',
            'items' => [
                ['name' => 'Item X', 'qty' => 1, 'unit_price' => 100]
            ]
        ]);

        $response->assertRedirect(route('requisitions.tracking'));
        
        // It should have generated code PR-YYYY-00011 (since PR-YYYY-00010 exists)
        $latest = Requisition::orderBy('id', 'desc')->first();
        $this->assertEquals('PR-' . now()->format('Y') . '-00011', $latest->code);
    }
}
