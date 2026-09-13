<?php

namespace App\Http\Controllers;

use App\Models\Annonce;
use App\Models\Journal;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $derniereAnnonce = Annonce::with('auteur')->latest()->first();

        if (auth()->user()->role !== 'administrateur') {
            return view('dashboard', compact('derniereAnnonce'));
        }

        $statistiques = [
            'utilisateurs' => User::count(),
            'administrateurs' => User::where('role', 'administrateur')->count(),
            'actions_aujourdhui' => Journal::whereDate('created_at', today())->count(),
        ];

        $activiteParJour = Journal::selectRaw('DATE(created_at) as jour, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('jour')
            ->get()
            ->keyBy(fn ($ligne) => (string) $ligne->jour);

        $labels = [];
        $valeurs = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('d/m');
            $ligne = $activiteParJour->get($date);
            $valeurs[] = $ligne ? $ligne->total : 0;
        }

        $dernieresActions = Journal::with('utilisateur')->latest('created_at')->take(8)->get();
        $tentativesEchouees = Journal::where('action', 'echec_connexion')->latest('created_at')->take(5)->get();

        return view('dashboard', compact(
            'derniereAnnonce', 'statistiques', 'labels', 'valeurs', 'dernieresActions', 'tentativesEchouees'
        ));
    }
}