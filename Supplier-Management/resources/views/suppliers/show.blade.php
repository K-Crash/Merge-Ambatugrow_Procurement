@extends('layouts.supplier')

@section('title', $supplier['name'])

@section('content')
    <div class="flex items-start gap-4 mb-6">
        <div class="w-16 h-16 rounded-full bg-gray-200"></div>
        <div>
            <h1 class="text-2xl font-bold">{{ $supplier['name'] }}</h1>
            <div class="text-sm text-gray-500">Supplier ID: {{ $supplier['supplier_id'] }} | Supplier since {{ $supplier['since'] }}</div>
            <p class="text-sm text-gray-600 mt-1">{{ $supplier['description'] }}</p>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6 mb-6">
        <div class="border rounded-xl p-5">
            <h2 class="font-semibold mb-3">Company Information</h2>
            <dl class="text-sm space-y-3">
                <div class="flex justify-between"><dt class="text-gray-500">Company Name</dt><dd>{{ $supplier['name'] }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Business Type</dt><dd>{{ $supplier['business_type'] }}</dd></div>
                <div class="flex justify-between gap-6"><dt class="text-gray-500">Address</dt><dd class="text-right">{{ $supplier['address'] }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Phone</dt><dd>{{ $supplier['phone'] }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Email</dt><dd>{{ $supplier['email'] }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Date Added</dt><dd>{{ $supplier['since'] }}</dd></div>
            </dl>
        </div>

        <div class="border rounded-xl p-5">
            <h2 class="font-semibold mb-3">Primary Contact</h2>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-full bg-green-700 text-white flex items-center justify-center text-sm font-medium">
                    {{ collect(explode(' ', $supplier['contact_name']))->map(fn($w) => $w[0])->join('') }}
                </div>
                <div>
                    <div class="font-medium">{{ $supplier['contact_name'] }}</div>
                    <div class="text-xs text-gray-500">{{ $supplier['contact_role'] }}</div>
                </div>
            </div>
            <div class="text-sm space-y-2">
                <div>📞 {{ $supplier['phone'] }}</div>
                <div>✉️ {{ $supplier['email'] }}</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6">
        <div class="border rounded-xl p-5">
            <h2 class="font-semibold mb-3">Product Supplied</h2>
            <a href="{{ route('suppliers.products', $supplier['slug']) }}" class="flex gap-6">
                @foreach ($supplier['products'] as $p)
                    <div class="text-center">
                        <div class="w-16 h-16 rounded-full border mx-auto mb-1"></div>
                        <div class="text-sm">{{ $p['name'] }}</div>
                    </div>
                @endforeach
            </a>
        </div>

        <div class="border rounded-xl p-5">
            <h2 class="font-semibold mb-3">Quick Stats</h2>
            <dl class="text-sm space-y-3">
                <div class="flex justify-between"><dt class="text-gray-500">Total Orders</dt><dd>{{ $supplier['total_orders'] }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Total Spent</dt><dd>{{ $supplier['total_spent'] }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Avarage Order Value</dt><dd>{{ $supplier['avg_order_value'] }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">On-time Delivery Rate</dt><dd>{{ $supplier['on_time_rate'] }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">Last Transaction</dt><dd>{{ $supplier['last_transaction'] }}</dd></div>
            </dl>
        </div>
    </div>
@endsection
