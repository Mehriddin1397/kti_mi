<div class="space-y-6">

    <!-- Project Overview Header Card -->
    <div class="bg-white rounded-3xl border border-slate-200/80 p-6 sm:p-8 shadow-xs relative overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div class="space-y-1">
                <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-full">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    Ilmiy loyiha kartasi
                </span>
                <h2 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">{{ $project->applicationType->name }}</h2>
                <div class="flex flex-wrap items-center gap-y-1 gap-x-4 text-xs text-slate-500 pt-1">
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Izlanuvchi: <strong class="text-slate-700">{{ $project->user->full_name }}</strong>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <span class="font-mono text-slate-700">{{ $project->phone }}</span>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Sana: {{ $project->created_at->format('d.m.Y') }}
                    </span>
                </div>
            </div>
            <div class="shrink-0">
                <x-status-badge :status="$project->status" class="text-sm px-3.5 py-1.5" />
            </div>
        </div>

        <div class="mt-6 pt-6 border-t border-slate-100">
            <div class="flex items-center justify-between text-xs font-semibold text-slate-700 mb-2">
                <span>Loyihaning umumiy bajarilishi</span>
                <span class="text-slate-500 font-normal">
                    @php
                        $allTasksCount = $project->stages->flatMap->tasks->count();
                        $completedTasksCount = $project->stages->flatMap->tasks->where('status', 'tasdiqlandi')->count();
                    @endphp
                    {{ $completedTasksCount }} / {{ $allTasksCount }} ta vazifa bajarildi
                </span>
            </div>
            <x-progress-bar :percent="$project->progress_percent" />
        </div>
    </div>

    <!-- Stepper / Stages List -->
    <div class="space-y-4">
        <div class="flex items-center justify-between px-1">
            <h3 class="font-bold text-lg sm:text-xl text-slate-900">Ilmiy bosqichlar va vazifalar ijrosi</h3>
            <span class="text-sm text-slate-400">{{ $project->stages->count() }} ta bosqich</span>
        </div>
        <p class="px-1 -mt-2 text-sm text-slate-500">
            Bosqichlar ketma-ket ochiladi: keyingi bosqichga hujjat yuklash uchun avvalgi bosqichning barcha vazifalari mas'ul xodim tomonidan tasdiqlanishi kerak.
        </p>

        @foreach ($project->stages as $stageIndex => $stage)
            @php
                $stageTasksCount = $stage->tasks->count();
                $stageCompletedCount = $stage->tasks->where('status', 'tasdiqlandi')->count();
                $isStageCompleted = $stageTasksCount > 0 && $stageCompletedCount === $stageTasksCount;
                $isStageUnlocked = $stage->isUnlocked();
                $accentBorder = match(true) {
                    $isStageCompleted => 'border-emerald-300',
                    $isStageUnlocked => 'border-indigo-400',
                    default => 'border-slate-300',
                };
            @endphp

            <div class="bg-white rounded-3xl border-2 {{ $isStageCompleted ? 'border-emerald-200/80 bg-emerald-50/10' : ($isStageUnlocked ? 'border-slate-200/80' : 'border-slate-200/60 bg-slate-50/40') }} border-s-8 {{ $accentBorder }} shadow-sm overflow-hidden transition-all duration-200">
                <!-- Stage Header -->
                <div class="px-6 py-5 bg-slate-50/70 border-b border-slate-100 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-4">
                        <div class="w-11 h-11 rounded-2xl font-bold text-base flex items-center justify-center shrink-0 {{ $isStageCompleted ? 'bg-emerald-600 text-white' : ($isStageUnlocked ? 'bg-indigo-600 text-white' : 'bg-slate-300 text-slate-600') }} shadow-2xs">
                            @if ($isStageCompleted)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                </svg>
                            @elseif (! $isStageUnlocked)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            @else
                                {{ $stage->order }}
                            @endif
                        </div>
                        <div>
                            <h4 class="font-bold text-lg sm:text-xl text-slate-900">{{ $stage->name }}</h4>
                            <p class="text-sm text-slate-500 mt-0.5">
                                {{ $stageCompletedCount }} / {{ $stageTasksCount }} ta vazifa yakunlangan
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2.5">
                        @unless ($isStageUnlocked)
                            <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-500 bg-slate-100 border border-slate-200 px-3 py-1.5 rounded-full">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                Yopiq
                            </span>
                        @endunless
                        <x-status-badge :status="$stage->status" class="text-sm px-3 py-1.5" />
                    </div>
                </div>

                @unless ($isStageUnlocked)
                    <div class="px-6 py-3 bg-amber-50/70 border-b border-amber-100 text-sm text-amber-800 flex items-center gap-2">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Bu bosqich vazifalarini ko'rishingiz mumkin, lekin oldingi bosqich(lar) to'liq yakunlanmaguncha hujjat yuklab bo'lmaydi.</span>
                    </div>
                @endunless

                <!-- Stage Tasks -->
                <div class="divide-y divide-slate-100">
                    @foreach ($stage->tasks as $task)
                        @php
                            $canUpload = Auth::user()->can('upload', $task);
                            $canReview = Auth::user()->can('review', $task);
                            $isOpen = $openTaskId === $task->id;

                            $taskIconColor = match($task->status) {
                                'tasdiqlandi', 'tasdiqlangan' => 'text-emerald-600 bg-emerald-50',
                                'jarayonda' => 'text-blue-600 bg-blue-50',
                                'qaytarildi', 'rad_etilgan' => 'text-rose-600 bg-rose-50',
                                default => 'text-slate-400 bg-slate-100',
                            };
                        @endphp

                        <div class="p-5 sm:p-6 transition-colors {{ $isOpen ? 'bg-slate-50/40' : 'hover:bg-slate-50/30' }}">
                            <button type="button" wire:click="toggleTask({{ $task->id }})" class="w-full flex items-start justify-between gap-4 text-left focus:outline-none group">
                                <div class="flex items-start gap-3.5">
                                    <div class="w-7 h-7 rounded-lg {{ $taskIconColor }} flex items-center justify-center shrink-0 mt-0.5">
                                        @if ($task->status === 'tasdiqlandi' || $task->status === 'tasdiqlangan')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                            </svg>
                                        @elseif ($task->status === 'qaytarildi' || $task->status === 'rad_etilgan')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        @elseif ($task->status === 'jarayonda')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @else
                                            <div class="w-2 h-2 rounded-full bg-slate-400"></div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-bold text-base sm:text-lg text-slate-800 group-hover:text-indigo-600 transition-colors">{{ $task->name }}</p>
                                        <div class="flex flex-wrap items-center gap-3 mt-1.5 text-sm text-slate-500">
                                            @if ($task->responsibleUser)
                                                <span class="inline-flex items-center gap-1 text-sm text-slate-500 bg-slate-100 px-2.5 py-1 rounded-md">
                                                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                    Mas'ul: <strong class="text-slate-700">{{ $task->responsibleUser->full_name }}</strong>
                                                </span>
                                            @else
                                                <span class="text-sm text-slate-400">Mas'ul: Izlanuvchi</span>
                                            @endif

                                            @if ($task->documents->isNotEmpty())
                                                <span class="text-sm text-indigo-600 font-medium flex items-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                                    </svg>
                                                    {{ $task->documents->count() }} ta hujjat yuklangan
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3 shrink-0">
                                    <x-status-badge :status="$task->status" class="text-sm px-3 py-1.5" />
                                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-indigo-50 group-hover:text-indigo-600 transition-all duration-200" :class="{ 'rotate-180 bg-indigo-50 text-indigo-600': {{ $isOpen ? 'true' : 'false' }} }">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                            </button>

                            <!-- Expandable Task Details -->
                            @if ($isOpen)
                                <div class="mt-5 space-y-5 border-t-2 border-slate-100 pt-5 ps-10">
                                    @if ($task->description)
                                        <div class="bg-slate-50/80 rounded-2xl p-4 sm:p-5 text-sm sm:text-base text-slate-700 leading-relaxed border border-slate-100">
                                            <p class="font-bold text-slate-900 mb-1.5">Vazifa talablari:</p>
                                            {{ $task->description }}
                                        </div>
                                    @endif

                                    {{-- Hujjatlar tarixi --}}
                                    <div class="bg-white rounded-2xl border border-slate-200/80 p-4 sm:p-5">
                                        <h5 class="text-sm font-bold text-slate-700 uppercase tracking-wider mb-3 flex items-center gap-2">
                                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Yuklangan hujjatlar
                                        </h5>

                                        @if ($task->documents->isEmpty())
                                            <p class="text-sm text-slate-400 italic py-1">Ushbu vazifa uchun hali hujjat yuklanmagan.</p>
                                        @else
                                            <div class="space-y-2">
                                                @foreach ($task->documents as $document)
                                                    <div class="flex items-center justify-between text-sm bg-white rounded-2xl border border-slate-200/80 p-3.5 shadow-2xs hover:border-slate-300 transition">
                                                        <div class="flex items-center gap-2.5 truncate max-w-md">
                                                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                                </svg>
                                                            </div>
                                                            <div class="truncate">
                                                                <span class="inline-block px-1.5 py-0.5 rounded bg-slate-100 text-slate-700 font-mono text-xs me-1 font-semibold">v{{ $document->version }}</span>
                                                                <span class="font-medium text-slate-800">{{ $document->file_name }}</span>
                                                            </div>
                                                        </div>

                                                        <div class="flex items-center gap-3 shrink-0 ms-3">
                                                            <x-status-badge :status="$document->status" />
                                                            <a href="{{ route('documents.download', $document) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-indigo-50 text-slate-700 hover:text-indigo-600 font-medium rounded-xl transition text-sm">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                                </svg>
                                                                Yuklab olish
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Izohlar (rad etish sabablari) --}}
                                    @if ($task->comments->isNotEmpty())
                                        <div class="bg-white rounded-2xl border border-rose-200/60 p-4 sm:p-5">
                                            <h5 class="text-sm font-bold text-rose-700 uppercase tracking-wider mb-3 flex items-center gap-2">
                                                <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                                Mas'ul xodim xulosasi / Rad etish sabablari
                                            </h5>
                                            <div class="space-y-2">
                                                @foreach ($task->comments as $comment)
                                                    <div class="text-sm bg-rose-50/70 border border-rose-200/80 rounded-2xl p-4 space-y-1.5">
                                                        <p class="text-rose-950 font-medium leading-relaxed">{{ $comment->text }}</p>
                                                        <div class="flex items-center gap-2 text-xs text-rose-600/80 pt-1.5 border-t border-rose-100">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                            </svg>
                                                            <span>{{ $comment->user->full_name }}</span>
                                                            <span>&bull;</span>
                                                            <span>{{ $comment->created_at->format('d.m.Y H:i') }}</span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Hujjat yuklash (Izlanuvchi yoki ruxsati borlar uchun) --}}
                                    @if ($canUpload && $task->status !== 'tasdiqlandi')
                                        <div class="bg-indigo-50/50 rounded-2xl p-4 sm:p-5 border-2 border-indigo-100">
                                            <h5 class="text-sm font-bold text-slate-900 uppercase tracking-wider mb-2 flex items-center gap-2">
                                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                                </svg>
                                                Yangi hujjat yuklash
                                            </h5>
                                            <p class="text-sm text-slate-500 mb-3">
                                                Tegishli faylni tanlang (PDF, Word yoki rasm fayllari, hajmi 20 MB gacha). Yangi hujjat yuklanganda, avvalgi versiya saqlanib qoladi.
                                            </p>

                                            <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                                                <input type="file" wire:model="file" class="block w-full text-sm text-slate-600 border border-slate-300 rounded-xl file:me-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer bg-white" />

                                                <x-primary-button class="sm:shrink-0 text-sm px-5 py-2.5" wire:click="uploadDocument({{ $task->id }})" wire:loading.attr="disabled">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                                    </svg>
                                                    <span>Saqlash va yuborish</span>
                                                </x-primary-button>
                                            </div>

                                            @error('file') <p class="text-rose-600 text-sm mt-1.5 font-medium">{{ $message }}</p> @enderror
                                            <div wire:loading wire:target="file" class="text-sm text-indigo-600 mt-2 flex items-center gap-1.5 font-medium">
                                                <svg class="animate-spin h-4 w-4" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                                </svg>
                                                Fayl yuklanmoqda, kuting...
                                            </div>
                                        </div>
                                    @elseif (! $canUpload && ! $isStageUnlocked && $task->stage->project->user_id === Auth::id() && $task->status !== 'tasdiqlandi')
                                        <div class="bg-slate-100/80 rounded-2xl p-4 sm:p-5 border-2 border-slate-200 flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-slate-200 text-slate-500 flex items-center justify-center shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                </svg>
                                            </div>
                                            <p class="text-sm text-slate-600 font-medium">
                                                Hujjat yuklash uchun bu bosqich hozircha yopiq — avval oldingi bosqich(lar)ni yakunlang.
                                            </p>
                                        </div>
                                    @endif

                                    {{-- Tasdiqlash / rad etish (Mas'ul xodim yoki Admin uchun) --}}
                                    @if ($canReview && $task->status === 'jarayonda')
                                        <div class="bg-slate-50 rounded-2xl p-5 border-2 border-slate-200/80 space-y-3">
                                            <h5 class="text-sm font-bold text-slate-900 uppercase tracking-wider flex items-center gap-2">
                                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Mas'ul xodim tekshiruvi va xulosasi
                                            </h5>
                                            <p class="text-sm text-slate-500">
                                                Hujjat talablarga javob bersa "Tasdiqlash" tugmasini bosing. Kamchiliklar mavjud bo'lsa, sababini yozib "Rad etish" orqali izlanuvchiga qaytaring.
                                            </p>

                                            <div class="flex flex-col sm:flex-row items-start gap-4 pt-2">
                                                <button type="button" wire:click="approve({{ $task->id }})" wire:loading.attr="disabled" class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-medium text-sm rounded-xl shadow-xs transition active:scale-[0.99] cursor-pointer">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    <span>Vazifani tasdiqlash</span>
                                                </button>

                                                <div class="flex-1 w-full space-y-2">
                                                    <textarea wire:model="rejectComment" rows="2" placeholder="Rad etish yoki tuzatish kiritish sababini batafsil yozing..." class="block w-full text-sm border-slate-300 rounded-xl shadow-2xs focus:border-rose-500 focus:ring-4 focus:ring-rose-500/15 placeholder-slate-400"></textarea>
                                                    @error('rejectComment') <p class="text-rose-600 text-sm font-medium">{{ $message }}</p> @enderror
                                                    <div class="flex justify-end">
                                                        <button type="button" wire:click="reject({{ $task->id }})" wire:loading.attr="disabled" class="inline-flex items-center gap-1.5 px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-medium text-sm rounded-xl shadow-xs transition active:scale-[0.99] cursor-pointer">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                            <span>Rad etish va izoh yuborish</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
