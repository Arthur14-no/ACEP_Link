<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gestion des utilisateurs</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
            @endif

            <table class="w-full bg-white border rounded">
                <thead>
                    <tr class="text-left border-b">
                        <th class="p-3">Nom</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Rôle</th>
                        <th class="p-3">Service</th>
                        <th class="p-3">Mot de passe</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($utilisateurs as $utilisateur)
                        <tr class="border-b align-top">
                            <td class="p-3">{{ $utilisateur->name }}</td>
                            <td class="p-3">{{ $utilisateur->email }}</td>
                            <td class="p-3">
                                @if($utilisateur->id === auth()->id())
                                    <span class="text-gray-500">{{ $utilisateur->role }} (toi)</span>
                                @else
                                    <form method="POST" action="{{ route('admin.utilisateurs.updateRole', $utilisateur) }}" class="flex gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" class="border rounded px-2 py-1 text-sm">
                                            <option value="utilisateur" @selected($utilisateur->role === 'utilisateur')>Utilisateur</option>
                                            <option value="moderateur" @selected($utilisateur->role === 'moderateur')>Modérateur</option>
                                            <option value="administrateur" @selected($utilisateur->role === 'administrateur')>Administrateur</option>
                                        </select>
                                        <button type="submit" class="bg-acep-dark hover:bg-acep-dark/90 text-white px-3 py-1 rounded text-sm">OK</button>
                                    </form>
                                @endif
                            </td>
                            <td class="p-3">
                                <form method="POST" action="{{ route('admin.utilisateurs.updateService', $utilisateur) }}" class="flex gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="service_id" class="border rounded px-2 py-1 text-sm">
                                        <option value="">Aucun</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}" @selected($utilisateur->service_id === $service->id)>{{ $service->nom }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="bg-acep-dark hover:bg-acep-dark/90 text-white px-3 py-1 rounded text-sm">OK</button>
                                </form>
                            </td>
                            <td class="p-3">
                                @if($utilisateur->id === auth()->id())
                                    <span class="text-gray-500 text-sm">Change-le depuis ton profil</span>
                                @else
                                    <form method="POST" action="{{ route('admin.utilisateurs.resetPassword', $utilisateur) }}" class="flex gap-2" onsubmit="return confirm('Réinitialiser le mot de passe de {{ $utilisateur->name }} ?');">
                                        @csrf
                                        @method('PATCH')
                                        <input type="password" name="password" placeholder="Nouveau mot de passe" minlength="8" class="border rounded px-2 py-1 text-sm" required>
                                        <button type="submit" class="bg-acep-dark hover:bg-acep-dark/90 text-white px-3 py-1 rounded text-sm">Réinitialiser</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>