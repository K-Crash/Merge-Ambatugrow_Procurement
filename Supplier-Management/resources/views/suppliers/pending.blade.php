@extends('layouts.erp')

@section('breadcrumb', 'Pending Verification')

@section('content')
    <h1 class="text-2xl font-bold flex items-center gap-2 mb-1">🕒 Pending Verification</h1>
    <p class="text-gray-500 mb-6">Suppliers awaiting review before they can be fully approved</p>

    <div class="bg-white rounded-xl border p-5">
        <table class="w-full text-sm">
            <thead class="text-gray-400 text-left border-b">
                <tr>
                    <th class="py-2">Supplier</th>
                    <th class="py-2">Supplier ID</th>
                    <th class="py-2">Products</th>
                    <th class="py-2">Location</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suppliers as $supplier)
                    <tr class="border-b">
                        <td class="py-3 font-medium">
                            <a href="{{ route('suppliers.show', $supplier['slug']) }}" class="hover:text-green-700">{{ $supplier['name'] }}</a>
                        </td>
                        <td class="py-3 text-gray-500">{{ $supplier['supplier_id'] }}</td>
                        <td class="py-3">{{ $supplier['products_list'] }}</td>
                        <td class="py-3">📍 {{ $supplier['location'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
