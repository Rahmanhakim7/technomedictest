@extends('layouts.app')

@section('title', 'Edit Dokter')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <a href="{{ route('doctors.index') }}"
                class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 transition hover:text-emerald-700">
                <x-icon name="arrow-left" class="h-4 w-4" />
                Kembali ke Data Dokter
            </a>
            <h1 class="mt-2 text-2xl font-semibold tracking-tight text-slate-900">Edit Data Dokter</h1>
            <p class="mt-1 text-sm text-slate-500">
                Perbarui identitas, kontak, dan poliklinik dokter.
            </p>
        </div>

        <span
            class="inline-flex items-center gap-1.5 self-start rounded-full bg-violet-50 px-2.5 py-1 text-xs font-semibold text-violet-700 ring-1 ring-inset ring-violet-200 sm:self-auto">
            <x-icon name="stethoscope" class="h-3.5 w-3.5" />
            {{ $doctor->polyclinic->name }}
        </span>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <form action="{{ route('doctors.update', $doctor->id) }}" method="POST"
                class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                @csrf
                @method('PUT')

                <div class="border-b border-slate-100 px-5 py-4 sm:px-6">
                    <h2 class="text-base font-semibold text-slate-900">Informasi Dokter</h2>
                    <p class="mt-0.5 text-xs text-slate-500">Kolom bertanda <span class="text-rose-500">*</span> wajib diisi.</p>
                </div>

                <div class="space-y-5 px-5 py-5 sm:px-6">
                    <div>
                        <label for="name" class="mb-1.5 block text-sm font-semibold text-slate-700">
                            Nama Dokter <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name', $doctor->name) }}" maxlength="150"
                            required autocomplete="name"
                            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 shadow-sm outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
                        @error('name')
                            <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <label for="specialization" class="mb-1.5 block text-sm font-semibold text-slate-700">
                                Spesialisasi
                            </label>
                            <input type="text" id="specialization" name="specialization"
                                value="{{ old('specialization', $doctor->specialization) }}" maxlength="100"
                                autocomplete="off"
                                class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 shadow-sm outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
                            @error('specialization')
                                <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" class="mb-1.5 block text-sm font-semibold text-slate-700">Nomor Telepon</label>
                            <div class="relative">
                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                    <x-icon name="phone" class="h-4 w-4" />
                                </span>
                                <input type="text" id="phone" name="phone" value="{{ old('phone', $doctor->phone) }}"
                                    maxlength="20" autocomplete="tel"
                                    class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-3.5 text-sm text-slate-800 shadow-sm outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
                            </div>
                            @error('phone')
                                <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="polyclinic_id" class="mb-1.5 block text-sm font-semibold text-slate-700">
                            Poliklinik <span class="text-rose-500">*</span>
                        </label>

                        @if ($doctor->registrations_count > 0)
                            <select id="polyclinic_id" disabled
                                class="w-full cursor-not-allowed rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2.5 text-sm text-slate-500 shadow-sm outline-none">
                                @foreach ($polyclinics as $polyclinic)
                                    <option value="{{ $polyclinic->id }}" @selected($polyclinic->id == $doctor->polyclinic_id)>
                                        {{ $polyclinic->name }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="polyclinic_id" value="{{ old('polyclinic_id', $doctor->polyclinic_id) }}">
                            <p class="mt-1.5 flex items-center gap-1.5 text-xs font-medium text-amber-700">
                                <x-icon name="info" class="h-3.5 w-3.5" />
                                Poliklinik tidak dapat diubah karena dokter sudah memiliki riwayat pendaftaran.
                            </p>
                        @else
                            <select id="polyclinic_id" name="polyclinic_id" required
                                class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 shadow-sm outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
                                <option value="">Pilih poliklinik</option>
                                @foreach ($polyclinics as $polyclinic)
                                    <option value="{{ $polyclinic->id }}" @selected(old('polyclinic_id', $doctor->polyclinic_id) == $polyclinic->id)>
                                        {{ $polyclinic->name }}
                                    </option>
                                @endforeach
                            </select>
                        @endif

                        @error('polyclinic_id')
                            <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-2 border-t border-slate-100 bg-slate-50/60 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                    <a href="{{ route('doctors.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-emerald-200 transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        <x-icon name="check" class="h-4 w-4" />
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <aside class="space-y-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex items-center gap-3">
                    <span
                        class="flex h-11 w-11 items-center justify-center rounded-full bg-violet-100 text-base font-semibold text-violet-700">
                        {{ strtoupper(substr($doctor->name, 0, 1)) }}
                    </span>
                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-slate-900">{{ $doctor->name }}</p>
                        <p class="text-xs text-slate-500">{{ $doctor->specialization ?: 'Spesialisasi belum diisi' }}</p>
                    </div>
                </div>

                <dl class="mt-4 space-y-2.5 border-t border-slate-100 pt-4 text-xs">
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-slate-500">Poliklinik</dt>
                        <dd class="font-semibold text-slate-700">{{ $doctor->polyclinic->name }}</dd>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-slate-500">Riwayat pendaftaran</dt>
                        <dd class="font-semibold text-slate-700">{{ $doctor->registrations_count }}</dd>
                    </div>
                </dl>
            </div>

            @if ($doctor->registrations_count > 0)
                <div class="rounded-2xl border border-amber-100 bg-amber-50 p-4 text-xs leading-relaxed text-amber-800">
                    <div class="flex items-center gap-2 font-semibold">
                        <x-icon name="info" class="h-4 w-4" />
                        Catatan
                    </div>
                    <p class="mt-1.5">
                        Dokter ini sudah memiliki riwayat pendaftaran. Data identitas dan kontak masih dapat diperbarui,
                        tetapi poliklinik tidak dapat dipindahkan dan dokter belum dapat dihapus.
                    </p>
                </div>
            @endif
        </aside>
    </div>
@endsection
