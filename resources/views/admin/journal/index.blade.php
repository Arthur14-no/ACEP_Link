<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Journal des actions</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <table class="w-full bg-white border rounded">
                <thead>
                    <tr class="text-left border-b">
                        <th class="p-3">Date</th>
                        <th class="p-3">Utilisateur</th>
                        <th class="p-3">Action</th>
                        <th class="p-3">Détail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($journaux as $journal)
                        <tr class="border-b">
                            <td class="p-3">{{ $journal->created_at->format('d/m/Y H:i') }}</td>
                            <td class="p-3">{{ $journal->utilisateur->name ?? 'Système' }}</td>
                            <td class="p-3">{{ $journal->action }}</td>
                            <td class="p-3">{{ $journal->description }}</td>
                        </tr>
                    @empty
                        <tr><td class="p-3 text-gray-500" colspan="4">Aucune action enregistrée.</td></tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $journaux->links() }}
            </div>
        </div>
    </div>
</x-app-layout>