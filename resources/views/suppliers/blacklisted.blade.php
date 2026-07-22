@extends('layouts.master')

@section('title', 'Blacklisted Suppliers')
@section('subtitle', 'Suppliers restricted from operations due to non-compliance or violations')

@section('content')

<div class="max-w-6xl mx-auto">

    {{-- KPI Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
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
    <div class="bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-800 rounded-xl overflow-hidden shadow-sm">
        {{-- Search / Filter Toolbar --}}
        <form method="GET" action="{{ route('suppliers.blacklisted') }}" id="blacklist-filter-form" class="flex flex-col sm:flex-row items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-slate-800 bg-gray-55/20 gap-4">
            <div class="search-box !w-full max-w-md">
                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/></svg>
                <input type="text" name="q" value="{{ request('q') }}" id="blacklist-search" placeholder="Search blacklisted suppliers…" class="!w-full">
            </div>

            {{-- Requirement 5: Removed Status filter, keep ONLY Risk Level filter --}}
            <div class="flex items-center gap-3 shrink-0 w-full sm:w-auto">
                <label for="risk-filter-select" class="text-xs font-bold text-slate-700 dark:text-slate-300">Risk Level:</label>
                <select name="risk" id="risk-filter-select" onchange="this.form.submit()" class="btn-outline text-sm font-semibold rounded-lg px-3 py-2 border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white cursor-pointer focus:ring-2 focus:ring-emerald-500">
                    <option value="All Risk Levels" {{ ($currentRisk ?? request('risk')) === 'All Risk Levels' ? 'selected' : '' }}>All Risk Levels</option>
                    <option value="Critical" {{ ($currentRisk ?? request('risk')) === 'Critical' ? 'selected' : '' }}>Critical</option>
                    <option value="High" {{ ($currentRisk ?? request('risk')) === 'High' ? 'selected' : '' }}>High</option>
                    <option value="Medium" {{ ($currentRisk ?? request('risk')) === 'Medium' ? 'selected' : '' }}>Medium</option>
                    <option value="Low" {{ ($currentRisk ?? request('risk')) === 'Low' ? 'selected' : '' }}>Low</option>
                </select>
            </div>
        </form>

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
                    <tr class="cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors" onclick="{{ !empty($b['slug']) ? "window.location='" . route('suppliers.show', $b['slug']) . "'" : '' }}">
                        <td style="padding-left:20px">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-red-100 dark:bg-red-950 text-red-700 dark:text-red-300 flex items-center justify-center font-bold text-xs shrink-0">
                                    {{ strtoupper(substr($b['supplier'], 0, 1)) }}
                                </div>
                                <div>
                                    <div class="supplier-name font-bold text-slate-900 dark:text-white">{{ $b['supplier'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="supplier-id text-sm font-semibold text-slate-700 dark:text-slate-300">{{ $b['supplier_id'] }}</span></td>
                        <td class="text-slate-700 dark:text-slate-300 text-[13px] font-medium">{{ $b['reason'] }}</td>
                        <td class="text-slate-500 dark:text-slate-400 text-[13px]">{{ $b['since'] }}</td>
                        <td style="padding-right:20px">
                            <span class="{{ $riskClass }} font-bold px-2.5 py-1 rounded-full text-xs">{{ $b['risk'] }}</span>
                        </td>
                    </tr>
                @empty
                    {{-- Requirement 5: Display exact empty state message when no record exists --}}
                    <tr>
                        <td colspan="5">
                            <div class="empty-state text-center py-12 px-4">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                                </svg>
                                <p class="text-base font-bold text-slate-700 dark:text-slate-200">No blacklisted suppliers found for this risk level.</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Try selecting a different risk level filter or clearing your search term.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-5 py-3.5 border-t border-gray-100 dark:border-slate-800 text-[13px] font-bold text-red-700 dark:text-red-400 flex items-center justify-between">
            <span>Showing {{ count($blacklisted) }} blacklisted supplier(s)</span>
            @if (($currentRisk ?? request('risk')) && ($currentRisk ?? request('risk')) !== 'All Risk Levels')
                <span class="text-xs text-slate-500 dark:text-slate-400">Filter: <strong>{{ $currentRisk ?? request('risk') }} Risk Level</strong></span>
            @endif
        </div>
    </div>
</div>

@endsection
