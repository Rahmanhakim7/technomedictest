@extends('layouts.app')

@section('title', 'Tambah Dokter')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <a href="{{ route('doctors.index') }}"
                class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 transition hover:text-emerald-700">
                <x-icon name="arrow-left" class="h-4 w-4" />
                Kembali ke Data Dokter
            </a>
            <h1 class="mt-2 text-2xl font-semibold tracking-tight text-slate-900">Tambah Dokter</h1>
            <p class="mt-1 text-sm text-slate-500">
                Lengkapi data dokter dan hubungkan dengan poliklinik tempat praktik.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <form action="{{ route('doctors.store') }}" method="POST"
                class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                @csrf

                <div class="border-b border-slate-100 px-5 py-4 sm:px-6">
                    <h2 class="text-base font-semibold text-slate-900">Informasi Dokter</h2>
                    <p class="mt-0.5 text-xs text-slate-500">Kolom bertanda <span class="text-rose-500">*</span> wajib diisi.</p>
                </div>

                <div class="space-y-5 px-5 py-5 sm:px-6">
                    <div>
                        <label for="name" class="mb-1.5 block text-sm font-semibold text-slate-700">
                            Nama Dokter <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" maxlength="150" required
                            autocomplete="name" placeholder="Contoh: dr. Andi Pratama"
                            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
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
                                value="{{ old('specialization') }}" maxlength="100" autocomplete="off"
                                placeholder="Contoh: Penyakit Dalam"
                                class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
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
                                <input type="text" id="phone" name="phone" value="{{ old('phone') }}" maxlength="20"
                                    autocomplete="tel" placeholder="08xxxxxxxxxx"
                                    class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-3.5 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
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
                        <select id="polyclinic_id" name="polyclinic_id" required
                            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 shadow-sm outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
                            <option value="">Pilih poliklinik</option>
                            @foreach ($polyclinics as $polyclinic)
                                <option value="{{ $polyclinic->id }}" @selected(old('polyclinic_id') == $polyclinic->id)>
                                    {{ $polyclinic->name }}
                                </option>
                            @endforeach
                        </select>
                        @if ($polyclinics->isEmpty())
                            <p class="mt-1.5 flex items-center gap-1.5 text-xs font-medium text-amber-700">
                                <x-icon name="info" class="h-3.5 w-3.5" />
                                Belum ada poliklinik.
                                <a href="{{ route('polyclinics.create') }}" class="font-semibold underline hover:text-amber-900">
                                    Tambah poliklinik terlebih dahulu
                                </a>
                            </p>
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
                        Simpan Dokter
                    </button>
                </div>
            </form>
        </div>

        <aside class="space-y-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <x-icon name="info" class="h-5 w-5" />
                </div>
                <h2 class="mt-3 text-sm font-semibold text-slate-900">Informasi</h2>
                <ul class="mt-2 space-y-2 text-xs leading-relaxed text-slate-500">
                    <li>Setiap dokter wajib terhubung dengan salah satu poliklinik yang tersedia.</li>
                    <li>Spesialisasi dan nomor telepon bersifat opsional.</li>
                    <li>Dokter yang sudah memiliki riwayat pendaftaran tidak dapat dihapus.</li>
                </ul>
            </div>
        </aside>
    </div>
@endsection
