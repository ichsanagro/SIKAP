<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\KpApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KpApplicationController extends Controller
{
    public function index()
    {
        $apps = KpApplication::where('student_id', Auth::id())
            ->with(['company'])
            ->latest()
            ->paginate(10);

        return view('student.kp.index', compact('apps'));
    }

    public function create()
    {
        $companiesBatch1 = Company::where('batch', 1)->get();
        $companiesBatch2 = Company::where('batch', 2)->get();

        return view('student.kp.create', compact('companiesBatch1', 'companiesBatch2'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'                 => 'required|string|max:255',
            'placement_option'      => 'required|in:1,2,3',
            'company_id'            => 'nullable|exists:companies,id',
            'custom_company_name'   => 'nullable|required_if:placement_option,3|max:255',
            'custom_company_address'=> 'nullable|required_if:placement_option,3|max:255',
            // 'start_date'            => 'nullable|required_if:placement_option,3|date|after:today',
            // KRS: opsional saat draft, tapi akan diwajibkan saat submit
            'krs'                   => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $data = $request->only([
            'title', 'placement_option', 'company_id',
            'custom_company_name', 'custom_company_address', 'start_date',
        ]);
        $data['student_id'] = Auth::id();
        $data['status'] = 'DRAFT';

        // simpan KRS jika diunggah saat membuat draft
        if ($request->hasFile('krs')) {
            $data['krs_path'] = $request->file('krs')->store('krs', 'public');
        }

        $kp = KpApplication::create($data);

        return redirect()->route('kp-applications.show', $kp)
            ->with('success', 'Draft pengajuan disimpan.');
    }

    public function show(KpApplication $kp_application)
    {
        $this->authorizeOwner($kp_application);
        $kp_application->load(['company', 'supervisor', 'fieldSupervisor', 'report']);

        return view('student.kp.show', ['kp' => $kp_application]);
    }

    public function edit(KpApplication $kp_application)
    {
        $this->authorizeOwner($kp_application);
        if ($kp_application->status !== 'DRAFT') abort(403);

        $companiesBatch1 = Company::where('batch', 1)->get();
        $companiesBatch2 = Company::where('batch', 2)->get();

        return view('student.kp.edit', compact('kp_application', 'companiesBatch1', 'companiesBatch2'));
    }

    public function update(Request $request, KpApplication $kp_application)
    {
        $this->authorizeOwner($kp_application);
        if ($kp_application->status !== 'DRAFT') abort(403);

        $request->validate([
            'title'                 => 'required|string|max:255',
            'placement_option'      => 'required|in:1,2,3',
            'company_id'            => 'nullable|exists:companies,id',
            'custom_company_name'   => 'nullable|required_if:placement_option,3|max:255',
            'custom_company_address'=> 'nullable|required_if:placement_option,3|max:255',
            // 'start_date'            => 'nullable|required_if:placement_option,3|date|after:today',
            'krs'                   => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $payload = $request->only([
            'title', 'placement_option', 'company_id',
            'custom_company_name', 'custom_company_address', 'start_date',
        ]);

        if ($request->hasFile('krs')) {
            if ($kp_application->krs_path) {
                Storage::disk('public')->delete($kp_application->krs_path);
            }
            $payload['krs_path'] = $request->file('krs')->store('krs', 'public');
        }

        $kp_application->update($payload);

        return redirect()
        ->route('kp-applications.index')
        ->with('success', 'Draft diperbarui.');
    }

    /**
     * Submit pengajuan KP (wajib KRS sudah terunggah)
     */
    public function submit(KpApplication $kp)
    {
        $this->authorizeOwner($kp);
        if ($kp->status !== 'DRAFT') abort(403);

        // Wajib KRS
        if (!$kp->krs_path) {
            return back()->with('error', 'Wajib unggah KRS (PDF/JPG/PNG maks 5MB) sebelum Submit. Silakan Edit draft untuk mengunggah KRS.');
        }

        // Validasi pilihan tempat
if ($kp->placement_option === '3') {
    if (!$kp->custom_company_name) {
        return back()->with('error', 'Lengkapi data perusahaan sendiri.');
    }
} else {
    if (!$kp->company_id) {
        return back()->with('error', 'Pilih perusahaan dari prodi.');
    }
}

        $kp->update(['status' => 'SUBMITTED']);

        return redirect()->route('kp-applications.show', $kp)
            ->with('success', 'Pengajuan dikirim ke verifikator prodi.');
    }

    /**
     * Download KRS (pemilik / admin prodi / superadmin)
     */
    public function downloadKrs(KpApplication $kp)
    {
        $user = Auth::user();
        $isOwner = $kp->student_id === $user->id;
        $isAdmin = in_array($user->role, ['ADMIN_PRODI', 'SUPERADMIN'], true);

        if (!$isOwner && !$isAdmin) abort(403);

        if (!$kp->krs_path || !Storage::disk('public')->exists($kp->krs_path)) {
            abort(404, 'File KRS tidak ditemukan.');
        }

        return Storage::disk('public')->download($kp->krs_path);
    }

    private function authorizeOwner(KpApplication $kp): void
    {
        if ($kp->student_id !== Auth::id()) abort(403);
    }
}
