<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="font-bold text-xl text-slate-900 leading-tight">
                {{ __('Yangi ariza topshirish') }}
            </h1>
            <p class="text-xs text-slate-500 mt-1">Kriminologiya tadqiqot instituti — Mustaqil izlanuvchilik dasturlari</p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto space-y-6">

            <!-- Instruction banner -->
            <div class="bg-indigo-50/80 border border-indigo-100 rounded-3xl p-5 sm:p-6 flex items-start gap-4">
                <div class="w-10 h-10 rounded-2xl bg-indigo-600 text-white flex items-center justify-center shrink-0 shadow-xs shadow-indigo-500/20">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-sm text-indigo-950">Kriminologiya tadqiqot instituti — Ariza topshirish tartibi</h3>
                    <p class="text-xs text-indigo-800/80 mt-1 leading-relaxed">
                        Quyidagi ro'yxatdan kerakli ilmiy dastur yoki ariza turini tanlang. Ma'lumotlaringizni tasdiqlab yuborganingizdan so'ng institut tomonidan sizga shaxsiy tadqiqot kartasi va unga tegishli bosqichlar (hujjat yuklash, ekspertiza, ilmiy kengash xulosasi) biriktiriladi.
                    </p>
                </div>
            </div>

            @if ($applicationTypes->isEmpty())
                <div class="bg-white rounded-3xl border border-slate-200/80 p-12 text-center shadow-xs">
                    <div class="w-16 h-16 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-800">Hozircha faol ariza turlari mavjud emas</h3>
                    <p class="text-sm text-slate-500 mt-1">
                        Iltimos, keyinroq qayta urinib ko'ring yoki administrator bilan bog'laning.
                    </p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($applicationTypes as $type)
                        <div x-data="{ open: false }" class="bg-white rounded-3xl border border-slate-200/80 shadow-xs hover:border-slate-300 transition-all overflow-hidden">
                            <button type="button" @click="open = !open" class="w-full flex items-center justify-between p-6 text-left focus:outline-none">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-base text-slate-900">{{ $type->name }}</h3>
                                        @if ($type->description)
                                            <p class="text-xs text-slate-500 mt-1 leading-relaxed">{{ $type->description }}</p>
                                        @endif
                                        <div class="mt-2.5 flex items-center gap-4 text-[11px] text-slate-400">
                                            <span class="inline-flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                                </svg>
                                                {{ $type->stages_count ?? $type->stages->count() }} ta bosqich
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="ms-4 shrink-0 flex items-center gap-2">
                                    <span class="hidden sm:inline-block text-xs font-semibold text-indigo-600" x-text="open ? 'Yopish' : 'Ariza to\'ldirish'"></span>
                                    <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 transition-transform duration-200" :class="{ 'rotate-180 bg-indigo-50 text-indigo-600': open }">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                            </button>

                            <!-- Accordion Form Body -->
                            <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" class="px-6 pb-6 pt-2 border-t border-slate-100 bg-slate-50/50">
                                <form method="POST" action="{{ route('apply.store', $type) }}" class="space-y-4 max-w-xl">
                                    @csrf

                                    <div>
                                        <x-input-label for="full_name_{{ $type->id }}" value="F.I.Sh (To'liq ism familiyangiz)" />
                                        <x-text-input id="full_name_{{ $type->id }}" name="full_name" class="block w-full" :value="old('full_name', auth()->user()->full_name)" required />
                                    </div>

                                    <div>
                                        <x-input-label for="phone_{{ $type->id }}" value="Aloqa uchun telefon raqamingiz" />
                                        <x-text-input id="phone_{{ $type->id }}" name="phone" class="block w-full" :value="old('phone', auth()->user()->phone)" required />
                                        <p class="text-[11px] text-slate-400 mt-1">Ushbu raqamga arizangiz ko'rib chiqilishi bo'yicha SMS xabarlar yuboriladi.</p>
                                    </div>

                                    <div class="pt-2 flex items-center gap-3">
                                        <x-primary-button type="submit" class="px-6">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span>Arizani tasdiqlash va topshirish</span>
                                        </x-primary-button>
                                        <button type="button" @click="open = false" class="text-xs text-slate-500 hover:text-slate-700 px-3 py-2">
                                            Bekor qilish
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
