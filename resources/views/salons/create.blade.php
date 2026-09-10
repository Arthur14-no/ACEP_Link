<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Créer un salon</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('salons.store') }}" class="space-y-4 bg-white p-6 rounded shadow">
                @csrf
                <div>
                    <label class="block text-sm font-medium">Nom du salon</label>
                    <input type="text" name="nom" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium">Service (optionnel)</label>
                    <input type="text" name="service" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium">Description (optionnel)</label>
                    <textarea name="description" class="w-full border rounded px-3 py-2"></textarea>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Créer</button>
            </form>
        </div>
    </div>
</x-app-layout>