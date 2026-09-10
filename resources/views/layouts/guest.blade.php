<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Kriminologiya tadqiqot instituti') }} — Tizimga kirish</title>
        <link rel="icon" type="image/jpeg" href="{{ asset('logo/photo_2025-09-03_15-19-21.jpg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-100/80 text-slate-800 min-h-full flex flex-col justify-center relative selection:bg-indigo-500 selection:text-white py-10">
        <!-- Background decorative elements -->
        <div class="fixed inset-0 pointer-events-none overflow-hidden -z-10">
            <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full bg-indigo-200/40 blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 rounded-full bg-amber-200/30 blur-3xl"></div>
        </div>

        <div class="w-full max-w-md mx-auto px-4">
            <!-- Brand Header -->
            <div class="flex flex-col items-center text-center mb-6">
                <a href="/" class="focus:outline-none focus:ring-4 focus:ring-amber-500/20 rounded-full transition-transform hover:scale-105 duration-200">
                    <div class="w-20 h-20 rounded-full overflow-hidden ring-4 ring-white shadow-xl shadow-slate-300/60 bg-white p-0.5">
                        <img src="{{ asset('logo/photo_2025-09-03_15-19-21.jpg') }}" alt="Kriminologiya tadqiqot instituti logosi" class="w-full h-full object-cover rounded-full" />
                    </div>
                </a>
                <span class="text-xs font-semibold text-indigo-700 tracking-wider uppercase mt-3.5">
                    O'zbekiston Respublikasi IIV
                </span>
                <h1 class="font-bold text-lg text-slate-900 leading-snug mt-0.5">
                    Kriminologiya tadqiqot instituti
                </h1>
                <p class="text-xs text-slate-500">
                    Mustaqil izlanuvchilar monitoring axborot tizimi
                </p>
            </div>

            <!-- Card Box -->
            <div class="bg-white/95 backdrop-blur-md rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-200/50 p-7 sm:p-9">
                {{ $slot }}
            </div>

            <div class="mt-8 text-center text-xs text-slate-400">
                O'zbekiston Respublikasi IIV Kriminologiya tadqiqot instituti &copy; {{ date('Y') }}
            </div>
        </div>
    </body>
</html>
