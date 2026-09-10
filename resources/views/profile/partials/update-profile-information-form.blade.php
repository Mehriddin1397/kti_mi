<section>
    <header>
        <h2 class="text-base font-bold text-slate-900">
            {{ __("Profil ma'lumotlari") }}
        </h2>

        <p class="mt-1 text-xs text-slate-500">
            {{ __("Ism-sharifingizni yangilang. Telefon raqam tizimda login hisoblanadi va uni faqat administrator o'zgartirishi mumkin.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-4">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="full_name" :value="__('F.I.Sh (To\'liq ism-sharif)')" />
            <x-text-input id="full_name" name="full_name" type="text" class="block w-full" :value="old('full_name', $user->full_name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-1.5" :messages="$errors->get('full_name')" />
        </div>

        <div>
            <x-input-label for="phone" :value="__('Telefon raqam (login)')" />
            <x-text-input id="phone" type="text" class="block w-full bg-slate-100 text-slate-500 cursor-not-allowed font-mono" :value="$user->phone" disabled />
            <p class="text-[11px] text-slate-400 mt-1">Telefon raqamni o'zgartirish uchun adminga murojaat qiling.</p>
        </div>

        <div class="flex items-center gap-4 pt-2">
            <x-primary-button>{{ __('Saqlash') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-xs font-semibold text-emerald-600 flex items-center gap-1"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ __('Saqlandi.') }}
                </p>
            @endif
        </div>
    </form>
</section>
