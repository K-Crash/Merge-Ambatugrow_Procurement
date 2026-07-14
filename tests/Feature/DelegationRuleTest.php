<?php

namespace Tests\Feature;

use App\Models\Requisition;
use App\Models\ApprovalStep;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DelegationRuleTest extends TestCase
{
    use RefreshDatabase;

    private $manager1;
    private $manager2;
    private $financeManager;
    private $deptHead;
    private $requestor;
    private $requisition;
    private $step;

    protected function setUp(): void
    {
        parent::setUp();

        // Create users of different roles
        $this->requestor = User::factory()->create(['role' => 'admin']);
        $this->manager1 = User::factory()->create(['role' => 'manager', 'name' => 'Manager One']);
        $this->manager2 = User::factory()->create(['role' => 'manager', 'name' => 'Manager Two']);
        $this->financeManager = User::factory()->create(['role' => 'finance_manager', 'name' => 'Finance Manager']);
        $this->deptHead = User::factory()->create(['role' => 'department_head', 'name' => 'Department Head']);

        // Create a pending requisition
        $this->requisition = Requisition::create([
            'code' => 'REQ-2026-001',
            'title' => 'Test Requisition',
            'requestor_id' => $this->requestor->id,
            'department' => 'Operations',
            'urgency' => 'Medium',
            'status' => 'pending_approval',
            'approval_type' => 'sequential',
            'total' => 5000.00,
        ]);

        // Create a pending step for manager1
        $this->step = ApprovalStep::create([
            'requisition_id' => $this->requisition->id,
            'approver_id' => $this->manager1->id,
            'step_order' => 1,
            'step_type' => 'manager_approval',
            'label' => 'Manager Step',
            'required' => true,
            'status' => 'pending',
        ]);
    }

    public function test_manager_sees_allowed_delegates_list()
    {
        // Act as manager1
        $response = $this->actingAs($this->manager1)
            ->get(route('approvals.index', ['requisition' => $this->requisition->id]));

        $response->assertStatus(200);

        // Fetch the delegates passed to the view
        $delegates = $response->viewData('delegates');

        // Manager should only see Finance Manager and Department Head (and NOT manager2)
        $this->assertTrue($delegates->contains('id', $this->financeManager->id));
        $this->assertTrue($delegates->contains('id', $this->deptHead->id));
        $this->assertFalse($delegates->contains('id', $this->manager2->id));
        $this->assertFalse($delegates->contains('id', $this->manager1->id));
    }

    public function test_finance_manager_sees_allowed_delegates_list()
    {
        // Re-assign step to finance manager
        $this->step->update(['approver_id' => $this->financeManager->id]);

        // Act as financeManager
        $response = $this->actingAs($this->financeManager)
            ->get(route('approvals.index', ['requisition' => $this->requisition->id]));

        $response->assertStatus(200);

        $delegates = $response->viewData('delegates');

        // Finance Manager should only see Managers (manager1 and manager2)
        $this->assertTrue($delegates->contains('id', $this->manager1->id));
        $this->assertTrue($delegates->contains('id', $this->manager2->id));
        $this->assertFalse($delegates->contains('id', $this->deptHead->id));
        $this->assertFalse($delegates->contains('id', $this->financeManager->id));
    }

    public function test_manager_can_delegate_to_finance_manager()
    {
        // Act as manager1 to delegate to finance manager
        $response = $this->actingAs($this->manager1)
            ->post(route('approvals.act', $this->requisition), [
                'decision' => 'delegate',
                'delegate_to' => $this->financeManager->id,
            ]);

        $response->assertRedirect(route('approvals.index'));
        $this->assertDatabaseHas('approval_steps', [
            'id' => $this->step->id,
            'approver_id' => $this->financeManager->id,
        ]);
    }

    public function test_manager_cannot_delegate_to_another_manager()
    {
        // Act as manager1 to delegate to manager2
        $response = $this->actingAs($this->manager1)
            ->post(route('approvals.act', $this->requisition), [
                'decision' => 'delegate',
                'delegate_to' => $this->manager2->id,
            ]);

        // Should return 403 forbidden
        $response->assertStatus(403);
        $this->assertDatabaseHas('approval_steps', [
            'id' => $this->step->id,
            'approver_id' => $this->manager1->id, // unchanged
        ]);
    }

    public function test_finance_manager_can_delegate_to_manager()
    {
        // Re-assign step to finance manager
        $this->step->update(['approver_id' => $this->financeManager->id]);

        // Act as financeManager to delegate to manager2
        $response = $this->actingAs($this->financeManager)
            ->post(route('approvals.act', $this->requisition), [
                'decision' => 'delegate',
                'delegate_to' => $this->manager2->id,
            ]);

        $response->assertRedirect(route('approvals.index'));
        $this->assertDatabaseHas('approval_steps', [
            'id' => $this->step->id,
            'approver_id' => $this->manager2->id,
        ]);
    }

    public function test_finance_manager_cannot_delegate_to_department_head()
    {
        // Re-assign step to finance manager
        $this->step->update(['approver_id' => $this->financeManager->id]);

        // Act as financeManager to delegate to department head
        $response = $this->actingAs($this->financeManager)
            ->post(route('approvals.act', $this->requisition), [
                'decision' => 'delegate',
                'delegate_to' => $this->deptHead->id,
            ]);

        // Should return 403 forbidden
        $response->assertStatus(403);
        $this->assertDatabaseHas('approval_steps', [
            'id' => $this->step->id,
            'approver_id' => $this->financeManager->id, // unchanged
        ]);
    }
}
