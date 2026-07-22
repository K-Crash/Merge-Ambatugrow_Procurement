@extends('layouts.master')

@section('title', 'Supplier Profile')
@section('subtitle', 'Overview and verification metrics')

@section('content')

<div x-data="{ blockModalOpen: false }">
    {{-- Supplier Header Bar --}}
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-6 mb-6 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-5 font-sans">
        <div class="flex items-center gap-5">
            <div class="w-20 h-20 rounded-2xl bg-[#1f5c3d] border-2 border-emerald-400/30 flex items-center justify-center text-white text-3xl font-black shrink-0 shadow-md">
                {{ strtoupper(substr($supplier['supplier_name'] ?? $supplier['name'], 0, 1)) }}
            </div>
            <div>
                {{-- Requirement 1: High Contrast Supplier Name --}}
                <div class="flex items-center gap-3 flex-wrap">
                    <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">{{ $supplier['supplier_name'] ?? $supplier['name'] }}</h1>
                    
                    {{-- Requirement 2: Current Supplier Status --}}
                    @if (in_array(strtolower($supplier['status'] ?? ''), ['blacklisted', 'blocked'], true))
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-red-100 dark:bg-red-950/80 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-800">
                            <span class="w-2 h-2 rounded-full bg-red-600 animate-pulse"></span>
                            Blocked / Blacklisted
                        </span>
                    @elseif (strtolower($supplier['status'] ?? '') === 'active')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-emerald-100 dark:bg-emerald-950/80 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                            <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                            Active Supplier
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-black bg-amber-100 dark:bg-amber-950/80 text-amber-700 dark:text-amber-300 border border-amber-200 dark:border-amber-800">
                            <span class="w-2 h-2 rounded-full bg-amber-600"></span>
                            {{ $supplier['status'] ?? 'Pending' }}
                        </span>
                    @endif
                </div>

                <div class="text-xs text-slate-600 dark:text-slate-400 mt-1.5 flex items-center gap-2 font-medium">
                    <span>Supplier ID: <strong class="text-slate-800 dark:text-slate-200 font-bold">{{ $supplier['supplier_id'] }}</strong></span>
                    <span class="text-slate-300 dark:text-slate-700">•</span>
                    <span>Supplier Since: <strong class="text-slate-800 dark:text-slate-200 font-bold">{{ $supplier['since'] }}</strong></span>
                </div>
                <p class="text-xs text-slate-600 dark:text-slate-300 mt-2 max-w-xl leading-relaxed">{{ $supplier['description'] }}</p>
            </div>
        </div>

        {{-- Action Buttons: Block / Unblock (Requirement 1 & 2) --}}
        <div class="shrink-0">
            @if (in_array(strtolower($supplier['status'] ?? ''), ['blacklisted', 'blocked'], true))
                {{-- Unblock Button --}}
                <form method="POST" action="{{ route('suppliers.unblock', $supplier['slug']) }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white text-sm font-bold shadow-md hover:shadow-lg transition-all focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                        <span>Unblock Supplier</span>
                    </button>
                </form>
            @else
                {{-- Block Button (Danger Red Styling) --}}
                <button type="button" @click="blockModalOpen = true" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 active:bg-red-800 text-white text-sm font-bold shadow-md hover:shadow-lg transition-all focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 cursor-pointer">
                    <i data-lucide="ban" class="w-4 h-4"></i>
                    <span>Block This Supplier</span>
                </button>
            @endif
        </div>
    </div>

    {{-- Requirement 3: Display Saved Blocking Reason if Blocked --}}
    @if (in_array(strtolower($supplier['status'] ?? ''), ['blacklisted', 'blocked'], true))
        <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800 text-red-900 dark:text-red-200 flex items-start gap-3">
            <i data-lucide="alert-octagon" class="w-5 h-5 text-red-600 shrink-0 mt-0.5"></i>
            <div>
                <h4 class="text-sm font-bold text-red-800 dark:text-red-300">Supplier Access Restricted</h4>
                <p class="text-xs text-red-700 dark:text-red-300/90 mt-1">
                    <strong>Reason for Blocking:</strong> {{ $supplier['blacklist_reason'] ?? 'Not specified' }}
                </p>
                @if (!empty($supplier['blacklisted_since']))
                    <p class="text-[11px] text-red-600 dark:text-red-400 mt-1">
                        <strong>Blocked Since:</strong> {{ $supplier['blacklisted_since'] }}
                    </p>
                @endif
            </div>
        </div>
    @endif

    {{-- Horizontal Sub-tabs Navigation --}}
    <div class="border-b border-slate-200/60 mb-6 w-full flex items-center gap-6 text-sm font-medium font-sans">
        <a href="{{ route('suppliers.show', $supplier['slug']) }}" class="pb-3 border-b-2 transition-colors {{ request()->routeIs('suppliers.show') ? 'border-green-800 text-green-800 font-bold dark:border-green-600 dark:text-green-500' : 'border-transparent text-gray-500 hover:text-gray-900 dark:text-slate-400 dark:hover:text-white' }}">Overview</a>
        <a href="{{ route('suppliers.products', $supplier['slug']) }}" class="pb-3 border-b-2 transition-colors {{ request()->routeIs('suppliers.products') ? 'border-green-800 text-green-800 font-bold dark:border-green-600 dark:text-green-500' : 'border-transparent text-gray-500 hover:text-gray-900 dark:text-slate-400 dark:hover:text-white' }}">Products</a>
        <a href="{{ route('suppliers.purchase-history', $supplier['slug']) }}" class="pb-3 border-b-2 transition-colors {{ request()->routeIs('suppliers.purchase-history') ? 'border-green-800 text-green-800 font-bold dark:border-green-600 dark:text-green-500' : 'border-transparent text-gray-500 hover:text-gray-900 dark:text-slate-400 dark:hover:text-white' }}">Purchase History</a>
        <a href="{{ route('suppliers.contract', $supplier['slug']) }}" class="pb-3 border-b-2 transition-colors {{ request()->routeIs('suppliers.contract') ? 'border-green-800 text-green-800 font-bold dark:border-green-600 dark:text-green-500' : 'border-transparent text-gray-500 hover:text-gray-900 dark:text-slate-400 dark:hover:text-white' }}">Contract</a>
        <a href="{{ route('suppliers.performance', $supplier['slug']) }}" class="pb-3 border-b-2 transition-colors {{ request()->routeIs('suppliers.performance') ? 'border-green-800 text-green-800 font-bold dark:border-green-600 dark:text-green-500' : 'border-transparent text-gray-500 hover:text-gray-900 dark:text-slate-400 dark:hover:text-white' }}">Performance</a>
    </div>

    <div class="w-full flex flex-col gap-5">
        {{-- Top row: Company Info + Primary Contact --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            {{-- Company Information --}}
            <div class="card">
                <h2 class="card-title font-bold text-slate-900 dark:text-white mb-4 text-base">Company Information</h2>
                <dl>
                    @foreach ([
                        'Company Name'  => $supplier['name'],
                        'Business Type' => $supplier['business_type'],
                        'Address'       => $supplier['address'],
                        'Phone'         => $supplier['phone'],
                        'Email'         => $supplier['email'],
                        'Date Added'    => $supplier['since'],
                    ] as $label => $value)
                    <div class="info-row flex justify-between py-2.5 border-b border-slate-100 dark:border-slate-800 {{ $loop->last ? '!border-0' : '' }}">
                        <dt class="text-xs font-semibold text-slate-600 dark:text-slate-400">{{ $label }}</dt>
                        <dd class="text-xs font-bold text-slate-900 dark:text-slate-100">{{ $value }}</dd>
                    </div>
                    @endforeach
                </dl>
            </div>

            <div class="flex flex-col gap-4">
                {{-- Primary Contact --}}
                <div class="card">
                    <h2 class="card-title font-bold text-slate-900 dark:text-white mb-4 text-base">Primary Contact</h2>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200 font-extrabold flex items-center justify-center text-sm">
                            {{ collect(explode(' ', $supplier['contact_name']))->map(fn($w) => $w[0] ?? '')->join('') }}
                        </div>
                        <div>
                            <div class="font-bold text-slate-900 dark:text-white text-sm">{{ $supplier['contact_name'] }}</div>
                            <div class="text-xs text-slate-500 dark:text-slate-400">{{ $supplier['contact_role'] }}</div>
                        </div>
                    </div>
                    <div class="space-y-2.5">
                        <div class="flex items-center gap-3 text-xs font-medium text-slate-700 dark:text-slate-300">
                            <i data-lucide="phone" class="w-4 h-4 text-slate-400 shrink-0"></i>
                            {{ $supplier['phone'] }}
                        </div>
                        <div class="flex items-center gap-3 text-xs font-medium text-slate-700 dark:text-slate-300">
                            <i data-lucide="mail" class="w-4 h-4 text-slate-400 shrink-0"></i>
                            {{ $supplier['email'] }}
                        </div>
                    </div>
                </div>

                {{-- Quick Stats --}}
                <div class="card">
                    <h2 class="card-title font-bold text-slate-900 dark:text-white mb-4 text-base">Quick Stats</h2>
                    <dl>
                        @foreach ([
                            'Total Orders'         => $supplier['total_orders'],
                            'Total Spent'          => '₱' . number_format((float)$supplier['total_spent'], 2),
                            'Average Order Value'  => '₱' . number_format((float)$supplier['avg_order_value'], 2),
                            'On-time Delivery Rate'=> $supplier['on_time_rate'] . '%',
                            'Last Transaction'     => $supplier['last_transaction'] ?? 'N/A',
                        ] as $label => $value)
                        <div class="flex items-center justify-between py-2.5 border-b border-slate-100 dark:border-slate-800 {{ $loop->last ? '!border-0' : '' }}">
                            <dt class="text-xs font-semibold text-slate-600 dark:text-slate-400">{{ $label }}</dt>
                            <dd class="text-xs font-bold text-slate-900 dark:text-slate-100">{{ $value }}</dd>
                        </div>
                        @endforeach
                    </dl>
                </div>
            </div>
        </div>
    </div>

    {{-- Requirement 3: Block Supplier Confirmation Modal --}}
    <div x-show="blockModalOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4"
         style="display: none;">
        
        <div @click.away="blockModalOpen = false" class="bg-white dark:bg-slate-900 rounded-2xl max-w-lg w-full p-6 shadow-2xl border border-slate-200 dark:border-slate-800">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-950/80 text-red-600 dark:text-red-400 flex items-center justify-center">
                        <i data-lucide="ban" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-900 dark:text-white">Block Supplier Confirmation</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Specify why {{ $supplier['supplier_name'] ?? $supplier['name'] }} is being blocked.</p>
                    </div>
                </div>
                <button type="button" @click="blockModalOpen = false" class="text-slate-400 hover:text-slate-600 focus:outline-none">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form method="POST" action="{{ route('suppliers.block', $supplier['slug']) }}" id="block-supplier-form">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-extrabold uppercase text-slate-700 dark:text-slate-300 mb-1.5">
                        Reason for Blocking <span class="text-red-500">*</span>
                    </label>
                    <textarea name="blacklist_reason" 
                              id="blacklist_reason"
                              rows="3" 
                              required 
                              class="w-full px-3 py-2 text-sm rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none"
                              placeholder="Describe the reason for blocking this supplier (e.g. Fraudulent transactions, repeated late deliveries)..."></textarea>
                    
                    {{-- Quick Preset Tags --}}
                    <div class="mt-2 flex flex-wrap gap-1.5">
                        <span class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 self-center mr-1">Presets:</span>
                        @foreach([
                            'Fraudulent transactions',
                            'Repeated late deliveries',
                            'Poor product quality',
                            'Contract violation',
                            'Expired Certification'
                        ] as $preset)
                            <button type="button" 
                                    @click="document.getElementById('blacklist_reason').value = '{{ $preset }}'"
                                    class="text-[11px] font-bold px-2.5 py-1 rounded-lg bg-slate-100 hover:bg-red-50 hover:text-red-700 dark:bg-slate-800 dark:hover:bg-red-950/50 dark:hover:text-red-300 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 transition-colors">
                                + {{ $preset }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="mb-5">
                    <label class="block text-xs font-extrabold uppercase text-slate-700 dark:text-slate-300 mb-1.5">
                        Risk Level Assessment
                    </label>
                    <select name="risk_level" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-red-500 outline-none">
                        <option value="Critical">Critical Risk</option>
                        <option value="High" selected>High Risk</option>
                        <option value="Medium">Medium Risk</option>
                        <option value="Low">Low Risk</option>
                    </select>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                    <button type="button" @click="blockModalOpen = false" class="px-4 py-2 rounded-xl border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 text-sm font-bold hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                        Cancel
                    </button>
                    <button type="submit" class="px-5 py-2 rounded-xl bg-red-600 hover:bg-red-700 active:bg-red-800 text-white text-sm font-bold shadow-md transition-all">
                        Confirm Block Supplier
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
