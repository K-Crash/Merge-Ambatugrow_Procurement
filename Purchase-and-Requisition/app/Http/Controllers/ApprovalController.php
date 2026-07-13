<?php

namespace App\Http\Controllers;

use App\Models\Requisition;
use App\Models\RequisitionComment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        // Requisitions where the CURRENT active step (lowest step_order still
        // pending) is assigned to this user - i.e. it's genuinely their turn.
        $myQueueIds = Requisition::where('status', 'pending_approval')
            ->whereHas('approvalSteps', function ($q) use ($userId) {
                $q->where('approver_id', $userId)->where('status', 'pending');
            })
            ->get()
            ->filter(function (Requisition $r) use ($userId) {
                if ($r->approval_type === 'parallel') {
                    return true;
                }
                $current = $r->currentStep();

                return $current && (int)$current->approver_id === (int)$userId;
            })
            ->pluck('id');

        $pendingForMe = Requisition::with(['requestor', 'approvalSteps.approver', 'items'])
            ->whereIn('id', $myQueueIds)
            ->orderByDesc('urgency')
            ->latest()
            ->get();

        $history = Requisition::with(['requestor', 'approvalSteps'])
            ->whereIn('status', ['approved', 'rejected'])
            ->whereHas('approvalSteps', fn ($q) => $q->where('approver_id', $userId))
            ->latest()
            ->limit(25)
            ->get();

        $selectedId = $request->get('requisition') ?? $pendingForMe->first()?->id;
        $selected = $selectedId
            ? Requisition::with(['requestor', 'items', 'approvalSteps.approver', 'comments.user'])->find($selectedId)
            : null;

        $stats = [
            'pending_count' => $pendingForMe->count(),
            'value_awaiting' => $pendingForMe->sum('total'),
        ];

        $delegates = User::whereIn('role', ['manager', 'department_head', 'finance_manager'])
            ->where('id', '!=', $userId)
            ->orderBy('name')
            ->get();

        $suppliers = \App\Models\Supplier::orderBy('name')->get();

        return view('approvals.index', compact('pendingForMe', 'history', 'selected', 'stats', 'delegates', 'suppliers'));
    }

    public function show(Requisition $requisition)
    {
        return redirect()->route('approvals.index', ['requisition' => $requisition->id]);
    }

    public function act(Request $request, Requisition $requisition)
    {
        $data = $request->validate([
            'decision' => ['required', 'in:approve,reject,delegate'],
            'comment' => ['nullable', 'string', 'max:2000'],
            'delegate_to' => ['nullable', 'required_if:decision,delegate', 'exists:users,id'],
        ]);

        $user = Auth::user();
        $step = $requisition->approvalSteps()
            ->where('approver_id', $user->id)
            ->where('status', 'pending')
            ->first();

        abort_if(! $step, 403, 'You do not have a pending approval step for this requisition.');

        abort_unless($step->canBeActedOnBy($user), 403, 'You are not authorized to act on this approval step.');

        DB::transaction(function () use ($data, $requisition, $step, $user) {
            if ($data['decision'] === 'approve') {
                $step->update([
                    'status' => 'approved',
                    'comment' => $data['comment'] ?? null,
                    'acted_at' => now(),
                ]);

                $remaining = $requisition->approvalSteps()->where('status', 'pending')->count();
                if ($remaining === 0) {
                    $requisition->update(['status' => 'approved']);
                }
            } elseif ($data['decision'] === 'reject') {
                $step->update([
                    'status' => 'rejected',
                    'comment' => $data['comment'] ?? null,
                    'acted_at' => now(),
                ]);
                $requisition->update(['status' => 'rejected']);
            } elseif ($data['decision'] === 'delegate') {
                $step->update(['approver_id' => $data['delegate_to']]);
            }

            if (! empty($data['comment'])) {
                RequisitionComment::create([
                    'requisition_id' => $requisition->id,
                    'user_id' => $user->id,
                    'body' => $data['comment'],
                ]);
            }
        });

        $message = match ($data['decision']) {
            'approve' => 'Requisition step approved.',
            'reject' => 'Requisition rejected.',
            'delegate' => 'Approval delegated.',
        };

        return redirect()->route('approvals.index')->with('status', $message);
    }
}
