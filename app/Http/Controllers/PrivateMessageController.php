<?php

namespace App\Http\Controllers;

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
        $messages = $this->conversation($utilisateur)->with('expediteur')->oldest()->get();
        return view('messages.show', compact('utilisateur', 'messages'));
    }

    public function store(Request $request, User $utilisateur)
    {
        $validated = $request->validate(['contenu' => 'required|string|max:2000']);

        Message::create([
            'contenu' => $validated['contenu'],
            'expediteur_id' => auth()->id(),
            'destinataire_id' => $utilisateur->id,
        ]);

        return back();
    }

    public function nouveaux(Request $request, User $utilisateur)
    {
        $dernierId = $request->query('apres', 0);

        $messages = $this->conversation($utilisateur)
            ->where('id', '>', $dernierId)
            ->with('expediteur')
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

    private function conversation(User $utilisateur)
    {
        // Tout regroupé dans UN SEUL where() pour que les ->where() enchaînés
        // ensuite (comme le filtre "id > dernierId") s'appliquent bien à
        // l'ensemble du groupe OR, et pas juste à sa seconde moitié.
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