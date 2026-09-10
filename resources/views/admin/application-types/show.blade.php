<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-2 text-xs text-slate-500">
                <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition">Bosh sahifa</a>
                <span>/</span>
                <a href="{{ route('admin.application-types.index') }}" class="hover:text-indigo-600 transition">Ariza turlari</a>
                <span>/</span>
                <span class="text-slate-800 font-semibold truncate">{{ $applicationType->name }}</span>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.application-types.edit', $applicationType) }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white hover:bg-slate-50 border border-slate-300 text-slate-700 text-xs font-semibold rounded-xl shadow-xs transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    <span>Tahrirlash</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto space-y-6">

            <!-- Information Banner -->
            <div class="bg-indigo-50/70 border border-indigo-100 rounded-3xl p-5 flex items-start gap-4">
                <div class="w-9 h-9 rounded-2xl bg-indigo-600 text-white flex items-center justify-center shrink-0 shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-sm text-indigo-950">Bosqichlar va vazifalar konstruktori</h3>
                    <p class="text-xs text-indigo-800/80 mt-0.5 leading-relaxed">
                        Bu yerda siz ushbu ariza turi bo'yicha ketma-ket bajariladigan barcha bosqichlar va vazifalar shablonini sozlaysiz. Izlanuvchi ariza topshirganda, tizim ushbu shablondan nusxa olib individual loyiha yaratadi.
                    </p>
                </div>
            </div>

            <!-- Stages & Tasks List -->
            <div class="space-y-6">
                @forelse ($applicationType->stages as $stage)
                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
                        <!-- Stage Header & Edit Form -->
                        <div class="px-6 py-4 bg-slate-50/80 border-b border-slate-100 flex flex-wrap items-center justify-between gap-3">
                            <form method="POST" action="{{ route('admin.application-types.stages.update', [$applicationType, $stage]) }}" class="flex flex-wrap items-center gap-2 flex-1">
                                @csrf @method('PUT')
                                <div class="w-7 h-7 rounded-lg bg-indigo-600 text-white font-bold text-xs flex items-center justify-center shrink-0">
                                    {{ $stage->order }}
                                </div>
                                <input type="text" name="name" value="{{ $stage->name }}" class="border-slate-300 rounded-xl text-xs flex-1 min-w-[200px] focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15" placeholder="Bosqich nomi">
                                <div class="flex items-center gap-1.5">
                                    <label class="text-[11px] text-slate-400 font-medium">Tartib:</label>
                                    <input type="number" name="order" value="{{ $stage->order }}" class="border-slate-300 rounded-xl text-xs w-16 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15">
                                </div>
                                <button type="submit" class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-600 text-indigo-700 hover:text-white rounded-xl text-xs font-semibold transition cursor-pointer">
                                    Saqlash
                                </button>
                            </form>
                            <form method="POST" action="{{ route('admin.application-types.stages.destroy', [$applicationType, $stage]) }}" onsubmit="return confirm('Ushbu bosqich va unga tegishli barcha vazifalarni o\'chirishni tasdiqlaysizmi?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-rose-600 hover:bg-rose-50 rounded-xl transition cursor-pointer">
                                    Bosqichni o'chirish
                                </button>
                            </form>
                        </div>

                        <!-- Stage Tasks -->
                        <div class="divide-y divide-slate-100">
                            @foreach ($stage->tasks as $task)
                                <div class="px-6 py-4 hover:bg-slate-50/40 transition">
                                    <form method="POST" action="{{ route('admin.tasks.update', $task) }}" class="flex flex-wrap items-center gap-2.5">
                                        @csrf @method('PUT')
                                        <div class="w-2 h-2 rounded-full bg-slate-300 shrink-0"></div>
                                        <input type="text" name="name" value="{{ $task->name }}" placeholder="Vazifa nomi" class="border-slate-300 rounded-xl text-xs flex-1 min-w-[180px] focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15" required>
                                        <input type="text" name="description" value="{{ $task->description }}" placeholder="Tavsif (ixtiyoriy)" class="border-slate-300 rounded-xl text-xs flex-1 min-w-[180px] focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15">
                                        <select name="default_responsible_user_id" class="border-slate-300 rounded-xl text-xs focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15">
                                            <option value="">Izlanuvchining o'zi</option>
                                            @foreach ($staff as $member)
                                                <option value="{{ $member->id }}" @selected($task->default_responsible_user_id == $member->id)>{{ $member->full_name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="number" name="order" value="{{ $task->order }}" class="border-slate-300 rounded-xl text-xs w-16 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15" title="Tartib raqami">
                                        <button type="submit" class="px-3 py-1.5 bg-slate-100 hover:bg-indigo-50 text-slate-700 hover:text-indigo-600 rounded-xl text-xs font-semibold transition cursor-pointer">
                                            Saqlash
                                        </button>
                                    </form>
                                    <div class="flex justify-end mt-1">
                                        <form method="POST" action="{{ route('admin.tasks.destroy', $task) }}" class="inline" onsubmit="return confirm('Ushbu vazifani o\'chirishni tasdiqlaysizmi?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-[11px] text-rose-500 hover:text-rose-700 hover:underline cursor-pointer">
                                                Vazifani o'chirish
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach

                            <!-- Add New Task Form in this Stage -->
                            <div class="px-6 py-4 bg-slate-50/60 border-t border-slate-100">
                                <form method="POST" action="{{ route('admin.stages.tasks.store', $stage) }}" class="flex flex-wrap items-center gap-2.5">
                                    @csrf
                                    <span class="text-xs font-bold text-slate-700 uppercase tracking-wider shrink-0 me-1">+ Yangi vazifa:</span>
                                    <input type="text" name="name" placeholder="Vazifa nomi *" required class="border-slate-300 rounded-xl text-xs flex-1 min-w-[180px] focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15 bg-white">
                                    <input type="text" name="description" placeholder="Talablar va tavsif (ixtiyoriy)" class="border-slate-300 rounded-xl text-xs flex-1 min-w-[180px] focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15 bg-white">
                                    <select name="default_responsible_user_id" class="border-slate-300 rounded-xl text-xs focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15 bg-white">
                                        <option value="">Mas'ul: Izlanuvchi</option>
                                        @foreach ($staff as $member)
                                            <option value="{{ $member->id }}">Mas'ul: {{ $member->full_name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs transition cursor-pointer">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        <span>Qo'shish</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-3xl border border-slate-200/80 p-12 text-center shadow-xs">
                        <div class="w-12 h-12 rounded-2xl bg-slate-100 flex items-center justify-center mx-auto mb-3 text-slate-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h4 class="text-sm font-bold text-slate-800">Hozircha birorta ham bosqich qo'shilmagan</h4>
                        <p class="text-xs text-slate-500 mt-1">Quyidagi shakl orqali birinchi bosqichni qo'shing.</p>
                    </div>
                @endforelse

                <!-- Add New Stage Card -->
                <div class="bg-white rounded-3xl border border-slate-200/80 p-6 shadow-xs">
                    <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Yangi bosqich qo'shish
                    </h4>
                    <form method="POST" action="{{ route('admin.application-types.stages.store', $applicationType) }}" class="flex flex-col sm:flex-row items-center gap-3">
                        @csrf
                        <input type="text" name="name" placeholder="Bosqich nomi (masalan: 1. Hujjatlarni qabul qilish yoki 2. Kafedra muhokamasi)" required class="w-full border-slate-300 rounded-xl text-xs focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15">
                        <button type="submit" class="sm:shrink-0 w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-semibold shadow-xs transition cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Bosqich qo'shish</span>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
