<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $utilisateurs = User::orderBy('name')->get();
        return view('admin.utilisateurs.index', compact('utilisateurs'));
    }

    public function updateRole(Request $request, User $utilisateur)
    {
        if ($utilisateur->id === auth()->id()) {
            return back()->with('error', 'Tu ne peux pas modifier ton propre rôle.');
        }

        $validated = $request->validate([
            'role' => 'required|in:utilisateur,moderateur,administrateur',
        ]);

        $utilisateur->update(['role' => $validated['role']]);

        return back()->with('success', 'Rôle mis à jour pour ' . $utilisateur->name . '.');
    }
}