<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Messagerie privée</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <input
                type="text"
                id="rechercheContact"
                placeholder="Rechercher un contact..."
                class="w-full border rounded px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-acep-light focus:border-acep-light"
            >

            <ul id="listeContacts" class="space-y-2">
                @forelse($utilisateurs as $utilisateur)
                    <li class="border rounded p-3 bg-white flex items-center gap-2" data-nom="{{ strtolower($utilisateur->name) }}">
                        @if($utilisateur->non_lu)
                            <span class="h-2 w-2 rounded-full bg-acep-light shrink-0" title="Nouveau message"></span>
                        @endif
                        <a href="{{ route('messages.show', $utilisateur) }}" class="font-semibold {{ $utilisateur->non_lu ? 'text-acep-dark' : 'text-gray-800 hover:text-acep-dark' }}">{{ $utilisateur->name }}</a>
                    </li>
                @empty
                    <li class="text-gray-500">Aucun autre utilisateur pour l'instant.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <script>
        const champRecherche = document.getElementById('rechercheContact');
        const contacts = document.querySelectorAll('#listeContacts li[data-nom]');

        champRecherche.addEventListener('input', () => {
            const recherche = champRecherche.value.toLowerCase();
            contacts.forEach(contact => {
                contact.style.display = contact.dataset.nom.includes(recherche) ? '' : 'none';
            });
        });
    </script>
</x-app-layout>