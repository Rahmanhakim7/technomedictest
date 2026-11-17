<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') &middot; Sistem Pendaftaran Rawat Jalan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-full bg-slate-50 font-sans text-slate-800 antialiased">
    <div id="sidebarOverlay" class="fixed inset-0 z-40 hidden bg-slate-900/50 backdrop-blur-sm lg:hidden"
        aria-hidden="true"></div>

    <x-sidebar />

    <div class="flex min-h-screen flex-col lg:pl-72">
        <header
            class="sticky top-0 z-30 border-b border-slate-200/80 bg-white/90 backdrop-blur supports-[backdrop-filter]:bg-white/75">
            <div class="flex h-16 items-center gap-3 px-4 sm:px-6 lg:px-8">
                <button type="button" id="sidebarToggle"
                    class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:bg-slate-50 hover:text-slate-900 lg:hidden"
                    aria-label="Buka menu" aria-controls="sidebar" aria-expanded="false">
                    <x-icon name="menu" class="h-5 w-5" />
                </button>

                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-semibold text-slate-900">@yield('title', 'Dashboard')</p>
                    <p class="mt-0.5 hidden text-xs text-slate-500 sm:block">
                        {{ now()->locale('id')->translatedFormat('l, d F Y') }}
                    </p>
                </div>

                <a href="{{ route('registrations.create') }}"
                    class="hidden items-center gap-2 rounded-xl bg-emerald-600 px-3.5 py-2 text-sm font-semibold text-white shadow-sm shadow-emerald-200 transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 sm:inline-flex">
                    <x-icon name="plus" class="h-4 w-4" />
                    <span>Pendaftaran Baru</span>
                </a>

                <div class="flex items-center gap-3 border-l border-slate-200 pl-3 sm:pl-4">
                    <span
                        class="flex h-9 w-9 items-center justify-center rounded-full bg-gradient-to-br from-emerald-500 to-teal-600 text-sm font-semibold text-white ring-2 ring-emerald-100">
                        A
                    </span>
                    <span class="hidden leading-tight md:block">
                        <span class="block text-sm font-semibold text-slate-800">Administrator</span>
                        <span class="block text-xs text-slate-500">Petugas Pendaftaran</span>
                    </span>
                </div>
            </div>
        </header>

        <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
            <div class="mx-auto w-full max-w-7xl space-y-6">
                @if (session('success'))
                    <div class="flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3.5 text-sm text-emerald-800 shadow-sm"
                        role="status">
                        <x-icon name="check-circle" class="mt-0.5 h-5 w-5 shrink-0 text-emerald-600" />
                        <p class="font-medium">{{ session('success') }}</p>
                    </div>
                @endif

                @if (session('error'))
                    <div class="flex items-start gap-3 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-3.5 text-sm text-rose-800 shadow-sm"
                        role="alert">
                        <x-icon name="alert" class="mt-0.5 h-5 w-5 shrink-0 text-rose-600" />
                        <p class="font-medium">{{ session('error') }}</p>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3.5 text-sm text-amber-900 shadow-sm"
                        role="alert">
                        <div class="flex items-start gap-3">
                            <x-icon name="alert" class="mt-0.5 h-5 w-5 shrink-0 text-amber-600" />
                            <div>
                                <p class="font-semibold">Periksa kembali data yang diisi.</p>
                                <ul class="mt-1.5 list-inside list-disc space-y-1 text-amber-800">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        <footer class="border-t border-slate-200 bg-white px-4 py-4 sm:px-6 lg:px-8">
            <div
                class="mx-auto flex w-full max-w-7xl flex-col items-center justify-between gap-2 text-xs text-slate-500 sm:flex-row">
                <p>&copy; {{ date('Y') }} Sistem Pendaftaran Rawat Jalan</p>
                <p class="flex items-center gap-1.5">
                    <x-icon name="heart-pulse" class="h-3.5 w-3.5 text-emerald-500" />
                    Dashboard administrasi klinik
                </p>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>

</html>
