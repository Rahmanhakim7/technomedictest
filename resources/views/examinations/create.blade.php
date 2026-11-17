@extends('layouts.app')

@section('title', 'Form Pemeriksaan Awal')

@section('content')
    <div>
        <a href="{{ route('examinations.index') }}"
            class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 transition hover:text-emerald-700">
            <x-icon name="arrow-left" class="h-4 w-4" />
            Kembali ke Pemeriksaan
        </a>
        <h1 class="mt-2 text-2xl font-semibold tracking-tight text-slate-900">Form Pemeriksaan Awal</h1>
        <p class="mt-1 text-sm text-slate-500">
            Catat keluhan dan tanda-tanda vital pasien sebelum pemeriksaan dokter.
        </p>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <form action="{{ route('examinations.store', $registration->id) }}" method="POST"
                class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                @csrf

                <div class="border-b border-slate-100 px-5 py-4 sm:px-6">
                    <h2 class="text-base font-semibold text-slate-900">Data Pemeriksaan</h2>
                    <p class="mt-0.5 text-xs text-slate-500">Kolom bertanda <span class="text-rose-500">*</span> wajib diisi.</p>
                </div>

                <div class="space-y-6 px-5 py-5 sm:px-6">
                    <div>
                        <label for="complaint" class="mb-1.5 block text-sm font-semibold text-slate-700">
                            Keluhan <span class="text-rose-500">*</span>
                        </label>
                        <textarea id="complaint" name="complaint" rows="3" required
                            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 shadow-sm outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">{{ old('complaint', $registration->main_complaint) }}</textarea>
                        @error('complaint')
                            <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="border-t border-slate-100 pt-5">
                        <div class="flex items-center gap-2">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-rose-50 text-rose-500">
                                <x-icon name="heart-pulse" class="h-4 w-4" />
                            </span>
                            <h3 class="text-sm font-semibold text-slate-900">Tanda-Tanda Vital</h3>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                        <div>
                            <label for="systolic" class="mb-1.5 block text-sm font-semibold text-slate-700">
                                Sistolik <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" id="systolic" name="systolic" min="50" max="300"
                                    value="{{ old('systolic') }}" required
                                    class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-3.5 pr-14 text-sm text-slate-800 shadow-sm outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
                                <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-xs text-slate-400">mmHg</span>
                            </div>
                            @error('systolic')
                                <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="diastolic" class="mb-1.5 block text-sm font-semibold text-slate-700">
                                Diastolik <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" id="diastolic" name="diastolic" min="30" max="200"
                                    value="{{ old('diastolic') }}" required
                                    class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-3.5 pr-14 text-sm text-slate-800 shadow-sm outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
                                <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-xs text-slate-400">mmHg</span>
                            </div>
                            @error('diastolic')
                                <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="pulse" class="mb-1.5 block text-sm font-semibold text-slate-700">
                                Denyut Nadi <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" id="pulse" name="pulse" min="20" max="250"
                                    value="{{ old('pulse') }}" required
                                    class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-3.5 pr-14 text-sm text-slate-800 shadow-sm outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
                                <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-xs text-slate-400">x/mnt</span>
                            </div>
                            @error('pulse')
                                <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="temperature" class="mb-1.5 block text-sm font-semibold text-slate-700">
                                Suhu Tubuh <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" id="temperature" name="temperature" min="30" max="45"
                                    step="0.1" value="{{ old('temperature') }}" required
                                    class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-3.5 pr-10 text-sm text-slate-800 shadow-sm outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
                                <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-xs text-slate-400">&deg;C</span>
                            </div>
                            @error('temperature')
                                <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="respiratory_rate" class="mb-1.5 block text-sm font-semibold text-slate-700">
                                Frekuensi Napas <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" id="respiratory_rate" name="respiratory_rate" min="5"
                                    max="80" value="{{ old('respiratory_rate') }}" required
                                    class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-3.5 pr-14 text-sm text-slate-800 shadow-sm outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
                                <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-xs text-slate-400">x/mnt</span>
                            </div>
                            @error('respiratory_rate')
                                <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="weight" class="mb-1.5 block text-sm font-semibold text-slate-700">
                                Berat Badan <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" id="weight" name="weight" min="1" max="500"
                                    step="0.01" value="{{ old('weight') }}" required
                                    class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-3.5 pr-10 text-sm text-slate-800 shadow-sm outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
                                <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-xs text-slate-400">kg</span>
                            </div>
                            @error('weight')
                                <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="height" class="mb-1.5 block text-sm font-semibold text-slate-700">
                                Tinggi Badan <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" id="height" name="height" min="20" max="250"
                                    step="0.01" value="{{ old('height') }}" required
                                    class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-3.5 pr-10 text-sm text-slate-800 shadow-sm outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
                                <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-xs text-slate-400">cm</span>
                            </div>
                            @error('height')
                                <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="examined_at" class="mb-1.5 block text-sm font-semibold text-slate-700">
                                Waktu Pemeriksaan <span class="text-rose-500">*</span>
                            </label>
                            <input type="datetime-local" id="examined_at" name="examined_at"
                                value="{{ old('examined_at', now()->format('Y-m-d\TH:i')) }}" required
                                class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 shadow-sm outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
                            @error('examined_at')
                                <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="border-t border-slate-100 pt-5">
                        <h3 class="text-sm font-semibold text-slate-900">Petugas Pemeriksa</h3>
                    </div>

                    <div>
                        <label for="examiner_name" class="mb-1.5 block text-sm font-semibold text-slate-700">
                            Nama Petugas <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="examiner_name" name="examiner_name"
                            value="{{ old('examiner_name') }}" maxlength="150" required autocomplete="name"
                            placeholder="Nama petugas yang melakukan pemeriksaan"
                            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
                        @error('examiner_name')
                            <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-2 border-t border-slate-100 bg-slate-50/60 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                    <a href="{{ route('examinations.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-emerald-200 transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        <x-icon name="check" class="h-4 w-4" />
                        Simpan Pemeriksaan
                    </button>
                </div>
            </form>
        </div>

        <aside class="space-y-4">
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="border-b border-slate-100 bg-gradient-to-r from-emerald-50 to-teal-50 px-5 py-4">
                    <p class="text-xs font-semibold uppercase tracking-wide text-emerald-700">Informasi Pasien</p>
                    <p class="mt-1 text-base font-semibold text-slate-900">{{ $registration->patient->full_name }}</p>
                    <p class="font-mono text-xs text-slate-500">{{ $registration->patient->medical_record_number }}</p>
                </div>

                <dl class="space-y-3 px-5 py-4 text-xs">
                    <div class="flex items-start justify-between gap-3">
                        <dt class="text-slate-500">No. Pendaftaran</dt>
                        <dd class="text-right font-mono font-medium text-slate-700">{{ $registration->registration_number }}</dd>
                    </div>
                    <div class="flex items-start justify-between gap-3">
                        <dt class="text-slate-500">Poliklinik</dt>
                        <dd class="text-right font-medium text-slate-700">{{ $registration->polyclinic->name }}</dd>
                    </div>
                    <div class="flex items-start justify-between gap-3">
                        <dt class="text-slate-500">Dokter</dt>
                        <dd class="text-right font-medium text-slate-700">{{ $registration->doctor->name }}</dd>
                    </div>
                    <div class="flex items-start justify-between gap-3">
                        <dt class="text-slate-500">Tanggal kunjungan</dt>
                        <dd class="text-right font-medium text-slate-700">{{ $registration->visit_date->format('d-m-Y') }}</dd>
                    </div>
                    <div class="border-t border-slate-100 pt-3">
                        <dt class="text-slate-500">Keluhan utama pendaftaran</dt>
                        <dd class="mt-1 leading-relaxed text-slate-700">{{ $registration->main_complaint }}</dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-2xl border border-amber-100 bg-amber-50 p-4 text-xs leading-relaxed text-amber-800">
                <div class="flex items-center gap-2 font-semibold">
                    <x-icon name="info" class="h-4 w-4" />
                    Catatan
                </div>
                <p class="mt-1.5">
                    Pemeriksaan awal hanya dapat disimpan satu kali. Setelah disimpan, status pendaftaran berubah menjadi
                    <strong>Diperiksa</strong>.
                </p>
            </div>
        </aside>
    </div>
@endsection
