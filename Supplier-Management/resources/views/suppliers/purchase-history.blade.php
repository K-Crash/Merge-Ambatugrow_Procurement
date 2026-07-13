@extends('layouts.supplier')

@section('title', $supplier['name'] . ' - Purchase History')

@section('extra-breadcrumb')
    <span>→</span> <span>Products</span> <span>→</span> <span class="text-gray-700">Purchase History</span>
@endsection

@section('content')
    <h1 class="text-2xl font-bold mb-1">Purchase History</h1>
    <p class="text-gray-500 mb-8">Details of your transactions with {{ $supplier['name'] }}.</p>

    @if (empty($supplier['purchase_history']))
        <div class="text-center text-gray-400 py-24 border rounded-xl border-dashed">
            No purchase history recorded yet.
        </div>
    @else
        <div class="border rounded-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-left text-gray-500">
                    <tr>
                        <th class="py-2 px-4">Date</th>
                        <th class="py-2 px-4">PO No.</th>
                        <th class="py-2 px-4">Product</th>
                        <th class="py-2 px-4">Quantity</th>
                        <th class="py-2 px-4">Amount</th>
                        <th class="py-2 px-4">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($supplier['purchase_history'] as $entry)
                        <tr class="border-t">
                            <td class="py-3 px-4">{{ $entry['date'] }}</td>
                            <td class="py-3 px-4">{{ $entry['po_number'] }}</td>
                            <td class="py-3 px-4 font-medium">{{ $entry['product'] }}</td>
                            <td class="py-3 px-4">{{ $entry['quantity'] }}</td>
                            <td class="py-3 px-4">{{ $entry['amount'] }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 rounded-full text-xs {{ $entry['status'] === 'Delivered' ? 'bg-green-100 text-green-700' : ($entry['status'] === 'Pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700') }}">
                                    {{ $entry['status'] }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
