<div class="relative" x-data="{ open: false }" @click.outside="open = false" wire:poll.15s>
    <!-- Notification Bell Button -->
    <button @click="open = !open" class="relative p-2 text-gray-400 hover:text-primary-600 bg-gray-50 dark:bg-gray-700 rounded-full transition-colors focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <!-- Red Badge for Unread Notifications -->
        @if($unreadCount > 0)
            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full border-2 border-white dark:border-gray-800 transform translate-x-1/4 -translate-y-1/4">
                {{ $unreadCount > 99 ? '99+' : $unreadCount }}
            </span>
        @endif
    </button>

    <!-- Notification Dropdown -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 mt-2 w-80 bg-white dark:bg-gray-800 rounded-xl shadow-lg z-50 ring-1 ring-black ring-opacity-5 overflow-hidden"
         style="display: none;">
        
        <!-- Header -->
        <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-900/50">
            <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200">Notifikasi</h3>
            @if($unreadCount > 0)
                <button wire:click="markAllAsRead" class="text-xs text-primary-600 hover:text-primary-700 font-medium">
                    Tandai semua dibaca
                </button>
            @endif
        </div>

        <!-- Notification List -->
        <div class="max-h-96 overflow-y-auto">
            @forelse($notifications as $notification)
                <div class="px-4 py-3 border-b border-gray-50 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors {{ is_null($notification->read_at) ? 'bg-primary-50/50 dark:bg-primary-900/20' : '' }}">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 pt-0.5">
                            @if(isset($notification->data['type']) && $notification->data['type'] == 'success')
                                <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            @elseif(isset($notification->data['type']) && $notification->data['type'] == 'warning')
                                <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                </div>
                            @elseif(isset($notification->data['type']) && $notification->data['type'] == 'error')
                                <div class="w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </div>
                            @else
                                <div class="w-8 h-8 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                            @endif
                        </div>
                        <div class="ml-3 w-0 flex-1">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $notification->data['title'] ?? 'Notifikasi Baru' }}
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5 line-clamp-2">
                                {{ $notification->data['message'] ?? '' }}
                            </p>
                            <div class="mt-2 flex items-center justify-between">
                                <p class="text-xs text-gray-400 dark:text-gray-500">
                                    {{ $notification->created_at->diffForHumans() }}
                                </p>
                                @if(is_null($notification->read_at))
                                    <button wire:click.stop="markAsRead('{{ $notification->id }}')" class="text-xs font-medium text-primary-600 hover:text-primary-700">
                                        Tandai dibaca
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <p class="mt-2 text-sm font-medium">Belum ada notifikasi.</p>
                </div>
            @endforelse
        </div>

        <!-- Footer -->
        <a href="{{ route('notifications.index') }}" wire:navigate class="block w-full text-center px-4 py-2 border-t border-gray-100 dark:border-gray-700 text-sm font-medium text-primary-600 hover:text-primary-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
            Lihat Semua Notifikasi
        </a>
    </div>
</div>
