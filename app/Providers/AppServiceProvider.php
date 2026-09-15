<?php

namespace App\Providers;

use App\Models\Journal;
use App\Models\Message;
use App\Models\Salon;
use App\Models\VueSalon;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;
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

        View::composer('layouts.navigation', function ($vue) {
            if (!auth()->check()) {
                return;
            }

            $messagesNonLus = Message::where('destinataire_id', auth()->id())
                ->whereNull('lu_a')
                ->count();

            $salons = Salon::withMax('messages as dernier_message_a', 'created_at')->get();
            $vues = VueSalon::where('user_id', auth()->id())->pluck('vu_a', 'salon_id');

            $salonsNonLus = $salons->filter(function ($salon) use ($vues) {
                if (!$salon->dernier_message_a) {
                    return false;
                }
                $vu = $vues->get($salon->id);
                return !$vu || $salon->dernier_message_a > $vu;
            })->count();

            $vue->with(compact('messagesNonLus', 'salonsNonLus'));
        });
    }
}