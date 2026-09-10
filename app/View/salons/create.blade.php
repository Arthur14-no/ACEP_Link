@extends('layouts.app')
@section('content')
<div class="max-w-lg mx-auto py-6">
    <h1 class="text-xl font-bold mb-4">Créer un salon</h1>
    <form method="POST" action="{{ route('salons.store') }}" class="space-y-4">
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
@endsection