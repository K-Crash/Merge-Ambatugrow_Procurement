@extends('layouts.master')

@section('title', 'Active Suppliers')
@section('subtitle', 'Verified active vendor accounts')

@section('topbar-actions')
    <a href="{{ route('suppliers.create') }}" class="top-bar-btn bg-emerald-600/80 hover:bg-emerald-700/90 border-emerald-500/30 flex items-center gap-1">
        <i data-lucide="plus" class="w-4 h-4"></i>
        <span>Add Supplier</span>
    </a>
@endsection

@section('content')

    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
        <table class="fig-table">
            <thead>
                <tr>
                    <th style="padding-left:20px">Supplier</th>
                    <th>Products</th>
                    <th>Location</th>
                    <th>Rating</th>
                    <th>Status</th>
                    <th>Last Transaction</th>
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
                    <td>
                        <span class="stars">
                            @for ($i = 1; $i <= 5; $i++) {{ $i <= round($s['rating']) ? '★' : '☆' }} @endfor
                        </span>
                        <span class="text-[13px] font-medium text-gray-700 ml-1">{{ $s['rating'] }}</span>
                    </td>
                    <td><span class="badge-active"><span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span>Active</span></td>
                    <td class="text-[13px] text-gray-500">{{ $s['last_transaction'] }}</td>
                </tr>
                @empty
                <tr><td colspan="6"><div class="empty-state"><p class="text-sm font-semibold text-gray-400">No active suppliers</p></div></td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-3.5 border-t border-gray-100 text-[13px] font-semibold text-green-700">
            Showing {{ count($suppliers) }} active supplier(s)
        </div>
    </div>
@endsection
