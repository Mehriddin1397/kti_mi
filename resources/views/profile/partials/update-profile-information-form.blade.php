<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __("Profil ma'lumotlari") }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Ismingizni yangilang. Telefon raqamni faqat administrator o'zgartira oladi.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="full_name" :value="__('Ism familiya')" />
            <x-text-input id="full_name" name="full_name" type="text" class="mt-1 block w-full" :value="old('full_name', $user->full_name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('full_name')" />
        </div>

        <div>
            <x-input-label for="phone" :value="__('Telefon raqam')" />
            <x-text-input id="phone" type="text" class="mt-1 block w-full bg-gray-100" :value="$user->phone" disabled />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Saqlash') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saqlandi.') }}</p>
            @endif
        </div>
    </form>
</section>
