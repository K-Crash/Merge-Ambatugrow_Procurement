@extends('layouts.erp')

@section('title', $supplier['name'])

@section('content')

    {{-- Supplier Header --}}
    <div class="flex items-start gap-5 mb-7 font-sans">
        <div class="w-20 h-20 rounded-full bg-green-900 border-2 border-white flex items-center justify-center text-white text-2xl font-black shrink-0 shadow-md">
            {{ strtoupper(substr($supplier['supplier_name'] ?? $supplier['name'], 0, 1)) }}
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $supplier['supplier_name'] ?? $supplier['name'] }}</h1>
            <div class="text-xs text-gray-500 dark:text-slate-400 mt-1 flex items-center gap-1.5">
                <span>Supplier ID: <span class="font-semibold">{{ $supplier['supplier_id'] }}</span></span>
                <span class="text-slate-300">•</span>
                <span>Supplier since {{ $supplier['since'] }}</span>
            </div>
            <p class="text-xs text-gray-600 dark:text-slate-300 mt-2.5 max-w-xl leading-relaxed">{{ $supplier['description'] }}</p>
        </div>
    </div>

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
            <div class="grid grid-cols-2 gap-5">
                {{-- Company Information --}}
                <div class="card">
                    <h2 class="card-title">Company Information</h2>
                    <dl>
                        @foreach ([
                            'Company Name'  => $supplier['name'],
                            'Business Type' => $supplier['business_type'],
                            'Address'       => $supplier['address'],
                            'Phone'         => $supplier['phone'],
                            'Email'         => $supplier['email'],
                            'Date Added'    => $supplier['since'],
                        ] as $label => $value)
                        <div class="info-row {{ $loop->last ? '!border-0' : '' }}">
                            <dt>{{ $label }}</dt>
                            <dd>{{ $value }}</dd>
                        </div>
                        @endforeach
                    </dl>
                </div>

                <div class="flex flex-col gap-4">
                    {{-- Primary Contact --}}
                    <div class="card">
                        <h2 class="card-title">Primary Contact</h2>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="avatar-initials text-sm">
                                {{ collect(explode(' ', $supplier['contact_name']))->map(fn($w) => $w[0])->join('') }}
                            </div>
                            <div>
                                <div class="font-semibold text-gray-900 text-[14px]">{{ $supplier['contact_name'] }}</div>
                                <div class="text-[12px] text-gray-500">{{ $supplier['contact_role'] }}</div>
                            </div>
                        </div>
                        <div class="space-y-2.5">
                            <div class="flex items-center gap-3 text-[13px] text-gray-600">
                                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                {{ $supplier['phone'] }}
                            </div>
                            <div class="flex items-center gap-3 text-[13px] text-gray-600">
                                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                {{ $supplier['email'] }}
                            </div>
                        </div>
                    </div>

                    {{-- Quick Stats --}}
                    <div class="card">
                        <h2 class="card-title">Quick Stats</h2>
                        <dl>
                            @foreach ([
                                'Total Orders'     => $supplier['total_orders'],
                                'Total Spent'      => $supplier['total_spent'],
                                'Avarage Order Value' => $supplier['avg_order_value'],
                                'On-time Delivery Rate' => $supplier['on_time_rate'],
                                'Last Transaction' => $supplier['last_transaction'],
                            ] as $label => $value)
                            <div class="flex items-center justify-between py-2.5 border-b border-gray-50 {{ $loop->last ? '!border-0' : '' }}">
                                <dt class="text-[13px] text-gray-500">{{ $label }}</dt>
                                <dd class="text-[13px] font-semibold text-gray-900">{{ $value }}</dd>
                            </div>
                            @endforeach
                        </dl>
                    </div>
                </div>
            </div>

            {{-- Products Supplied --}}
            <div class="card">
                <h2 class="card-title">Product Supplied</h2>
                <a href="{{ route('suppliers.products', $supplier['slug']) }}" class="flex gap-6">
                    @foreach ($supplier['products'] as $p)
                    <div class="text-center">
                        <div class="w-16 h-16 rounded-full bg-gray-200 mx-auto mb-2"></div>
                        <div class="text-[12px] text-gray-600 font-medium">{{ $p['name'] }}</div>
                    </div>
                    @endforeach
                </a>
            </div>

    </div>
@endsection
