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
                    <input type="text" name="nom" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-acep-light focus:border-acep-light" required>
                </div>
                <div>
                    <label class="block text-sm font-medium">Visibilité</label>
                    <select name="visibilite" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-acep-light focus:border-acep-light" required>
                        <option value="public">Public — tous les employés voient et écrivent</option>
                        <option value="public_lecture_seule">Public en lecture seule — tous voient, seuls admin/modérateurs écrivent</option>
                        <option value="prive">Privé — seulement les membres autorisés</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">Service concerné (optionnel, informatif)</label>
                    <select name="service_id" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-acep-light focus:border-acep-light">
                        <option value="">Aucun / transverse</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->nom }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">Description (optionnel)</label>
                    <textarea name="description" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-acep-light focus:border-acep-light"></textarea>
                </div>
                <button type="submit" class="bg-acep-dark hover:bg-acep-dark/90 text-white px-4 py-2 rounded">Créer</button>
            </form>
        </div>
    </div>
</x-app-layout>