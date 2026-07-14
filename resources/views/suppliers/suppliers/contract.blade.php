@extends('layouts.supplier')

@section('title', $supplier['name'] . ' - Contract')

@section('extra-breadcrumb')
    <span>→</span> <span>Products</span> <span>→</span> <span>Purchase History</span> <span>→</span> <span class="text-gray-700">Contract</span>
@endsection

@section('content')
    <h1 class="text-2xl font-bold mb-1">Contract Information</h1>
    <p class="text-gray-500 mb-6">Details of the current contract with {{ $supplier['name'] }}.</p>

    <div class="grid grid-cols-2 gap-6 mb-6">
        <div class="border rounded-xl p-5">
            <h2 class="font-semibold mb-3">Contract Details</h2>
            <dl class="text-sm space-y-3">
                <div class="flex justify-between"><dt class="text-gray-500">Contract Start</dt><dd>{{ $supplier['contract']['start'] }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Contract End</dt><dd>{{ $supplier['contract']['end'] }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Contract Duration</dt><dd>{{ $supplier['contract']['duration'] }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Days Remaining</dt><dd>{{ $supplier['contract']['days_remaining'] }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Payment Terms</dt><dd>{{ $supplier['contract']['payment_terms'] }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Auto-renewal</dt><dd>{{ $supplier['contract']['auto_renewal'] }}</dd></div>
            </dl>
        </div>

        <div class="border rounded-xl p-5">
            <h2 class="font-semibold mb-3">Contract Document</h2>
            <div class="flex items-center gap-3 border rounded-lg p-3 mb-6">
                <span class="text-red-500 text-xl">📄</span>
                <div>
                    <div class="text-sm font-medium">{{ $supplier['contract']['document'] }}</div>
                    <div class="text-xs text-gray-400">PDF • {{ $supplier['contract']['document_size'] }}</div>
                </div>
            </div>

            <h2 class="font-semibold mb-2">Scope of Supply</h2>
            <ul class="text-sm text-gray-600 list-disc pl-5 space-y-1">
                @foreach ($supplier['contract']['scope'] as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <div class="border rounded-xl p-5">
        <h2 class="font-semibold mb-3">Contract History</h2>
        <table class="w-full text-sm">
            <thead class="text-gray-400 text-left border-b">
                <tr>
                    <th class="py-2">Date</th>
                    <th class="py-2">Action</th>
                    <th class="py-2">Performed By</th>
                    <th class="py-2">Remarks</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($supplier['contract']['history'] as $h)
                    <tr class="border-b">
                        <td class="py-2">{{ $h['date'] }}</td>
                        <td class="py-2">{{ $h['action'] }}</td>
                        <td class="py-2">{{ $h['by'] }}</td>
                        <td class="py-2 text-gray-500">{{ $h['remarks'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
