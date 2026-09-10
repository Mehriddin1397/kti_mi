<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="font-bold text-xl text-slate-900 leading-tight">
                    {{ __('Foydalanuvchilar boshqaruvi') }}
                </h1>
                <p class="text-xs text-slate-500 mt-1">Tizimdagi barcha foydalanuvchilar, izlanuvchilar va ekspertlar</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow-xs transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
                <span>Foydalanuvchi qo'shish</span>
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto space-y-6">

            <!-- Role Filter Pills -->
            <div class="flex flex-wrap items-center gap-2">
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold transition {{ !$currentRole ? 'bg-indigo-600 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200/80' }}">
                    Barchasi
                </a>
                @foreach ($roles as $key => $label)
                    <a href="{{ route('admin.users.index', ['role' => $key]) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold transition {{ $currentRole === $key ? 'bg-indigo-600 text-white shadow-xs' : 'bg-white text-slate-600 hover:bg-slate-100 border border-slate-200/80' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            <!-- Users Table -->
            <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xs overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                        <thead class="bg-slate-50/80">
                            <tr>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">F.I.Sh</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Telefon (login)</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Tizimdagi roli</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Parol</th>
                                <th class="px-6 py-3.5 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Holat</th>
                                <th class="px-6 py-3.5 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Amallar</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($users as $user)
                                @php
                                    $userRoleName = $user->roles->first()?->name;
                                    $userRoleBadge = match($userRoleName) {
                                        \App\Support\Roles::ADMIN => 'bg-purple-50 text-purple-700 border-purple-200/80',
                                        \App\Support\Roles::MASUL_XODIM => 'bg-indigo-50 text-indigo-700 border-indigo-200/80',
                                        default => 'bg-emerald-50 text-emerald-700 border-emerald-200/80',
                                    };
                                @endphp
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-indigo-600 to-blue-500 text-white font-semibold text-xs flex items-center justify-center shrink-0 shadow-2xs">
                                                {{ mb_substr($user->full_name, 0, 1) }}
                                            </div>
                                            <div class="font-semibold text-slate-900 text-xs">
                                                {{ $user->full_name }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-mono text-xs text-slate-600">
                                        {{ $user->phone }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-semibold border {{ $userRoleBadge }}">
                                            {{ $roles[$userRoleName] ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($user->initial_password)
                                            <div x-data="{ show: false, copied: false }" class="inline-flex items-center gap-1.5 bg-slate-50 border border-slate-200/80 px-2.5 py-1 rounded-xl">
                                                <span x-show="!show" class="font-mono text-xs text-slate-400 select-none tracking-widest">••••••••</span>
                                                <span x-show="show" x-cloak class="font-mono text-xs text-indigo-700 font-semibold select-all">{{ $user->initial_password }}</span>

                                                <!-- Show / Hide Button -->
                                                <button type="button" @click="show = !show" class="p-1 rounded-md text-slate-400 hover:text-slate-700 hover:bg-slate-200/60 transition cursor-pointer" :title="show ? 'Yashirish' : 'Ko\'rsatish'">
                                                    <svg x-show="!show" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    <svg x-show="show" x-cloak class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                                    </svg>
                                                </button>

                                                <!-- Copy Button -->
                                                <button type="button" 
                                                        @click="navigator.clipboard.writeText('{{ $user->initial_password }}'); copied = true; setTimeout(() => copied = false, 2000)" 
                                                        class="p-1 rounded-md text-slate-400 hover:text-indigo-600 hover:bg-slate-200/60 transition cursor-pointer" 
                                                        :title="copied ? 'Nusxalandi!' : 'Nusxalash'">
                                                    <svg x-show="!copied" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                    </svg>
                                                    <svg x-show="copied" x-cloak class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </button>
                                            </div>
                                        @else
                                            <span class="text-xs text-slate-400 italic">O'rnatilmagan</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <x-status-badge :status="$user->is_active ? 'faol' : 'nofaol'" />
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="inline-flex items-center gap-1 text-xs font-semibold text-slate-600 hover:text-slate-900 p-1.5 rounded-lg hover:bg-slate-100 transition">
                                            Tahrirlash
                                        </a>
                                        @if ($user->is_active)
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('Foydalanuvchini nofaollashtirishni tasdiqlaysizmi?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-1 text-xs font-semibold text-rose-600 hover:text-rose-800 p-1.5 rounded-lg hover:bg-rose-50 transition cursor-pointer">
                                                    Nofaollashtirish
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-400 text-sm">
                                        Foydalanuvchilar topilmadi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($users->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
