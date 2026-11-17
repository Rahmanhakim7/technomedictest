<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Polyclinic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class DoctorController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $doctors = Doctor::query()
            ->with('polyclinic')
            ->withCount('registrations')
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('specialization', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhereHas('polyclinic', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('doctors.index', compact('doctors', 'search'));
    }

    public function create(): View
    {
        $polyclinics = Polyclinic::orderBy('name')->get();

        return view('doctors.create', compact('polyclinics'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'specialization' => ['nullable', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20'],
            'polyclinic_id' => ['required', 'integer', 'exists:polyclinics,id'],
        ]);

        Doctor::create($validated);

        return redirect()
            ->route('doctors.index')
            ->with('success', 'Data dokter berhasil ditambahkan.');
    }

    public function edit(Doctor $doctor): View
    {
        $doctor->load('polyclinic')->loadCount('registrations');

        $polyclinics = Polyclinic::orderBy('name')->get();

        return view('doctors.edit', compact('doctor', 'polyclinics'));
    }

    public function update(Request $request, Doctor $doctor): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'specialization' => ['nullable', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:20'],
            'polyclinic_id' => ['required', 'integer', 'exists:polyclinics,id'],
        ]);

        if ($doctor->registrations()->exists() && (int) $validated['polyclinic_id'] !== $doctor->polyclinic_id) {
            throw ValidationException::withMessages([
                'polyclinic_id' => 'Poliklinik dokter tidak dapat diubah karena sudah memiliki riwayat pendaftaran.',
            ]);
        }

        $doctor->update($validated);

        return redirect()
            ->route('doctors.index')
            ->with('success', 'Data dokter berhasil diperbarui.');
    }

    public function destroy(Doctor $doctor): RedirectResponse
    {
        if ($doctor->registrations()->exists()) {
            return redirect()
                ->route('doctors.index')
                ->with('error', 'Dokter tidak dapat dihapus karena sudah memiliki riwayat pendaftaran.');
        }

        $doctor->delete();

        return redirect()
            ->route('doctors.index')
            ->with('success', 'Data dokter berhasil dihapus.');
    }
}
