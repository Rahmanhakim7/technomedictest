@extends('layouts.app')

@section('title', 'Edit Pasien')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <a href="{{ route('patients.index') }}"
                class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 transition hover:text-emerald-700">
                <x-icon name="arrow-left" class="h-4 w-4" />
                Kembali ke Data Pasien
            </a>
            <h1 class="mt-2 text-2xl font-semibold tracking-tight text-slate-900">Edit Data Pasien</h1>
            <p class="mt-1 text-sm text-slate-500">
                Perbarui identitas dan informasi kontak pasien.
            </p>
        </div>

        <x-status-badge :status="$patient->is_active ? 'AKTIF' : 'NONAKTIF'" class="self-start sm:self-auto" />
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <form action="{{ route('patients.update', $patient->id) }}" method="POST"
                class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                @csrf
                @method('PUT')

                <div class="border-b border-slate-100 px-5 py-4 sm:px-6">
                    <h2 class="text-base font-semibold text-slate-900">Identitas Pasien</h2>
                    <p class="mt-0.5 text-xs text-slate-500">Kolom bertanda <span class="text-rose-500">*</span> wajib diisi.</p>
                </div>

                <div class="space-y-5 px-5 py-5 sm:px-6">
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <label for="medical_record_number" class="mb-1.5 block text-sm font-semibold text-slate-700">
                                Nomor Rekam Medis <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="medical_record_number" name="medical_record_number"
                                value="{{ old('medical_record_number', $patient->medical_record_number) }}" required
                                autocomplete="off"
                                class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 shadow-sm outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
                            @error('medical_record_number')
                                <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="nik" class="mb-1.5 block text-sm font-semibold text-slate-700">
                                NIK <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="nik" name="nik" maxlength="16"
                                value="{{ old('nik', $patient->nik) }}" required inputmode="numeric" autocomplete="off"
                                class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 shadow-sm outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
                            @error('nik')
                                <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="full_name" class="mb-1.5 block text-sm font-semibold text-slate-700">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="full_name" name="full_name"
                            value="{{ old('full_name', $patient->full_name) }}" required autocomplete="name"
                            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 shadow-sm outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
                        @error('full_name')
                            <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <label for="gender" class="mb-1.5 block text-sm font-semibold text-slate-700">
                                Jenis Kelamin <span class="text-rose-500">*</span>
                            </label>
                            <select id="gender" name="gender" required
                                class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 shadow-sm outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
                                <option value="">Pilih jenis kelamin</option>
                                <option value="Laki-laki" @selected(old('gender', $patient->gender) === 'Laki-laki')>Laki-laki</option>
                                <option value="Perempuan" @selected(old('gender', $patient->gender) === 'Perempuan')>Perempuan</option>
                            </select>
                            @error('gender')
                                <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="birth_date" class="mb-1.5 block text-sm font-semibold text-slate-700">
                                Tanggal Lahir <span class="text-rose-500">*</span>
                            </label>
                            <input type="date" id="birth_date" name="birth_date"
                                value="{{ old('birth_date', $patient->birth_date->format('Y-m-d')) }}"
                                max="{{ date('Y-m-d') }}" required
                                class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 shadow-sm outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
                            @error('birth_date')
                                <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="phone" class="mb-1.5 block text-sm font-semibold text-slate-700">Nomor Telepon</label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                                <x-icon name="phone" class="h-4 w-4" />
                            </span>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $patient->phone) }}"
                                maxlength="20" autocomplete="tel"
                                class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-3.5 text-sm text-slate-800 shadow-sm outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
                        </div>
                        @error('phone')
                            <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="address" class="mb-1.5 block text-sm font-semibold text-slate-700">Alamat</label>
                        <textarea id="address" name="address" rows="3"
                            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 shadow-sm outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">{{ old('address', $patient->address) }}</textarea>
                        @error('address')
                            <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-2 border-t border-slate-100 bg-slate-50/60 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                    <a href="{{ route('patients.index') }}"
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
                    <span class="flex h-11 w-11 items-center justify-center rounded-full bg-emerald-100 text-base font-semibold text-emerald-700">
                        {{ strtoupper(substr($patient->full_name, 0, 1)) }}
                    </span>
                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-slate-900">{{ $patient->full_name }}</p>
                        <p class="font-mono text-xs text-slate-500">{{ $patient->medical_record_number }}</p>
                    </div>
                </div>

                <dl class="mt-4 space-y-2.5 border-t border-slate-100 pt-4 text-xs">
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-slate-500">NIK</dt>
                        <dd class="font-mono font-medium text-slate-700">{{ $patient->nik }}</dd>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-slate-500">Jenis kelamin</dt>
                        <dd class="font-medium text-slate-700">{{ $patient->gender }}</dd>
                    </div>
                    <div class="flex items-center justify-between gap-3">
                        <dt class="text-slate-500">Tanggal lahir</dt>
                        <dd class="font-medium text-slate-700">{{ $patient->birth_date->format('d-m-Y') }}</dd>
                    </div>
                </dl>
            </div>

            <div class="rounded-2xl border border-amber-100 bg-amber-50 p-4 text-xs leading-relaxed text-amber-800">
                <div class="flex items-center gap-2 font-semibold">
                    <x-icon name="info" class="h-4 w-4" />
                    Catatan
                </div>
                <p class="mt-1.5">Perubahan data identitas akan langsung digunakan pada pendaftaran berikutnya.</p>
            </div>
        </aside>
    </div>
@endsection
