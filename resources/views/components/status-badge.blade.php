@props(['status'])

@php
    $labels = [
        'jarayonda' => 'Jarayonda',
        'yakunlangan' => 'Yakunlangan',
        'tugallangan' => 'Tugallangan',
        'bekor_qilingan' => 'Bekor qilingan',
        'kutilmoqda' => 'Kutilmoqda',
        'qaytarildi' => 'Qaytarildi',
        'tasdiqlandi' => 'Tasdiqlandi',
        'tasdiqlangan' => 'Tasdiqlangan',
        'rad_etilgan' => 'Rad etilgan',
        'yuborildi' => 'Yuborildi',
        'xato' => 'Xato',
        'faol' => 'Faol',
        'nofaol' => 'Nofaol',
    ];

    $styles = [
        'jarayonda' => [
            'badge' => 'bg-blue-50 text-blue-700 border-blue-200/80 ring-1 ring-blue-500/10',
            'dot' => 'bg-blue-600',
            'pulse' => true,
        ],
        'yakunlangan' => [
            'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200/80 ring-1 ring-emerald-500/10',
            'dot' => 'bg-emerald-600',
            'pulse' => false,
        ],
        'tugallangan' => [
            'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200/80 ring-1 ring-emerald-500/10',
            'dot' => 'bg-emerald-600',
            'pulse' => false,
        ],
        'tasdiqlandi' => [
            'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200/80 ring-1 ring-emerald-500/10',
            'dot' => 'bg-emerald-600',
            'pulse' => false,
        ],
        'tasdiqlangan' => [
            'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200/80 ring-1 ring-emerald-500/10',
            'dot' => 'bg-emerald-600',
            'pulse' => false,
        ],
        'faol' => [
            'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200/80 ring-1 ring-emerald-500/10',
            'dot' => 'bg-emerald-600',
            'pulse' => false,
        ],
        'yuborildi' => [
            'badge' => 'bg-indigo-50 text-indigo-700 border-indigo-200/80 ring-1 ring-indigo-500/10',
            'dot' => 'bg-indigo-600',
            'pulse' => false,
        ],
        'kutilmoqda' => [
            'badge' => 'bg-amber-50 text-amber-700 border-amber-200/80 ring-1 ring-amber-500/10',
            'dot' => 'bg-amber-500',
            'pulse' => false,
        ],
        'qaytarildi' => [
            'badge' => 'bg-rose-50 text-rose-700 border-rose-200/80 ring-1 ring-rose-500/10',
            'dot' => 'bg-rose-600',
            'pulse' => false,
        ],
        'rad_etilgan' => [
            'badge' => 'bg-rose-50 text-rose-700 border-rose-200/80 ring-1 ring-rose-500/10',
            'dot' => 'bg-rose-600',
            'pulse' => false,
        ],
        'xato' => [
            'badge' => 'bg-rose-50 text-rose-700 border-rose-200/80 ring-1 ring-rose-500/10',
            'dot' => 'bg-rose-600',
            'pulse' => false,
        ],
        'bekor_qilingan' => [
            'badge' => 'bg-slate-100 text-slate-600 border-slate-200 ring-1 ring-slate-400/10',
            'dot' => 'bg-slate-400',
            'pulse' => false,
        ],
        'nofaol' => [
            'badge' => 'bg-slate-100 text-slate-600 border-slate-200 ring-1 ring-slate-400/10',
            'dot' => 'bg-slate-400',
            'pulse' => false,
        ],
    ];

    $currentStyle = $styles[$status] ?? [
        'badge' => 'bg-slate-100 text-slate-600 border-slate-200',
        'dot' => 'bg-slate-400',
        'pulse' => false,
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium border shadow-2xs ' . $currentStyle['badge']]) }}>
    <span class="relative flex h-2 w-2">
        @if ($currentStyle['pulse'])
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $currentStyle['dot'] }} opacity-75"></span>
        @endif
        <span class="relative inline-flex rounded-full h-2 w-2 {{ $currentStyle['dot'] }}"></span>
    </span>
    <span>{{ $labels[$status] ?? $status }}</span>
</span>
