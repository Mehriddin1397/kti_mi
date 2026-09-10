<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Kriminologiya tadqiqot instituti') }} — Mustaqil izlanuvchilar tizimi</title>
        <link rel="icon" type="image/jpeg" href="{{ asset('logo/photo_2025-09-03_15-19-21.jpg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-800 min-h-full flex flex-col selection:bg-indigo-500 selection:text-white">
        <div class="min-h-screen flex flex-col">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white/80 backdrop-blur-sm border-b border-slate-200/80 sticky top-16 z-20">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1 pb-16">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
                    @if (session('status'))
                        <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms class="mb-6 rounded-2xl bg-emerald-50 border border-emerald-200/80 p-4 shadow-xs flex items-center justify-between gap-3 text-emerald-900">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div class="text-sm font-medium">
                                    {{ session('status') }}
                                </div>
                            </div>
                            <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 p-1 rounded-lg hover:bg-emerald-100/60 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms class="mb-6 rounded-2xl bg-rose-50 border border-rose-200/80 p-4 shadow-xs flex items-center justify-between gap-3 text-rose-900">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                </div>
                                <div class="text-sm font-medium">
                                    {{ session('error') }}
                                </div>
                            </div>
                            <button @click="show = false" class="text-rose-500 hover:text-rose-700 p-1 rounded-lg hover:bg-rose-100/60 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>

                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="mt-auto bg-white border-t border-slate-200/80 py-6 text-slate-500 text-xs">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('logo/photo_2025-09-03_15-19-21.jpg') }}" alt="Logo" class="w-7 h-7 rounded-full ring-1 ring-amber-500/30" />
                        <div>
                            <span class="font-bold text-slate-800">O'zbekiston Respublikasi IIV Kriminologiya tadqiqot instituti</span>
                            <span class="hidden sm:inline text-slate-400 mx-1.5">&bull;</span>
                            <span class="block sm:inline text-slate-500">Mustaqil izlanuvchilar axborot tizimi</span>
                        </div>
                    </div>
                    <div class="text-slate-400 font-mono">
                        &copy; {{ date('Y') }} Barcha huquqlar himoyalangan.
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
