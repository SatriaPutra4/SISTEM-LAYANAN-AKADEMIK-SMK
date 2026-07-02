<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Riwayat Notifikasi</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Semua notifikasi yang Anda terima.</p>
        </div>
        <button wire:click="markAllAsRead" class="px-4 py-2 bg-primary-50 text-primary-600 rounded-lg hover:bg-primary-100 font-medium text-sm transition-colors">
            Tandai semua dibaca
        </button>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="divide-y divide-gray-100 dark:divide-gray-700">
            @forelse($notifications as $notification)
                <div class="p-4 sm:px-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors {{ is_null($notification->read_at) ? 'bg-primary-50/30 dark:bg-primary-900/10' : '' }}">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0 mt-1">
                                @if(isset($notification->data['type']) && $notification->data['type'] == 'success')
                                    <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                @elseif(isset($notification->data['type']) && $notification->data['type'] == 'warning')
                                    <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    </div>
                                @elseif(isset($notification->data['type']) && $notification->data['type'] == 'error')
                                    <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </div>
                                @else
                                    <div class="w-10 h-10 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">
                                    {{ $notification->data['title'] ?? 'Notifikasi Baru' }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    {{ $notification->data['message'] ?? '' }}
                                </p>
                                <div class="mt-2 text-xs text-gray-400 flex items-center space-x-2">
                                    <span>{{ $notification->created_at->translatedFormat('d M Y, H:i') }}</span>
                                    <span>&bull;</span>
                                    <span>{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col items-end space-y-2">
                            @if(is_null($notification->read_at))
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-primary-100 text-primary-800">
                                    Baru
                                </span>
                                <button wire:click="markAsRead('{{ $notification->id }}')" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                                    Tandai dibaca
                                </button>
                            @else
                                <button wire:click="delete('{{ $notification->id }}')" class="text-sm text-red-500 hover:text-red-700 font-medium">
                                    Hapus
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-12 text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 dark:bg-gray-800 mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Tidak ada notifikasi</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Anda belum memiliki riwayat notifikasi apapun saat ini.</p>
                </div>
            @endforelse
        </div>
        
        @if($notifications->hasPages())
            <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</div>
