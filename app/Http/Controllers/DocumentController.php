<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::with('deposant')
            ->whereDoesntHave('message', function ($query) {
                $query->whereNotNull('destinataire_id');
            })
            ->latest()
            ->get();

        return view('documents.index', compact('documents'));
    }

    public function create()
    {
        return view('documents.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fichier' => 'required|file|max:10240|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg',
        ]);

        $fichier = $request->file('fichier');
        $cheminStocke = $fichier->store('documents', 'local');

        $document = Document::create([
            'nom_original' => $fichier->getClientOriginalName(),
            'chemin' => $cheminStocke,
            'type_mime' => $fichier->getClientMimeType(),
            'taille' => $fichier->getSize(),
            'depose_par' => auth()->id(),
        ]);

        return redirect()->route('documents.index')->with('success', 'Document déposé avec succès.');
    }

    public function download(Document $document)
    {
        $message = Message::where('document_id', $document->id)->first();

        if ($message) {
            if ($message->destinataire_id) {
                $autorise = in_array(auth()->id(), [$message->expediteur_id, $message->destinataire_id])
                    || auth()->user()->role === 'administrateur';

                if (!$autorise) {
                    abort(403, 'Accès non autorisé à ce document.');
                }
            } elseif ($message->salon_id) {
                if (!$message->salon->estVisiblePour(auth()->user())) {
                    abort(403, 'Accès non autorisé à ce document.');
                }
            }
        }

        return Storage::disk('local')->download($document->chemin, $document->nom_original);
    }

    public function destroy(Document $document)
    {
        if ($document->depose_par !== auth()->id() && !in_array(auth()->user()->role, ['administrateur', 'moderateur'])) {
            abort(403, 'Action non autorisée.');
        }

        Storage::disk('local')->delete($document->chemin);
        $document->delete();

        return back()->with('success', 'Document supprimé.');
    }
}