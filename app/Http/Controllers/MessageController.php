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
}