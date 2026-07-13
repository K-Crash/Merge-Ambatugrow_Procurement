<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApprovalStep extends Model
{
    protected $fillable = [
        'requisition_id', 'step_order', 'step_type', 'label', 'description',
        'required', 'approver_id', 'status', 'comment', 'acted_at',
    ];

    protected $casts = [
        'acted_at' => 'datetime',
        'required' => 'boolean',
        'approver_id' => 'integer',
        'step_order' => 'integer',
    ];

    public function requisition()
    {
        return $this->belongsTo(Requisition::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    /**
     * Only the assigned approver can act, and only when this is the
     * next pending step in the sequence for the requisition.
     */
    public function canBeActedOnBy(User $user): bool
    {
        if ($this->status !== 'pending') {
            return false;
        }

        if ((int)$this->approver_id !== (int)$user->id) {
            return false;
        }

        if ($this->requisition->approval_type === 'parallel') {
            return true;
        }

        $current = $this->requisition->currentStep();

        return $current && (int)$current->id === (int)$this->id;
    }
}
