@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-medium text-emerald-600">Ringkasan operasional</p>
            <h1 class="mt-1 text-2xl font-semibold tracking-tight text-slate-900">Dashboard Rawat Jalan</h1>
            <p class="mt-1 text-sm text-slate-500">
                Pantau kunjungan dan aktivitas layanan rawat jalan hari ini.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <a href="{{ route('patients.create') }}"
                class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-3.5 py-2 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
                <x-icon name="user-plus" class="h-4 w-4 text-slate-500" />
                Tambah Pasien
            </a>
            <a href="{{ route('registrations.create') }}"
                class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-3.5 py-2 text-sm font-semibold text-white shadow-sm shadow-emerald-200 transition hover:bg-emerald-700">
                <x-icon name="plus" class="h-4 w-4" />
                Pendaftaran Baru
            </a>
        </div>
    </div>

    @php
        $stats = [
            [
                'label' => 'Total Pasien Aktif',
                'value' => $totalPatients,
                'description' => 'Pasien dengan status aktif',
                'icon' => 'users',
                'tone' => 'emerald',
                'badge' => 'Aktif',
            ],
            [
                'label' => 'Kunjungan Hari Ini',
                'value' => $todayVisits,
                'description' => 'Seluruh pendaftaran hari ini',
                'icon' => 'calendar',
                'tone' => 'sky',
                'badge' => 'Hari ini',
            ],
            [
                'label' => 'Menunggu',
                'value' => $waitingVisits,
                'description' => 'Belum masuk pemeriksaan',
                'icon' => 'clock',
                'tone' => 'amber',
                'badge' => 'Hari ini',
            ],
            [
                'label' => 'Sedang Diperiksa',
                'value' => $inProgressVisits,
                'description' => 'Pemeriksaan awal berjalan',
                'icon' => 'stethoscope',
                'tone' => 'violet',
                'badge' => 'Hari ini',
            ],
            [
                'label' => 'Selesai',
                'value' => $completedVisits,
                'description' => 'Kunjungan selesai hari ini',
                'icon' => 'check-circle',
                'tone' => 'teal',
                'badge' => 'Hari ini',
            ],
        ];

        $tones = [
            'emerald' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'ring' => 'ring-emerald-100'],
            'sky' => ['bg' => 'bg-sky-50', 'text' => 'text-sky-600', 'ring' => 'ring-sky-100'],
            'amber' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'ring' => 'ring-amber-100'],
            'violet' => ['bg' => 'bg-violet-50', 'text' => 'text-violet-600', 'ring' => 'ring-violet-100'],
            'teal' => ['bg' => 'bg-teal-50', 'text' => 'text-teal-600', 'ring' => 'ring-teal-100'],
        ];

        $maxVisits = max(1, (int) $polyclinicStats->max('visits_today_count'));
        $totalForStatus = max(1, (int) $todayVisits);

        $statusSummary = [
            [
                'label' => 'Menunggu',
                'value' => $waitingVisits,
                'color' => 'bg-amber-500',
                'track' => 'bg-amber-100',
                'text' => 'text-amber-700',
            ],
            [
                'label' => 'Sedang diperiksa',
                'value' => $inProgressVisits,
                'color' => 'bg-violet-500',
                'track' => 'bg-violet-100',
                'text' => 'text-violet-700',
            ],
            [
                'label' => 'Selesai',
                'value' => $completedVisits,
                'color' => 'bg-emerald-500',
                'track' => 'bg-emerald-100',
                'text' => 'text-emerald-700',
            ],
        ];
    @endphp

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
        @foreach ($stats as $stat)
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                <div class="flex items-start justify-between gap-3">
                    <span
                        class="flex h-10 w-10 items-center justify-center rounded-xl ring-1 ring-inset {{ $tones[$stat['tone']]['bg'] }} {{ $tones[$stat['tone']]['text'] }} {{ $tones[$stat['tone']]['ring'] }}">
                        <x-icon :name="$stat['icon']" class="h-5 w-5" />
                    </span>
                    <span class="rounded-full bg-slate-50 px-2 py-1 text-[10px] font-semibold uppercase tracking-wide text-slate-400">
                        {{ $stat['badge'] }}
                    </span>
                </div>
                <p class="mt-4 text-2xl font-semibold tracking-tight text-slate-900">
                    {{ number_format($stat['value'], 0, ',', '.') }}
                </p>
                <p class="mt-0.5 text-sm font-medium text-slate-700">{{ $stat['label'] }}</p>
                <p class="mt-1 text-xs leading-relaxed text-slate-500">{{ $stat['description'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm lg:col-span-2">
            <div class="flex items-center justify-between gap-4 border-b border-slate-100 px-5 py-4">
                <div>
                    <h2 class="text-base font-semibold text-slate-900">Kunjungan per Poliklinik</h2>
                    <p class="mt-0.5 text-xs text-slate-500">Distribusi kunjungan hari ini berdasarkan poliklinik.</p>
                </div>
                <a href="{{ route('registrations.index') }}"
                    class="hidden items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-xs font-semibold text-emerald-700 transition hover:bg-emerald-50 sm:inline-flex">
                    Lihat pendaftaran
                    <x-icon name="chevron-right" class="h-3.5 w-3.5" />
                </a>
            </div>

            <div class="overflow-x-auto scrollbar-thin">
                <table class="w-full min-w-[520px] text-left text-sm">
                    <thead>
                        <tr class="bg-slate-50/80 text-xs uppercase tracking-wide text-slate-500">
                            <th class="px-5 py-3 font-semibold">Poliklinik</th>
                            <th class="px-5 py-3 font-semibold">Kunjungan</th>
                            <th class="px-5 py-3 font-semibold">Proporsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($polyclinicStats as $polyclinic)
                            <tr class="transition hover:bg-slate-50/70">
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-2.5">
                                        <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                                            <x-icon name="building" class="h-4 w-4" />
                                        </span>
                                        <span class="font-medium text-slate-800">{{ $polyclinic->name }}</span>
                                    </div>
                                </td>
                                <td class="px-5 py-3.5">
                                    <span class="inline-flex min-w-8 items-center justify-center rounded-lg bg-slate-100 px-2 py-1 text-xs font-semibold text-slate-700">
                                        {{ number_format($polyclinic->visits_today_count, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <div class="h-2 w-full max-w-40 overflow-hidden rounded-full bg-slate-100">
                                            <div class="h-full rounded-full bg-gradient-to-r from-emerald-500 to-teal-500"
                                                style="width: {{ round(($polyclinic->visits_today_count / $maxVisits) * 100) }}%">
                                            </div>
                                        </div>
                                        <span class="w-10 text-right text-xs font-medium text-slate-500">
                                            {{ $todayVisits > 0 ? round(($polyclinic->visits_today_count / $todayVisits) * 100) : 0 }}%
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-5 py-10 text-center">
                                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                        <x-icon name="building" class="h-6 w-6" />
                                    </div>
                                    <p class="mt-3 text-sm font-medium text-slate-700">Belum ada data poliklinik.</p>
                                    <p class="mt-1 text-xs text-slate-500">Data akan tampil setelah poliklinik tersedia.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-semibold text-slate-900">Status Kunjungan</h2>
                        <p class="mt-0.5 text-xs text-slate-500">Ringkasan status hari ini.</p>
                    </div>
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-slate-50 text-slate-500">
                        <x-icon name="activity" class="h-5 w-5" />
                    </span>
                </div>

                <div class="mt-5 space-y-4">
                    @foreach ($statusSummary as $status)
                        @php
                            $percentage = $todayVisits > 0 ? round(($status['value'] / $totalForStatus) * 100) : 0;
                        @endphp
                        <div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="flex items-center gap-2 font-medium text-slate-700">
                                    <span class="h-2 w-2 rounded-full {{ $status['color'] }}"></span>
                                    {{ $status['label'] }}
                                </span>
                                <span class="font-semibold {{ $status['text'] }}">
                                    {{ number_format($status['value'], 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="mt-2 h-2 overflow-hidden rounded-full {{ $status['track'] }}">
                                <div class="h-full rounded-full {{ $status['color'] }}" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-5 flex items-center justify-between rounded-xl bg-slate-50 px-3.5 py-3">
                    <span class="text-xs font-medium text-slate-500">Total kunjungan hari ini</span>
                    <span class="text-sm font-semibold text-slate-900">{{ number_format($todayVisits, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="text-base font-semibold text-slate-900">Akses Cepat</h2>
                <p class="mt-0.5 text-xs text-slate-500">Tugas yang sering digunakan.</p>

                <div class="mt-4 space-y-2">
                    <a href="{{ route('registrations.create') }}"
                        class="group flex items-center gap-3 rounded-xl border border-slate-100 px-3.5 py-3 transition hover:border-emerald-200 hover:bg-emerald-50/60">
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
                            <x-icon name="clipboard-list" class="h-4 w-4" />
                        </span>
                        <span class="min-w-0 flex-1">
                            <span class="block text-sm font-semibold text-slate-800">Daftarkan pasien</span>
                            <span class="block text-xs text-slate-500">Buat pendaftaran rawat jalan</span>
                        </span>
                        <x-icon name="chevron-right" class="h-4 w-4 shrink-0 text-slate-300 transition group-hover:text-emerald-500" />
                    </a>

                    <a href="{{ route('examinations.index') }}"
                        class="group flex items-center gap-3 rounded-xl border border-slate-100 px-3.5 py-3 transition hover:border-emerald-200 hover:bg-emerald-50/60">
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-violet-100 text-violet-600">
                            <x-icon name="stethoscope" class="h-4 w-4" />
                        </span>
                        <span class="min-w-0 flex-1">
                            <span class="block text-sm font-semibold text-slate-800">Pemeriksaan awal</span>
                            <span class="block text-xs text-slate-500">Lanjutkan pemeriksaan pasien</span>
                        </span>
                        <x-icon name="chevron-right" class="h-4 w-4 shrink-0 text-slate-300 transition group-hover:text-emerald-500" />
                    </a>

                    <a href="{{ route('patients.index') }}"
                        class="group flex items-center gap-3 rounded-xl border border-slate-100 px-3.5 py-3 transition hover:border-emerald-200 hover:bg-emerald-50/60">
                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-sky-100 text-sky-600">
                            <x-icon name="users" class="h-4 w-4" />
                        </span>
                        <span class="min-w-0 flex-1">
                            <span class="block text-sm font-semibold text-slate-800">Cari data pasien</span>
                            <span class="block text-xs text-slate-500">Kelola identitas pasien</span>
                        </span>
                        <x-icon name="chevron-right" class="h-4 w-4 shrink-0 text-slate-300 transition group-hover:text-emerald-500" />
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
