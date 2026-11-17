@extends('layouts.app')

@section('title', 'Tambah Poliklinik')

@section('content')
    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <a href="{{ route('polyclinics.index') }}"
                class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 transition hover:text-emerald-700">
                <x-icon name="arrow-left" class="h-4 w-4" />
                Kembali ke Data Poliklinik
            </a>
            <h1 class="mt-2 text-2xl font-semibold tracking-tight text-slate-900">Tambah Poliklinik</h1>
            <p class="mt-1 text-sm text-slate-500">
                Tambahkan unit layanan baru yang akan tersedia pada pendaftaran rawat jalan.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <form action="{{ route('polyclinics.store') }}" method="POST"
                class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                @csrf

                <div class="border-b border-slate-100 px-5 py-4 sm:px-6">
                    <h2 class="text-base font-semibold text-slate-900">Informasi Poliklinik</h2>
                    <p class="mt-0.5 text-xs text-slate-500">Kolom bertanda <span class="text-rose-500">*</span> wajib diisi.</p>
                </div>

                <div class="space-y-5 px-5 py-5 sm:px-6">
                    <div>
                        <label for="name" class="mb-1.5 block text-sm font-semibold text-slate-700">
                            Nama Poliklinik <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" maxlength="100" required
                            autocomplete="off" placeholder="Contoh: Poliklinik Umum"
                            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
                        @error('name')
                            <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="description" class="mb-1.5 block text-sm font-semibold text-slate-700">Deskripsi</label>
                        <textarea id="description" name="description" rows="4"
                            placeholder="Jelaskan layanan atau cakupan poliklinik ini..."
                            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-2 border-t border-slate-100 bg-slate-50/60 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                    <a href="{{ route('polyclinics.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-emerald-200 transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        <x-icon name="check" class="h-4 w-4" />
                        Simpan Poliklinik
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
                    <li>Nama poliklinik wajib diisi dan tidak boleh sama dengan poliklinik lain.</li>
                    <li>Poliklinik yang sudah digunakan dokter atau memiliki riwayat pendaftaran tidak dapat dihapus.</li>
                    <li>Deskripsi bersifat opsional dan membantu petugas memahami cakupan layanan.</li>
                </ul>
            </div>
        </aside>
    </div>
@endsection
