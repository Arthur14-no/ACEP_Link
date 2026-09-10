<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Messagerie privée</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <ul class="space-y-2">
                @forelse($utilisateurs as $utilisateur)
                    <li class="border rounded p-3 bg-white">
                        <a href="{{ route('messages.show', $utilisateur) }}" class="font-semibold">{{ $utilisateur->name }}</a>
                    </li>
                @empty
                    <li class="text-gray-500">Aucun autre utilisateur pour l'instant.</li>
                @endforelse
            </ul>
        </div>
    </div>
</x-app-layout>