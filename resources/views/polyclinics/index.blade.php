@extends('layouts.app')

@section('title', 'Data Poliklinik')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-medium text-emerald-600">Master data</p>
            <h1 class="mt-1 text-2xl font-semibold tracking-tight text-slate-900">Data Poliklinik</h1>
            <p class="mt-1 text-sm text-slate-500">
                Kelola unit layanan poliklinik yang tersedia untuk pendaftaran rawat jalan.
            </p>
        </div>

        <a href="{{ route('polyclinics.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-emerald-200 transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
            <x-icon name="plus" class="h-4 w-4" />
            Tambah Poliklinik
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-5 py-4">
            <form action="{{ route('polyclinics.index') }}" method="GET"
                class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <div class="relative flex-1">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        <x-icon name="search" class="h-4 w-4" />
                    </span>
                    <input type="text" name="search" value="{{ $search }}"
                        placeholder="Cari nama atau deskripsi poliklinik..."
                        class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2">
                        <x-icon name="search" class="h-4 w-4" />
                        Cari
                    </button>

                    @if ($search)
                        <a href="{{ route('polyclinics.index') }}"
                            class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                            <x-icon name="refresh" class="h-4 w-4" />
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            <div class="mt-3 flex flex-wrap items-center gap-2 text-xs text-slate-500">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 font-medium">
                    <x-icon name="building" class="h-3.5 w-3.5" />
                    {{ number_format($polyclinics->total(), 0, ',', '.') }} poliklinik
                </span>
                @if ($search)
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 font-medium text-emerald-700">
                        <x-icon name="filter" class="h-3.5 w-3.5" />
                        Pencarian: &ldquo;{{ $search }}&rdquo;
                    </span>
                @endif
            </div>
        </div>

        <div class="overflow-x-auto scrollbar-thin">
            <table class="w-full min-w-[900px] text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/80 text-xs uppercase tracking-wide text-slate-500">
                        <th class="px-5 py-3.5 font-semibold">No</th>
                        <th class="px-5 py-3.5 font-semibold">Poliklinik</th>
                        <th class="px-5 py-3.5 font-semibold">Deskripsi</th>
                        <th class="px-5 py-3.5 font-semibold">Dokter</th>
                        <th class="px-5 py-3.5 font-semibold">Pendaftaran</th>
                        <th class="px-5 py-3.5 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse ($polyclinics as $index => $polyclinic)
                        <tr class="transition hover:bg-slate-50/70">
                            <td class="px-5 py-3.5 text-slate-500">
                                {{ $polyclinics->firstItem() + $index }}
                            </td>

                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <span
                                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-700">
                                        <x-icon name="building" class="h-4 w-4" />
                                    </span>
                                    <p class="font-semibold text-slate-800">{{ $polyclinic->name }}</p>
                                </div>
                            </td>

                            <td class="max-w-xs px-5 py-3.5 text-slate-600">
                                @if ($polyclinic->description)
                                    <p class="line-clamp-2">{{ $polyclinic->description }}</p>
                                @else
                                    <span class="text-xs text-slate-400">Belum ada deskripsi</span>
                                @endif
                            </td>

                            <td class="px-5 py-3.5">
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700">
                                    <x-icon name="user-round" class="h-3.5 w-3.5" />
                                    {{ number_format($polyclinic->doctors_count, 0, ',', '.') }} dokter
                                </span>
                            </td>

                            <td class="px-5 py-3.5">
                                <span
                                    class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700">
                                    <x-icon name="clipboard-list" class="h-3.5 w-3.5" />
                                    {{ number_format($polyclinic->registrations_count, 0, ',', '.') }}
                                </span>
                            </td>

                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('polyclinics.edit', $polyclinic->id) }}"
                                        class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-amber-200 hover:bg-amber-50 hover:text-amber-700">
                                        <x-icon name="pencil" class="h-3.5 w-3.5" />
                                        Edit
                                    </a>

                                    @if ($polyclinic->doctors_count === 0 && $polyclinic->registrations_count === 0)
                                        <form action="{{ route('polyclinics.destroy', $polyclinic->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus poliklinik ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="inline-flex items-center gap-1.5 rounded-lg border border-rose-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-rose-600 shadow-sm transition hover:bg-rose-50">
                                                <x-icon name="trash" class="h-3.5 w-3.5" />
                                                Hapus
                                            </button>
                                        </form>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-slate-50 px-2.5 py-1.5 text-xs font-semibold text-slate-400"
                                            title="Tidak dapat dihapus karena masih memiliki dokter atau riwayat pendaftaran">
                                            <x-icon name="ban" class="h-3.5 w-3.5" />
                                            Terkunci
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-14 text-center">
                                <div
                                    class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                    <x-icon name="building" class="h-7 w-7" />
                                </div>
                                <p class="mt-4 text-sm font-semibold text-slate-700">Data poliklinik tidak ditemukan.</p>
                                <p class="mt-1 text-xs text-slate-500">
                                    @if ($search)
                                        Coba kata kunci lain atau reset pencarian.
                                    @else
                                        Tambahkan poliklinik baru untuk memulai layanan rawat jalan.
                                    @endif
                                </p>
                                <a href="{{ route('polyclinics.create') }}"
                                    class="mt-4 inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-emerald-700">
                                    <x-icon name="plus" class="h-3.5 w-3.5" />
                                    Tambah Poliklinik
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($polyclinics->hasPages())
            <div class="flex flex-col gap-3 border-t border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-xs text-slate-500">
                    Menampilkan
                    <span class="font-semibold text-slate-700">{{ $polyclinics->firstItem() }}</span>
                    &ndash;
                    <span class="font-semibold text-slate-700">{{ $polyclinics->lastItem() }}</span>
                    dari
                    <span class="font-semibold text-slate-700">{{ $polyclinics->total() }}</span>
                    poliklinik
                </p>
                <div class="overflow-x-auto">
                    {{ $polyclinics->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
