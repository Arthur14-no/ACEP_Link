<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $salon->nom }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="border rounded p-4 h-96 overflow-y-auto mb-4 space-y-2 bg-white">
                @foreach($messages as $message)
                    <div>
                        <strong>{{ $message->expediteur->name }}</strong>
                        <span class="text-xs text-gray-500">{{ $message->created_at->format('H:i') }}</span>
                        <p>{{ $message->contenu }}</p>
                    </div>
                @endforeach
            </div>

            <form method="POST" action="{{ route('messages.store', $salon) }}" class="flex gap-2">
                @csrf
                <input type="text" name="contenu" class="flex-1 border rounded px-3 py-2" placeholder="Écris un message..." required>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Envoyer</button>
            </form>
        </div>
    </div>
</x-app-layout> 