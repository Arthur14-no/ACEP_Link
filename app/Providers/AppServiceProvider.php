<?php

namespace App\Providers;

use App\Models\Journal;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Event::listen(Login::class, function (Login $event) {
            Journal::create([
                'user_id' => $event->user->id,
                'action' => 'connexion',
                'description' => $event->user->name . " s'est connecté.",
            ]);
        });

        Event::listen(Logout::class, function (Logout $event) {
            if ($event->user) {
                Journal::create([
                    'user_id' => $event->user->id,
                    'action' => 'deconnexion',
                    'description' => $event->user->name . " s'est déconnecté.",
                ]);
            }
        });

        Event::listen(Failed::class, function (Failed $event) {
            Journal::create([
                'user_id' => $event->user?->id,
                'action' => 'echec_connexion',
                'description' => 'Tentative de connexion échouée pour : ' . ($event->credentials['email'] ?? 'inconnu'),
            ]);
        });
    }
}