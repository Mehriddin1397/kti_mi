<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Foydalanuvchini tahrirlash') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="full_name" value="Ism familiya" />
                        <x-text-input id="full_name" name="full_name" class="block mt-1 w-full" :value="old('full_name', $user->full_name)" required autofocus />
                        <x-input-error :messages="$errors->get('full_name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="phone" value="Telefon raqam (login)" />
                        <x-text-input id="phone" name="phone" class="block mt-1 w-full" :value="old('phone', $user->phone)" required />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="role" value="Rol" />
                        <select id="role" name="role" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" required>
                            @foreach ($roles as $key => $label)
                                <option value="{{ $key }}" @selected(old('role', $currentRole) === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password" value="Yangi parol (o'zgartirmasangiz bo'sh qoldiring)" />
                        <x-text-input id="password" name="password" type="text" class="block mt-1 w-full" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="is_active" value="1" @checked($user->is_active) class="rounded border-gray-300">
                        <span class="text-sm text-gray-700">Faol</span>
                    </label>

                    <div class="flex items-center gap-3 pt-2">
                        <x-primary-button>Saqlash</x-primary-button>
                        <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:underline">Bekor qilish</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
