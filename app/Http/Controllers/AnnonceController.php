<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Journal;
use Illuminate\Http\Request;

class AnnonceController extends Controller
{
    public function index()
    {
        $annonces = Annonce::with('auteur')->latest()->get();
        return view('annonces.index', compact('annonces'));
    }

    public function create()
    {
        return view('annonces.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:150',
            'contenu' => 'required|string',
        ]);

        $annonce = Annonce::create([...$validated, 'publie_par' => auth()->id()]);

        Journal::enregistrer('publication_annonce', "Annonce \"{$annonce->titre}\" publiée");

        return redirect()->route('annonces.index')->with('success', 'Annonce publiée.');
    }

    public function destroy(Annonce $annonce)
    {
        if (!in_array(auth()->user()->role, ['administrateur', 'moderateur'])) {
            abort(403, 'Action non autorisée.');
        }

        Journal::enregistrer('suppression_annonce', "Annonce \"{$annonce->titre}\" supprimée");

        $annonce->delete();

        return back()->with('success', 'Annonce supprimée.');
    }
}