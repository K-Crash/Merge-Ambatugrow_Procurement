@extends('layouts.supplier')

@section('title', 'Suppliers')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-bold">Suppliers</h1>
        <div class="flex items-center gap-3">
            <input type="text" placeholder="Search supplier name..." class="border rounded-lg px-3 py-1.5 text-sm">
            <button class="border rounded-lg px-3 py-1.5 text-sm">▽ Filter</button>
            <a href="{{ route('suppliers.create') }}" class="bg-green-700 text-white text-sm px-3 py-1.5 rounded-lg">+ Add Supplier</a>
        </div>
    </div>

    @if (session('status'))
        <div class="mb-4 bg-green-50 text-green-700 text-sm px-4 py-2 rounded-lg">{{ session('status') }}</div>
    @endif

    <div class="border rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="text-gray-400 text-left bg-gray-50">
                <tr>
                    <th class="py-2 px-4">Supplier</th>
                    <th class="py-2 px-4">Products</th>
                    <th class="py-2 px-4">Location</th>
                    <th class="py-2 px-4">Rating</th>
                    <th class="py-2 px-4">Status</th>
                    <th class="py-2 px-4">Last Transaction</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suppliers as $s)
                    <tr class="border-t">
                        <td class="py-3 px-4">
                            <a href="{{ route('suppliers.show', $s['slug']) }}" class="hover:text-green-700">
                                <div class="font-medium">{{ $s['name'] }}</div>
                                <div class="text-xs text-gray-400">{{ $s['supplier_id'] }}</div>
                            </a>
                        </td>
                        <td class="py-3 px-4 text-gray-600">{{ $s['products_list'] }}</td>
                        <td class="py-3 px-4 text-gray-600">📍 {{ $s['location'] }}</td>
                        <td class="py-3 px-4">★★★★★ {{ $s['rating'] }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 rounded-full text-xs {{ $s['status'] === 'Active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-600' }}">
                                ● {{ $s['status'] }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-gray-600">{{ $s['last_transaction'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="flex items-center justify-between mt-4 text-sm text-gray-500">
        <span>Showing 1 to {{ count($suppliers) }} of 125 results</span>
        <div class="flex gap-1">
            <span class="px-3 py-1 rounded-lg bg-green-700 text-white">1</span>
            <span class="px-3 py-1 rounded-lg border">2</span>
            <span class="px-3 py-1 rounded-lg border">3</span>
            <span class="px-3 py-1 rounded-lg border">4</span>
            <span class="px-3 py-1 rounded-lg border">5</span>
            <span class="px-3 py-1 rounded-lg border">›</span>
        </div>
    </div>
@endsection
