<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'ACEP Link') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex bg-gray-50" x-data="{ sidebarOuverte: false }">
        @include('layouts.navigation')

        <div x-show="sidebarOuverte" @click="sidebarOuverte = false" x-cloak class="fixed inset-0 bg-black/40 z-20 lg:hidden"></div>

        <div class="flex-1 flex flex-col min-w-0">
            <div class="lg:hidden flex items-center justify-between bg-acep-dark text-white px-4 py-3">
                <button @click="sidebarOuverte = true" class="p-1">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <span class="font-semibold">ACEP Link</span>
                <div class="w-6"></div>
            </div>

            @if (isset($header))
                <header class="bg-white border-b">
                    <div class="max-w-5xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main class="flex-1 overflow-y-auto">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>