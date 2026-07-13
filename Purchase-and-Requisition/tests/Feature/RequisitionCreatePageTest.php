<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

test('authenticated user can open the requisition create page', function () {
    $user = User::create([
        'name' => 'JJ Miranda',
        'username' => 'jj.miranda',
        'email' => 'jj.miranda@ambatugrow.test',
        'role' => 'manager',
        'department' => 'Marketing',
        'password' => Hash::make('password'),
    ]);

    $this->actingAs($user)
        ->get(route('requisitions.create'))
        ->assertOk()
        ->assertSee('CREATE PURCHASE REQUISITION');
});
