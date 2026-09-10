<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-bold text-xl text-slate-900 leading-tight">
                    {{ __('Mening loyihalarim') }}
                </h1>
                <p class="text-xs text-slate-500 mt-1">Barcha topshirilgan arizalar va ularning ijro holati</p>
            </div>
            <a href="{{ route('apply.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-medium text-sm rounded-xl shadow-xs shadow-indigo-500/20 hover:shadow-md transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Yangi ariza topshirish</span>
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto space-y-6">
            @if ($projects->isEmpty())
                <div class="bg-white rounded-3xl border border-slate-200/80 p-12 text-center max-w-xl mx-auto shadow-xs">
                    <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-800">Sizda hali loyihalar mavjud emas</h3>
                    <p class="text-sm text-slate-500 mt-1 max-w-sm mx-auto">
                        Ilmiy daraja olish yoki tadqiqotni ro'yxatdan o'tkazish uchun yangi ariza topshiring.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('apply.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-xl shadow-xs transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Ariza topshirish
                        </a>
                    </div>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @foreach ($projects as $project)
                        <a href="{{ route('projects.show', $project) }}" class="group block bg-white rounded-3xl border border-slate-200/80 p-6 shadow-xs hover:shadow-lg hover:shadow-indigo-500/5 hover:border-indigo-200 transition-all duration-200 relative overflow-hidden">
                            <div class="flex items-start justify-between gap-3 mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-base text-slate-900 group-hover:text-indigo-600 transition-colors">{{ $project->applicationType->name }}</h3>
                                        <p class="text-xs text-slate-400 mt-0.5">Topshirilgan: {{ $project->created_at->format('d.m.Y') }}</p>
                                    </div>
                                </div>
                                <x-status-badge :status="$project->status" />
                            </div>

                            <div class="mt-4 pt-4 border-t border-slate-100">
                                <div class="flex items-center justify-between text-xs text-slate-500 mb-2">
                                    <span class="font-medium">Ijro jarayoni:</span>
                                </div>
                                <x-progress-bar :percent="$project->progress_percent" />
                            </div>

                            <div class="mt-5 flex items-center justify-between pt-3 border-t border-slate-100 text-xs font-semibold text-indigo-600 group-hover:text-indigo-700">
                                <span class="inline-flex items-center gap-1.5 text-slate-500 font-normal">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    {{ $project->stages->count() }} ta bosqich
                                </span>
                                <span class="inline-flex items-center gap-1 group-hover:translate-x-0.5 transition-transform">
                                    Bosqichlar va vazifalar
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
