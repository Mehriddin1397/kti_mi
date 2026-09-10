<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-bold text-xl text-slate-900 leading-tight">
                    {{ __('Boshqaruv paneli (Admin)') }}
                </h1>
                <p class="text-xs text-slate-500 mt-1">Kriminologiya tadqiqot instituti — Tizim statistikasi, arizalar oqimi va ma'muriy boshqaruv</p>
            </div>
            <div class="flex flex-wrap items-center gap-2.5">
                <a href="{{ route('admin.application-types.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow-xs transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Yangi ariza turi</span>
                </a>
                <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white hover:bg-slate-50 border border-slate-300 text-slate-700 text-xs font-semibold rounded-xl shadow-xs transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                    </svg>
                    <span>Foydalanuvchi</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto space-y-6">

            <!-- Stats Metric Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Total Projects -->
                <div class="bg-white rounded-3xl border border-slate-200/80 p-5 shadow-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-slate-500">Jami loyihalar</span>
                        <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-900 mt-2">{{ $totalProjects }}</p>
                    <div class="mt-2 flex items-center text-[11px] text-slate-400">
                        <span>Barcha topshirilgan ilmiy arizalar</span>
                    </div>
                </div>

                <!-- In Progress -->
                <div class="bg-white rounded-3xl border border-slate-200/80 p-5 shadow-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-slate-500">Jarayonda</span>
                        <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ $activeProjects }}</p>
                    <div class="mt-2 flex items-center text-[11px] text-slate-400">
                        <span>Ijro bosqichidagi arizalar</span>
                    </div>
                </div>

                <!-- Finished -->
                <div class="bg-white rounded-3xl border border-slate-200/80 p-5 shadow-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-slate-500">Yakunlangan</span>
                        <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-emerald-600 mt-2">{{ $finishedProjects }}</p>
                    <div class="mt-2 flex items-center text-[11px] text-slate-400">
                        <span>Muvaffaqiyatli yakunlangan</span>
                    </div>
                </div>

                <!-- Total Users -->
                <div class="bg-white rounded-3xl border border-slate-200/80 p-5 shadow-xs">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-medium text-slate-500">Foydalanuvchilar</span>
                        <div class="w-10 h-10 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-3xl font-bold text-slate-900 mt-2">{{ $totalUsers }}</p>
                    <div class="mt-2 flex items-center text-[11px] text-slate-400">
                        <span>Izlanuvchilar va xodimlar</span>
                    </div>
                </div>
            </div>

            <!-- Recent Projects Table -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="px-6 py-4.5 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h3 class="font-bold text-sm text-slate-900">So'nggi kelib tushgan arizalar</h3>
                        <p class="text-xs text-slate-400 mt-0.5">Yangi topshirilgan va ko'rilayotgan loyihalar</p>
                    </div>
                    <a href="{{ route('admin.projects.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 flex items-center gap-1">
                        <span>Barchasini ko'rish</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                        <thead class="bg-slate-50/80">
                            <tr>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Izlanuvchi</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Ariza turi</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Holat</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Progress</th>
                                <th class="px-6 py-3.5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Amal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($recentProjects as $project)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-xl bg-indigo-50 text-indigo-700 font-semibold text-xs flex items-center justify-center shrink-0">
                                                {{ mb_substr($project->user->full_name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-semibold text-slate-800 text-xs">{{ $project->user->full_name }}</div>
                                                <div class="font-mono text-[11px] text-slate-400 mt-0.5">{{ $project->phone }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-xs font-medium text-slate-700">{{ $project->applicationType->name }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-status-badge :status="$project->status" />
                                    </td>
                                    <td class="px-6 py-4 w-48">
                                        <x-progress-bar :percent="$project->progress_percent" />
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('projects.show', $project) }}" class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 hover:text-indigo-800">
                                            <span>Ko'rish</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-slate-400 text-sm">
                                        Hozircha loyihalar mavjud emas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
