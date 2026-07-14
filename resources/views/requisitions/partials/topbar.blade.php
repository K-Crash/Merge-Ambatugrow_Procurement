<header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 gap-4">
    <div class="relative w-80 max-w-full">
        <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
        <input type="text" placeholder="Search requisitions, POs, vendors..."
               class="w-full pl-9 pr-3 py-2 text-sm rounded-lg border border-slate-200 bg-slate-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-200">
    </div>

    <div class="flex items-center gap-4">
        <span class="text-sm text-slate-500 hidden md:block">{{ now()->format('F j, Y') }}</span>

        <button class="relative w-9 h-9 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-500">
            <i class="fa-regular fa-bell"></i>
            <span class="absolute -top-0.5 -right-0.5 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
        </button>

        <div class="relative" x-data="{ open: false }" @click.outside="open = false">
            <button @click="open = !open" class="flex items-center gap-2 pl-1">
                <div class="w-9 h-9 rounded-full bg-emerald-600 text-white flex items-center justify-center text-xs font-semibold">
                    {{ auth()->user()->initials() }}
                </div>
                <div class="text-left hidden sm:block leading-tight">
                    <p class="text-sm font-semibold text-slate-700">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-400">{{ auth()->user()->roleLabel() }}</p>
                </div>
                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 ml-1"></i>
            </button>

            <div x-show="open" x-cloak x-transition
                 class="absolute right-0 mt-2 w-52 bg-white rounded-lg border border-slate-200 shadow-lg py-1 z-50">
                <div class="px-4 py-2.5 border-b border-slate-100">
                    <p class="text-sm font-semibold text-slate-700">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-400">{{ auth()->user()->email }}</p>
                </div>
                <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50">
                    <i class="fa-regular fa-user w-4"></i> Profile
                </a>
                <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50">
                    <i class="fa-solid fa-gear w-4"></i> Settings
                </a>
                <form method="POST" action="{{ route('logout') }}" class="border-t border-slate-100 mt-1 pt-1">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                        <i class="fa-solid fa-arrow-right-from-bracket w-4"></i> Log out
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
