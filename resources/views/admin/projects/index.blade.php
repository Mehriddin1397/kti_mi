<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-bold text-xl text-slate-900 leading-tight">
                {{ __('Barcha loyihalar va arizalar') }}
            </h1>
            <p class="text-xs text-slate-500 mt-1">Tizimdagi barcha ilmiy arizalarni qidirish va filtrlash</p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto space-y-6">

            <!-- Filter Card -->
            <form method="GET" class="bg-white rounded-3xl border border-slate-200/80 p-5 sm:p-6 shadow-xs">
                <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-4 items-end">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Holat</label>
                        <select name="status" class="w-full border-slate-300 rounded-xl text-xs focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15">
                            <option value="">Barcha holatlar</option>
                            @foreach (['jarayonda' => 'Jarayonda', 'yakunlangan' => 'Yakunlangan', 'bekor_qilingan' => 'Bekor qilingan'] as $key => $label)
                                <option value="{{ $key }}" @selected(($filters['status'] ?? '') === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Ariza turi</label>
                        <select name="application_type_id" class="w-full border-slate-300 rounded-xl text-xs focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15">
                            <option value="">Barcha turlar</option>
                            @foreach ($applicationTypes as $type)
                                <option value="{{ $type->id }}" @selected(($filters['application_type_id'] ?? '') == $type->id)>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1.5">Mas'ul xodim</label>
                        <select name="responsible_user_id" class="w-full border-slate-300 rounded-xl text-xs focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15">
                            <option value="">Barcha xodimlar</option>
                            @foreach ($staff as $member)
                                <option value="{{ $member->id }}" @selected(($filters['responsible_user_id'] ?? '') == $member->id)>{{ $member->full_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center gap-2 pt-1">
                        <button type="submit" class="flex-1 inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-xs rounded-xl shadow-xs transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            Filtrlash
                        </button>
                        <a href="{{ route('admin.projects.index') }}" class="px-3 py-2.5 text-xs text-slate-500 hover:text-slate-700 rounded-xl hover:bg-slate-100 transition">
                            Tozalash
                        </a>
                    </div>
                </div>
            </form>

            <!-- Table -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                        <thead class="bg-slate-50/80">
                            <tr>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Izlanuvchi</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Ariza turi</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Holat</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Progress</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Sana</th>
                                <th class="px-6 py-3.5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Amal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($projects as $project)
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
                                    <td class="px-6 py-4 text-xs text-slate-500 font-mono">
                                        {{ $project->created_at->format('d.m.Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('projects.show', $project) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-indigo-50 hover:bg-indigo-600 text-indigo-700 hover:text-white text-xs font-semibold transition">
                                            <span>Ko'rish</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-400 text-sm">
                                        Ko'rsatilgan parametrlar bo'yicha loyihalar topilmadi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($projects->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $projects->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
