<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ACEP Link</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white text-gray-800">
    <div class="min-h-screen flex flex-col">
        <header class="flex items-center justify-between px-6 py-5 sm:px-10">
            <img src="{{ asset('images/logo-acep2.png') }}" alt="ACEP" class="h-8">

            @if (Route::has('login'))
                <nav class="flex items-center gap-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-acep-dark hover:underline">Tableau de bord</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-acep-dark">Se connecter</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-acep-dark hover:bg-acep-dark/90 text-white text-sm font-medium px-4 py-2 rounded-md">S'inscrire</a>
                        @endif
                    @endauth
                </nav>
            @endif
        </header>

        <main class="flex-1 flex items-center justify-center px-6">
            <div class="text-center max-w-xl">
                <img src="{{ asset('images/logo-acep.png') }}" alt="ACEP Link" class="h-16 mx-auto mb-8">
                <h1 class="text-3xl sm:text-4xl font-bold text-acep-dark mb-4">WELCOME !</h1>
                <p class="text-gray-500 text-lg">
                    La messagerie interne sécurisée d'ACEP Cameroun — salons, messagerie privée
                    et documents, réunis en un seul endroit.
                </p>
            </div>
        </main>

        <footer class="text-center text-xs text-gray-400 py-6">
            ACEP Cameroun X Arthur14
        </footer>
    </div>
</body>
</html>