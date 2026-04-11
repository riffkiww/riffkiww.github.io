<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('search')->toString();

        $patients = Patient::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('medical_record_number', 'like', '%' . $search . '%')
                        ->orWhere('full_name', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%');
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('patients.index', [
            'patients' => $patients,
            'search' => $search,
        ]);
    }

    public function create()
    {
        return view('patients.create', [
            'patient' => new Patient(),
            'action' => route('patients.store'),
            'method' => 'POST',
            'title' => 'Tambah Pasien',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        Patient::create($data);

        return redirect()
            ->route('patients.index')
            ->with('success', 'Data pasien berhasil disimpan.');
    }

    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', [
            'patient' => $patient,
            'action' => route('patients.update', $patient),
            'method' => 'PUT',
            'title' => 'Edit Pasien',
        ]);
    }

    public function update(Request $request, Patient $patient)
    {
        $data = $this->validatedData($request, $patient->id);

        $patient->update($data);

        return redirect()
            ->route('patients.index')
            ->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy(Patient $patient)
    {
        $patient->delete();

        return redirect()
            ->route('patients.index')
            ->with('success', 'Data pasien berhasil dihapus.');
    }

    private function validatedData(Request $request, ?int $patientId = null): array
    {
        return $request->validate([
            'medical_record_number' => [
                'required',
                'string',
                'max:30',
                Rule::unique('patients', 'medical_record_number')->ignore($patientId),
            ],
            'full_name' => ['required', 'string', 'max:150'],
            'gender' => ['required', Rule::in(['Laki-laki', 'Perempuan'])],
            'age' => ['nullable', 'integer', 'min:0', 'max:120'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'complaint' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['Aktif', 'Selesai', 'Rujuk'])],
        ]);
    }
}