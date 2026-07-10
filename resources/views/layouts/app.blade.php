<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="{ sidebarOpen: window.innerWidth >= 1024 }" 
      @resize.window="sidebarOpen = window.innerWidth >= 1024">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SMK Tri Bhakti') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gray-50 dark:bg-gray-900">
        <div class="flex h-screen overflow-hidden">
            <!-- Sidebar -->
            <livewire:layout.sidebar />

            <!-- Main Content -->
            <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
                <!-- Topbar -->
                <livewire:layout.topbar />

                <main>
                    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
                        <!-- Welcome banner -->
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
        
        @livewireScripts
        
        <!-- Toast Notification -->
        <div x-data="{ 
                show: false, 
                message: '', 
                type: 'success',
                timeout: null,
                init() {
                    @if(session()->has('message'))
                        this.showToast('{{ session('message') }}', 'success');
                    @endif
                    window.addEventListener('notify', (e) => {
                        this.showToast(e.detail.message, e.detail.type || 'success');
                    });
                },
                showToast(msg, type) {
                    this.message = msg;
                    this.type = type;
                    this.show = true;
                    if (this.timeout) clearTimeout(this.timeout);
                    this.timeout = setTimeout(() => { this.show = false }, 3000);
                }
            }" 
            x-show="show" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-2"
            class="fixed bottom-5 right-5 z-[100] max-w-xs w-full bg-white dark:bg-gray-800 border-l-4 rounded-xl shadow-2xl p-4"
            :class="type === 'success' ? 'border-emerald-500' : 'border-red-500'"
            style="display: none;"
        >
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <template x-if="type === 'success'">
                        <svg class="h-5 w-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    </template>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-bold text-gray-800 dark:text-white" x-text="message"></p>
                </div>
            </div>
        </div>
    </body>
</html>
