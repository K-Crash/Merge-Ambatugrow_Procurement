<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'job_title',
        'department',
        'avatar_initial',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function requisitions()
    {
        return $this->hasMany(Requisition::class, 'requestor_id');
    }

    public function approvalSteps()
    {
        return $this->hasMany(ApprovalStep::class, 'approver_id');
    }

    public function initials(): string
    {
        if ($this->avatar_initial) {
            return $this->avatar_initial;
        }

        $parts = explode(' ', trim($this->name));
        $initials = '';
        foreach (array_slice($parts, 0, 2) as $p) {
            $initials .= strtoupper(substr($p, 0, 1));
        }

        return $initials ?: 'U';
    }

    public function roleLabel(): string
    {
        return match ($this->role) {
            'manager' => 'Manager',
            'department_head' => $this->job_title ?: 'Department Head',
            'finance_manager' => 'Finance Manager',
            'admin' => 'Administrator',
            default => ucfirst($this->role),
        };
    }
}
