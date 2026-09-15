<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $utilisateurs = User::with('service')->orderBy('name')->get();
        $services = Service::orderBy('nom')->get();
        return view('admin.utilisateurs.index', compact('utilisateurs', 'services'));
    }

    public function updateRole(Request $request, User $utilisateur)
    {
        if ($utilisateur->id === auth()->id()) {
            return back()->with('error', 'Tu ne peux pas modifier ton propre rôle.');
        }

        $validated = $request->validate([
            'role' => 'required|in:utilisateur,moderateur,administrateur',
        ]);

        $ancienRole = $utilisateur->role;
        $utilisateur->update(['role' => $validated['role']]);

        Journal::enregistrer('changement_role', "Rôle de {$utilisateur->name} changé de \"{$ancienRole}\" à \"{$validated['role']}\"");

        return back()->with('success', 'Rôle mis à jour pour ' . $utilisateur->name . '.');
    }

    public function updateService(Request $request, User $utilisateur)
    {
        $validated = $request->validate([
            'service_id' => 'nullable|exists:services,id',
        ]);

        $utilisateur->update(['service_id' => $validated['service_id']]);

        Journal::enregistrer('changement_service', "Service de {$utilisateur->name} mis à jour");

        return back()->with('success', 'Service mis à jour pour ' . $utilisateur->name . '.');
    }

    public function resetPassword(Request $request, User $utilisateur)
    {
        $validated = $request->validate([
            'password' => 'required|string|min:8',
        ]);

        // Le cast 'hashed' sur le modèle User se charge du hachage automatiquement
        $utilisateur->update(['password' => $validated['password']]);

        Journal::enregistrer('reinitialisation_mot_de_passe', "Mot de passe réinitialisé pour {$utilisateur->name} par un administrateur");

        return back()->with('success', 'Mot de passe réinitialisé pour ' . $utilisateur->name . '.');
    }
}