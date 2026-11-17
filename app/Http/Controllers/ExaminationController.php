<?php

namespace App\Http\Controllers;

use App\Models\Examination;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ExaminationController extends Controller
{
    public function index()
    {
        $registrations = Registration::with([
            'patient',
            'doctor',
            'polyclinic',
            'examination',
        ])
            ->whereIn('status', ['MENUNGGU', 'DIPERIKSA'])
            ->latest()
            ->paginate(10);

        return view('examinations.index', compact('registrations'));
    }
    public function create(Registration $registration)
    {
        $registration->load([
            'patient',
            'doctor',
            'polyclinic',
            'examination',
        ]);

        if ($registration->status !== 'MENUNGGU') {
            return redirect()
                ->route('examinations.index')
                ->with('error', 'Pendaftaran ini tidak dapat diperiksa.');
        }

        if ($registration->examination) {
            return redirect()
                ->route('examinations.index')
                ->with('error', 'Pemeriksaan untuk pendaftaran ini sudah tersedia.');
        }

        return view('examinations.create', compact('registration'));
    }
    public function store(Request $request, Registration $registration)
    {
        $validated = $request->validate([
            'complaint' => 'required|string',
            'systolic' => 'required|integer|between:50,300',
            'diastolic' => 'required|integer|between:30,200',
            'pulse' => 'required|integer|between:20,250',
            'temperature' => 'required|numeric|between:30,45',
            'respiratory_rate' => 'required|integer|between:5,80',
            'weight' => 'required|numeric|between:1,500',
            'height' => 'required|numeric|between:20,250',
            'examined_at' => 'required|date',
            'examiner_name' => 'required|string|max:150',
        ]);

        DB::transaction(function () use ($registration, $validated) {
            $lockedRegistration = Registration::whereKey($registration->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedRegistration->status !== 'MENUNGGU') {
                throw ValidationException::withMessages([
                    'registration' => 'Pendaftaran ini tidak lagi menunggu pemeriksaan.',
                ]);
            }

            if (Examination::where('registration_id', $lockedRegistration->id)->exists()) {
                throw ValidationException::withMessages([
                    'registration' => 'Pemeriksaan untuk pendaftaran ini sudah tersedia.',
                ]);
            }

            Examination::create([
                'registration_id' => $lockedRegistration->id,
                ...$validated,
            ]);

            $lockedRegistration->update([
                'status' => 'DIPERIKSA',
            ]);
        });

        return redirect()
            ->route('examinations.index')
            ->with('success', 'Pemeriksaan awal berhasil disimpan.');
    }
}
