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
            ->with(['company', 'student.supervisor'])
            ->latest()
            ->paginate(10);

        return view('student.kp.index', compact('apps'));
    }

    public function create()
    {
        // Cek apakah mahasiswa sudah memiliki aplikasi KP aktif (status selain REJECTED)
        $hasActiveApplication = KpApplication::where('student_id', Auth::id())
            ->where('status', '!=', 'REJECTED')
            ->exists();

        if ($hasActiveApplication) {
            return redirect()->route('kp-applications.index')
                ->with('error', 'Anda sudah memiliki pengajuan KP yang sedang diproses. Tunggu hingga selesai atau ditolak sebelum membuat pengajuan baru.');
        }

        $query = Company::query();

        if (request('search')) {
            $search = request('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
        }

        $companies = $query->paginate(12);

        return view('student.kp.create', compact('companies'));
    }

    public function store(Request $request)
    {
        // Cek apakah mahasiswa sudah memiliki aplikasi KP aktif (status selain REJECTED)
        $hasActiveApplication = KpApplication::where('student_id', Auth::id())
            ->where('status', '!=', 'REJECTED')
            ->exists();

        if ($hasActiveApplication) {
            return redirect()->route('kp-applications.index')
                ->with('error', 'Anda sudah memiliki pengajuan KP yang sedang diproses. Tunggu hingga selesai atau ditolak sebelum membuat pengajuan baru.');
        }

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

    // Company detail
    public function companyDetail(Company $company)
    {
        return view('student.kp.company_detail', compact('company'));
    }

    // Apply form for specific company
    public function applyForm(Company $company)
    {
        // Cek apakah mahasiswa sudah memiliki aplikasi KP aktif (status selain REJECTED)
        $hasActiveApplication = KpApplication::where('student_id', Auth::id())
            ->where('status', '!=', 'REJECTED')
            ->exists();

        if ($hasActiveApplication) {
            return redirect()->route('kp-applications.index')
                ->with('error', 'Anda sudah memiliki pengajuan KP yang sedang diproses. Tunggu hingga selesai atau ditolak sebelum membuat pengajuan baru.');
        }

        // Validate quota
        if ($company->quota <= 0) {
            return redirect()->route('kp.company.detail', $company)
                ->with('error', 'Kuota KP di instansi ini sudah penuh. Tidak dapat mengajukan KP.');
        }

        return view('student.kp.apply', compact('company'));
    }

    // Store apply for specific company
    public function storeApply(Request $request, Company $company)
    {
        // Cek apakah mahasiswa sudah memiliki aplikasi KP aktif (status selain REJECTED)
        $hasActiveApplication = KpApplication::where('student_id', Auth::id())
            ->where('status', '!=', 'REJECTED')
            ->exists();

        if ($hasActiveApplication) {
            return redirect()->route('kp-applications.index')
                ->with('error', 'Anda sudah memiliki pengajuan KP yang sedang diproses. Tunggu hingga selesai atau ditolak sebelum membuat pengajuan baru.');
        }

        // Validate quota
        if ($company->quota <= 0) {
            return redirect()->route('kp.company.detail', $company)
                ->with('error', 'Kuota KP di instansi ini sudah penuh. Tidak dapat mengajukan KP.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'krs_drive_link' => 'required|url',
            'proposal_drive_link' => 'required|url',
        ]);

        $data = [
            'student_id' => Auth::id(),
            'title' => $request->title,
            'placement_option' => '1', // Assuming batch 1, but can adjust
            'company_id' => $company->id,
            'status' => 'SUBMITTED', // Pending for supervisor
            'krs_drive_link' => $request->krs_drive_link,
            'proposal_drive_link' => $request->proposal_drive_link,
        ];

        KpApplication::create($data);

        return redirect()->route('kp-applications.index')->with('success', 'Pengajuan KP dikirim.');
    }

    // Apply other form
    public function applyOtherForm()
    {
        // Cek apakah mahasiswa sudah memiliki aplikasi KP aktif (status selain REJECTED)
        $hasActiveApplication = KpApplication::where('student_id', Auth::id())
            ->where('status', '!=', 'REJECTED')
            ->exists();

        if ($hasActiveApplication) {
            return redirect()->route('kp-applications.index')
                ->with('error', 'Anda sudah memiliki pengajuan KP yang sedang diproses. Tunggu hingga selesai atau ditolak sebelum membuat pengajuan baru.');
        }

        return view('student.kp.apply_other');
    }

    // Store apply other
    public function storeApplyOther(Request $request)
    {
        // Cek apakah mahasiswa sudah memiliki aplikasi KP aktif (status selain REJECTED)
        $hasActiveApplication = KpApplication::where('student_id', Auth::id())
            ->where('status', '!=', 'REJECTED')
            ->exists();

        if ($hasActiveApplication) {
            return redirect()->route('kp-applications.index')
                ->with('error', 'Anda sudah memiliki pengajuan KP yang sedang diproses. Tunggu hingga selesai atau ditolak sebelum membuat pengajuan baru.');
        }

        $request->validate([
            'custom_company_name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'approval' => 'required|file|mimes:pdf|max:5120',
            'proposal' => 'required|file|mimes:pdf|max:5120',
            'krs' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $data = [
            'student_id' => Auth::id(),
            'title' => $request->title,
            'placement_option' => '3', // Other
            'custom_company_name' => $request->custom_company_name,
            'status' => 'SUBMITTED', // Pending for supervisor
            'krs_path' => $request->file('krs')->store('krs', 'public'),
            'proposal_path' => $request->file('proposal')->store('proposals', 'public'),
            'approval_path' => $request->file('approval')->store('approvals', 'public'),
        ];

        KpApplication::create($data);

        return redirect()->route('kp-applications.index')->with('success', 'Pengajuan KP dikirim.');
    }

    private function authorizeOwner(KpApplication $kp): void
    {
        if ($kp->student_id !== Auth::id()) abort(403);
    }
}
