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
    <body class="font-sans antialiased bg-slate-900 text-slate-800 min-h-full flex flex-col justify-center relative selection:bg-indigo-500 selection:text-white py-10">
        <!-- Institut muhiti: bino, hovli va zal fotolari asta almashadigan fon -->
        <div class="site-bg-slideshow" aria-hidden="true">
            <div class="site-bg-slide" style="background-image: url('{{ asset('img/building-day.jpg') }}');"></div>
            <div class="site-bg-slide" style="background-image: url('{{ asset('img/courtyard.jpg') }}');"></div>
            <div class="site-bg-slide" style="background-image: url('{{ asset('img/hall.jpg') }}');"></div>
            <div class="site-bg-slide" style="background-image: url('{{ asset('img/building-night.jpg') }}');"></div>
            <div class="site-bg-overlay site-bg-overlay--dark"></div>
            <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full bg-indigo-500/20 blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 rounded-full bg-amber-400/10 blur-3xl"></div>
        </div>

        <div class="w-full max-w-md mx-auto px-4">
            <!-- Brand Header -->
            <div class="flex flex-col items-center text-center mb-6">
                <a href="/" class="focus:outline-none focus:ring-4 focus:ring-amber-500/30 rounded-full transition-transform hover:scale-105 duration-200">
                    <div class="w-24 h-24 rounded-full overflow-hidden ring-4 ring-white/90 shadow-xl shadow-black/30 bg-white p-1">
                        <img src="{{ asset('img/logo-seal.jpg') }}" alt="Kriminologiya tadqiqot instituti logosi" class="w-full h-full object-cover rounded-full" />
                    </div>
                </a>
                <span class="text-sm font-semibold text-amber-300 tracking-wider uppercase mt-4">
                    O'zbekiston Respublikasi IIV
                </span>
                <h1 class="font-bold text-2xl text-white leading-snug mt-1 drop-shadow-sm">
                    Kriminologiya tadqiqot instituti
                </h1>
                <p class="text-sm text-slate-200">
                    Mustaqil izlanuvchilar monitoring axborot tizimi
                </p>
            </div>

            <!-- Card Box -->
            <div class="bg-white/97 backdrop-blur-md rounded-3xl border border-white/50 shadow-2xl shadow-black/40 p-7 sm:p-9">
                {{ $slot }}
            </div>

            <div class="mt-8 text-center text-sm text-slate-300">
                O'zbekiston Respublikasi IIV Kriminologiya tadqiqot instituti &copy; {{ date('Y') }}
            </div>
        </div>
    </body>
</html>
