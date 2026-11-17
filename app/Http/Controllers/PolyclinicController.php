<?php

namespace App\Http\Controllers;

use App\Models\Polyclinic;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PolyclinicController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('search');

        $polyclinics = Polyclinic::query()
            ->withCount(['doctors', 'registrations'])
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('polyclinics.index', compact('polyclinics', 'search'));
    }

    public function create(): View
    {
        return view('polyclinics.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('polyclinics', 'name'),
            ],
            'description' => ['nullable', 'string'],
        ]);

        Polyclinic::create($validated);

        return redirect()
            ->route('polyclinics.index')
            ->with('success', 'Data poliklinik berhasil ditambahkan.');
    }

    public function edit(Polyclinic $polyclinic): View
    {
        $polyclinic->loadCount(['doctors', 'registrations']);

        return view('polyclinics.edit', compact('polyclinic'));
    }

    public function update(Request $request, Polyclinic $polyclinic): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('polyclinics', 'name')->ignore($polyclinic->id),
            ],
            'description' => ['nullable', 'string'],
        ]);

        $polyclinic->update($validated);

        return redirect()
            ->route('polyclinics.index')
            ->with('success', 'Data poliklinik berhasil diperbarui.');
    }

    public function destroy(Polyclinic $polyclinic): RedirectResponse
    {
        if ($polyclinic->doctors()->exists()) {
            return redirect()
                ->route('polyclinics.index')
                ->with('error', 'Poliklinik tidak dapat dihapus karena masih memiliki dokter terdaftar.');
        }

        if ($polyclinic->registrations()->exists()) {
            return redirect()
                ->route('polyclinics.index')
                ->with('error', 'Poliklinik tidak dapat dihapus karena sudah digunakan pada riwayat pendaftaran.');
        }

        $polyclinic->delete();

        return redirect()
            ->route('polyclinics.index')
            ->with('success', 'Data poliklinik berhasil dihapus.');
    }
}
