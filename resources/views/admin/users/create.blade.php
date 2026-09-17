<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-xs text-slate-500">
            <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition">Bosh sahifa</a>
            <span>/</span>
            <a href="{{ route('admin.users.index') }}" class="hover:text-indigo-600 transition">Foydalanuvchilar</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold">Yangi foydalanuvchi</span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl border border-slate-200/80 p-7 sm:p-8 shadow-xs">
                <div class="mb-6">
                    <h2 class="text-lg font-bold text-slate-900">Yangi foydalanuvchi qo'shish</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Tizimga yangi izlanuvchi, mas'ul ekspert yoki administrator biriktiring</p>
                </div>

                <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="full_name" value="F.I.Sh (To'liq ism familiya) *" />
                        <x-text-input id="full_name" name="full_name" class="block w-full" :value="old('full_name')" placeholder="Masalan: Abdullayev Temur Olimovich" required autofocus />
                        <x-input-error :messages="$errors->get('full_name')" class="mt-1.5" />
                    </div>

                    <div>
                        <x-input-label for="phone" value="Telefon raqam (login sifatida ishlatiladi) *" />
                        <x-text-input id="phone" name="phone" class="block w-full" :value="old('phone')" placeholder="+998901234567" required />
                        <x-input-error :messages="$errors->get('phone')" class="mt-1.5" />
                        <p class="text-xs text-slate-400 mt-1">Ushbu raqam orqali foydalanuvchi tizimga kiradi.</p>
                    </div>

                    <div>
                        <x-input-label for="role" value="Tizimdagi roli *" />
                        <select id="role" name="role" class="block w-full border-slate-300 rounded-xl text-xs focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15" required>
                            <option value="">— Rolni tanlang —</option>
                            @foreach ($roles as $key => $label)
                                <option value="{{ $key }}" @selected(old('role') === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-1.5" />
                    </div>

                    <div>
                        <x-input-label for="password" value="Parol (ixtiyoriy)" />
                        <x-text-input id="password" name="password" type="text" class="block w-full" :value="old('password')" placeholder="Bo'sh qoldirsangiz, avtomatik yaratiladi" />
                        <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                    </div>

                    <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                        <x-primary-button>
                            <span>Foydalanuvchini yaratish</span>
                        </x-primary-button>
                        <a href="{{ route('admin.users.index') }}" class="text-xs font-medium text-slate-500 hover:text-slate-700 px-3 py-2">
                            Bekor qilish
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
