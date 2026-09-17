<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-bold text-xl text-slate-900 leading-tight">
                    {{ __('Mas\'ul xodim ish stoli') }}
                </h1>
                <p class="text-xs text-slate-500 mt-1">Kriminologiya tadqiqot instituti — Ekspertiza va vazifalar monitoringi</p>
            </div>
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-indigo-50 border border-indigo-100 text-xs font-semibold text-indigo-700">
                <span class="w-2 h-2 rounded-full bg-indigo-600 animate-pulse"></span>
                <span>Mas'ul ekspert: {{ Auth::user()->full_name }}</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto space-y-6">

            <!-- Institute Hero Banner -->
            <div class="relative overflow-hidden rounded-3xl text-white p-6 sm:p-8 shadow-xl shadow-slate-900/20 bg-institute-photo" style="background-image: url('{{ asset('img/hall.jpg') }}');">
                <div class="absolute inset-0 bg-gradient-to-r from-indigo-950/90 via-slate-900/75 to-slate-900/40"></div>
                <div class="relative z-10 flex items-center gap-4">
                    <img src="{{ asset('img/logo-seal.jpg') }}" alt="Institut logosi" class="w-14 h-14 sm:w-16 sm:h-16 rounded-full ring-2 ring-white/50 shadow-lg bg-white p-0.5 shrink-0" />
                    <div>
                        <span class="text-xs sm:text-sm font-semibold text-amber-300 uppercase tracking-wider">O'zbekiston Respublikasi IIV</span>
                        <h2 class="text-xl sm:text-2xl font-bold tracking-tight">Kriminologiya tadqiqot instituti — Ekspertiza bo'limi</h2>
                    </div>
                </div>
            </div>

            <!-- Stats Overview Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-white rounded-3xl border border-slate-200/80 p-5 shadow-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-slate-500">Tekshirish kutilmoqda</span>
                        <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-amber-600 mt-2">{{ $counts['jarayonda'] }}</p>
                    <p class="text-xs text-slate-400 mt-1">Hujjat yuklangan, ko'rib chiqish kerak</p>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200/80 p-5 shadow-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-slate-500">Hujjat kutilmoqda</span>
                        <div class="w-8 h-8 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-slate-800 mt-2">{{ $counts['kutilmoqda'] }}</p>
                    <p class="text-xs text-slate-400 mt-1">Izlanuvchi yuklashi lozim</p>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200/80 p-5 shadow-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-slate-500">Qaytarilganlar</span>
                        <div class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-rose-600 mt-2">{{ $counts['qaytarildi'] }}</p>
                    <p class="text-xs text-slate-400 mt-1">Kamchiliklar bilan qaytarilgan</p>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200/80 p-5 shadow-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-slate-500">Tasdiqlangan</span>
                        <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-2xl font-bold text-emerald-600 mt-2">{{ $counts['tasdiqlandi'] }}</p>
                    <p class="text-xs text-slate-400 mt-1">Muvaffaqiyatli qabul qilingan</p>
                </div>
            </div>

            <!-- Filter Tabs -->
            <div class="flex flex-wrap items-center gap-2">
                @php
                    $allTotal = array_sum($counts);
                @endphp
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold transition {{ !$currentStatus ? 'bg-indigo-600 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200/80' }}">
                    <span>Barchasi</span>
                    <span class="px-1.5 py-0.5 rounded-full text-xs {{ !$currentStatus ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-700' }}">{{ $allTotal }}</span>
                </a>
                @foreach (['jarayonda' => 'Jarayonda (Tekshirish)', 'kutilmoqda' => 'Hujjat kutilmoqda', 'qaytarildi' => 'Qaytarildi', 'tasdiqlandi' => 'Tasdiqlandi'] as $key => $label)
                    <a href="{{ route('dashboard', ['status' => $key]) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold transition {{ $currentStatus === $key ? 'bg-indigo-600 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200/80' }}">
                        <span>{{ $label }}</span>
                        <span class="px-1.5 py-0.5 rounded-full text-xs {{ $currentStatus === $key ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-700' }}">{{ $counts[$key] }}</span>
                    </a>
                @endforeach
            </div>

            <!-- Tasks Table -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                        <thead class="bg-slate-50/80">
                            <tr>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Vazifa va bosqich</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Izlanuvchi</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Loyiha turi</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Holat</th>
                                <th class="px-6 py-3.5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Amal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($tasks as $task)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-slate-800 text-sm">{{ $task->name }}</div>
                                        <div class="text-xs text-slate-400 mt-0.5 flex items-center gap-1">
                                            <span>Bosqich:</span>
                                            <span class="text-slate-600 font-medium">{{ $task->stage->name }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-700 font-semibold text-xs flex items-center justify-center shrink-0">
                                                {{ mb_substr($task->stage->project->user->full_name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-medium text-slate-800 text-xs">{{ $task->stage->project->user->full_name }}</div>
                                                <div class="font-mono text-xs text-slate-400 mt-0.5">{{ $task->stage->project->phone }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-xs text-slate-600 font-medium">{{ $task->stage->project->applicationType->name }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-status-badge :status="$task->status" />
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('projects.show', $task->stage->project) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-indigo-50 hover:bg-indigo-600 text-indigo-700 hover:text-white text-xs font-semibold transition shadow-2xs">
                                            <span>Ko'rib chiqish</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                        <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-2 text-slate-400">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>
                                        <p class="text-sm font-medium text-slate-600">Ushbu holat bo'yicha vazifalar topilmadi</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($tasks->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $tasks->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
