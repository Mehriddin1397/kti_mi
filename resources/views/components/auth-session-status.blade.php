@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'rounded-2xl bg-emerald-50 border border-emerald-200/80 p-3.5 text-xs font-semibold text-emerald-800 flex items-center gap-2.5 shadow-2xs']) }}>
        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span>{{ $status }}</span>
    </div>
@endif
