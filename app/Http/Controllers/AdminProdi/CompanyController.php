<?php

namespace App\Http\Controllers\AdminProdi;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::latest()->paginate(10);
        return view('admin_prodi.companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin_prodi.companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:companies,name',
            'address' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'quota' => 'required|integer|min:1',
        ], [
            'name.required' => 'Nama Instansi wajib diisi.',
            'name.unique' => 'Nama Instansi sudah digunakan.',
            'name.max' => 'Nama Instansi maksimal 255 karakter.',
            'address.max' => 'Alamat maksimal 255 karakter.',
            'contact_person.max' => 'Kontak Layanan maksimal 255 karakter.',
            'contact_phone.max' => 'No. Telepon maksimal 20 karakter.',
            'quota.required' => 'Kuota wajib diisi.',
            'quota.integer' => 'Kuota harus berupa angka.',
            'quota.min' => 'Kuota tidak boleh 0.',
        ]);

        Company::create($request->all());

        return redirect()->route('admin-prodi.companies.index')
            ->with('success', 'Instansi berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        return view('admin_prodi.companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        return view('admin_prodi.companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:companies,name,' . $company->id,
            'address' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'quota' => 'required|integer|min:1',
        ], [
            'name.required' => 'Nama Instansi wajib diisi.',
            'name.unique' => 'Nama Instansi sudah digunakan.',
            'name.max' => 'Nama Instansi maksimal 255 karakter.',
            'address.max' => 'Alamat maksimal 255 karakter.',
            'contact_person.max' => 'Kontak Layanan maksimal 255 karakter.',
            'contact_phone.max' => 'No. Telepon maksimal 20 karakter.',
            'quota.required' => 'Kuota wajib diisi.',
            'quota.integer' => 'Kuota harus berupa angka.',
            'quota.min' => 'Kuota tidak boleh 0.',
        ]);

        $company->update($request->all());

        return redirect()->route('admin-prodi.companies.index')
            ->with('success', 'Instansi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('admin-prodi.companies.index')
            ->with('success', 'Instansi berhasil dihapus.');
    }
}
