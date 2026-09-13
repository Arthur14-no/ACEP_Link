<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nouvelle annonce</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('annonces.store') }}" class="space-y-4 bg-white p-6 rounded shadow">
                @csrf
                <div>
                    <label class="block text-sm font-medium">Titre</label>
                    <input type="text" name="titre" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-acep-light focus:border-acep-light" required>
                </div>
                <div>
                    <label class="block text-sm font-medium">Contenu</label>
                    <textarea name="contenu" rows="6" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-acep-light focus:border-acep-light" required></textarea>
                </div>
                <button type="submit" class="bg-acep-dark hover:bg-acep-dark/90 text-white px-4 py-2 rounded">Publier</button>
            </form>
        </div>
    </div>
</x-app-layout>