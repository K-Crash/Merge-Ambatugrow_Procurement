<?php

namespace App\Http\Controllers;

use App\Models\ApprovalStep;
use App\Models\Requisition;
use App\Models\RequisitionItem;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RequisitionController extends Controller
{
    public function create()
    {
        return view('requisitions.create', [
            'services' => Service::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
            'needed_by' => ['nullable', 'date'],
            'purpose' => ['nullable', 'string'],
            'urgency' => ['nullable', 'in:Low,Medium,High'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.name' => ['required', 'string', 'max:255'],
            'items.*.qty' => ['required', 'numeric', 'min:0.01'],
            'items.*.unit' => ['nullable', 'string', 'max:50'],
            'items.*.unit_price' => ['required', 'numeric', 'min:0'],
            'items.*.service_id' => ['nullable', 'exists:services,id'],
            'action' => ['required', 'in:draft,continue'],
        ]);

        $requisition = DB::transaction(function () use ($data, $request) {
            $subtotal = collect($data['items'])->sum(fn ($i) => $i['qty'] * $i['unit_price']);
            $taxRate = 0; // adjustable
            $taxAmount = round($subtotal * ($taxRate / 100), 2);

            $requisition = Requisition::create([
                'code' => $this->generateCode(),
                'title' => $data['title'],
                'department' => $data['department'] ?? Auth::user()->department,
                'requestor_id' => Auth::id(),
                'needed_by' => $data['needed_by'] ?? null,
                'purpose' => $data['purpose'] ?? null,
                'subtotal' => $subtotal,
                'tax_rate' => $taxRate,
                'tax_amount' => $taxAmount,
                'total' => $subtotal + $taxAmount,
                'urgency' => $data['urgency'] ?? 'Medium',
                'status' => 'draft',
            ]);

            foreach ($data['items'] as $item) {
                RequisitionItem::create([
                    'requisition_id' => $requisition->id,
                    'service_id' => $item['service_id'] ?? null,
                    'name' => $item['name'],
                    'qty' => $item['qty'],
                    'unit' => $item['unit'] ?? 'service',
                    'unit_price' => $item['unit_price'],
                    'total' => $item['qty'] * $item['unit_price'],
                ]);
            }

            return $requisition;
        });

        if ($data['action'] === 'draft') {
            return redirect()->route('requisitions.tracking')->with('status', 'Requisition saved as draft.');
        }

        return redirect()->route('requisitions.route', $requisition);
    }

    public function showRoute(Requisition $requisition)
    {
        $this->authorizeOwner($requisition);

        $approvers = [
            'manager' => User::where('role', 'manager')->get(),
            'department_head' => User::where('role', 'department_head')->get(),
            'finance_manager' => User::where('role', 'finance_manager')->get(),
        ];

        $steps = $requisition->approvalSteps;

        if ($steps->isEmpty()) {
            $steps = collect([
                new ApprovalStep(['step_order' => 1, 'step_type' => 'manager_approval', 'label' => 'Manager approval', 'description' => 'First level approval from the requestor\'s manager', 'required' => true]),
                new ApprovalStep(['step_order' => 2, 'step_type' => 'department_head_approval', 'label' => 'Department Head Approval', 'description' => 'Approval from the head of the department', 'required' => true]),
                new ApprovalStep(['step_order' => 3, 'step_type' => 'finance_approval', 'label' => 'Department Head Approval', 'description' => 'Final approval from Finance Department', 'required' => true]),
            ]);
        }

        return view('requisitions.route-approval', compact('requisition', 'approvers', 'steps'));
    }

    public function storeRoute(Request $request, Requisition $requisition)
    {
        $this->authorizeOwner($requisition);

        $data = $request->validate([
            'approval_type' => ['required', 'in:sequential,parallel'],
            'steps' => ['required', 'array', 'min:1'],
            'steps.*.step_type' => ['required', 'in:manager_approval,department_head_approval,finance_approval'],
            'steps.*.label' => ['required', 'string', 'max:255'],
            'steps.*.description' => ['nullable', 'string', 'max:255'],
            'steps.*.approver_id' => ['required', 'exists:users,id'],
            'steps.*.required' => ['nullable'],
        ]);

        DB::transaction(function () use ($data, $requisition) {
            $requisition->approvalSteps()->delete();

            foreach ($data['steps'] as $index => $step) {
                ApprovalStep::create([
                    'requisition_id' => $requisition->id,
                    'step_order' => $index + 1,
                    'step_type' => $step['step_type'],
                    'label' => $step['label'],
                    'description' => $step['description'] ?? null,
                    'required' => ! empty($step['required']),
                    'approver_id' => $step['approver_id'],
                    'status' => 'pending',
                ]);
            }

            $requisition->update([
                'approval_type' => $data['approval_type'],
                'status' => 'pending_approval',
                'submitted_at' => now(),
            ]);
        });

        return redirect()->route('requisitions.tracking')->with('status', 'Requisition routed for approval.');
    }

    public function tracking()
    {
        $requisitions = Requisition::with(['requestor', 'approvalSteps'])
            ->where('requestor_id', Auth::id())
            ->latest()
            ->get();

        return view('requisitions.tracking', compact('requisitions'));
    }

    public function searchServices(Request $request)
    {
        $query = trim((string) $request->get('q'));

        $services = Service::when($query, fn ($q) => $q->where('name', 'like', "%{$query}%"))
            ->orderBy('name')
            ->limit(20)
            ->get();

        return response()->json($services);
    }

    private function authorizeOwner(Requisition $requisition): void
    {
        abort_unless($requisition->requestor_id === Auth::id(), 403);
    }

    private function generateCode(): string
    {
        $year = now()->format('Y');
        $count = Requisition::whereYear('created_at', $year)->count() + 1;

        return sprintf('PR-%s-%05d', $year, $count);
    }
}
