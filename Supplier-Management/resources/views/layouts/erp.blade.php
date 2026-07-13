<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Ambatugrow ERP')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="w-64 bg-green-800 text-white flex flex-col justify-between shrink-0">
            <div>
                <div class="p-5 flex items-center gap-3 border-b border-green-700">
                    <div class="w-9 h-9 rounded-full bg-white flex items-center justify-center text-green-800 text-lg">🌱</div>
                    <div>
                        <div class="font-bold leading-tight">AMBATUGROW</div>
                        <div class="text-[10px] text-green-300 tracking-wide">ERP SYSTEM</div>
                    </div>
                </div>

                <nav class="mt-4 text-sm">
                    <a href="{{ route('suppliers.dashboard') }}" class="block px-5 py-2 bg-green-700 font-medium">Supplier Management</a>

                    <div class="px-5 pt-4 pb-1 text-xs text-green-300 uppercase tracking-wide">Procurement</div>
                    <a href="#" class="block px-5 py-2 hover:bg-green-700">Purchase Order</a>
                    <a href="#" class="block px-5 py-2 hover:bg-green-700">Good Receipt &amp; Invoice</a>
                    <a href="{{ route('suppliers.dashboard') }}" class="block px-5 py-2 hover:bg-green-700 {{ request()->routeIs('suppliers.dashboard') || request()->routeIs('suppliers.blacklisted') ? 'bg-green-700' : '' }}">Supplier Management</a>
                    <a href="#" class="block px-5 py-2 hover:bg-green-700">Purchase &amp; Requisition</a>

                    <div class="px-5 pt-4 pb-1 text-xs text-green-300 uppercase tracking-wide">Inventory &amp; Warehouse</div>
                    <a href="#" class="block px-5 py-2 hover:bg-green-700">Inventory Tracking</a>
                    <a href="#" class="block px-5 py-2 hover:bg-green-700">Stock Transaction</a>
                    <a href="#" class="block px-5 py-2 hover:bg-green-700">Warehouse Location</a>
                    <a href="#" class="block px-5 py-2 hover:bg-green-700">Inventory Reporting</a>

                    <div class="px-5 pt-4 pb-1 text-xs text-green-300 uppercase tracking-wide">Supply Chain Management</div>
                    <a href="#" class="block px-5 py-2 hover:bg-green-700">Procurement &amp; Supplier Coordination</a>
                    <a href="#" class="block px-5 py-2 hover:bg-green-700">Logistics and Transportation Management</a>
                    <a href="#" class="block px-5 py-2 hover:bg-green-700">Demand Forecasting and Planning</a>
                    <a href="#" class="block px-5 py-2 hover:bg-green-700">Inventory Distribution and Warehouse Coordination</a>
                </nav>
            </div>

            <div class="px-5 py-4 border-t border-green-700 text-sm space-y-2">
                <a href="#" class="block hover:text-green-200">⚙ Settings</a>
                <a href="#" class="block hover:text-green-200">? Support</a>
            </div>
        </aside>

        {{-- Main content --}}
        <div class="flex-1 flex flex-col">
            <header class="bg-white border-b px-6 py-3 flex items-center justify-between text-sm text-gray-500">
                <div class="flex items-center gap-2">
                    <span>Procurement</span> <span>→</span> <span class="text-gray-700 font-medium">@yield('breadcrumb', 'Supplier Management')</span>
                </div>
                <div class="flex items-center gap-4">
                    <input type="text" placeholder="Search supplier..." class="border rounded-lg px-3 py-1.5 text-sm w-56">
                    <span>🔔</span>
                    <span>▦</span>
                </div>
            </header>

            <main class="p-6 flex-1">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
