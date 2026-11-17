@extends('layouts.app')

@section('title', 'Data Pasien')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-medium text-emerald-600">Manajemen pasien</p>
            <h1 class="mt-1 text-2xl font-semibold tracking-tight text-slate-900">Data Pasien</h1>
            <p class="mt-1 text-sm text-slate-500">
                Kelola identitas, kontak, dan status pasien klinik.
            </p>
        </div>

        <a href="{{ route('patients.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-emerald-200 transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
            <x-icon name="plus" class="h-4 w-4" />
            Tambah Pasien
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 px-5 py-4">
            <form action="{{ route('patients.index') }}" method="GET"
                class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <div class="relative flex-1">
                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                        <x-icon name="search" class="h-4 w-4" />
                    </span>
                    <input type="text" name="search" value="{{ $search }}"
                        placeholder="Cari nomor rekam medis, NIK, atau nama pasien..."
                        class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2">
                        <x-icon name="search" class="h-4 w-4" />
                        Cari
                    </button>

                    @if ($search)
                        <a href="{{ route('patients.index') }}"
                            class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                            <x-icon name="refresh" class="h-4 w-4" />
                            Reset
                        </a>
                    @endif
                </div>
            </form>

            <div class="mt-3 flex flex-wrap items-center gap-2 text-xs text-slate-500">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 font-medium">
                    <x-icon name="users" class="h-3.5 w-3.5" />
                    {{ number_format($patients->total(), 0, ',', '.') }} pasien terdaftar
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
            <table class="w-full min-w-[960px] text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/80 text-xs uppercase tracking-wide text-slate-500">
                        <th class="px-5 py-3.5 font-semibold">No</th>
                        <th class="px-5 py-3.5 font-semibold">No. Rekam Medis</th>
                        <th class="px-5 py-3.5 font-semibold">Pasien</th>
                        <th class="px-5 py-3.5 font-semibold">NIK</th>
                        <th class="px-5 py-3.5 font-semibold">Jenis Kelamin</th>
                        <th class="px-5 py-3.5 font-semibold">Tanggal Lahir</th>
                        <th class="px-5 py-3.5 font-semibold">Status</th>
                        <th class="px-5 py-3.5 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse ($patients as $index => $patient)
                        <tr class="transition hover:bg-slate-50/70">
                            <td class="px-5 py-3.5 text-slate-500">
                                {{ $patients->firstItem() + $index }}
                            </td>

                            <td class="px-5 py-3.5">
                                <span class="inline-flex rounded-lg bg-slate-100 px-2.5 py-1 font-mono text-xs font-semibold text-slate-700">
                                    {{ $patient->medical_record_number }}
                                </span>
                            </td>

                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <span
                                        class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-sm font-semibold text-emerald-700">
                                        {{ strtoupper(substr($patient->full_name, 0, 1)) }}
                                    </span>
                                    <div class="min-w-0">
                                        <p class="truncate font-semibold text-slate-800">{{ $patient->full_name }}</p>
                                        @if ($patient->phone)
                                            <p class="mt-0.5 flex items-center gap-1 text-xs text-slate-500">
                                                <x-icon name="phone" class="h-3 w-3" />
                                                {{ $patient->phone }}
                                            </p>
                                        @else
                                            <p class="mt-0.5 text-xs text-slate-400">Nomor telepon belum diisi</p>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-3.5 font-mono text-xs text-slate-600">
                                {{ $patient->nik }}
                            </td>

                            <td class="px-5 py-3.5 text-slate-600">
                                {{ $patient->gender }}
                            </td>

                            <td class="px-5 py-3.5 whitespace-nowrap text-slate-600">
                                {{ $patient->birth_date->format('d-m-Y') }}
                            </td>

                            <td class="px-5 py-3.5">
                                <x-status-badge :status="$patient->is_active ? 'AKTIF' : 'NONAKTIF'" />
                            </td>

                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('patients.edit', $patient->id) }}"
                                        class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-amber-200 hover:bg-amber-50 hover:text-amber-700">
                                        <x-icon name="pencil" class="h-3.5 w-3.5" />
                                        Edit
                                    </a>

                                    @if ($patient->is_active)
                                        <form action="{{ route('patients.deactivate', $patient->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menonaktifkan pasien ini?')">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                class="inline-flex items-center gap-1.5 rounded-lg border border-rose-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-rose-600 shadow-sm transition hover:bg-rose-50">
                                                <x-icon name="user-x" class="h-3.5 w-3.5" />
                                                Nonaktifkan
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-14 text-center">
                                <div
                                    class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                    <x-icon name="users" class="h-7 w-7" />
                                </div>
                                <p class="mt-4 text-sm font-semibold text-slate-700">Data pasien tidak ditemukan.</p>
                                <p class="mt-1 text-xs text-slate-500">
                                    @if ($search)
                                        Coba kata kunci lain atau reset pencarian.
                                    @else
                                        Tambahkan pasien baru untuk memulai pendaftaran.
                                    @endif
                                </p>
                                <a href="{{ route('patients.create') }}"
                                    class="mt-4 inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-emerald-700">
                                    <x-icon name="plus" class="h-3.5 w-3.5" />
                                    Tambah Pasien
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($patients->hasPages())
            <div class="flex flex-col gap-3 border-t border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-xs text-slate-500">
                    Menampilkan
                    <span class="font-semibold text-slate-700">{{ $patients->firstItem() }}</span>
                    &ndash;
                    <span class="font-semibold text-slate-700">{{ $patients->lastItem() }}</span>
                    dari
                    <span class="font-semibold text-slate-700">{{ $patients->total() }}</span>
                    pasien
                </p>
                <div class="overflow-x-auto">
                    {{ $patients->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
