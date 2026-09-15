<aside
    x-cloak
    :class="sidebarOuverte ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
    class="fixed lg:static inset-y-0 left-0 z-30 w-64 bg-acep-dark text-white flex flex-col transition-transform duration-200 ease-in-out"
>
    <div class="flex items-center justify-between px-4 py-4 border-b border-white/10">
        <a href="{{ route('dashboard') }}" class="bg-white rounded-lg px-3 py-2 inline-block">
            <img src="{{ asset('images/logo-acep.png') }}" alt="ACEP Link" class="h-6">
        </a>
        <button @click="sidebarOuverte = false" class="lg:hidden text-white/70">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l18 18" />
            </svg>
        </button>
    </div>

    <nav class="flex-1 overflow-y-auto px-2 py-4 space-y-1">
        <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
        </x-sidebar-link>
        <x-sidebar-link :href="route('annonces.index')" :active="request()->routeIs('annonces.*')">
            {{ __('Annonces') }}
        </x-sidebar-link>
        <x-sidebar-link :href="route('salons.index')" :active="request()->routeIs('salons.*')" class="justify-between">
            <span>{{ __('Salons') }}</span>
            @if($salonsNonLus > 0)
                <span class="bg-acep-light text-acep-dark text-xs font-bold px-2 py-0.5 rounded-full">{{ $salonsNonLus }}</span>
            @endif
        </x-sidebar-link>
        <x-sidebar-link :href="route('messages.index')" :active="request()->routeIs('messages.index') || request()->routeIs('messages.show')" class="justify-between">
            <span>{{ __('Messages') }}</span>
            @if($messagesNonLus > 0)
                <span class="bg-acep-light text-acep-dark text-xs font-bold px-2 py-0.5 rounded-full">{{ $messagesNonLus }}</span>
            @endif
        </x-sidebar-link>
        <x-sidebar-link :href="route('documents.index')" :active="request()->routeIs('documents.*')">
            {{ __('Documents') }}
        </x-sidebar-link>

        @if(auth()->user()->role === 'administrateur')
            <p class="px-3 pt-4 pb-1 text-xs uppercase tracking-wide text-white/40">Administration</p>
            <x-sidebar-link :href="route('admin.utilisateurs.index')" :active="request()->routeIs('admin.utilisateurs.*')">
                {{ __('Utilisateurs') }}
            </x-sidebar-link>
            <x-sidebar-link :href="route('admin.journal.index')" :active="request()->routeIs('admin.journal.*')">
                {{ __('Journal') }}
            </x-sidebar-link>
        @endif
    </nav>

    <div class="border-t border-white/10 p-3">
        <div class="flex items-center gap-2 px-1">
            <div class="h-8 w-8 rounded-full bg-acep-light text-acep-dark flex items-center justify-center font-semibold text-sm">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium truncate">{{ Auth::user()->name }}</p>
                <p class="text-xs text-white/50 truncate">{{ ucfirst(Auth::user()->role) }}</p>
            </div>
        </div>
        <div class="mt-2 flex gap-3 text-xs px-1">
            <a href="{{ route('profile.edit') }}" class="text-white/70 hover:text-white">{{ __('Profil') }}</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-white/70 hover:text-white">{{ __('Déconnexion') }}</button>
            </form>
        </div>
    </div>
</aside>