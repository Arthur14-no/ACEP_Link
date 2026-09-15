<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            'Haute Direction',
            'Pôle Audit Interne',
            'Direction Administrative et Financière',
            'Direction des Ressources Humaines',
            'Direction des Opérations',
            'Direction des Affaires Juridiques',
            "Direction des Systèmes d'Information",
            'Direction du Contrôle Opérationnel',
        ];

        foreach ($services as $nom) {
            Service::firstOrCreate(['nom' => $nom]);
        }
    }
}