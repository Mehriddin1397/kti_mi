<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ariza topshirish') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-4">

            @if ($applicationTypes->isEmpty())
                <div class="bg-white rounded-lg border border-gray-200 p-10 text-center text-gray-500">
                    Hozircha faol ariza turlari yo'q. Administrator bilan bog'laning.
                </div>
            @else
                @foreach ($applicationTypes as $type)
                    <div x-data="{ open: false }" class="bg-white rounded-lg border border-gray-200">
                        <button type="button" @click="open = !open" class="w-full flex items-center justify-between px-5 py-4 text-left">
                            <div>
                                <h3 class="font-medium text-gray-900">{{ $type->name }}</h3>
                                @if ($type->description)
                                    <p class="text-sm text-gray-500 mt-1">{{ $type->description }}</p>
                                @endif
                            </div>
                            <span class="text-gray-400" x-text="open ? '−' : '+'"></span>
                        </button>

                        <div x-show="open" x-cloak class="px-5 pb-5 border-t border-gray-100 pt-4">
                            <form method="POST" action="{{ route('apply.store', $type) }}" class="space-y-4">
                                @csrf

                                <div>
                                    <x-input-label for="full_name_{{ $type->id }}" value="Ism familiya" />
                                    <x-text-input id="full_name_{{ $type->id }}" name="full_name" class="block mt-1 w-full" :value="old('full_name', auth()->user()->full_name)" required />
                                </div>

                                <div>
                                    <x-input-label for="phone_{{ $type->id }}" value="Telefon raqam" />
                                    <x-text-input id="phone_{{ $type->id }}" name="phone" class="block mt-1 w-full" :value="old('phone', auth()->user()->phone)" required />
                                </div>

                                <x-primary-button type="submit">Yuborish</x-primary-button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
    </div>
</x-app-layout>
