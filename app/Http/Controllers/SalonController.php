<?php

namespace App\Http\Controllers;

use App\Models\Journal;
use App\Models\Salon;
use App\Models\Service;
use App\Models\VueSalon;
use Illuminate\Http\Request;

class SalonController extends Controller
{
    public function index()
    {
        $salons = Salon::with('service')
            ->withMax('messages as dernier_message_a', 'created_at')
            ->get()
            ->filter(fn ($salon) => $salon->estVisiblePour(auth()->user()))
            ->values();

        $vues = VueSalon::where('user_id', auth()->id())->pluck('vu_a', 'salon_id');

        $salons->each(function ($salon) use ($vues) {
            $vu = $vues->get($salon->id);
            $salon->non_lu = $salon->dernier_message_a && (!$vu || $salon->dernier_message_a > $vu);
        });

        return view('salons.index', compact('salons'));
    }

    public function create()
    {
        $services = Service::orderBy('nom')->get();
        return view('salons.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'visibilite' => 'required|in:public,public_lecture_seule,prive',
            'service_id' => 'nullable|exists:services,id',
            'description' => 'nullable|string',
        ]);

        $salon = Salon::create([...$validated, 'cree_par' => auth()->id()]);

        Journal::enregistrer('creation_salon', "Salon \"{$salon->nom}\" créé ({$salon->visibilite})");

        return redirect()->route('salons.index')->with('success', 'Salon créé.');
    }

    public function show(Salon $salon)
    {
        if (!$salon->estVisiblePour(auth()->user())) {
            abort(403, "Tu n'as pas accès à ce salon.");
        }

        $messages = $salon->messages()->with(['expediteur', 'document'])->latest()->get()->reverse();

        VueSalon::updateOrCreate(
            ['user_id' => auth()->id(), 'salon_id' => $salon->id],
            ['vu_a' => now()]
        );

        return view('salons.show', compact('salon', 'messages'));
    }
}