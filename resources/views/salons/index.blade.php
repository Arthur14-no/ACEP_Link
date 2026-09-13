<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Salons de discussion</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if(in_array(auth()->user()->role, ['administrateur','moderateur']))
                <a href="{{ route('salons.create') }}" class="text-acep-dark font-medium hover:underline">+ Nouveau salon</a>
            @endif

            <ul class="space-y-2 mt-4">
                @forelse($salons as $salon)
                    <li class="border rounded p-3 bg-white">
                        <a href="{{ route('salons.show', $salon) }}" class="font-semibold text-gray-800 hover:text-acep-dark">{{ $salon->nom }}</a>
                        @if($salon->service)<span class="text-sm text-gray-500"> — {{ $salon->service }}</span>@endif
                    </li>
                @empty
                    <li class="text-gray-500">Aucun salon pour l'instant.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-app-layout>