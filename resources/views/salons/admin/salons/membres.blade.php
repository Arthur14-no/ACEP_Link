<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Membres du salon "{{ $salon->nom }}"</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(session('success'))
                <div class="p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white border rounded p-4">
                <p class="text-sm font-semibold mb-2">Membres actuels</p>
                <ul class="space-y-1">
                    @forelse($membres as $membre)
                        <li class="flex justify-between items-center text-sm border-b py-1">
                            {{ $membre->name }}
                            <form method="POST" action="{{ route('admin.salons.membres.destroy', [$salon, $membre]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 text-xs">Retirer</button>
                            </form>
                        </li>
                    @empty
                        <li class="text-gray-500 text-sm">Aucun membre pour l'instant.</li>
                    @endforelse
                </ul>
            </div>

            <div class="bg-white border rounded p-4">
                <p class="text-sm font-semibold mb-2">Ajouter un membre</p>
                <form method="POST" action="{{ route('admin.salons.membres.store', $salon) }}" class="flex gap-2">
                    @csrf
                    <select name="user_id" class="flex-1 border rounded px-2 py-1 text-sm">
                        @foreach($autresUtilisateurs as $utilisateur)
                            <option value="{{ $utilisateur->id }}">{{ $utilisateur->name }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="bg-acep-dark hover:bg-acep-dark/90 text-white px-3 py-1 rounded text-sm">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>