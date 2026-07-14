@extends('layouts.master')

@section('title', 'Suppliers List')
@section('subtitle', 'All registered agricultural suppliers')

@section('content')

    {{-- Page Header --}}
    <div class="flex items-center justify-between mb-6">
        <div></div>
        <div class="flex items-center gap-3">
            {{-- Search --}}
            <form method="GET" action="{{ route('suppliers.index') }}">
                <div class="search-box">
                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/></svg>
                    <input name="q" type="text" value="{{ request('q') }}" placeholder="Search supplier name...">
                    <button type="submit" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/></svg>
                    </button>
                </div>
            </form>

            {{-- Filter --}}
            <button class="btn-outline">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Filter
            </button>

            {{-- Add Supplier --}}
            <a href="{{ route('suppliers.create') }}" class="btn-primary">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                Add Supplier
            </a>
        </div>
    </div>

    @if (session('status'))
    <div class="mb-4 flex items-center gap-3 bg-green-50 text-green-800 border border-green-200 px-4 py-3 rounded-lg text-sm font-medium">
        <svg class="w-4 h-4 text-green-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('status') }}
    </div>
    @endif

    {{-- Table Card --}}
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
                        <div class="flex items-center gap-2">
                            <span class="stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    {{ $i <= round($s['rating']) ? '★' : '☆' }}
                                @endfor
                            </span>
                            <span class="text-[13px] font-medium text-gray-700">{{ $s['rating'] }}</span>
                        </div>
                    </td>
                    <td>
                        @if ($s['status'] === 'Active')
                            <span class="badge-active"><span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span>Active</span>
                        @elseif ($s['status'] === 'Blacklisted')
                            <span class="badge-blacklisted"><span class="w-1.5 h-1.5 rounded-full bg-red-500 inline-block"></span>Blacklisted</span>
                        @else
                            <span class="badge-pending"><span class="w-1.5 h-1.5 rounded-full bg-amber-500 inline-block"></span>Pending</span>
                        @endif
                    </td>
                    <td class="text-[13px] text-gray-500">{{ $s['last_transaction'] }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <svg class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            <p class="text-sm font-semibold text-gray-400">No suppliers found</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="flex items-center justify-between px-5 py-4 border-t border-gray-100">
            <span class="text-[13px] font-semibold text-green-700">
                Showing 1 to {{ count($suppliers) }} of 125 results
            </span>
            <div class="flex items-center gap-1.5">
                <span class="page-btn-active">1</span>
                <span class="page-btn">2</span>
                <span class="page-btn">3</span>
                <span class="page-btn">4</span>
                <span class="page-btn">5</span>
                <span class="page-btn">›</span>
            </div>
        </div>
    </div>
@endsection
