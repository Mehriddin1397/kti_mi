@props(['showText' => true, 'size' => 'md'])

@php
    $imageSizes = [
        'sm' => 'w-8 h-8',
        'md' => 'w-11 h-11',
        'lg' => 'w-16 h-16',
        'xl' => 'w-24 h-24',
    ];
    $imgSizeClass = $imageSizes[$size] ?? $imageSizes['md'];
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center gap-3']) }}>
    <div class="relative {{ $imgSizeClass }} rounded-full overflow-hidden ring-2 ring-amber-500/30 shadow-md shrink-0 bg-white p-0.5">
        <img src="{{ asset('logo/photo_2025-09-03_15-19-21.jpg') }}" alt="Kriminologiya tadqiqot instituti logosi" class="w-full h-full object-cover rounded-full" />
    </div>

    @if ($showText)
        <div class="flex flex-col text-left">
            <span class="font-bold text-sm sm:text-base tracking-tight text-slate-900 leading-tight">
                Kriminologiya tadqiqot instituti
            </span>
            <span class="text-[11px] font-medium text-slate-500 tracking-wide">
                Mustaqil izlanuvchilar axborot tizimi
            </span>
        </div>
    @endif
</div>
