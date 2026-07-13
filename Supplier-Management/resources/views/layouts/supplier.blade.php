<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Suppliers')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white text-gray-800">
    <div class="max-w-5xl mx-auto p-8">
        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-sm text-gray-400 mb-4">
            <a href="{{ route('suppliers.dashboard') }}" class="text-gray-500">←</a>
            <a href="{{ route('suppliers.dashboard') }}" class="hover:text-green-700">Supplier Management</a>
            @isset($supplier)
                <span>→</span>
                <a href="{{ route('suppliers.show', $supplier['slug']) }}" class="hover:text-green-700">{{ $supplier['name'] }}</a>
            @endisset
            @yield('extra-breadcrumb')
        </div>

        <div class="flex gap-8">
            @isset($supplier)
                {{-- Tab sidebar --}}
                <div class="w-44 shrink-0">
                    <div class="border rounded-xl p-2 space-y-1 text-sm">
                        @php
                            $tabs = [
                                'suppliers.show' => 'Overview',
                                'suppliers.products' => 'Products',
                                'suppliers.purchase-history' => 'Purchase History',
                                'suppliers.contract' => 'Contract',
                                'suppliers.performance' => 'Performance',
                            ];
                        @endphp
                        @foreach ($tabs as $routeName => $label)
                            <a href="{{ route($routeName, $supplier['slug']) }}"
                               class="block px-3 py-2 rounded-lg {{ request()->routeIs($routeName) ? 'bg-green-100 text-green-800 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endisset

            <div class="flex-1">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
