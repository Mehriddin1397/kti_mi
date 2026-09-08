@props(['status'])

@php
    $labels = [
        'jarayonda' => "Jarayonda",
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

    $colors = [
        'jarayonda' => 'bg-blue-50 text-blue-700 border-blue-200',
        'yakunlangan' => 'bg-green-50 text-green-700 border-green-200',
        'tugallangan' => 'bg-green-50 text-green-700 border-green-200',
        'bekor_qilingan' => 'bg-gray-100 text-gray-600 border-gray-200',
        'kutilmoqda' => 'bg-amber-50 text-amber-700 border-amber-200',
        'qaytarildi' => 'bg-red-50 text-red-700 border-red-200',
        'tasdiqlandi' => 'bg-green-50 text-green-700 border-green-200',
        'tasdiqlangan' => 'bg-green-50 text-green-700 border-green-200',
        'rad_etilgan' => 'bg-red-50 text-red-700 border-red-200',
        'yuborildi' => 'bg-green-50 text-green-700 border-green-200',
        'xato' => 'bg-red-50 text-red-700 border-red-200',
        'faol' => 'bg-green-50 text-green-700 border-green-200',
        'nofaol' => 'bg-gray-100 text-gray-600 border-gray-200',
    ];
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border ' . ($colors[$status] ?? 'bg-gray-100 text-gray-600 border-gray-200')]) }}>
    {{ $labels[$status] ?? $status }}
</span>
