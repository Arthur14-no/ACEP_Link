<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Déposer un document</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            @if($errors->any())
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
                    @foreach($errors->all() as $erreur)
                        <div>{{ $erreur }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded shadow">
                @csrf
                <div>
                    <label class="block text-sm font-medium">Fichier (PDF, Word, Excel, image — 10 Mo max)</label>
                    <input type="file" name="fichier" class="w-full border rounded px-3 py-2" required>
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Déposer</button>
            </form>
        </div>
    </div>
</x-app-layout>