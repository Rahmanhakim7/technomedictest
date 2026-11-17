<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $patients = Patient::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('medical_record_number', 'like', "%{$search}%")
                        ->orWhere('nik', 'like', "%{$search}%")
                        ->orWhere('full_name', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('patients.index', compact('patients', 'search'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'medical_record_number' => 'required|string|max:20|unique:patients,medical_record_number',
            'nik' => 'required|string|size:16|unique:patients,nik',
            'full_name' => 'required|string|max:150',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'birth_date' => 'required|date|before_or_equal:today',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
        ]);

        Patient::create($validated);

        return redirect()
            ->route('patients.index')
            ->with('success', 'Data pasien berhasil ditambahkan.');
    }
    // Menampilkan form edit pasien
    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    // Memperbarui data pasien
    public function update(Request $request, Patient $patient)
    {
        $validated = $request->validate([
            'medical_record_number' => [
                'required',
                'string',
                'max:20',
                Rule::unique('patients', 'medical_record_number')->ignore($patient->id),
            ],
            'nik' => [
                'required',
                'string',
                'size:16',
                Rule::unique('patients', 'nik')->ignore($patient->id),
            ],
            'full_name' => 'required|string|max:150',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'birth_date' => 'required|date|before_or_equal:today',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
        ]);

        $patient->update($validated);

        return redirect()
            ->route('patients.index')
            ->with('success', 'Data pasien berhasil diperbarui.');
    }
    public function deactivate(Patient $patient)
    {
        $patient->update([
            'is_active' => false,
        ]);

        return redirect()
            ->route('patients.index')
            ->with('success', 'Pasien berhasil dinonaktifkan.');
    }
}
