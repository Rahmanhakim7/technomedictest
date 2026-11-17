<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Polyclinic;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RegistrationController extends Controller
{
    public function index()
    {
        $registrations = Registration::with([
            'patient',
            'doctor',
            'polyclinic'
        ])
            ->latest()
            ->paginate(10);

        return view('registrations.index', compact('registrations'));
    }

    public function create()
    {
        $patients = Patient::where('is_active', true)
            ->orderBy('full_name')
            ->get();

        $polyclinics = Polyclinic::orderBy('name')->get();

        $doctors = Doctor::with('polyclinic')
            ->orderBy('name')
            ->get();

        return view('registrations.create', compact(
            'patients',
            'polyclinics',
            'doctors'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'registration_number' => 'required|string|max:30|unique:registrations,registration_number',
            'visit_date' => 'required|date',

            'patient_id' => [
                'required',
                'exists:patients,id,is_active,1',
            ],

            'polyclinic_id' => 'required|exists:polyclinics,id',
            'doctor_id' => 'required|exists:doctors,id',

            'payment_type' => 'required|in:UMUM,BPJS',
            'main_complaint' => 'required|string',
        ]);

        // Memastikan dokter sesuai dengan poliklinik
        $doctorMatches = Doctor::where('id', $validated['doctor_id'])
            ->where('polyclinic_id', $validated['polyclinic_id'])
            ->exists();

        if (!$doctorMatches) {
            throw ValidationException::withMessages([
                'doctor_id' => 'Dokter tidak sesuai dengan poliklinik yang dipilih.',
            ]);
        }

        // Memeriksa pendaftaran aktif pasien pada dokter yang sama
        $hasActiveRegistration = Registration::where(
            'patient_id',
            $validated['patient_id']
        )
            ->where('doctor_id', $validated['doctor_id'])
            ->whereIn('status', ['MENUNGGU', 'DIPERIKSA'])
            ->exists();

        if ($hasActiveRegistration) {
            throw ValidationException::withMessages([
                'patient_id' => 'Pasien masih memiliki pendaftaran aktif pada dokter tersebut.',
            ]);
        }

        Registration::create([
            ...$validated,
            'status' => 'MENUNGGU',
        ]);

        return redirect()
            ->route('registrations.index')
            ->with('success', 'Pendaftaran rawat jalan berhasil disimpan.');
    }

    public function updateStatus(Request $request, Registration $registration)
    {
        $validated = $request->validate([
            'status' => 'required|in:SELESAI,BATAL',
        ]);

        if (!in_array($registration->status, ['MENUNGGU', 'DIPERIKSA'])) {
            return redirect()
                ->route('registrations.index')
                ->with('error', 'Status pendaftaran ini tidak dapat diubah lagi.');
        }

        $registration->update([
            'status' => $validated['status'],
        ]);

        return redirect()
            ->route('registrations.index')
            ->with('success', 'Status pendaftaran berhasil diperbarui.');
    }
}
