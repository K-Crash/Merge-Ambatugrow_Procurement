@extends('layouts.supplier')

@section('title', $supplier['name'] . ' - Performance')

@section('extra-breadcrumb')
    <span>→</span> <span>Products</span> <span>→</span> <span>Purchase History</span> <span>→</span> <span>Contract</span> <span>→</span> <span class="text-gray-700">Performance</span>
@endsection

@section('content')
    <h1 class="text-2xl font-bold mb-1">{{ $supplier['name'] }} Performance</h1>
    <p class="text-gray-500 mb-6">Perforance insights based on total orders, on-time delivery, avarage rating and product quality</p>

    <div class="grid grid-cols-2 gap-6">
        <div class="bg-gray-50 rounded-xl p-5">
            <div class="text-sm text-gray-500 mb-1">Avarage Rating</div>
            <div class="text-2xl font-bold">{{ $supplier['performance']['avg_rating'] }} / 5</div>
            <div class="text-xs text-green-600 mt-1">{{ $supplier['performance']['avg_rating_delta'] }}</div>
        </div>
        <div class="bg-gray-50 rounded-xl p-5">
            <div class="text-sm text-gray-500 mb-1">On-time Delivery</div>
            <div class="text-2xl font-bold">{{ $supplier['performance']['on_time'] }}</div>
            <div class="text-xs text-green-600 mt-1">{{ $supplier['performance']['on_time_delta'] }}</div>
        </div>
        <div class="bg-gray-50 rounded-xl p-5">
            <div class="text-sm text-gray-500 mb-1">Quality Score</div>
            <div class="text-2xl font-bold">{{ $supplier['performance']['quality_score'] }} / 5</div>
            <div class="text-xs text-green-600 mt-1">{{ $supplier['performance']['quality_delta'] }}</div>
        </div>
        <div class="bg-gray-50 rounded-xl p-5">
            <div class="text-sm text-gray-500 mb-1">Total Orders</div>
            <div class="text-2xl font-bold">{{ $supplier['performance']['total_orders'] }}</div>
            <div class="text-xs text-green-600 mt-1">{{ $supplier['performance']['total_orders_delta'] }}</div>
        </div>
    </div>
@endsection
