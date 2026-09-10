<?php

namespace App\Http\Controllers;

use App\Models\Salon;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request, Salon $salon)
    {
        $validated = $request->validate(['contenu' => 'required|string|max:2000']);

        $salon->messages()->create([
            'contenu' => $validated['contenu'],
            'expediteur_id' => auth()->id(),
        ]);

        return back();
    }

    public function nouveaux(Request $request, Salon $salon)
    {
        $dernierId = $request->query('apres', 0);

        $messages = $salon->messages()
            ->with('expediteur')
            ->where('id', '>', $dernierId)
            ->oldest()
            ->get();

        return response()->json(
            $messages->map(function ($message) {
                return [
                    'id' => $message->id,
                    'auteur' => $message->expediteur->name,
                    'contenu' => $message->contenu,
                    'heure' => $message->created_at->format('H:i'),
                ];
            })
        );
    }
}