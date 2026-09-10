<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-xs text-slate-500">
            <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition">Bosh sahifa</a>
            <span>/</span>
            <a href="{{ route('admin.application-types.index') }}" class="hover:text-indigo-600 transition">Ariza turlari</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold">Yangi ariza turi</span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl border border-slate-200/80 p-7 sm:p-8 shadow-xs">
                <div class="mb-6">
                    <h2 class="text-lg font-bold text-slate-900">Yangi ariza turini yaratish</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Ilmiy dastur yoki ariza nomini kiriting. Saqlagandan so'ng bosqichlar qo'shiladi.</p>
                </div>

                <form method="POST" action="{{ route('admin.application-types.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="name" value="Ariza turi nomi *" />
                        <x-text-input id="name" name="name" class="block w-full" :value="old('name')" placeholder="Masalan: PhD - Falsafa doktori dissertatsiyasi" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
                    </div>

                    <div>
                        <x-input-label for="description" value="Tavsif (ixtiyoriy)" />
                        <textarea id="description" name="description" rows="3" class="block w-full border-slate-300 rounded-xl text-xs focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15" placeholder="Ushbu ariza kimlar uchun va qanday tartibda topshirilishi haqida qisqacha ma'lumot...">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-1.5" />
                    </div>

                    <div class="pt-1">
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 rounded border-slate-300 text-indigo-600 shadow-2xs focus:ring-indigo-500">
                            <span class="text-xs font-semibold text-slate-700 select-none">Faol (izlanuvchilar uchun ariza topshirish ochiq)</span>
                        </label>
                    </div>

                    <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                        <x-primary-button>
                            <span>Saqlash va davom etish</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </x-primary-button>
                        <a href="{{ route('admin.application-types.index') }}" class="text-xs font-medium text-slate-500 hover:text-slate-700 px-3 py-2">
                            Bekor qilish
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
