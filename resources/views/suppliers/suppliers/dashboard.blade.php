@extends('layouts.erp')

@section('title', 'Supplier Management')
@section('subtitle', 'Manage and evaluate your agricultural suppliers')

@section('header_right')
@endsection

@section('content')

    {{-- KPI cards --}}
   <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mt-8 mb-8 px-6">
        <a href="{{ route('suppliers.index') }}" class="unified-card flex flex-col justify-between hover:scale-[1.01] transition-transform">
            <div>
                <div class="text-xs uppercase font-extrabold tracking-wider text-gray-400">Total Supplier</div>
                <div class="text-2xl font-extrabold text-slate-900 mt-2">{{ $stats['total'] }}</div>
            </div>
            <div class="text-xs text-green-600 mt-2">↑ 8 this month</div>
        </a>
        <a href="{{ route('suppliers.active') }}" class="unified-card flex flex-col justify-between hover:scale-[1.01] transition-transform">
            <div>
                <div class="text-xs uppercase font-extrabold tracking-wider text-gray-400">Active Suppliers</div>
                <div class="text-2xl font-extrabold text-slate-900 mt-2">{{ $stats['active'] }}</div>
            </div>
            <div class="text-xs text-green-600 mt-2">{{ round(($stats['active'] / max($stats['total'], 1)) * 100) }}% of total</div>
        </a>
        <a href="{{ route('suppliers.pending') }}" class="unified-card flex flex-col justify-between hover:scale-[1.01] transition-transform">
            <div>
                <div class="text-xs uppercase font-extrabold tracking-wider text-gray-400">Pending Verification</div>
                <div class="text-2xl font-extrabold text-slate-900 mt-2">{{ $stats['pending'] }}</div>
            </div>
            <div class="text-xs text-yellow-600 mt-2">Requires to review</div>
        </a>
        <a href="{{ route('suppliers.blacklisted') }}" class="unified-card flex flex-col justify-between hover:scale-[1.01] transition-transform">
            <div>
                <div class="text-xs uppercase font-extrabold tracking-wider text-gray-400">Blacklisted Suppliers</div>
                <div class="text-2xl font-extrabold text-slate-900 mt-2">{{ $stats['blacklisted'] }}</div>
            </div>
            <div class="text-xs text-red-600 mt-2">{{ round(($stats['blacklisted'] / max($stats['total'], 1)) * 100) }}% of total</div>
        </a>
    </div>

    <div class="grid grid-cols-3 gap-6 mb-6">
        {{-- Supplier list overview --}}
        <div class="col-span-2 flex flex-col ml-6 mr-6   gap-4">
            <div class="unified-card">
                <div class="flex items-center justify-between">
                    <h2 class="font-semibold text-lg text-slate-900">Supplier List Overview</h2>
                    <a href="{{ route('suppliers.create') }}" class="bg-green-700 hover:bg-green-800 text-white text-sm px-3 py-1.5 rounded-lg transition-colors font-semibold">+ Add Supplier</a>
                </div>
            </div>
            <div class="unified-table-card">
                <table class="unified-table">
                    <thead>
                        <tr>
                            <th>Supplier</th>
                            <th>Products</th>
                            <th>Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suppliers as $s)
                            <tr>
                                <td>
                                    <a href="{{ route('suppliers.show', $s['slug']) }}" class="hover:text-green-700">
                                        <div class="font-bold text-slate-800">{{ $s['name'] }}</div>
                                        <div class="text-xs text-gray-400">{{ $s['supplier_id'] }}</div>
                                    </a>
                                </td>
                                <td class="text-gray-600">{{ $s['products_list'] }}</td>
                                <td class="text-gray-600">📍 {{ $s['location'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="px-5 py-3 border-t bg-gray-50/50">
                    <a href="{{ route('suppliers.index') }}" class="text-green-700 hover:text-green-800 text-sm font-semibold inline-block">View all suppliers →</a>
                </div>
            </div>
        </div>

        {{-- Product supplied donut (static legend) --}}
        <div class="unified-card flex flex-col justify-between ml-6 mr-6">
            <div>
                <h2 class="font-semibold text-lg text-slate-900 mb-4">Product Supplied</h2>
                <ul class="text-sm space-y-2.5">
                    <li class="flex justify-between border-b pb-2"><span>🟢 Rice</span><span class="font-bold">40%</span></li>
                    <li class="flex justify-between border-b pb-2"><span>🟠 Fruits</span><span class="font-bold">30%</span></li>
                    <li class="flex justify-between border-b pb-2"><span>🟢 Vegetables</span><span class="font-bold">20%</span></li>
                    <li class="flex justify-between pb-1"><span>⚪ Others</span><span class="font-bold">10%</span></li>
                </ul>

                <h2 class="font-semibold text-lg text-slate-900 mt-8 mb-4">Top Suppliers (by Orders)</h2>
                <ol class="text-sm space-y-3">
                    @foreach ($suppliers as $s)
                        <li class="border-b pb-2">
                            <a href="{{ route('suppliers.show', $s['slug']) }}" class="flex justify-between hover:text-green-700">
                                <span class="font-medium text-slate-700">{{ $s['name'] }}</span>
                                <span class="text-gray-400 text-xs">{{ $s['total_orders'] }} orders</span>
                            </a>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>

    {{-- Performance overview --}}
    <div class="unified-card ml-6 mr-6 mb-6">
        <h2 class="font-semibold text-lg text-slate-900 mb-4">Supplier Performance Overview</h2>
        <div class="grid grid-cols-4 gap-4">
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                <div class="text-xs uppercase font-extrabold tracking-wider text-gray-400">Average Rating</div>
                <div class="text-xl font-bold text-slate-900 mt-2">4.6 <span class="text-sm font-normal text-gray-400">/ 5</span></div>
                <div class="text-xs text-green-600 mt-1">↑ 0.2 from last month</div>
            </div>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                <div class="text-xs uppercase font-extrabold tracking-wider text-gray-400">On-time Delivery</div>
                <div class="text-xl font-bold text-slate-900 mt-2">92%</div>
                <div class="text-xs text-green-600 mt-1">↑ 5% from last month</div>
            </div>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                <div class="text-xs uppercase font-extrabold tracking-wider text-gray-400">Total Orders</div>
                <div class="text-xl font-bold text-slate-900 mt-2">245</div>
                <div class="text-xs text-green-600 mt-1">↑ 18 this month</div>
            </div>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
                <div class="text-xs uppercase font-extrabold tracking-wider text-gray-400">Quality Score</div>
                <div class="text-xl font-bold text-slate-900 mt-2">4.6 <span class="text-sm font-normal text-gray-400">/ 5</span></div>
                <div class="text-xs text-green-600 mt-1">↑ 0.3 from last month</div>
            </div>
        </div>
    </div>
@endsection
