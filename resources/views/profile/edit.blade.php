<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2 text-xs text-slate-500">
            <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition">Bosh sahifa</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold">Profil sozlamalari</span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto space-y-6">
            <div class="p-6 sm:p-8 bg-white border border-slate-200/80 rounded-3xl shadow-xs">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 sm:p-8 bg-white border border-slate-200/80 rounded-3xl shadow-xs">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
