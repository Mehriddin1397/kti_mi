<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-bold text-xl text-slate-900 leading-tight">
                    {{ __('Ariza turlari va bosqichlar') }}
                </h1>
                <p class="text-xs text-slate-500 mt-1">Ilmiy dasturlar, bosqichlar va vazifalar shablonlari</p>
            </div>
            <a href="{{ route('admin.application-types.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow-xs transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Yangi ariza turi</span>
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto space-y-6">

            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                        <thead class="bg-slate-50/80">
                            <tr>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Ariza turi nomi</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Bosqichlar</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Mavjud loyihalar</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Holat</th>
                                <th class="px-6 py-3.5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Amallar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($applicationTypes as $type)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <a href="{{ route('admin.application-types.show', $type) }}" class="font-semibold text-slate-900 hover:text-indigo-600 text-sm transition">
                                                    {{ $type->name }}
                                                </a>
                                                @if ($type->description)
                                                    <p class="text-xs text-slate-400 mt-0.5 line-clamp-1">{{ $type->description }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('admin.application-types.show', $type) }}" class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 hover:underline">
                                            <span>{{ $type->stages_count }} ta bosqich</span>
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-slate-600">
                                        {{ $type->projects_count }} ta ariza
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-status-badge :status="$type->is_active ? 'faol' : 'nofaol'" />
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <a href="{{ route('admin.application-types.show', $type) }}" class="inline-flex items-center gap-1 text-xs font-semibold text-indigo-600 hover:text-indigo-800 p-1.5 rounded-lg hover:bg-indigo-50 transition">
                                            Bosqichlar
                                        </a>
                                        <a href="{{ route('admin.application-types.edit', $type) }}" class="inline-flex items-center gap-1 text-xs font-semibold text-slate-600 hover:text-slate-800 p-1.5 rounded-lg hover:bg-slate-100 transition">
                                            Tahrirlash
                                        </a>
                                        <form method="POST" action="{{ route('admin.application-types.destroy', $type) }}" class="inline" onsubmit="return confirm('Haqiqatan ham ushbu ariza turini o\'chirmoqchimisiz?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 text-xs font-semibold text-rose-600 hover:text-rose-800 p-1.5 rounded-lg hover:bg-rose-50 transition cursor-pointer">
                                                O'chirish
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-400 text-sm">
                                        Hozircha ariza turlari yaratilmagan.
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
