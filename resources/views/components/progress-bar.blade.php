@props(['percent' => 0])

@php
    $intPercent = min(100, max(0, (int) $percent));
    $isComplete = $intPercent === 100;
@endphp

<div class="flex items-center gap-2.5 w-full">
    <div class="flex-1 bg-slate-100 rounded-full h-2.5 overflow-hidden ring-1 ring-slate-200/80 p-0.5">
        <div class="h-1.5 rounded-full transition-all duration-500 {{ $isComplete ? 'bg-gradient-to-r from-emerald-500 to-teal-600' : 'bg-gradient-to-r from-blue-600 to-indigo-600' }}"
             style="width: {{ $intPercent }}%"></div>
    </div>
    <span class="text-xs font-semibold {{ $isComplete ? 'text-emerald-700 font-bold' : 'text-slate-600' }} min-w-9 text-right font-mono">
        {{ $intPercent }}%
    </span>
</div>
