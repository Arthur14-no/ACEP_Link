<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\Salon;
use App\Models\User;
use Illuminate\Http\Request;

class SalonMembreController extends Controller
{
    public function index(Salon $salon)
    {
        $membres = $salon->membres()->orderBy('name')->get();
        $autresUtilisateurs = User::whereNotIn('id', $membres->pluck('id'))->orderBy('name')->get();

        return view('admin.salons.membres', compact('salon', 'membres', 'autresUtilisateurs'));
    }

    public function store(Request $request, Salon $salon)
    {
        $validated = $request->validate(['user_id' => 'required|exists:users,id']);

        $salon->membres()->syncWithoutDetaching([$validated['user_id']]);

        Journal::enregistrer('ajout_membre_salon', "Membre ajouté au salon privé \"{$salon->nom}\"");

        return back()->with('success', 'Membre ajouté.');
    }

    public function destroy(Salon $salon, User $utilisateur)
    {
        $salon->membres()->detach($utilisateur->id);

        Journal::enregistrer('retrait_membre_salon', "Membre retiré du salon privé \"{$salon->nom}\"");

        return back()->with('success', 'Membre retiré.');
    }
}