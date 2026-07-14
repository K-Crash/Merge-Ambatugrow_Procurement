<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AmbatuGrow ERP')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }
        /* Disable CSS transitions during initial page render to prevent reload animation flicker */
        .no-transition,
        .no-transition * {
            transition: none !important;
        }

        /* Real Working Dark Mode styling sheet */
        .dark body {
            background-color: #0f172a !important; /* bg-slate-900 */
            color: #f1f5f9 !important; /* text-slate-100 */
        }
        .dark .bg-slate-100, .dark .bg-[#f8faf9] {
            background-color: #0f172a !important;
        }
        .dark .bg-white {
            background-color: #1e293b !important; /* bg-slate-800 */
            color: #f1f5f9 !important;
        }
        .dark .card, .dark .kpi-card, .dark .bg-[#e8ece6], .dark .bg-[#f4f7f3], .dark .bg-[#e8eee9], .dark .bg-[#edf3ef] {
            background-color: #1e293b !important;
            border-color: #334155 !important;
        }
        .dark .border-slate-200, .dark .border-slate-200\/60, .dark .border-slate-200\/50, .dark .border-slate-350, .dark .border-slate-300, .dark .border-[#d4ded6], .dark .border-[#e4e9e6] {
            border-color: #334155 !important;
        }
        .dark .text-slate-700, .dark .text-slate-805, .dark .text-slate-800, .dark .text-slate-900, .dark .text-slate-750, .dark .text-gray-800, .dark .text-gray-900, .dark .text-slate-800 {
            color: #cbd5e1 !important; /* text-slate-300 */
        }
        .dark .text-slate-500, .dark .text-slate-650, .dark .text-slate-600, .dark .text-gray-500, .dark .text-gray-600 {
            color: #94a3b8 !important; /* text-slate-400 */
        }
        .dark .text-slate-400, .dark .text-gray-400 {
            color: #64748b !important; /* text-slate-500 */
        }
        .dark .bg-slate-50 {
            background-color: #0f172a !important;
            border-color: #334155 !important;
        }
        .dark input, .dark select, .dark textarea {
            background-color: #0f172a !important;
            color: #f1f5f9 !important;
            border-color: #334155 !important;
        }
        .dark .unified-table th, .dark .fig-table th {
            background-color: #0f172a !important;
            color: #f1f5f9 !important;
        }
        .dark .unified-table td, .dark .fig-table td {
            color: #cbd5e1 !important;
        }
        .dark .unified-badge-neutral {
            background-color: #334155 !important;
            color: #cbd5e1 !important;
        }
        /* Top bar dark style */
        .dark header {
            background-color: #1e293b !important;
            border-color: #334155 !important;
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 antialiased" x-data="appLayout">
    <div class="min-h-screen flex">
        
        <!-- SIDEBAR CONTAINER GROUP (Handles Expand/Collapse hover actions via .sidebar-expanded class) -->
        <div id="main-sidebar-container" class="flex shrink-0 min-h-screen group/sidebar no-transition">
            <!-- Inline Script to prevent Flash of Unstyled Content (FOUC) by expanding instantly before rendering -->
            <script>
                if (sessionStorage.getItem('sidebarHovered') === 'true') {
                    document.getElementById('main-sidebar-container').classList.add('sidebar-expanded');
                }
            </script>
            
            <!-- TIER 1: Main System Navigation (Slim Sidebar) -->
            <aside class="w-[72px] bg-[#e8ece6] border-r border-slate-200/60 flex flex-col justify-between items-center py-6 shrink-0 font-sans h-full">
                <!-- Top Logo + Hub Icons -->
                <div class="flex flex-col items-center gap-4 w-full px-2">
                    <!-- Logo -->
                    <div class="w-12 h-12 rounded-full overflow-hidden border border-slate-200 bg-white p-1 shadow-sm flex items-center justify-center mb-2">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Ambatugrow" class="w-full h-full object-cover rounded-full">
                    </div>

                    <!-- Hub Icons -->
                    <!-- Purchase Requisitions -->
                    <a href="{{ route('approvals.index') }}" class="relative w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-200 {{ (request()->routeIs('approvals.*') || request()->routeIs('requisitions.*') || request()->is('purchase-and-requisition*')) ? 'bg-[#235c2b] text-white shadow-sm' : 'text-slate-700 hover:bg-slate-200/50' }}" title="Purchase Requisitions">
                        @if (request()->routeIs('approvals.*') || request()->routeIs('requisitions.*') || request()->is('purchase-and-requisition*'))
                            <div class="absolute left-0 top-1/4 bottom-1/4 w-1 bg-white rounded-r"></div>
                        @endif
                        <i data-lucide="clipboard-list" class="w-5 h-5"></i>
                    </a>
                    
                    <!-- Supplier Directory -->
                    <a href="{{ route('suppliers.dashboard') }}" class="relative w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-200 {{ (request()->routeIs('suppliers.*') || request()->is('supplier-management*')) ? 'bg-[#235c2b] text-white shadow-sm' : 'text-slate-700 hover:bg-slate-200/50' }}" title="Supplier Directory">
                        @if (request()->routeIs('suppliers.*') || request()->is('supplier-management*'))
                            <div class="absolute left-0 top-1/4 bottom-1/4 w-1 bg-white rounded-r"></div>
                        @endif
                        <i data-lucide="users" class="w-5 h-5"></i>
                    </a>

                    <!-- Order Management -->
                    <a href="{{ route('procurement.home') }}" class="relative w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-200 {{ (request()->routeIs('procurement.*') || request()->routeIs('purchase_orders.*') || request()->is('order-management*')) ? 'bg-[#235c2b] text-white shadow-sm' : 'text-slate-700 hover:bg-slate-200/50' }}" title="Order Management">
                        @if (request()->routeIs('procurement.*') || request()->routeIs('purchase_orders.*') || request()->is('order-management*'))
                            <div class="absolute left-0 top-1/4 bottom-1/4 w-1 bg-white rounded-r"></div>
                        @endif
                        <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                    </a>

                    <!-- Receipt & Invoice -->
                    <a href="{{ route('matching.index') }}" class="relative w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-200 {{ (request()->routeIs('matching.*') || request()->is('goods-receipt-invoice-matching*')) ? 'bg-[#235c2b] text-white shadow-sm' : 'text-slate-700 hover:bg-slate-200/50' }}" title="Goods Receipt & Invoice Matching">
                        @if (request()->routeIs('matching.*') || request()->is('goods-receipt-invoice-matching*'))
                            <div class="absolute left-0 top-1/4 bottom-1/4 w-1 bg-white rounded-r"></div>
                        @endif
                        <i data-lucide="file-check" class="w-5 h-5"></i>
                    </a>

                    <!-- Divider -->
                    <div class="w-8 h-[1px] bg-slate-300 my-1"></div>

                    <!-- Secondary Icons -->
                    <a href="{{ route('dashboard') }}" class="relative w-12 h-12 rounded-xl flex items-center justify-center text-slate-700 hover:bg-slate-200/50 cursor-pointer transition-all" title="Dashboard Home">
                        <i data-lucide="home" class="w-5 h-5"></i>
                    </a>

                    <div @click="activeRightPanel = 'notifications'" class="relative w-12 h-12 rounded-xl flex items-center justify-center text-slate-700 hover:bg-slate-200/50 cursor-pointer transition-all" title="Notifications">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                        <div class="absolute top-3.5 right-3.5 w-2 h-2 bg-red-500 rounded-full border border-white" x-show="notificationsList.some(n => !n.read)"></div>
                    </div>

                    <!-- Avatar bubbles -->
                    <div class="flex flex-col items-center gap-1.5 my-1">
                        <div @click="openChat('Emily Cooper')" class="w-7 h-7 rounded-full bg-blue-50 border border-blue-200 text-blue-700 flex items-center justify-center text-[9px] font-black shadow-sm cursor-pointer" title="Emily Cooper">EC</div>
                        <div @click="openChat('Alex Morgan')" class="w-7 h-7 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center justify-center text-[9px] font-black shadow-sm cursor-pointer" title="Alex Morgan">AM</div>
                        <div @click="openChat('Marcus Davis')" class="w-7 h-7 rounded-full bg-purple-50 border border-purple-200 text-purple-700 flex items-center justify-center text-[9px] font-black shadow-sm cursor-pointer" title="Marcus Davis">MD</div>
                    </div>
                </div>

                <!-- Bottom icons -->
                <div class="flex flex-col items-center gap-4 w-full px-2">
                    <!-- Divider -->
                    <div class="w-8 h-[1px] bg-slate-300 my-1"></div>

                    <div @click="activeRightPanel = 'settings'" class="w-12 h-12 rounded-xl flex items-center justify-center text-slate-700 hover:bg-slate-200/50 cursor-pointer transition-all" title="Settings">
                        <i data-lucide="settings" class="w-5 h-5"></i>
                    </div>

                    <div @click="toggleDarkMode()" class="w-12 h-12 rounded-xl flex items-center justify-center text-indigo-500 hover:bg-slate-200/50 cursor-pointer transition-all" title="Toggle Dark Mode">
                        <i data-lucide="moon" class="w-5 h-5"></i>
                    </div>

                    <div @click="activeRightPanel = 'help'" class="w-12 h-12 rounded-xl flex items-center justify-center text-slate-700 hover:bg-slate-200/50 cursor-pointer transition-all" title="Support">
                        <i data-lucide="help-circle" class="w-5 h-5"></i>
                    </div>

                    @if (Auth::check())
                        <div @click="activeRightPanel = 'profile'" class="w-8 h-8 rounded-full border border-[#235c2b] p-0.5 flex items-center justify-center bg-white shadow-sm mt-1 cursor-pointer" title="{{ Auth::user()->name }} ({{ str_replace('_', ' ', Auth::user()->role) }})">
                            <div class="w-full h-full rounded-full bg-emerald-50 text-[#235c2b] flex items-center justify-center text-[9px] font-black">
                                {{ Auth::user()->avatar_initial ?? strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                        </div>
                    @endif
                </div>
            </aside>

            <!-- TIER 2: Active Module Navigation (Submenu Column) -->
            <aside class="w-20 group-[.sidebar-expanded]/sidebar:w-60 bg-[#edf3ef] border-r border-[#d4ded6] flex flex-col justify-between shrink-0 shadow-[inset_-1px_0_0_0_rgba(0,0,0,0.02)] transition-all duration-300 ease-in-out delay-100 group-[.sidebar-expanded]/sidebar:delay-0 overflow-hidden">
                <div class="flex flex-col py-6 font-sans">
                    <!-- Module Header -->
                    <div class="px-5 mb-6 opacity-0 group-[.sidebar-expanded]/sidebar:opacity-100 h-0 group-[.sidebar-expanded]/sidebar:h-auto overflow-hidden transition-all duration-300 delay-100 group-[.sidebar-expanded]/sidebar:delay-0">
                        <span class="text-[10px] font-bold text-green-700 tracking-widest uppercase">Procurement</span>
                        <h2 class="font-extrabold text-slate-800 text-lg leading-tight uppercase">Supplier Management</h2>
                    </div>
                    
                    <!-- Menu Items -->
                    <nav class="flex flex-col gap-1 px-3 text-sm">
                        <a href="{{ route('suppliers.dashboard') }}" class="flex items-center gap-3 px-3 py-3 pl-[28px] group-[.sidebar-expanded]/sidebar:pl-5 rounded-full transition-all duration-300 delay-100 group-[.sidebar-expanded]/sidebar:delay-0 {{ request()->routeIs('suppliers.dashboard') ? 'bg-green-800 text-white font-semibold shadow-md' : 'text-slate-600 hover:bg-[#dedfde] hover:text-slate-900' }}">
                            <span class="text-base shrink-0">📊</span>
                            <span class="opacity-0 group-[.sidebar-expanded]/sidebar:opacity-100 transition-opacity duration-250 delay-100 group-[.sidebar-expanded]/sidebar:delay-0 whitespace-nowrap">Dashboard</span>
                        </a>
                        <a href="{{ route('suppliers.index') }}" class="flex items-center gap-3 px-3 py-3 pl-[28px] group-[.sidebar-expanded]/sidebar:pl-5 rounded-full transition-all duration-300 delay-100 group-[.sidebar-expanded]/sidebar:delay-0 {{ request()->routeIs('suppliers.index') ? 'bg-green-800 text-white font-semibold shadow-md' : 'text-slate-600 hover:bg-[#dedfde] hover:text-slate-900' }}">
                            <span class="text-base shrink-0">🤝</span>
                            <span class="opacity-0 group-[.sidebar-expanded]/sidebar:opacity-100 transition-opacity duration-250 delay-100 group-[.sidebar-expanded]/sidebar:delay-0 whitespace-nowrap">View All Suppliers</span>
                        </a>
                        <a href="{{ route('suppliers.active') }}" class="flex items-center gap-3 px-3 py-3 pl-[28px] group-[.sidebar-expanded]/sidebar:pl-5 rounded-full transition-all duration-300 delay-100 group-[.sidebar-expanded]/sidebar:delay-0 {{ request()->routeIs('suppliers.active') ? 'bg-green-800 text-white font-semibold shadow-md' : 'text-slate-600 hover:bg-[#dedfde] hover:text-slate-900' }}">
                            <span class="text-base shrink-0">✅</span>
                            <span class="opacity-0 group-[.sidebar-expanded]/sidebar:opacity-100 transition-opacity duration-250 delay-100 group-[.sidebar-expanded]/sidebar:delay-0 whitespace-nowrap">Active Suppliers</span>
                        </a>
                        <a href="{{ route('suppliers.pending') }}" class="flex items-center gap-3 px-3 py-3 pl-[28px] group-[.sidebar-expanded]/sidebar:pl-5 rounded-full transition-all duration-300 delay-100 group-[.sidebar-expanded]/sidebar:delay-0 {{ request()->routeIs('suppliers.pending') ? 'bg-green-800 text-white font-semibold shadow-md' : 'text-slate-600 hover:bg-[#dedfde] hover:text-slate-900' }}">
                            <span class="text-base shrink-0">⏳</span>
                            <span class="opacity-0 group-[.sidebar-expanded]/sidebar:opacity-100 transition-opacity duration-250 delay-100 group-[.sidebar-expanded]/sidebar:delay-0 whitespace-nowrap">Pending Verification</span>
                        </a>
                        <a href="{{ route('suppliers.blacklisted') }}" class="flex items-center gap-3 px-3 py-3 pl-[28px] group-[.sidebar-expanded]/sidebar:pl-5 rounded-full transition-all duration-300 delay-100 group-[.sidebar-expanded]/sidebar:delay-0 {{ request()->routeIs('suppliers.blacklisted') ? 'bg-green-800 text-white font-semibold shadow-md' : 'text-slate-600 hover:bg-[#dedfde] hover:text-slate-900' }}">
                            <span class="text-base shrink-0">🚫</span>
                            <span class="opacity-0 group-[.sidebar-expanded]/sidebar:opacity-100 transition-opacity duration-250 delay-100 group-[.sidebar-expanded]/sidebar:delay-0 whitespace-nowrap">Blacklisted Suppliers</span>
                        </a>
                        
                        <div class="h-[1px] bg-[#dce5df] my-3"></div>
                        
                        <a href="{{ route('suppliers.create') }}" class="flex items-center gap-3 px-3 py-3 pl-[28px] group-[.sidebar-expanded]/sidebar:pl-5 rounded-full transition-all duration-300 delay-100 group-[.sidebar-expanded]/sidebar:delay-0 {{ request()->routeIs('suppliers.create') ? 'bg-green-800 text-white font-semibold shadow-md' : 'text-slate-600 hover:bg-[#dedfde] hover:text-slate-900' }}">
                            <span class="text-base shrink-0">➕</span>
                            <span class="opacity-0 group-[.sidebar-expanded]/sidebar:opacity-100 transition-opacity duration-250 delay-100 group-[.sidebar-expanded]/sidebar:delay-0 whitespace-nowrap">Add New Supplier</span>
                        </a>
                    </nav>
                </div>
                
            </aside>



        </div>

        <!-- MAIN CONTENT AREA -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Header bar with Breadcrumbs & Search -->
            <header class="bg-white border-b border-[#e4e9e6] px-8 py-4 flex items-center justify-between shrink-0 relative" style="box-shadow: 0 1px 4px rgba(0,0,0,0.06);">
                <div class="flex items-center gap-2">
                    <span class="text-gray-400 font-sans">Procurement</span>
                    <span class="text-gray-400">→</span>
                    <a href="{{ route('suppliers.dashboard') }}" class="hover:text-green-800 transition-colors font-medium">Supplier Management</a>
                    @if (isset($supplier) && isset($supplier['slug']) && request()->routeIs('suppliers.show', 'suppliers.products', 'suppliers.purchase-history', 'suppliers.contract', 'suppliers.performance'))
                        <span class="text-gray-400">→</span>
                        <a href="{{ route('suppliers.show', $supplier['slug']) }}" class="text-gray-800 font-bold hover:text-green-800 transition-colors">{{ $supplier['supplier_name'] ?? $supplier['name'] }}</a>
                    @endif
                    @yield('extra-breadcrumb')
                </div>

                <!-- Center: Global Search Input (Triggers Command Bar) -->
                <div class="absolute left-1/2 -translate-x-1/2 flex items-center z-10">
                    <div class="relative flex items-center">
                        <input id="global-search-input" type="text" placeholder="Search supplier... (Ctrl+K)" class="border border-gray-200 rounded-full pl-9 pr-4 py-2 text-xs w-64 focus:outline-none focus:ring-1 focus:ring-green-600 focus:border-transparent transition-all shadow-sm cursor-pointer" readonly>
                        <span class="absolute left-3 text-xs text-gray-400">🔍</span>
                    </div>
                </div>
                
                <div class="flex items-center gap-4 relative">
                    <!-- Notification Bell (With Dropdown) -->
                    @php
                        $pendingCount = \App\Models\Supplier::where('status', 'Pending Verification')->count();
                        $blacklistedCount = \App\Models\Supplier::where('status', 'Blacklisted')->count() + \App\Models\BlacklistedSupplier::count();
                        $notificationsCount = $pendingCount + $blacklistedCount;
                    @endphp
                    <div class="relative">
                        <button id="bell-button" class="relative w-9 h-9 border border-gray-200 rounded-full flex items-center justify-center text-slate-500 hover:bg-gray-50 hover:text-green-800 transition-colors shadow-sm focus:outline-none">
                            <span>🔔</span>
                            @if ($notificationsCount > 0)
                                <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"></span>
                            @endif
                        </button>
                        
                        <!-- Notifications Dropdown -->
                        <div id="notifications-dropdown" class="absolute right-0 mt-2 w-80 bg-white border border-gray-200 rounded-2xl shadow-xl z-50 hidden flex flex-col divide-y divide-gray-50 overflow-hidden text-sm">
                            <div class="px-4 py-3 bg-[#edf3ef] text-green-950 font-bold flex justify-between items-center font-sans">
                                <span>Notifications</span>
                                @if ($notificationsCount > 0)
                                    <span class="text-[10px] bg-red-500 text-white px-2 py-0.5 rounded-full font-mono">{{ $notificationsCount }} New</span>
                                @endif
                            </div>
                            <div class="max-h-72 overflow-y-auto custom-scrollbar divide-y divide-gray-50 font-sans">
                                <!-- Pending notifications -->
                                @foreach (\App\Models\Supplier::where('status', 'Pending Verification')->get() as $n)
                                    <a href="{{ route('suppliers.pending') }}" class="block px-4 py-3 hover:bg-gray-50 transition-colors">
                                        <div class="flex justify-between items-start gap-1">
                                            <span class="font-bold text-slate-800 text-xs">⏳ Verification Pending</span>
                                            <span class="text-[9px] text-gray-400 font-mono">Alert</span>
                                        </div>
                                        <p class="text-xs text-gray-600 mt-1">Supplier <strong class="text-slate-700">{{ $n->supplier_name }}</strong> is awaiting manual verification.</p>
                                    </a>
                                @endforeach

                                <!-- Blacklisted notifications -->
                                @foreach (\App\Models\Supplier::where('status', 'Blacklisted')->get() as $n)
                                    <a href="{{ route('suppliers.blacklisted') }}" class="block px-4 py-3 hover:bg-gray-50 transition-colors">
                                        <div class="flex justify-between items-start gap-1">
                                            <span class="font-bold text-red-700 text-xs">🚫 Supplier Blacklisted</span>
                                            <span class="text-[9px] text-gray-400 font-mono">Flag</span>
                                        </div>
                                        <p class="text-xs text-gray-600 mt-1">Supplier <strong class="text-slate-700">{{ $n->supplier_name }}</strong> has been flagged as blacklisted.</p>
                                    </a>
                                @endforeach

                                <!-- Standalone Blacklisted notifications -->
                                @foreach (\App\Models\BlacklistedSupplier::all() as $n)
                                    <a href="{{ route('suppliers.blacklisted') }}" class="block px-4 py-3 hover:bg-gray-50 transition-colors">
                                        <div class="flex justify-between items-start gap-1">
                                            <span class="font-bold text-orange-700 text-xs">⚠️ Vendor Vetting Flag</span>
                                            <span class="text-[9px] text-gray-400 font-mono">Vetting</span>
                                        </div>
                                        <p class="text-xs text-gray-600 mt-1">External vendor <strong class="text-slate-700">{{ $n->name }}</strong> is listed: {{ $n->reason }}</p>
                                    </a>
                                @endforeach
                                
                                @if ($notificationsCount === 0)
                                    <div class="p-6 text-center text-gray-400 text-xs italic">No new notifications.</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Contents -->
            <main class="p-8 flex-1 overflow-y-auto custom-scrollbar bg-[#F9FAFB]">
                <div class="w-full">
                    @yield('content')
                </div>
            </main>
        </div>
        
    </div>

    <!-- TIER 4: Command Bar Modal (Ctrl + K) -->
    <div id="command-bar-modal" class="fixed inset-0 bg-slate-900/35 backdrop-blur-xs flex justify-center pt-24 z-50 hidden">
        <div id="command-bar-container" class="bg-white rounded-2xl w-full max-w-lg shadow-2xl border border-slate-200 overflow-hidden flex flex-col h-fit mx-4 font-sans">
            <div class="relative flex items-center border-b border-slate-100">
                <span class="absolute left-4 text-slate-400 text-lg">🔍</span>
                <input id="command-bar-input" type="text" placeholder="Search suppliers, products, locations... (Esc to close)" class="w-full pl-11 pr-5 py-4 text-base focus:outline-none text-slate-800">
            </div>
            <div id="command-bar-results" class="max-h-80 overflow-y-auto p-2 space-y-1 text-sm custom-scrollbar">
                <!-- Dynamic results -->
            </div>
            <div class="bg-slate-50 border-t border-slate-100 px-4 py-2 flex items-center justify-between text-[11px] text-slate-400 shrink-0 font-medium">
                <span>Use <kbd class="bg-white border border-slate-200 px-1 py-0.5 rounded shadow-xs font-mono">↑↓</kbd> to navigate, <kbd class="bg-white border border-slate-200 px-1 py-0.5 rounded shadow-xs font-mono">Enter</kbd> to view</span>
                <span>Esc to close</span>
            </div>
        </div>
    </div>

    <!-- Command Bar Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarContainer = document.getElementById('main-sidebar-container');
            let clickedSidebar = false;

            // 1. Mouse enter/leave/click events to control state & save in sessionStorage
            if (sidebarContainer) {
                sidebarContainer.addEventListener('mouseenter', function() {
                    sidebarContainer.classList.add('sidebar-expanded');
                    sessionStorage.setItem('sidebarHovered', 'true');
                });

                sidebarContainer.addEventListener('mouseleave', function() {
                    if (clickedSidebar) return;
                    sidebarContainer.classList.remove('sidebar-expanded');
                    sessionStorage.setItem('sidebarHovered', 'false');
                });

                sidebarContainer.addEventListener('click', function() {
                    clickedSidebar = true;
                    sessionStorage.setItem('sidebarHovered', 'true');
                });
            }

            // 2. Enable transitions and verify alignment on first mouse movement
            setTimeout(function() {
                if (sidebarContainer) {
                    sidebarContainer.classList.remove('no-transition');
                }
            }, 100);

            // On first mouse move, verify if cursor is actually inside the sidebar.
            // If not, collapse it. This handles page load hover misalignments without any reload flicker.
            document.addEventListener('mousemove', function(e) {
                if (sidebarContainer && !sidebarContainer.contains(e.target)) {
                    sidebarContainer.classList.remove('sidebar-expanded');
                    sessionStorage.setItem('sidebarHovered', 'false');
                }
            }, { once: true });

            // Notifications dropdown toggle
            const bellButton = document.getElementById('bell-button');
            const notificationsDropdown = document.getElementById('notifications-dropdown');

            if (bellButton && notificationsDropdown) {
                bellButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    notificationsDropdown.classList.toggle('hidden');
                });

                document.addEventListener('click', function(e) {
                    if (!notificationsDropdown.contains(e.target) && e.target !== bellButton) {
                        notificationsDropdown.classList.add('hidden');
                    }
                });
            }

            // Command Bar logic
            const modal = document.getElementById('command-bar-modal');
            const input = document.getElementById('command-bar-input');
            const resultsContainer = document.getElementById('command-bar-results');
            const globalSearchInput = document.getElementById('global-search-input');
            
            // All suppliers loaded as JSON
            const suppliers = {!! json_encode(\App\Models\Supplier::with('productsRelation')->get()->toArray()) !!};
            
            let selectedIndex = -1;
            let filteredSuppliers = [];

            function openModal() {
                modal.classList.remove('hidden');
                input.value = '';
                input.focus();
                renderResults(suppliers);
            }
            
            function closeModal() {
                modal.classList.add('hidden');
                selectedIndex = -1;
            }

            // Keyboard shortcut trigger: Ctrl+K or Cmd+K
            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
                    e.preventDefault();
                    if (modal.classList.contains('hidden')) {
                        openModal();
                    } else {
                        closeModal();
                    }
                }
                
                if (e.key === 'Escape') {
                    closeModal();
                }

                // Arrow keys navigation
                if (!modal.classList.contains('hidden') && filteredSuppliers.length > 0) {
                    if (e.key === 'ArrowDown') {
                        e.preventDefault();
                        selectedIndex = (selectedIndex + 1) % filteredSuppliers.length;
                        highlightResult();
                    } else if (e.key === 'ArrowUp') {
                        e.preventDefault();
                        selectedIndex = (selectedIndex - 1 + filteredSuppliers.length) % filteredSuppliers.length;
                        highlightResult();
                    } else if (e.key === 'Enter') {
                        e.preventDefault();
                        if (selectedIndex >= 0 && selectedIndex < filteredSuppliers.length) {
                            window.location.href = `/suppliers/${filteredSuppliers[selectedIndex].slug}`;
                        }
                    }
                }
            });

            // Click outside closes modal
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal();
                }
            });

            // Focus on header search opens modal
            if (globalSearchInput) {
                globalSearchInput.addEventListener('click', function(e) {
                    openModal();
                });
            }

            // Input filter
            input.addEventListener('input', function() {
                const query = input.value.toLowerCase().trim();
                if (query === '') {
                    renderResults(suppliers);
                    return;
                }

                const filtered = suppliers.filter(s => {
                    const name = (s.supplier_name || '').toLowerCase();
                    const id = (s.supplier_id || '').toLowerCase();
                    const location = (s.location || '').toLowerCase();
                    const products = (s.products_list || '').toLowerCase();
                    return name.includes(query) || id.includes(query) || location.includes(query) || products.includes(query);
                });

                renderResults(filtered);
            });

            function renderResults(list) {
                filteredSuppliers = list;
                selectedIndex = list.length > 0 ? 0 : -1;
                resultsContainer.innerHTML = '';

                if (list.length === 0) {
                    resultsContainer.innerHTML = `<div class="p-4 text-center text-slate-400 italic">No matching suppliers found.</div>`;
                    return;
                }

                list.forEach((s, index) => {
                    const item = document.createElement('a');
                    item.href = `/suppliers/${s.slug}`;
                    item.className = `flex flex-col p-3 rounded-xl transition-colors duration-100 border border-transparent ${index === selectedIndex ? 'bg-slate-50 border-slate-200' : ''}`;
                    item.innerHTML = `
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-slate-800 text-xs">${s.supplier_name}</span>
                            <span class="text-[10px] text-gray-500 font-mono">${s.supplier_id}</span>
                        </div>
                        <div class="flex justify-between items-center mt-1 text-[11px] text-slate-550">
                            <span>📍 ${s.location} • Products: ${s.products_list}</span>
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-bold ${s.status === 'Active' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-600'}">${s.status}</span>
                        </div>
                    `;
                    resultsContainer.appendChild(item);
                });
                
                highlightResult();
            }

            function highlightResult() {
                const items = resultsContainer.querySelectorAll('a');
                items.forEach((item, index) => {
                    if (index === selectedIndex) {
                        item.classList.add('bg-slate-50', 'border-slate-200');
                        item.scrollIntoView({ block: 'nearest' });
                    } else {
                        item.classList.remove('bg-slate-50', 'border-slate-200');
                    }
                });
            }
        });
    </script>
    <!-- Unified Right-Side Panel Backdrop -->
    <div x-show="activeRightPanel !== ''" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[100] lg:flex" 
         @click="activeRightPanel = ''" 
         style="display: none;">
    </div>

    <!-- Unified Right-Side Panel Drawer -->
    <div x-show="activeRightPanel !== ''"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in duration-250 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="translate-x-full"
         class="fixed inset-y-0 right-0 z-[101] w-full max-w-md bg-white border-l border-slate-200 shadow-2xl flex flex-col justify-between h-full dark:bg-slate-800 dark:border-slate-700"
         style="display: none;">
        
        <!-- Header -->
        <div class="px-6 py-4 border-b border-slate-200/80 flex items-center justify-between bg-slate-50/50 dark:bg-slate-900/40 dark:border-slate-700">
            <div>
                <h3 class="text-xs font-black text-slate-900 dark:text-white uppercase tracking-wider" x-text="activeRightPanel === 'profile' ? 'User Profile' : activeRightPanel === 'settings' ? 'Configure Settings' : activeRightPanel === 'help' ? 'Help & Documentation' : activeRightPanel === 'notifications' ? 'Alerts & Notifications' : 'Chat: ' + chatRecipient">Panel</h3>
            </div>
            <button @click="activeRightPanel = ''" class="text-slate-400 hover:text-slate-650 focus:outline-none p-1 rounded-md hover:bg-slate-100 dark:hover:bg-slate-700">
                <i data-lucide="x" class="w-5 h-5"></i>
            </button>
        </div>

        <!-- Content Area -->
        <div class="flex-1 overflow-y-auto p-6 space-y-6">
            <!-- PROFILE PANEL -->
            <template x-if="activeRightPanel === 'profile'">
                <div class="space-y-6">
                    <div class="flex flex-col items-center text-center pb-6 border-b border-slate-100 dark:border-slate-700">
                        <div class="w-20 h-20 rounded-full bg-emerald-50 border-2 border-[#235c2b] flex items-center justify-center text-2xl font-black text-[#235c2b] shadow-md mb-3 dark:bg-slate-900">
                            @if(Auth::check()) {{ Auth::user()->avatar_initial ?? strtoupper(substr(Auth::user()->name, 0, 2)) }} @else SA @endif
                        </div>
                        <h4 class="text-base font-black text-slate-900 dark:text-white">@if(Auth::check()) {{ Auth::user()->name }} @else System Admin @endif</h4>
                        <p class="text-xs font-bold text-[#235c2b] uppercase tracking-wider mt-0.5">@if(Auth::check()) {{ str_replace('_', ' ', Auth::user()->role) }} @else admin @endif</p>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-slate-50 rounded-xl p-4 dark:bg-slate-900/50">
                            <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Username</span>
                            <div class="text-xs font-bold text-slate-800 mt-0.5 dark:text-slate-200">@if(Auth::check()) {{ Auth::user()->username }} @else system.admin @endif</div>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-4 dark:bg-slate-900/50">
                            <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Email Address</span>
                            <div class="text-xs font-bold text-slate-800 mt-0.5 dark:text-slate-200">@if(Auth::check()) {{ Auth::user()->email }} @else admin@ambatugrow.test @endif</div>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-4 dark:bg-slate-900/50">
                            <span class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider">Department</span>
                            <div class="text-xs font-bold text-slate-800 mt-0.5 dark:text-slate-200">@if(Auth::check()) {{ Auth::user()->department ?? 'IT Operations' }} @else IT @endif</div>
                        </div>
                    </div>
                    
                    @if (Auth::check())
                        <form method="POST" action="{{ route('logout') }}" class="w-full pt-4">
                            @csrf
                            <button type="submit" class="w-full py-2.5 bg-red-600 hover:bg-red-700 text-white rounded-lg text-xs font-bold transition shadow-sm">LOG OUT ACCOUNT</button>
                        </form>
                    @endif
                </div>
            </template>

            <!-- SETTINGS PANEL -->
            <template x-if="activeRightPanel === 'settings'">
                <div class="space-y-5">
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl dark:bg-slate-900/50">
                        <div>
                            <div class="text-xs font-black text-slate-800 dark:text-slate-200">Email Notifications</div>
                            <div class="text-[10px] text-slate-500 mt-0.5">Receive digests of pending approvals</div>
                        </div>
                        <input type="checkbox" x-model="systemSettings.emailAlerts" class="rounded border-slate-350 text-emerald-600 focus:ring-emerald-500 bg-white dark:bg-slate-800">
                    </div>
                    <div class="flex items-center justify-between p-4 bg-slate-50 rounded-xl dark:bg-slate-900/50">
                        <div>
                            <div class="text-xs font-black text-slate-800 dark:text-slate-200">Desktop Alerts</div>
                            <div class="text-[10px] text-slate-500 mt-0.5">Push notifications for urgent reviews</div>
                        </div>
                        <input type="checkbox" x-model="systemSettings.desktopAlerts" class="rounded border-slate-350 text-emerald-600 focus:ring-emerald-500 bg-white dark:bg-slate-800">
                    </div>
                    <div class="p-4 bg-slate-50 rounded-xl dark:bg-slate-900/50 space-y-2">
                        <label class="text-xs font-black text-slate-800 dark:text-slate-200 block">Default Urgency Level</label>
                        <select x-model="systemSettings.defaultUrgency" class="w-full px-2.5 py-1.5 border border-slate-200 rounded-lg text-xs bg-white dark:bg-slate-800 dark:border-slate-700 text-slate-800 dark:text-slate-200">
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="High">High</option>
                            <option value="Urgent">Urgent</option>
                        </select>
                    </div>
                </div>
            </template>

            <!-- HELP PANEL -->
            <template x-if="activeRightPanel === 'help'">
                <div class="space-y-4">
                    <div class="border border-slate-100 rounded-xl p-4 space-y-2 dark:border-slate-750 dark:bg-slate-900/10">
                        <h4 class="text-xs font-black text-slate-900 dark:text-white flex items-center gap-2">
                            <i data-lucide="route" class="w-4 h-4 text-emerald-655"></i>
                            Requisition Routing
                        </h4>
                        <p class="text-[11px] text-slate-550 leading-relaxed dark:text-slate-400">
                            - **Sequential Flow:** Approvals occur step-by-step in ordered sequence. If one approver rejects, the entire requisition is canceled.
                            <br>- **Parallel Flow:** All approvers review simultaneously. All must approve to clear the routing.
                        </p>
                    </div>
                    <div class="border border-slate-100 rounded-xl p-4 space-y-2 dark:border-slate-750 dark:bg-slate-900/10">
                        <h4 class="text-xs font-black text-slate-900 dark:text-white flex items-center gap-2">
                            <i data-lucide="file-check" class="w-4 h-4 text-emerald-655"></i>
                            Three-Way Matching
                        </h4>
                        <p class="text-[11px] text-slate-550 leading-relaxed dark:text-slate-400">
                            Ensures compliance by validating that the Purchase Order quantities/costs align with the Delivery Receipt (goods received) and the Supplier Invoice before payment is initiated.
                        </p>
                    </div>
                </div>
            </template>

            <!-- NOTIFICATIONS PANEL -->
            <template x-if="activeRightPanel === 'notifications'">
                <div class="space-y-3">
                    <template x-for="item in notificationsList" :key="item.id">
                        <div class="p-3 bg-slate-50 rounded-xl flex items-start justify-between gap-3 dark:bg-slate-900/50" :class="item.read ? 'opacity-60' : ''">
                            <div class="flex items-start gap-2.5">
                                <span class="w-2 h-2 bg-emerald-500 rounded-full mt-1.5 shrink-0 animate-pulse" x-show="!item.read"></span>
                                <div>
                                    <div class="text-xs font-bold text-slate-800 dark:text-slate-200" x-text="item.text"></div>
                                    <span class="text-[9px] text-slate-400 block mt-1" x-text="item.time"></span>
                                </div>
                            </div>
                            <button @click="item.read = true" x-show="!item.read" class="text-[9px] text-emerald-600 hover:text-emerald-700 hover:underline font-extrabold shrink-0">Mark read</button>
                        </div>
                    </template>
                </div>
            </template>

            <!-- CHAT PANEL -->
            <template x-if="activeRightPanel === 'chat'">
                <div class="flex flex-col h-full justify-between">
                    <div class="flex-1 overflow-y-auto space-y-3 pr-1">
                        <template x-for="msg in chatMessages[chatRecipient]">
                            <div class="flex flex-col" :class="msg.sender === 'You' ? 'items-end' : 'items-start'">
                                <div class="px-3 py-2 rounded-xl text-xs max-w-[85%]" :class="msg.sender === 'You' ? 'bg-[#235c2b] text-white rounded-tr-none' : 'bg-slate-100 text-slate-800 rounded-tl-none dark:bg-slate-900 dark:text-slate-200'">
                                    <span x-text="msg.text"></span>
                                </div>
                                <span class="text-[8px] text-slate-400 mt-0.5" x-text="msg.time"></span>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
        </div>

        <!-- Footer / Input Form for Chat -->
        <template x-if="activeRightPanel === 'chat'">
            <form @submit.prevent="sendChatMessage()" class="p-4 border-t border-slate-200/80 bg-slate-50 dark:bg-slate-900/60 dark:border-slate-700 flex gap-2">
                <input type="text" x-model="chatInput" placeholder="Type a message..." class="flex-1 px-3 py-1.5 border border-slate-250 rounded-lg text-xs bg-white focus:outline-none dark:bg-slate-800 dark:border-slate-700 text-slate-850 dark:text-slate-100">
                <button type="submit" class="px-3.5 py-1.5 bg-[#235c2b] text-white rounded-lg text-xs font-bold hover:bg-[#1a4a21] transition">Send</button>
            </form>
        </template>
    </div>

    <!-- Toast Notification Container -->
    <div x-show="showToast" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="translate-y-2 opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="translate-y-0 opacity-100"
         x-transition:leave-end="translate-y-2 opacity-0"
         class="fixed bottom-5 right-5 z-[9999] flex items-center gap-3 px-4 py-3 bg-slate-900 text-white rounded-xl shadow-lg border border-slate-700/50"
         style="display: none;">
        <i class="fa-solid fa-circle-info text-emerald-400"></i>
        <span class="text-xs font-bold" x-text="toastMessage"></span>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
</body>
</html>
