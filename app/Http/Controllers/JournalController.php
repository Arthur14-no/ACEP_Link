<?php

namespace App\Http\Controllers;

use App\Models\Journal;

class JournalController extends Controller
{
    public function index()
    {
        $journaux = Journal::with('utilisateur')->latest('created_at')->paginate(30);
        return view('admin.journal.index', compact('journaux'));
    }
}