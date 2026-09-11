<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class PrivateMessageController extends Controller
{
    public function index()
    {
        $utilisateurs = User::where('id', '!=', auth()->id())->orderBy('name')->get();
        return view('messages.index', compact('utilisateurs'));
    }

    public function show(User $utilisateur)
    {
        $messages = $this->conversation($utilisateur)->with(['expediteur', 'document'])->oldest()->get();
        return view('messages.show', compact('utilisateur', 'messages'));
    }

    public function store(Request $request, User $utilisateur)
    {
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

        Message::create([
            'contenu' => $validated['contenu'] ?? '',
            'expediteur_id' => auth()->id(),
            'destinataire_id' => $utilisateur->id,
            'document_id' => $documentId,
        ]);

        return back();
    }

    public function nouveaux(Request $request, User $utilisateur)
    {
        $dernierId = $request->query('apres', 0);

        $messages = $this->conversation($utilisateur)
            ->where('id', '>', $dernierId)
            ->with(['expediteur', 'document'])
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

    private function conversation(User $utilisateur)
    {
        return Message::where(function ($query) use ($utilisateur) {
            $query->where(function ($q) use ($utilisateur) {
                    $q->where('expediteur_id', auth()->id())
                      ->where('destinataire_id', $utilisateur->id);
                })
                ->orWhere(function ($q) use ($utilisateur) {
                    $q->where('expediteur_id', $utilisateur->id)
                      ->where('destinataire_id', auth()->id());
                });
        });
    }
}