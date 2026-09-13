<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Documents</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            @if(in_array(auth()->user()->role, ['administrateur','moderateur']))
                <a href="{{ route('documents.create') }}" class="text-acep-dark font-medium hover:underline">+ Déposer un document</a>
            @endif

            <table class="w-full bg-white border rounded mt-4">
                <thead>
                    <tr class="text-left border-b">
                        <th class="p-3">Nom</th>
                        <th class="p-3">Déposé par</th>
                        <th class="p-3">Taille</th>
                        <th class="p-3">Date</th>
                        <th class="p-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $document)
                        <tr class="border-b">
                            <td class="p-3">{{ $document->nom_original }}</td>
                            <td class="p-3">{{ $document->deposant->name }}</td>
                            <td class="p-3">{{ round($document->taille / 1024) }} Ko</td>
                            <td class="p-3">{{ $document->created_at->format('d/m/Y H:i') }}</td>
                            <td class="p-3 flex gap-2">
                                <a href="{{ route('documents.download', $document) }}" class="text-acep-dark hover:underline">Télécharger</a>
                                @if($document->depose_par === auth()->id() || in_array(auth()->user()->role, ['administrateur','moderateur']))
                                    <form method="POST" action="{{ route('documents.destroy', $document) }}" onsubmit="return confirm('Supprimer ce document ?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600">Supprimer</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td class="p-3 text-gray-500" colspan="5">Aucun document pour l'instant.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>