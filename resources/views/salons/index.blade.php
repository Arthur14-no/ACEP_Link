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
                    <li class="border rounded p-3 bg-white flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            @if($salon->non_lu)
                                <span class="h-2 w-2 rounded-full bg-acep-light shrink-0" title="Nouveau message"></span>
                            @endif
                            <div>
                                <a href="{{ route('salons.show', $salon) }}" class="font-semibold {{ $salon->non_lu ? 'text-acep-dark' : 'text-gray-800 hover:text-acep-dark' }}">{{ $salon->nom }}</a>
                                <span class="text-sm text-gray-500"> — {{ $salon->service->nom ?? 'Transverse' }}</span>
                                @if($salon->visibilite === 'prive')
                                    <span class="text-xs bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full ml-1">Privé</span>
                                @elseif($salon->visibilite === 'public_lecture_seule')
                                    <span class="text-xs bg-gray-200 text-gray-700 px-2 py-0.5 rounded-full ml-1">Lecture seule</span>
                                @endif
                            </div>
                        </div>
                        @if($salon->visibilite === 'prive' && auth()->user()->role === 'administrateur')
                            <a href="{{ route('admin.salons.membres.index', $salon) }}" class="text-xs text-acep-dark hover:underline">Gérer les membres</a>
                        @endif
                    </li>
                @empty
                    <li class="text-gray-500">Aucun salon pour l'instant.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-app-layout>