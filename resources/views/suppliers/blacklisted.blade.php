@extends('layouts.erp')

@section('title', 'Blacklisted Suppliers')

@section('content')

<div class="max-w-5xl mx-auto">

    {{-- Page Header --}}
    <div class="mb-6">
        <h1 style="font-size:26px; font-weight:700; color:#111827; letter-spacing:-0.02em;">Blacklisted Suppliers</h1>
        <p class="page-subtitle">Suppliers restricted from operations due to non-compliance or violations</p>
    </div>

    {{-- KPI Cards --}}
    <div class="grid grid-cols-4 gap-4 mb-6">
        {{-- Total Suppliers --}}
        <a href="{{ route('suppliers.index') }}" class="kpi-card hover:shadow-md transition-shadow">
            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xs font-medium text-gray-500 mb-0.5">Total Supplier</div>
                <div class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</div>
                <div class="text-xs text-green-600 font-medium mt-1 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                    8 this month
                </div>
            </div>
        </a>

        {{-- Active Suppliers --}}
        <a href="{{ route('suppliers.active') }}" class="kpi-card hover:shadow-md transition-shadow">
            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xs font-medium text-gray-500 mb-0.5">Active Suppliers</div>
                <div class="text-2xl font-bold text-gray-900">{{ $stats['active'] }}</div>
                <div class="text-xs text-gray-500 font-medium mt-1">{{ round(($stats['active'] / max($stats['total'], 1)) * 100) }}% of total</div>
            </div>
        </a>

        {{-- Pending --}}
        <a href="{{ route('suppliers.pending') }}" class="kpi-card hover:shadow-md transition-shadow">
            <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xs font-medium text-gray-500 mb-0.5">Pending Verification</div>
                <div class="text-2xl font-bold text-gray-900">{{ $stats['pending'] }}</div>
                <div class="text-xs text-orange-500 font-medium mt-1">Requires review</div>
            </div>
        </a>

        {{-- Blacklisted --}}
        <a href="{{ route('suppliers.blacklisted') }}" class="kpi-card hover:shadow-md transition-shadow !border-red-200">
            <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <div class="text-xs font-medium text-gray-500 mb-0.5">Blacklisted Suppliers</div>
                <div class="text-2xl font-bold text-gray-900">{{ $stats['blacklisted'] }}</div>
                <div class="text-xs text-red-500 font-medium mt-1">{{ round(($stats['blacklisted'] / max($stats['total'], 1)) * 100) }}% of total</div>
            </div>
        </a>
    </div>

    {{-- Danger alert --}}
    @if (count($blacklisted) > 0)
    <div class="mb-4 flex items-center gap-3 bg-red-50 text-red-800 border border-red-200 px-4 py-3 rounded-lg text-sm font-medium">
        <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
        {{ count($blacklisted) }} supplier(s) are currently blacklisted and blocked from procurement activities.
    </div>
    @endif

    {{-- Table Card --}}
    <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">
        {{-- Search / Filter Toolbar --}}
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 bg-gray-55/20 gap-4">
            <div class="search-box !w-full max-w-md">
                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/></svg>
                <input type="text" id="blacklist-search" placeholder="Search blacklisted suppliers…" class="!w-full">
            </div>
            <div class="flex items-center gap-3 shrink-0">
                <select class="btn-outline text-sm">
                    <option>All Status</option>
                    <option>Active</option>
                    <option>Blacklisted</option>
                </select>
                <select class="btn-outline text-sm">
                    <option>All Risk Levels</option>
                    <option>Critical</option>
                    <option>High</option>
                    <option>Medium</option>
                    <option>Low</option>
                </select>
            </div>
        </div>

        <table class="fig-table" id="blacklist-table">
            <thead>
                <tr>
                    <th style="padding-left:20px">Supplier</th>
                    <th>Supplier ID</th>
                    <th>Reason</th>
                    <th>Blacklisted Since</th>
                    <th style="padding-right:20px">Risk Level</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($blacklisted as $b)
                    @php
                        $riskClass = match($b['risk']) {
                            'Critical' => 'badge-risk-critical',
                            'High'     => 'badge-risk-high',
                            'Medium'   => 'badge-risk-medium',
                            default    => 'badge-risk-low',
                        };
                    @endphp
                    <tr class="cursor-pointer" onclick="{{ $b['slug'] ? "window.location='" . route('suppliers.show', $b['slug']) . "'" : '' }}">
                        <td style="padding-left:20px">
                            <div class="flex items-center gap-3">
                                <div class="avatar"></div>
                                <div>
                                    <div class="supplier-name">{{ $b['supplier'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="supplier-id text-sm">{{ $b['supplier_id'] }}</span></td>
                        <td class="text-gray-600 text-[13px]">{{ $b['reason'] }}</td>
                        <td class="text-gray-500 text-[13px]">{{ $b['since'] }}</td>
                        <td style="padding-right:20px">
                            <span class="{{ $riskClass }}">{{ $b['risk'] }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <svg class="w-12 h-12 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="text-base font-semibold text-gray-450">No blacklisted suppliers</p>
                                <p class="text-sm text-gray-400">All suppliers are compliant.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-3.5 border-t border-gray-100 text-[13px] font-semibold text-red-700">
            Showing {{ count($blacklisted) }} blacklisted supplier(s)
        </div>
    </div>

    {{-- Inline search filter script --}}
    <script>
        document.getElementById('blacklist-search')?.addEventListener('input', function() {
            const q = this.value.toLowerCase();
            document.querySelectorAll('#blacklist-table tbody tr').forEach(function(row) {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        });
    </script>
</div>
@endsection
