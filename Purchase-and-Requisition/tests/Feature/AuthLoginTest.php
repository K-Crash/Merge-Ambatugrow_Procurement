<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

test('user can login and reach the approvals dashboard', function () {
    User::create([
        'name' => 'JJ Miranda',
        'username' => 'jj.miranda',
        'email' => 'jj.miranda@ambatugrow.test',
        'role' => 'manager',
        'password' => Hash::make('password'),
    ]);

    $this->post('/login', [
        'username' => 'jj.miranda',
        'password' => 'password',
    ])->assertRedirect(route('approvals.index'));
});
