@php
    $mainMenu = [
        [
            'label' => 'Dashboard',
            'route' => 'dashboard',
            'icon' => 'dashboard',
            'active' => request()->routeIs('dashboard'),
        ],
        [
            'label' => 'Data Pasien',
            'route' => 'patients.index',
            'icon' => 'users',
            'active' => request()->routeIs('patients.*'),
        ],
        [
            'label' => 'Pendaftaran Rawat Jalan',
            'route' => 'registrations.index',
            'icon' => 'clipboard-list',
            'active' => request()->routeIs('registrations.*'),
        ],
        [
            'label' => 'Pemeriksaan Awal',
            'route' => 'examinations.index',
            'icon' => 'stethoscope',
            'active' => request()->routeIs('examinations.*'),
        ],
    ];

    $masterMenu = [
        [
            'label' => 'Data Dokter',
            'route' => 'doctors.index',
            'icon' => 'user-round',
            'active' => request()->routeIs('doctors.*'),
        ],
        [
            'label' => 'Data Poliklinik',
            'route' => 'polyclinics.index',
            'icon' => 'building',
            'active' => request()->routeIs('polyclinics.*'),
        ],
    ];
@endphp

<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-slate-200 bg-white transition-transform duration-300 ease-in-out lg:translate-x-0"
    aria-label="Navigasi utama">
    <div class="flex h-16 shrink-0 items-center justify-between border-b border-slate-100 px-5">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3" aria-label="Rawat Jalan - Dashboard">
            <span
                class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white shadow-sm shadow-emerald-200">
                <x-icon name="heart-pulse" class="h-5 w-5" />
            </span>
            <span class="leading-tight">
                <span class="block text-base font-semibold tracking-tight text-slate-900">Rawat Jalan</span>
                <span class="block text-xs font-medium text-slate-500">Sistem Pendaftaran</span>
            </span>
        </a>

        <button type="button" id="sidebarClose"
            class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-slate-500 transition hover:bg-slate-100 hover:text-slate-700 lg:hidden"
            aria-label="Tutup menu">
            <x-icon name="x" class="h-5 w-5" />
        </button>
    </div>

    <nav class="flex-1 space-y-6 overflow-y-auto px-4 py-5">
        <div>
            <p class="px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-400">Menu Utama</p>
            <div class="mt-2 space-y-1">
                @foreach ($mainMenu as $item)
                    <a href="{{ route($item['route']) }}"
                        @class([
                            'group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition',
                            'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-100' => $item['active'],
                            'text-slate-600 hover:bg-slate-50 hover:text-slate-900' => !$item['active'],
                        ])
                        @if ($item['active']) aria-current="page" @endif>
                        <x-icon :name="$item['icon']"
                            class="h-5 w-5 shrink-0 transition {{ $item['active'] ? 'text-emerald-600' : 'text-slate-400 group-hover:text-slate-600' }}" />
                        <span class="min-w-0 truncate">{{ $item['label'] }}</span>
                        @if ($item['active'])
                            <span class="ml-auto h-1.5 w-1.5 shrink-0 rounded-full bg-emerald-500"></span>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>

        <div>
            <p class="px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-400">Master Data</p>
            <div class="mt-2 space-y-1">
                @foreach ($masterMenu as $item)
                    <a href="{{ route($item['route']) }}"
                        @class([
                            'group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition',
                            'bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-100' => $item['active'],
                            'text-slate-600 hover:bg-slate-50 hover:text-slate-900' => !$item['active'],
                        ])
                        @if ($item['active']) aria-current="page" @endif>
                        <x-icon :name="$item['icon']"
                            class="h-5 w-5 shrink-0 transition {{ $item['active'] ? 'text-emerald-600' : 'text-slate-400 group-hover:text-slate-600' }}" />
                        <span class="min-w-0 truncate">{{ $item['label'] }}</span>
                        @if ($item['active'])
                            <span class="ml-auto h-1.5 w-1.5 shrink-0 rounded-full bg-emerald-500"></span>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </nav>

    <div class="shrink-0 border-t border-slate-100 p-4">
        <div class="rounded-xl border border-emerald-100 bg-emerald-50/70 p-3.5">
            <div class="flex items-center gap-2 text-xs font-semibold text-emerald-700">
                <span class="relative flex h-2 w-2">
                    <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-60"></span>
                    <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                </span>
                Sistem berjalan normal
            </div>
            <p class="mt-1.5 text-xs leading-relaxed text-emerald-800/70">
                Kelola pasien, pendaftaran, pemeriksaan, dokter, dan poliklinik dalam satu tempat.
            </p>
        </div>
    </div>
</aside>
