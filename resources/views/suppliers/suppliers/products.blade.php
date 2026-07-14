@extends('layouts.supplier')

@section('title', $supplier['name'] . ' - Products')

@section('extra-breadcrumb')
    <span>→</span> <span class="text-gray-700">Products</span>
@endsection

@section('content')
    <h1 class="text-2xl font-bold mb-6">Product Details</h1>

    <div class="space-y-6">
        @foreach ($supplier['products'] as $p)
            <div class="border rounded-xl p-5 flex gap-6">
                <div class="w-40 h-40 border rounded-xl flex items-center justify-center text-gray-300 font-bold shrink-0">IMG</div>
                <div class="flex-1">
                    <h2 class="font-semibold text-lg mb-3">{{ $p['name'] }}</h2>
                    <table class="w-full text-sm">
                        <tbody>
                            <tr class="border-b"><td class="py-1.5 text-gray-500 w-1/3">Product Code</td><td class="py-1.5">{{ $p['code'] }}</td></tr>
                            <tr class="border-b"><td class="py-1.5 text-gray-500">Category</td><td class="py-1.5">{{ $p['category'] }}</td></tr>
                            <tr class="border-b"><td class="py-1.5 text-gray-500">Unit</td><td class="py-1.5">{{ $p['unit'] }}</td></tr>
                            <tr class="border-b"><td class="py-1.5 text-gray-500">Unit Price</td><td class="py-1.5">{{ $p['price'] }}</td></tr>
                            <tr class="border-b"><td class="py-1.5 text-gray-500">Stock Status</td><td class="py-1.5">{{ $p['stock'] }}</td></tr>
                            <tr class="border-b"><td class="py-1.5 text-gray-500">Minimum Order Quantity</td><td class="py-1.5">{{ $p['moq'] }}</td></tr>
                            <tr><td class="py-1.5 text-gray-500">Lead time</td><td class="py-1.5">{{ $p['lead_time'] }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    </div>
@endsection
