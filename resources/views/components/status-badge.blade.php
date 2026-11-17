@props(['status' => null])

@php
    $normalized = strtoupper((string) $status);

    $badges = [
        'MENUNGGU' => [
            'label' => 'Menunggu',
            'classes' => 'bg-amber-50 text-amber-700 ring-amber-200',
            'dot' => 'bg-amber-500',
        ],
        'DIPERIKSA' => [
            'label' => 'Diperiksa',
            'classes' => 'bg-violet-50 text-violet-700 ring-violet-200',
            'dot' => 'bg-violet-500',
        ],
        'SELESAI' => [
            'label' => 'Selesai',
            'classes' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
            'dot' => 'bg-emerald-500',
        ],
        'BATAL' => [
            'label' => 'Batal',
            'classes' => 'bg-rose-50 text-rose-700 ring-rose-200',
            'dot' => 'bg-rose-500',
        ],
        'AKTIF' => [
            'label' => 'Aktif',
            'classes' => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
            'dot' => 'bg-emerald-500',
        ],
        'NONAKTIF' => [
            'label' => 'Nonaktif',
            'classes' => 'bg-slate-100 text-slate-600 ring-slate-200',
            'dot' => 'bg-slate-400',
        ],
    ];

    $badge = $badges[$normalized] ?? [
        'label' => $status ?: 'Tidak diketahui',
        'classes' => 'bg-slate-100 text-slate-600 ring-slate-200',
        'dot' => 'bg-slate-400',
    ];
@endphp

<span
    {{ $attributes->merge(['class' => 'inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset ' . $badge['classes']]) }}>
    <span class="h-1.5 w-1.5 shrink-0 rounded-full {{ $badge['dot'] }}"></span>
    {{ $badge['label'] }}
</span>
