<x-app-layout>
    <div class="py-2">
        @if(auth()->user()->isAdmin())
            <livewire:dashboard.admin />
        @elseif(auth()->user()->isGuru())
            <livewire:guru-role.dashboard />
        @elseif(auth()->user()->isSiswa())
            <livewire:dashboard.siswa />
        @endif
    </div>
</x-app-layout>
