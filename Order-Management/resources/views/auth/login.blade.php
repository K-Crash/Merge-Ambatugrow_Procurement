<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-[#e9f5ee] text-[#1f5c3d] mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Ambatugrow Procurement</h2>
        <p class="text-sm text-gray-500 mt-1">Please sign in to access the system</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Email Address</label>
            <input id="email" class="block mt-1 w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-950 text-gray-900 dark:text-gray-100 focus:border-[#1f5c3d] focus:ring focus:ring-[#1f5c3d]/20 transition" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center">
                <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Password</label>
            </div>
            <input id="password" class="block mt-1 w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-950 text-gray-900 dark:text-gray-100 focus:border-[#1f5c3d] focus:ring focus:ring-[#1f5c3d]/20 transition"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#1f5c3d] focus:ring-[#1f5c3d]" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm font-medium text-[#1f5c3d] hover:underline" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <button type="submit" class="w-full py-2.5 bg-[#1f5c3d] hover:bg-[#163f2b] text-white font-bold rounded-xl transition shadow-md shadow-emerald-950/20">
            Sign In
        </button>
    </form>

    <div class="relative flex py-5 items-center">
        <div class="flex-grow border-t border-gray-300"></div>
        <span class="flex-shrink mx-4 text-gray-400 text-xs font-bold uppercase">Quick Login (Demo Roles)</span>
        <div class="flex-grow border-t border-gray-300"></div>
    </div>

    <div class="grid grid-cols-1 gap-2">
        <button onclick="quickLogin('sarah.jenkins@ambatugrow.test')" class="flex items-center justify-between p-3 rounded-xl bg-sky-50 border border-sky-100 hover:bg-sky-100/70 text-sky-950 text-left transition">
            <div>
                <div class="font-bold text-sm">Sarah Jenkins</div>
                <div class="text-[11px] text-sky-600 font-semibold uppercase">Manager Role</div>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-sky-700">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
            </svg>
        </button>

        <button onclick="quickLogin('finance.manager@ambatugrow.test')" class="flex items-center justify-between p-3 rounded-xl bg-amber-50 border border-amber-100 hover:bg-amber-100/70 text-amber-950 text-left transition">
            <div>
                <div class="font-bold text-sm">Michael Finn</div>
                <div class="text-[11px] text-amber-600 font-semibold uppercase">Finance Manager</div>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-amber-700">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
            </svg>
        </button>

        <button onclick="quickLogin('johny.papa@ambatugrow.test')" class="flex items-center justify-between p-3 rounded-xl bg-purple-50 border border-purple-100 hover:bg-purple-100/70 text-purple-950 text-left transition">
            <div>
                <div class="font-bold text-sm">Johny Papa</div>
                <div class="text-[11px] text-purple-600 font-semibold uppercase">Department Head (Final)</div>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4 text-purple-700">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
            </svg>
        </button>
    </div>

    <script>
        function quickLogin(email) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = 'password';
            document.querySelector('form').submit();
        }
    </script>
</x-guest-layout>
