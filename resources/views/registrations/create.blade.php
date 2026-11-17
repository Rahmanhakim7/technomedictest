@extends('layouts.app')

@section('title', 'Pendaftaran Baru')

@section('content')
    <div>
        <a href="{{ route('registrations.index') }}"
            class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 transition hover:text-emerald-700">
            <x-icon name="arrow-left" class="h-4 w-4" />
            Kembali ke Pendaftaran
        </a>
        <h1 class="mt-2 text-2xl font-semibold tracking-tight text-slate-900">Form Pendaftaran Rawat Jalan</h1>
        <p class="mt-1 text-sm text-slate-500">
            Daftarkan pasien ke poliklinik dan dokter tujuan.
        </p>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <div class="lg:col-span-2">
            <form action="{{ route('registrations.store') }}" method="POST"
                class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                @csrf

                <div class="border-b border-slate-100 px-5 py-4 sm:px-6">
                    <h2 class="text-base font-semibold text-slate-900">Data Kunjungan</h2>
                    <p class="mt-0.5 text-xs text-slate-500">Kolom bertanda <span class="text-rose-500">*</span> wajib diisi.</p>
                </div>

                <div class="space-y-6 px-5 py-5 sm:px-6">
                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                        <div>
                            <label for="registration_number" class="mb-1.5 block text-sm font-semibold text-slate-700">
                                Nomor Pendaftaran <span class="text-rose-500">*</span>
                            </label>
                            <input type="text" id="registration_number" name="registration_number"
                                value="{{ old('registration_number') }}" maxlength="30" required autocomplete="off"
                                placeholder="Contoh: REG-20261117-001"
                                class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
                            @error('registration_number')
                                <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="visit_date" class="mb-1.5 block text-sm font-semibold text-slate-700">
                                Tanggal Kunjungan <span class="text-rose-500">*</span>
                            </label>
                            <input type="date" id="visit_date" name="visit_date"
                                value="{{ old('visit_date', date('Y-m-d')) }}" required
                                class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 shadow-sm outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
                            @error('visit_date')
                                <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="border-t border-slate-100 pt-5">
                        <h3 class="text-sm font-semibold text-slate-900">Pasien &amp; Layanan</h3>
                    </div>

                    <div>
                        <label for="patient_id" class="mb-1.5 block text-sm font-semibold text-slate-700">
                            Pasien <span class="text-rose-500">*</span>
                        </label>
                        <select id="patient_id" name="patient_id" required
                            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 shadow-sm outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
                            <option value="">Pilih pasien aktif</option>
                            @foreach ($patients as $patient)
                                <option value="{{ $patient->id }}" @selected(old('patient_id') == $patient->id)>
                                    {{ $patient->medical_record_number }} &mdash; {{ $patient->full_name }}
                                </option>
                            @endforeach
                        </select>
                        @if ($patients->isEmpty())
                            <p class="mt-1.5 flex items-center gap-1.5 text-xs font-medium text-amber-700">
                                <x-icon name="info" class="h-3.5 w-3.5" />
                                Belum ada pasien aktif.
                                <a href="{{ route('patients.create') }}" class="font-semibold underline hover:text-amber-900">
                                    Tambah pasien terlebih dahulu
                                </a>
                            </p>
                        @endif
                        @error('patient_id')
                            <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
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
                            @error('polyclinic_id')
                                <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="doctor_id" class="mb-1.5 block text-sm font-semibold text-slate-700">
                                Dokter <span class="text-rose-500">*</span>
                            </label>
                            <select id="doctor_id" name="doctor_id" required
                                class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 shadow-sm outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
                                <option value="">Pilih dokter</option>
                                @foreach ($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" data-polyclinic="{{ $doctor->polyclinic_id }}"
                                        @selected(old('doctor_id') == $doctor->id)>
                                        {{ $doctor->name }} &mdash; {{ $doctor->polyclinic->name }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="mt-1.5 text-xs text-slate-500">Pilih poliklinik untuk menyaring dokter yang tersedia.</p>
                            @error('doctor_id')
                                <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="border-t border-slate-100 pt-5">
                        <h3 class="text-sm font-semibold text-slate-900">Pembayaran &amp; Keluhan</h3>
                    </div>

                    <div>
                        <label for="payment_type" class="mb-1.5 block text-sm font-semibold text-slate-700">
                            Jenis Pembayaran <span class="text-rose-500">*</span>
                        </label>
                        <select id="payment_type" name="payment_type" required
                            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 shadow-sm outline-none transition focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">
                            <option value="">Pilih jenis pembayaran</option>
                            <option value="UMUM" @selected(old('payment_type') === 'UMUM')>UMUM</option>
                            <option value="BPJS" @selected(old('payment_type') === 'BPJS')>BPJS</option>
                        </select>
                        @error('payment_type')
                            <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="main_complaint" class="mb-1.5 block text-sm font-semibold text-slate-700">
                            Keluhan Utama <span class="text-rose-500">*</span>
                        </label>
                        <textarea id="main_complaint" name="main_complaint" rows="4" required
                            placeholder="Tuliskan keluhan utama pasien..."
                            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-800 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-emerald-400 focus:ring-4 focus:ring-emerald-100">{{ old('main_complaint') }}</textarea>
                        @error('main_complaint')
                            <p class="mt-1.5 text-xs font-medium text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col-reverse gap-2 border-t border-slate-100 bg-slate-50/60 px-5 py-4 sm:flex-row sm:justify-end sm:px-6">
                    <a href="{{ route('registrations.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm shadow-emerald-200 transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        <x-icon name="check" class="h-4 w-4" />
                        Simpan Pendaftaran
                    </button>
                </div>
            </form>
        </div>

        <aside class="space-y-4">
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <x-icon name="clipboard-list" class="h-5 w-5" />
                </div>
                <h2 class="mt-3 text-sm font-semibold text-slate-900">Alur Pendaftaran</h2>
                <ol class="mt-3 space-y-3 text-xs leading-relaxed text-slate-500">
                    <li class="flex gap-2.5">
                        <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-[10px] font-bold text-emerald-700">1</span>
                        Pilih pasien aktif dan tentukan tanggal kunjungan.
                    </li>
                    <li class="flex gap-2.5">
                        <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-[10px] font-bold text-emerald-700">2</span>
                        Tentukan poliklinik, lalu pilih dokter yang sesuai.
                    </li>
                    <li class="flex gap-2.5">
                        <span class="flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-[10px] font-bold text-emerald-700">3</span>
                        Lengkapi pembayaran dan keluhan utama pasien.
                    </li>
                </ol>
            </div>

            <div class="rounded-2xl border border-sky-100 bg-sky-50 p-4 text-xs leading-relaxed text-sky-800">
                <div class="flex items-center gap-2 font-semibold">
                    <x-icon name="info" class="h-4 w-4" />
                    Status pendaftaran
                </div>
                <p class="mt-1.5">
                    Pendaftaran baru otomatis tersimpan dengan status <strong>Menunggu</strong> hingga pasien menjalani pemeriksaan awal.
                </p>
            </div>
        </aside>
    </div>
@endsection

@push('scripts')
    <script>
        const polyclinicSelect = document.getElementById('polyclinic_id');
        const doctorSelect = document.getElementById('doctor_id');

        function filterDoctors() {
            if (!polyclinicSelect || !doctorSelect) {
                return;
            }

            const selectedPolyclinic = polyclinicSelect.value;

            doctorSelect.value = '';

            Array.from(doctorSelect.options).forEach((option) => {
                if (!option.value) {
                    option.hidden = false;
                    return;
                }

                option.hidden = option.dataset.polyclinic !== selectedPolyclinic;
            });

            const oldDoctorId = @json(old('doctor_id'));

            if (oldDoctorId) {
                const oldDoctor = Array.from(doctorSelect.options).find(
                    (option) => option.value === String(oldDoctorId)
                );

                if (oldDoctor && !oldDoctor.hidden) {
                    doctorSelect.value = oldDoctorId;
                }
            }
        }

        polyclinicSelect?.addEventListener('change', filterDoctors);

        filterDoctors();
    </script>
@endpush
