<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Salon;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request, Salon $salon)
    {
        if (!$salon->peutEcrire(auth()->user())) {
            abort(403, "Tu ne peux pas écrire dans ce salon.");
        }

        $validated = $request->validate([
            'contenu' => 'nullable|string|max:2000',
            'fichier' => 'nullable|file|max:10240',
        ]);

        if (empty($validated['contenu']) && !$request->hasFile('fichier')) {
            return back()->withErrors(['contenu' => 'Écris un message ou joins un fichier.']);
        }

        $documentId = null;

        if ($request->hasFile('fichier')) {
            $fichier = $request->file('fichier');
            $chemin = $fichier->store('documents', 'local');

            $document = Document::create([
                'nom_original' => $fichier->getClientOriginalName(),
                'chemin' => $chemin,
                'type_mime' => $fichier->getClientMimeType(),
                'taille' => $fichier->getSize(),
                'depose_par' => auth()->id(),
            ]);

            $documentId = $document->id;
        }

        $salon->messages()->create([
            'contenu' => $validated['contenu'] ?? '',
            'expediteur_id' => auth()->id(),
            'document_id' => $documentId,
        ]);

        return back();
    }

    public function nouveaux(Request $request, Salon $salon)
    {
        if (!$salon->estVisiblePour(auth()->user())) {
            abort(403, "Tu n'as pas accès à ce salon.");
        }

        $dernierId = $request->query('apres', 0);

        $messages = $salon->messages()
            ->with(['expediteur', 'document'])
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
                    'document' => $message->document ? [
                        'nom' => $message->document->nom_original,
                        'url' => route('documents.download', $message->document),
                    ] : null,
                ];
            })
        );
    }
}