<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Annonces institutionnelles</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            @if(in_array(auth()->user()->role, ['administrateur','moderateur']))
                <a href="{{ route('annonces.create') }}" class="text-acep-dark font-medium hover:underline">+ Nouvelle annonce</a>
            @endif

            <div class="space-y-4 mt-4">
                @forelse($annonces as $annonce)
                    <div class="bg-white border rounded p-4">
                        <div class="flex justify-between items-start">
                            <h3 class="font-semibold text-lg">{{ $annonce->titre }}</h3>
                            @if(in_array(auth()->user()->role, ['administrateur','moderateur']))
                                <form method="POST" action="{{ route('annonces.destroy', $annonce) }}" onsubmit="return confirm('Supprimer cette annonce ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 text-sm">Supprimer</button>
                                </form>
                            @endif
                        </div>
                        <p class="text-sm text-gray-500 mb-2">Par {{ $annonce->auteur->name }} — {{ $annonce->created_at->format('d/m/Y H:i') }}</p>
                        <p class="whitespace-pre-line">{{ $annonce->contenu }}</p>
                    </div>
                @empty
                    <p class="text-gray-500">Aucune annonce pour l'instant.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>