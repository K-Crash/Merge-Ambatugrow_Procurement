@extends('layouts.erp')

@section('title', 'Pending Verification')

@section('content')
    
    <div class="flex items-center justify-between mb-6">
        <h1 style="font-size:26px; font-weight:700; color:#111827; letter-spacing:-0.02em;">Pending Verification</h1>
    </div>

    @if (count($suppliers) > 0)
    <div class="flex items-center gap-3 bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-lg text-[13px] font-medium mb-4">
        <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
        {{ count($suppliers) }} supplier(s) are awaiting verification.
    </div>
    @endif

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
        <table class="fig-table">
            <thead>
                <tr>
                    <th style="padding-left:20px">Supplier</th>
                    <th>Products</th>
                    <th>Location</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suppliers as $s)
                <tr class="cursor-pointer" onclick="window.location='{{ route('suppliers.show', $s['slug']) }}'">
                    <td style="padding-left:20px">
                        <div class="flex items-center gap-3">
                            <div class="avatar"></div>
                            <div>
                                <div class="supplier-name">{{ $s['name'] }}</div>
                                <div class="supplier-id">{{ $s['supplier_id'] }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="text-gray-600 text-[13px]">{{ $s['products_list'] }}</td>
                    <td>
                        <span class="flex items-center gap-1.5 text-[13px] text-gray-600">
                            <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
                            {{ $s['location'] }}
                        </span>
                    </td>
                    <td><span class="badge-pending"><span class="w-1.5 h-1.5 rounded-full bg-amber-500 inline-block"></span>Pending</span></td>
                </tr>
                @empty
                <tr>
                    <td colspan="4">
                        <div class="empty-state">
                            <svg class="w-10 h-10 text-green-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="text-sm font-semibold text-gray-400">No pending suppliers — all clear!</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        @if (count($suppliers) > 0)
        <div class="px-5 py-3.5 border-t border-gray-100 text-[13px] font-semibold text-amber-600">
            {{ count($suppliers) }} pending supplier(s) require review
        </div>
        @endif
    </div>
@endsection
