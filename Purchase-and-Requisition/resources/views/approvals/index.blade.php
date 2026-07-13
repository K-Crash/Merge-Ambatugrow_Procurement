@extends('layouts.app')

@section('title', 'Approvals')

@section('content')
<div x-data="{ tab: 'pr' }">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-5">
        <div>
            <h1 class="text-lg font-bold text-slate-800 mb-1">PR &amp; PO Approval Queue</h1>
            <p class="text-xs text-slate-400">Requisitions currently awaiting your decision</p>
        </div>
        <div class="flex items-center gap-2">
            <button @click="$dispatch('open-requisition-modal')" class="px-4 py-2 text-xs font-semibold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg shadow-sm transition flex items-center gap-1.5">
                <i class="fa-solid fa-file-invoice"></i>
                <span>Create Requisition</span>
            </button>
            <button @click="$dispatch('open-po-modal')" class="px-4 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-sm transition flex items-center gap-1.5">
                <i class="fa-solid fa-cart-shopping"></i>
                <span>Create PO</span>
            </button>
        </div>
    </div>

    {{-- Stat cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="card p-5 bg-blue-50/60 border-blue-100">
            <p class="text-xs text-slate-500 font-medium mb-1">Pending Approvals</p>
            <p class="text-2xl font-extrabold text-slate-800">{{ $stats['pending_count'] }}</p>
            <p class="text-xs text-slate-400 mt-1">Awaiting your action</p>
        </div>
        <div class="card p-5 bg-emerald-50/60 border-emerald-100">
            <p class="text-xs text-slate-500 font-medium mb-1">Value Awaiting Approval</p>
            <p class="text-2xl font-extrabold text-slate-800">₱{{ number_format($stats['value_awaiting'], 0) }}</p>
            <p class="text-xs text-slate-400 mt-1">Across your queue</p>
        </div>
        <div class="card p-5 bg-amber-50/60 border-amber-100">
            <p class="text-xs text-slate-500 font-medium mb-1">Your Role</p>
            <p class="text-2xl font-extrabold text-slate-800">{{ auth()->user()->roleLabel() }}</p>
            <p class="text-xs text-slate-400 mt-1">{{ auth()->user()->department }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-[1fr_360px] gap-5 items-start">

        {{-- Left: queue table --}}
        <div class="card overflow-hidden">
            <div class="flex items-center gap-5 px-5 pt-4 border-b border-slate-100 text-sm">
                <button @click="tab = 'pr'" :class="tab === 'pr' ? 'text-blue-600 border-blue-600' : 'text-slate-400 border-transparent'"
                        class="pb-3 border-b-2 font-semibold">Purchase Requisitions ({{ $pendingForMe->count() }})</button>
                <button @click="tab = 'history'" :class="tab === 'history' ? 'text-blue-600 border-blue-600' : 'text-slate-400 border-transparent'"
                        class="pb-3 border-b-2 font-semibold">History ({{ $history->count() }})</button>
            </div>

            <div x-show="tab === 'pr'">
                <table class="w-full text-sm">
                    <thead class="text-xs text-slate-400">
                        <tr>
                            <th class="text-left font-medium px-5 py-3">Request ID</th>
                            <th class="text-left font-medium px-5 py-3">Requester</th>
                            <th class="text-left font-medium px-5 py-3">Department</th>
                            <th class="text-left font-medium px-5 py-3">Total Amount</th>
                            <th class="text-left font-medium px-5 py-3">Urgency</th>
                            <th class="text-left font-medium px-5 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($pendingForMe as $req)
                            @php
                                $urgencyBadge = match($req->urgency) {
                                    'High' => 'bg-red-100 text-red-600',
                                    'Low' => 'bg-emerald-100 text-emerald-600',
                                    default => 'bg-amber-100 text-amber-600',
                                };
                            @endphp
                            <tr class="hover:bg-slate-50 {{ $selected && $selected->id === $req->id ? 'bg-blue-50/60' : '' }}">
                                <td class="px-5 py-3 font-medium text-slate-700">{{ $req->code }}</td>
                                <td class="px-5 py-3 text-slate-600">{{ $req->requestor->name }}</td>
                                <td class="px-5 py-3 text-slate-600">{{ $req->department }}</td>
                                <td class="px-5 py-3 text-slate-600">₱{{ number_format($req->total, 2) }}</td>
                                <td class="px-5 py-3">
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $urgencyBadge }}">{{ $req->urgency }}</span>
                                </td>
                                <td class="px-5 py-3">
                                    <a href="{{ route('approvals.index', ['requisition' => $req->id]) }}"
                                       class="text-xs font-semibold px-3 py-1.5 rounded-md bg-emerald-500 text-white hover:bg-emerald-600">View Details</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-10 text-center text-slate-400">Nothing waiting on your approval right now.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div x-show="tab === 'history'" x-cloak>
                <table class="w-full text-sm">
                    <thead class="text-xs text-slate-400">
                        <tr>
                            <th class="text-left font-medium px-5 py-3">Request ID</th>
                            <th class="text-left font-medium px-5 py-3">Requester</th>
                            <th class="text-left font-medium px-5 py-3">Total Amount</th>
                            <th class="text-left font-medium px-5 py-3">Result</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($history as $req)
                            <tr>
                                <td class="px-5 py-3 font-medium text-slate-700">{{ $req->code }}</td>
                                <td class="px-5 py-3 text-slate-600">{{ $req->requestor->name }}</td>
                                <td class="px-5 py-3 text-slate-600">₱{{ number_format($req->total, 2) }}</td>
                                <td class="px-5 py-3">
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $req->status === 'approved' ? 'bg-emerald-100 text-emerald-600' : 'bg-red-100 text-red-600' }}">
                                        {{ $req->statusLabel() }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-5 py-10 text-center text-slate-400">No decisions recorded yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Right: detail panel --}}
        <div class="card p-5">
            @if ($selected)
                @php 
                    $currentStep = $selected->currentStep();
                    $userStep = $selected->approvalSteps->where('approver_id', auth()->id())->where('status', 'pending')->first();
                    $canAct = $userStep && $userStep->canBeActedOnBy(auth()->user()); 
                @endphp

                <div class="flex items-center justify-between mb-1">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-amber-50 text-amber-600">{{ $selected->statusLabel() }}</span>
                    <span class="text-xs text-slate-400">{{ $selected->submitted_at?->format('M d, Y') }}</span>
                </div>
                <p class="text-sm font-bold text-slate-700 mt-2">{{ $selected->requestor->name }} <span class="text-slate-400 font-normal">[{{ $selected->department }}]</span></p>
                <p class="text-xs text-slate-400 mb-4">{{ $selected->code }} &middot; {{ $selected->title }}</p>

                <div class="border-t border-slate-100 pt-4">
                    <p class="text-xs font-semibold text-slate-500 mb-2">Line items</p>
                    <ul class="space-y-1.5">
                        @foreach ($selected->items as $item)
                            <li class="flex justify-between text-sm">
                                <span class="text-slate-600">{{ $item->name }} <span class="text-slate-400">&times;{{ rtrim(rtrim(number_format($item->qty, 2), '0'), '.') }}</span></span>
                                <span class="text-slate-700 font-medium">₱{{ number_format($item->total, 2) }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="border-t border-slate-100 mt-4 pt-4 flex justify-between text-sm">
                    <span class="font-semibold text-slate-600">Grand total</span>
                    <span class="font-bold text-slate-800">₱{{ number_format($selected->total, 2) }}</span>
                </div>

                <div class="border-t border-slate-100 mt-4 pt-4">
                    <p class="text-xs font-semibold text-slate-500 mb-2">Approval Workflow</p>
                    <ol class="space-y-2">
                        @foreach ($selected->approvalSteps as $s)
                            @php
                                $stColor = match($s->status) {
                                    'approved' => 'text-emerald-600',
                                    'rejected' => 'text-red-600',
                                    default => 'text-amber-600',
                                };
                                $isCurrent = $currentStep && $currentStep->id === $s->id;
                            @endphp
                            <li class="flex items-center justify-between text-sm {{ $isCurrent ? 'font-semibold text-slate-800' : 'text-slate-500' }}">
                                <span>Step {{ $s->step_order }}: {{ $s->approver?->name ?? 'Unassigned' }}</span>
                                <span class="text-xs {{ $stColor }} font-semibold">{{ ucfirst($s->status) }}</span>
                            </li>
                        @endforeach
                    </ol>
                </div>

                <div class="border-t border-slate-100 mt-4 pt-4">
                    @if ($canAct)
                        <form method="POST" action="{{ route('approvals.act', $selected) }}" class="space-y-3" x-data="{ decision: '', submitted: false }" @submit="submitted = true">
                            @csrf
                            <input type="hidden" name="decision" x-model="decision">
                            <textarea name="comment" rows="2" placeholder="Comment (optional)"
                                      class="w-full px-3 py-2 text-sm rounded-md border border-slate-200 focus:outline-none focus:ring-2 focus:ring-blue-200"></textarea>

                            <select name="delegate_to" class="w-full text-xs rounded-md border border-slate-200 px-2 py-1.5">
                                <option value="">Delegate to... (optional)</option>
                                @foreach ($delegates as $d)
                                    <option value="{{ $d->id }}">{{ $d->name }} — {{ $d->roleLabel() }}</option>
                                @endforeach
                            </select>

                            <div class="flex gap-2 pt-1">
                                <button type="submit" @click="decision = 'reject'" :disabled="submitted" class="flex-1 px-3 py-2 text-xs font-semibold rounded-md bg-red-50 text-red-600 hover:bg-red-100 disabled:opacity-50">Reject</button>
                                <button type="submit" @click="decision = 'delegate'" :disabled="submitted" class="flex-1 px-3 py-2 text-xs font-semibold rounded-md bg-slate-100 text-slate-600 hover:bg-slate-200 disabled:opacity-50">Delegate</button>
                                <button type="submit" @click="decision = 'approve'" :disabled="submitted" class="flex-1 px-3 py-2 text-xs font-semibold rounded-md bg-emerald-500 text-white hover:bg-emerald-600 disabled:opacity-50">Approve</button>
                            </div>
                        </form>
                    @else
                        <p class="text-xs text-slate-400 bg-slate-50 rounded-md px-3 py-2.5">
                            <i class="fa-solid fa-lock mr-1"></i>
                            It isn't your turn to act on this requisition, or you're not the assigned approver for the current step.
                        </p>
                    @endif
                </div>
            @else
                <div class="text-center py-14 text-slate-400">
                    <i class="fa-regular fa-folder-open text-3xl mb-3"></i>
                    <p class="text-sm">Select a requisition to view details.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
