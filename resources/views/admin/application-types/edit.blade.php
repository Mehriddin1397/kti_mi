<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-xs text-slate-500">
            <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition">Bosh sahifa</a>
            <span>/</span>
            <a href="{{ route('admin.application-types.index') }}" class="hover:text-indigo-600 transition">Ariza turlari</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold">{{ $applicationType->name }} (tahrirlash)</span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl border border-slate-200/80 p-7 sm:p-8 shadow-xs">
                <div class="mb-6">
                    <h2 class="text-lg font-bold text-slate-900">Ariza turini tahrirlash</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Asosiy parametrlarni o'zgartiring va saqlang</p>
                </div>

                <form method="POST" action="{{ route('admin.application-types.update', $applicationType) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="name" value="Ariza turi nomi *" />
                        <x-text-input id="name" name="name" class="block w-full" :value="old('name', $applicationType->name)" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
                    </div>

                    <div>
                        <x-input-label for="description" value="Tavsif (ixtiyoriy)" />
                        <textarea id="description" name="description" rows="3" class="block w-full border-slate-300 rounded-xl text-xs focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/15">{{ old('description', $applicationType->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-1.5" />
                    </div>

                    <div class="pt-1">
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" @checked($applicationType->is_active) class="w-4 h-4 rounded border-slate-300 text-indigo-600 shadow-2xs focus:ring-indigo-500">
                            <span class="text-xs font-semibold text-slate-700 select-none">Faol</span>
                        </label>
                    </div>

                    <div class="flex items-center gap-3 pt-4 border-t border-slate-100">
                        <x-primary-button>Saqlash</x-primary-button>
                        <a href="{{ route('admin.application-types.show', $applicationType) }}" class="text-xs font-medium text-slate-500 hover:text-slate-700 px-3 py-2">
                            Bekor qilish
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
