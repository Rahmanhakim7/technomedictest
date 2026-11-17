@extends('layouts.app')

@section('title', 'Pemeriksaan Awal')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="text-sm font-medium text-emerald-600">Layanan pemeriksaan</p>
            <h1 class="mt-1 text-2xl font-semibold tracking-tight text-slate-900">Pemeriksaan Awal Pasien</h1>
            <p class="mt-1 text-sm text-slate-500">
                Lanjutkan pemeriksaan untuk pendaftaran yang menunggu atau sedang diperiksa.
            </p>
        </div>

        <a href="{{ route('registrations.index') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:border-slate-300 hover:bg-slate-50">
            <x-icon name="clipboard-list" class="h-4 w-4" />
            Lihat Pendaftaran
        </a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-base font-semibold text-slate-900">Antrean Pemeriksaan</h2>
                <p class="mt-0.5 text-xs text-slate-500">Pendaftaran dengan status menunggu dan sedang diperiksa.</p>
            </div>
            <span class="inline-flex w-fit items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">
                <x-icon name="stethoscope" class="h-3.5 w-3.5" />
                {{ number_format($registrations->total(), 0, ',', '.') }} pendaftaran aktif
            </span>
        </div>

        <div class="overflow-x-auto scrollbar-thin">
            <table class="w-full min-w-[980px] text-left text-sm">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/80 text-xs uppercase tracking-wide text-slate-500">
                        <th class="px-5 py-3.5 font-semibold">No</th>
                        <th class="px-5 py-3.5 font-semibold">No. Pendaftaran</th>
                        <th class="px-5 py-3.5 font-semibold">Pasien</th>
                        <th class="px-5 py-3.5 font-semibold">Poliklinik</th>
                        <th class="px-5 py-3.5 font-semibold">Dokter</th>
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

                            <td class="px-5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-violet-100 text-xs font-semibold text-violet-700">
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
                                <x-status-badge :status="$registration->status" />
                            </td>

                            <td class="px-5 py-3.5">
                                <div class="flex justify-end">
                                    @if ($registration->status === 'MENUNGGU' && !$registration->examination)
                                        <a href="{{ route('examinations.create', $registration->id) }}"
                                            class="inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm shadow-emerald-200 transition hover:bg-emerald-700">
                                            <x-icon name="stethoscope" class="h-3.5 w-3.5" />
                                            Periksa
                                        </a>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 rounded-lg bg-slate-100 px-2.5 py-1.5 text-xs font-medium text-slate-500">
                                            <x-icon name="check-circle" class="h-3.5 w-3.5" />
                                            Sudah diperiksa
                                        </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-14 text-center">
                                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                    <x-icon name="stethoscope" class="h-7 w-7" />
                                </div>
                                <p class="mt-4 text-sm font-semibold text-slate-700">Belum ada pemeriksaan yang menunggu.</p>
                                <p class="mt-1 text-xs text-slate-500">Pendaftaran baru akan muncul di antrean ini.</p>
                                <a href="{{ route('registrations.create') }}"
                                    class="mt-4 inline-flex items-center gap-1.5 rounded-lg bg-emerald-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-emerald-700">
                                    <x-icon name="plus" class="h-3.5 w-3.5" />
                                    Buat Pendaftaran
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
