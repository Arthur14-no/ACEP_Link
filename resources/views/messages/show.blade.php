<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Conversation avec {{ $utilisateur->name }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                    @foreach($errors->all() as $erreur)
                        <div>{{ $erreur }}</div>
                    @endforeach
                </div>
            @endif

            <div id="messages-container" data-dernier-id="{{ $messages->last()->id ?? 0 }}" class="border rounded p-4 h-96 overflow-y-auto mb-4 space-y-2 bg-white">
                @foreach($messages as $message)
                    <div>
                        <strong>{{ $message->expediteur->name }}</strong>
                        <span class="text-xs text-gray-500">{{ $message->created_at->format('H:i') }}</span>
                        @if($message->contenu)
                            <p>{{ $message->contenu }}</p>
                        @endif
                        @if($message->document)
                            <p><a href="{{ route('documents.download', $message->document) }}" class="text-blue-600 underline">📎 {{ $message->document->nom_original }}</a></p>
                        @endif
                    </div>
                @endforeach
            </div>

            <form method="POST" action="{{ route('messages.privees.store', $utilisateur) }}" enctype="multipart/form-data" class="flex gap-2 items-center">
                @csrf
                <input type="text" name="contenu" class="flex-1 border rounded px-3 py-2" placeholder="Écris un message...">
                <input type="file" name="fichier" class="text-sm">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Envoyer</button>
            </form>
        </div>
    </div>

    <script>
        const container = document.getElementById('messages-container');
        const utilisateurId = {{ $utilisateur->id }};
        let dernierId = container.dataset.dernierId;

        function chargerNouveauxMessages() {
            fetch(`/messages/${utilisateurId}/nouveaux?apres=${dernierId}`)
                .then(response => response.json())
                .then(messages => {
                    messages.forEach(message => {
                        const div = document.createElement('div');

                        const auteur = document.createElement('strong');
                        auteur.textContent = message.auteur;

                        const heure = document.createElement('span');
                        heure.className = 'text-xs text-gray-500';
                        heure.textContent = ' ' + message.heure;

                        div.appendChild(auteur);
                        div.appendChild(heure);

                        if (message.contenu) {
                            const contenu = document.createElement('p');
                            contenu.textContent = message.contenu;
                            div.appendChild(contenu);
                        }

                        if (message.document) {
                            const piece = document.createElement('p');
                            const lien = document.createElement('a');
                            lien.href = message.document.url;
                            lien.className = 'text-blue-600 underline';
                            lien.textContent = '📎 ' + message.document.nom;
                            piece.appendChild(lien);
                            div.appendChild(piece);
                        }

                        container.appendChild(div);
                        dernierId = message.id;
                    });

                    if (messages.length > 0) {
                        container.scrollTop = container.scrollHeight;
                    }
                });
        }

        setInterval(chargerNouveauxMessages, 3000);
    </script>
</x-app-layout>