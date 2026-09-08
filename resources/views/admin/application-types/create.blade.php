<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Yangi ariza turi') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <form method="POST" action="{{ route('admin.application-types.store') }}" class="space-y-4">
                    @csrf

                    <div>
                        <x-input-label for="name" value="Nomi" />
                        <x-text-input id="name" name="name" class="block mt-1 w-full" :value="old('name')" required autofocus />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" value="Tavsif" />
                        <textarea id="description" name="description" rows="3" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="is_active" value="1" checked class="rounded border-gray-300">
                        <span class="text-sm text-gray-700">Faol</span>
                    </label>

                    <div class="flex items-center gap-3 pt-2">
                        <x-primary-button>Saqlash</x-primary-button>
                        <a href="{{ route('admin.application-types.index') }}" class="text-sm text-gray-500 hover:underline">Bekor qilish</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
