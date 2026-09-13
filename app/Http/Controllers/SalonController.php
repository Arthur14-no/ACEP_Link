<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\Salon;
use Illuminate\Http\Request;

class SalonController extends Controller
{
    public function index()
    {
        $salons = Salon::latest()->get();
        return view('salons.index', compact('salons'));
    }

    public function create()
    {
        return view('salons.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'service' => 'nullable|string|max:100',
            'description' => 'nullable|string',
        ]);

        $salon = Salon::create([...$validated, 'cree_par' => auth()->id()]);

        Journal::enregistrer('creation_salon', "Salon \"{$salon->nom}\" créé");

        return redirect()->route('salons.index')->with('success', 'Salon créé.');
    }

    public function show(Salon $salon)
    {
        $messages = $salon->messages()->with('expediteur')->latest()->get()->reverse();
        return view('salons.show', compact('salon', 'messages'));
    }
}