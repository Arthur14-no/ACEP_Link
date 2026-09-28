<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if($derniereAnnonce)
                <div class="bg-acep-light/10 border border-acep-light/40 rounded-lg p-4">
                    <p class="text-xs text-acep-dark font-semibold uppercase mb-1">Dernière annonce</p>
                    <h3 class="font-semibold text-lg">{{ $derniereAnnonce->titre }}</h3>
                    <p class="text-sm text-gray-500 mb-2">Par {{ $derniereAnnonce->auteur->name }} — {{ $derniereAnnonce->created_at->format('d/m/Y H:i') }}</p>
                    <p class="whitespace-pre-line">{{ $derniereAnnonce->contenu }}</p>
                    <a href="{{ route('annonces.index') }}" class="text-acep-dark text-sm underline mt-2 inline-block">Voir toutes les annonces</a>
                </div>
            @endif

            @if(auth()->user()->role === 'administrateur')
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-white border rounded-lg p-4">
                        <p class="text-sm text-gray-500">Utilisateurs inscrits</p>
                        <p class="text-3xl font-bold text-acep-dark">{{ $statistiques['utilisateurs'] }}</p>
                    </div>
                    <div class="bg-white border rounded-lg p-4">
                        <p class="text-sm text-gray-500">Administrateurs</p>
                        <p class="text-3xl font-bold text-acep-dark">{{ $statistiques['administrateurs'] }}</p>
                    </div>
                    <div class="bg-white border rounded-lg p-4">
                        <p class="text-sm text-gray-500">Actions aujourd'hui</p>
                        <p class="text-3xl font-bold text-acep-dark">{{ $statistiques['actions_aujourdhui'] }}</p>
                    </div>
                </div>

                <div class="bg-white border rounded-lg p-4">
                    <p class="text-sm font-semibold mb-2">Activité (7 derniers jours)</p>
                    <canvas id="graphiqueActivite" height="80"></canvas>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                    <div class="bg-white border rounded-lg p-4">
                        <p class="text-sm font-semibold mb-2">Dernières actions</p>
                        <ul class="space-y-1 text-sm">
                            @forelse($dernieresActions as $action)
                                <li class="border-b pb-1">
                                    <span class="text-gray-500">{{ $action->created_at->format('d/m H:i') }}</span>
                                    — <strong>{{ $action->utilisateur->name ?? 'Système' }}</strong> : {{ $action->description }}
                                </li>
                            @empty
                                <li class="text-gray-500">Aucune action pour l'instant.</li>
                            @endforelse
                        </ul>
                        <a href="{{ route('admin.journal.index') }}" class="text-acep-dark text-sm underline mt-2 inline-block">Voir tout le journal</a>
                    </div>

                    <div class="bg-white border rounded-lg p-4">
                        <p class="text-sm font-semibold mb-2 text-red-700">Tentatives de connexion échouées</p>
                        <ul class="space-y-1 text-sm">
                            @forelse($tentativesEchouees as $tentative)
                                <li class="border-b pb-1 text-red-600">
                                    <span class="text-gray-500">{{ $tentative->created_at->format('d/m H:i') }}</span>
                                    — {{ $tentative->description }}
                                </li>
                            @empty
                                <li class="text-gray-500">Aucune tentative échouée récente.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">{{ __("You're logged in!") }}</div>
            </div>
        </div>
    </div>

    @if(auth()->user()->role === 'administrateur')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const ctx = document.getElementById('graphiqueActivite');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($labels),
                        datasets: [{
                            label: 'Actions enregistrées',
                            data: @json($valeurs),
                            borderColor: '#00564b',
                            backgroundColor: 'rgba(80, 194, 187, 0.25)',
                            fill: true,
                            tension: 0.3,
                        }]
                    },
                    options: {
                        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
                    }
                });
            });
        </script>
    @endif
</x-app-layout>