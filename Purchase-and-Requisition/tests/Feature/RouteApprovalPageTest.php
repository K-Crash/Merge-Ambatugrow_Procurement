<?php

use App\Models\Requisition;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

test('authenticated user can open the route approval page', function () {
    $user = User::create([
        'name' => 'JJ Miranda',
        'username' => 'jj.miranda',
        'email' => 'jj.miranda@ambatugrow.test',
        'role' => 'manager',
        'job_title' => 'Manager',
        'department' => 'Marketing',
        'password' => Hash::make('password'),
    ]);

    $requisition = Requisition::create([
        'code' => 'PR-2026-00001',
        'title' => 'Marketing software renewal',
        'department' => 'Marketing',
        'requestor_id' => $user->id,
        'needed_by' => now()->addDays(5),
        'purpose' => 'Need new software licenses',
        'subtotal' => 85,
        'tax_rate' => 0,
        'tax_amount' => 0,
        'total' => 85,
        'urgency' => 'Medium',
        'status' => 'draft',
    ]);

    $this->actingAs($user)
        ->get(route('requisitions.route', $requisition))
        ->assertOk()
        ->assertSee('Route Requisition for Approval');
});
