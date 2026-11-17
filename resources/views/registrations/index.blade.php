@extends('layouts.app')

@section('title', 'Pendaftaran Rawat Jalan')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-medium text-emerald-600">Layanan rawat jalan</p>
            <h1 class="mt-1 text-2xl font-semibold tracking-tight text-slate-900">Pendaftaran Rawat Jalan</h1>
            <p class="mt-1 text-sm text-slate-500">
                Kelola pendaftaran pasien, poliklinik, dokter, dan status kunjungan.
            </p>
        </div>

        <a href="{{ route('registrations.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-emerald-200 transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
            <x-icon name="plus" class="h-4 w-4" />
            Pendaftaran Baru
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-base font-semibold text-slate-900">Daftar Pendaftaran</h2>
                <p class="mt-0.5 text-xs text-slate-500">Data terbaru ditampilkan lebih dahulu.</p>
            </div>
            <span class="inline-flex w-fit items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                <x-icon name="clipboard-list" class="h-3.5 w-3.5" />
                {{ number_format($registrations->total(), 0, ',', '.') }} pendaftaran
            </span>
        </div>

        <div class="overflow-x-auto scrollbar-thin">
            <table class="w-full min-w-[1100px] text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/80 text-xs uppercase tracking-wide text-slate-500">
                        <th class="px-5 py-3.5 font-semibold">No</th>
                        <th class="px-5 py-3.5 font-semibold">No. Pendaftaran</th>
                        <th class="px-5 py-3.5 font-semibold">Tanggal</th>
                        <th class="px-5 py-3.5 font-semibold">Pasien</th>
                        <th class="px-5 py-3.5 font-semibold">Poliklinik</th>
                        <th class="px-5 py-3.5 font-semibold">Dokter</th>
                        <th class="px-5 py-3.5 font-semibold">Pembayaran</th>
                        <th class="px-5 py-3.5 font-semibold">Status</th>
                        <th class="px-5 py-3.5 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse ($registrations as $index => $registration)
                        <tr class="transition hover:bg-slate-50/70">
                            <td class="px-5 py-3.5 text-slate-500">
                                {{ $registrations->firstItem() + $index }}
                            </td>

                            <td class="px-5 py-3.5">
                                <span class="inline-flex rounded-lg bg-slate-100 px-2.5 py-1 font-mono text-xs font-semibold text-slate-700">
                                    {{ $registration->registration_number }}
                                </span>
                            </td>

                            <td class="px-5 py-3.5 whitespace-nowrap text-slate-600">
                                {{ $registration->visit_date->format('d-m-Y') }}
                            </td>

                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-sky-100 text-xs font-semibold text-sky-700">
                                        {{ strtoupper(substr($registration->patient->full_name, 0, 1)) }}
                                    </span>
                                    <div class="min-w-0">
                                        <p class="truncate font-semibold text-slate-800">{{ $registration->patient->full_name }}</p>
                                        <p class="font-mono text-xs text-slate-500">{{ $registration->patient->medical_record_number }}</p>
                                    </div>
                                </div>
                            </td>

                            <td class="px-5 py-3.5">
                                <span class="inline-flex items-center gap-1.5 text-slate-600">
                                    <x-icon name="building" class="h-3.5 w-3.5 text-slate-400" />
                                    {{ $registration->polyclinic->name }}
                                </span>
                            </td>

                            <td class="px-5 py-3.5 text-slate-600">
                                {{ $registration->doctor->name }}
                            </td>

                            <td class="px-5 py-3.5">
                                <span @class([
                                    'inline-flex rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset',
                                    'bg-emerald-50 text-emerald-700 ring-emerald-200' => $registration->payment_type === 'BPJS',
                                    'bg-sky-50 text-sky-700 ring-sky-200' => $registration->payment_type === 'UMUM',
                                ])>
                                    {{ $registration->payment_type }}
                                </span>
                            </td>

                            <td class="px-5 py-3.5">
                                <x-status-badge :status="$registration->status" />
                            </td>

                            <td class="px-5 py-3.5">
                                <div class="flex items-center justify-end gap-1.5">
                                    @if (in_array($registration->status, ['MENUNGGU', 'DIPERIKSA']))
                                        <form action="{{ route('registrations.updateStatus', $registration->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="SELESAI">

                                            <button type="submit"
                                                class="inline-flex items-center gap-1.5 rounded-lg border border-emerald-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-emerald-700 shadow-sm transition hover:bg-emerald-50">
                                                <x-icon name="check" class="h-3.5 w-3.5" />
                                                Selesaikan
                                            </button>
                                        </form>

                                        <form action="{{ route('registrations.updateStatus', $registration->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin membatalkan pendaftaran ini?')">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="BATAL">

                                            <button type="submit"
                                                class="inline-flex items-center gap-1.5 rounded-lg border border-rose-200 bg-white px-2.5 py-1.5 text-xs font-semibold text-rose-600 shadow-sm transition hover:bg-rose-50">
                                                <x-icon name="ban" class="h-3.5 w-3.5" />
                                                Batalkan
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-slate-400">Tidak ada aksi</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-5 py-14 text-center">
                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                    <x-icon name="clipboard-list" class="h-7 w-7" />
                                </div>
                                <p class="mt-4 text-sm font-semibold text-slate-700">Belum ada data pendaftaran.</p>
                                <p class="mt-1 text-xs text-slate-500">Buat pendaftaran baru untuk pasien yang akan berobat.</p>
                                <a href="{{ route('registrations.create') }}"
                                    class="mt-4 inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-emerald-700">
                                    <x-icon name="plus" class="h-3.5 w-3.5" />
                                    Pendaftaran Baru
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($registrations->hasPages())
            <div class="flex flex-col gap-3 border-t border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                <p class="text-xs text-slate-500">
                    Menampilkan
                    <span class="font-semibold text-slate-700">{{ $registrations->firstItem() }}</span>
                    &ndash;
                    <span class="font-semibold text-slate-700">{{ $registrations->lastItem() }}</span>
                    dari
                    <span class="font-semibold text-slate-700">{{ $registrations->total() }}</span>
                    pendaftaran
                </p>
                <div class="overflow-x-auto">
                    {{ $registrations->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection
