<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-xs text-slate-500">
            <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition">Bosh sahifa</a>
            <span>/</span>
            <a href="{{ route('admin.users.index') }}" class="hover:text-indigo-600 transition">Foydalanuvchilar</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold">{{ $user->full_name }} (tahrirlash)</span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl border border-slate-200/80 p-7 sm:p-8 shadow-xs">
                <div class="mb-6">
                    <h2 class="text-lg font-bold text-slate-900">Foydalanuvchini tahrirlash</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Shaxsiy ma'lumotlar, rol va faollik holatini yangilang</p>
                </div>

                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="full_name" value="F.I.Sh *" />
                        <x-text-input id="full_name" name="full_name" class="block w-full" :value="old('full_name', $user->full_name)" required autofocus />
                        <x-input-error :messages="$errors->get('full_name')" class="mt-1.5" />
                    </div>

                    <div>
                        <x-input-label for="phone" value="Telefon raqam (login) *" />
                        <x-text-input id="phone" name="phone" class="block w-full" :value="old('phone', $user->phone)" required />
                        <x-input-error :messages="$errors->get('phone')" class="mt-1.5" />
                    </div>

                    <div>
                        <x-input-label for="role" value="Tizimdagi roli *" />
                        <select id="role" name="role" class="block w-full border-slate-300 rounded-xl text-xs focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15" required>
                            @foreach ($roles as $key => $label)
                                <option value="{{ $key }}" @selected(old('role', $currentRole) === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-1.5" />
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <x-input-label for="password" value="Yangi parol" />
                            @if ($user->initial_password)
                                <span class="text-[11px] text-slate-500 mb-1">Joriy parol: <strong class="font-mono text-indigo-700 bg-indigo-50 px-1.5 py-0.5 rounded border border-indigo-100 select-all">{{ $user->initial_password }}</strong></span>
                            @endif
                        </div>
                        <x-text-input id="password" name="password" type="text" class="block w-full" placeholder="O'zgartirmasangiz, bo'sh qoldiring" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                        <p class="text-[11px] text-slate-400 mt-1">Yangi parol kiritilsa, foydalanuvchining paroli o'zgaradi va admin panelda ko'rinadi.</p>
                    </div>

                    <div class="pt-1">
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" @checked($user->is_active) class="w-4 h-4 rounded border-slate-300 text-indigo-600 shadow-2xs focus:ring-indigo-500">
                            <span class="text-xs font-semibold text-slate-700 select-none">Faol foydalanuvchi</span>
                        </label>
                    </div>

                    <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                        <x-primary-button>Saqlash</x-primary-button>
                        <a href="{{ route('admin.users.index') }}" class="text-xs font-medium text-slate-500 hover:text-slate-700 px-3 py-2">
                            Bekor qilish
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
