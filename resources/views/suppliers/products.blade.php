@extends('layouts.master')

@section('title', 'Supplier Profile')
@section('subtitle', 'Supplier catalog and custom pricing')

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

    <div class="w-full">
            <h1 style="font-size:22px; font-weight:700; color:#111827; margin-bottom:20px;">Product Details</h1>

            <div class="flex flex-col gap-5">
                @foreach ($supplier['products'] as $p)
                <div class="card">
                    <h2 class="text-[16px] font-bold text-gray-900 mb-4">{{ $p['name'] }}</h2>
                    <div class="flex gap-6">
                        {{-- Image Placeholder --}}
                        <div class="w-52 h-44 bg-gray-100 border border-gray-200 rounded-lg flex items-center justify-center shrink-0">
                            <span class="text-gray-400 font-semibold text-sm">IMG</span>
                        </div>

                        {{-- Product Details Table --}}
                        <table class="flex-1" style="border-collapse:collapse;">
                            <thead>
                                <tr>
                                    <th style="text-align:left; padding:8px 16px 8px 0; font-size:13px; font-weight:600; color:#111827; border-bottom:1px solid #E5E7EB; width:50%">Field</th>
                                    <th style="text-align:left; padding:8px 16px 8px 0; font-size:13px; font-weight:600; color:#111827; border-bottom:1px solid #E5E7EB;">Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    ['Product Code', $p['code'] ?? '—'],
                                    ['Category',     $p['category'] ?? '—'],
                                    ['Unit',         $p['unit'] ?? '—'],
                                    ['Unit Price',   $p['unit_price'] ?? '—'],
                                    ['Stock Status', $p['stock_status'] ?? 'In Stock'],
                                    ['Minimum Order Quantity', $p['min_order'] ?? '—'],
                                    ['Lead time',    $p['lead_time'] ?? '—'],
                                ] as [$field, $detail])
                                <tr>
                                    <td style="padding:9px 16px 9px 0; font-size:13px; color:#6B7280; border-bottom:1px solid #F3F4F6;">{{ $field }}</td>
                                    <td style="padding:9px 16px 9px 0; font-size:13px; color:#111827; border-bottom:1px solid #F3F4F6;">{{ $detail }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
@endsection
