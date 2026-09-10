<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-bold text-xl text-slate-900 leading-tight">
                    {{ __('Izlanuvchi paneli') }}
                </h1>
                <p class="text-xs text-slate-500 mt-1">Arizalaringiz va bosqichlar ijrosi monitoringi</p>
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

            <!-- Hero Welcome Card -->
            <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-900 via-indigo-800 to-blue-800 text-white p-6 sm:p-8 shadow-xl shadow-indigo-900/20">
                <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div class="max-w-xl">
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-white/15 backdrop-blur-md text-amber-200 mb-3 border border-white/10">
                            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                            O'zbekiston Respublikasi IIV Kriminologiya tadqiqot instituti
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-bold tracking-tight">Xush kelibsiz, {{ Auth::user()->full_name }}!</h2>
                        <p class="text-sm text-indigo-100 mt-2 leading-relaxed">
                            Kriminologiya tadqiqot institutida mustaqil izlanuvchilik va ilmiy daraja arizalaringizning har bir bosqichini onlayn kuzatib boring, ilmiy hujjatlarni yuklang va ekspert xulosalarini qabul qiling.
                        </p>
                    </div>

                    @php
                        $total = $projects->count();
                        $inProgress = $projects->where('status', 'jarayonda')->count();
                        $finished = $projects->where('status', 'yakunlangan')->count();
                    @endphp

                    <div class="grid grid-cols-3 gap-3 shrink-0">
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 text-center border border-white/15">
                            <p class="text-xs text-indigo-100">Jami</p>
                            <p class="text-2xl font-bold mt-0.5">{{ $total }}</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 text-center border border-white/15">
                            <p class="text-xs text-indigo-100">Jarayonda</p>
                            <p class="text-2xl font-bold mt-0.5 text-amber-300">{{ $inProgress }}</p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-4 text-center border border-white/15">
                            <p class="text-xs text-indigo-100">Yakunlangan</p>
                            <p class="text-2xl font-bold mt-0.5 text-emerald-300">{{ $finished }}</p>
                        </div>
                    </div>
                </div>

                <!-- Institute logo watermark in hero card background -->
                <div class="absolute -right-6 -bottom-6 w-56 h-56 rounded-full overflow-hidden opacity-10 pointer-events-none">
                    <img src="{{ asset('logo/photo_2025-09-03_15-19-21.jpg') }}" alt="Watermark" class="w-full h-full object-cover" />
                </div>
            </div>

            <!-- Projects Grid Section -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-lg text-slate-900">Mening ilmiy loyihalarim</h3>
                    <span class="text-xs text-slate-500">{{ $projects->count() }} ta ariza</span>
                </div>

                @if ($projects->isEmpty())
                    <div class="bg-white rounded-3xl border border-slate-200/80 p-12 text-center max-w-xl mx-auto shadow-xs">
                        <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h4 class="text-base font-bold text-slate-800">Sizda hali loyihalar mavjud emas</h4>
                        <p class="text-sm text-slate-500 mt-1 max-w-sm mx-auto">
                            Yangi ilmiy daraja olish yoki arizani ro'yxatdan o'tkazish uchun yangi ariza topshiring.
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
                                            <h4 class="font-bold text-base text-slate-900 group-hover:text-indigo-600 transition-colors">{{ $project->applicationType->name }}</h4>
                                            <p class="text-xs text-slate-400 mt-0.5">Yaratilgan sana: {{ $project->created_at->format('d.m.Y') }}</p>
                                        </div>
                                    </div>
                                    <x-status-badge :status="$project->status" />
                                </div>

                                <div class="mt-4 pt-4 border-t border-slate-100">
                                    <div class="flex items-center justify-between text-xs text-slate-500 mb-2">
                                        <span class="font-medium">Umumiy bajarilish darajasi:</span>
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
                                        Bosqichlarni ko'rish
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
    </div>
</x-app-layout>
