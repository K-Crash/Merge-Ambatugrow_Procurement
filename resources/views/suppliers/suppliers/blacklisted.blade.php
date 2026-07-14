@extends('layouts.erp')

@section('breadcrumb', 'Suplier Management')

@section('content')
    <h1 class="text-2xl font-bold flex items-center gap-2 mb-1">🛡 Blacklisted Suppliers</h1>
    <p class="text-gray-500 mb-6">List of suppliers that are restricted or blacklisted due to non-compliance or violations</p>

    <div class="grid grid-cols-4 gap-4 mb-6">
        <a href="{{ route('suppliers.index') }}" class="bg-white rounded-xl border p-4 hover:shadow transition">
            <div class="text-sm text-gray-500">Total Supplier</div>
            <div class="text-2xl font-bold">{{ $stats['total'] }}</div>
            <div class="text-xs text-green-600">↑ 8 this month</div>
        </a>
        <a href="{{ route('suppliers.active') }}" class="bg-white rounded-xl border p-4 hover:shadow transition">
            <div class="text-sm text-gray-500">Active Suppliers</div>
            <div class="text-2xl font-bold">{{ $stats['active'] }}</div>
            <div class="text-xs text-green-600">{{ round(($stats['active'] / max($stats['total'], 1)) * 100) }}% of total</div>
        </a>
        <a href="{{ route('suppliers.pending') }}" class="bg-white rounded-xl border p-4 hover:shadow transition">
            <div class="text-sm text-gray-500">Pending Verification</div>
            <div class="text-2xl font-bold">{{ $stats['pending'] }}</div>
            <div class="text-xs text-yellow-600">Requires to review</div>
        </a>
        <div class="bg-white rounded-xl border-2 border-red-200 p-4">
            <div class="text-sm text-gray-500">Blacklisted Suppliers</div>
            <div class="text-2xl font-bold">{{ $stats['blacklisted'] }}</div>
            <div class="text-xs text-red-600">{{ round(($stats['blacklisted'] / max($stats['total'], 1)) * 100) }}% of total</div>
        </div>
    </div>

    <div class="bg-white rounded-xl border p-5">
        <div class="flex items-center gap-3 mb-4">
            <input type="text" placeholder="Search Supplier..." class="border rounded-lg px-3 py-1.5 text-sm flex-1">
            <select class="border rounded-lg px-3 py-1.5 text-sm"><option>Status</option></select>
            <select class="border rounded-lg px-3 py-1.5 text-sm"><option>Risk Level</option></select>
        </div>

        <table class="w-full text-sm">
            <thead class="text-gray-400 text-left border-b">
                <tr>
                    <th class="py-2">Supplier</th>
                    <th class="py-2">Supplier ID</th>
                    <th class="py-2">Reason</th>
                    <th class="py-2">Blacklisted Since</th>
                    <th class="py-2">Risk Level</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($blacklisted as $b)
                    @php
                        $riskColors = [
                            'High' => 'bg-red-100 text-red-600',
                            'Low' => 'bg-green-100 text-green-600',
                            'Critical' => 'bg-red-200 text-red-700',
                            'Medium' => 'bg-yellow-100 text-yellow-700',
                        ];
                    @endphp
                    <tr class="border-b">
                        <td class="py-3 font-medium">
                            @if ($b['slug'])
                                <a href="{{ route('suppliers.show', $b['slug']) }}" class="hover:text-green-700">{{ $b['supplier'] }}</a>
                            @else
                                {{ $b['supplier'] }}
                            @endif
                        </td>
                        <td class="py-3 text-gray-500">{{ $b['supplier_id'] }}</td>
                        <td class="py-3">{{ $b['reason'] }}</td>
                        <td class="py-3">{{ $b['since'] }}</td>
                        <td class="py-3"><span class="px-2 py-1 rounded-full text-xs {{ $riskColors[$b['risk']] }}">{{ $b['risk'] }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-sm text-gray-500 mt-3">Showing 1 to {{ count($blacklisted) }} of 5 results</div>
    </div>
@endsection
