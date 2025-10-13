<?php

namespace App\Http\Controllers\FieldSupervisor;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyQuota;
use App\Models\KpApplication;
use Illuminate\Http\Request;

class CompanyQuotaController extends Controller
{
    private function myCompaniesQuery()
    {
        $companyIds = KpApplication::query()
            ->where('supervisor_id', auth()->id())
            ->whereNotNull('company_id')
            ->distinct()
            ->pluck('company_id')
            ->all();

        return Company::query()->whereIn('id', $companyIds);
    }

    public function index()
    {
        $companies = $this->myCompaniesQuery()->orderBy('name')->get();

        $quotas = CompanyQuota::with('company')
            ->whereIn('company_id', $companies->pluck('id'))
            ->latest()
            ->paginate(15);

        return view('field_supervisor.company_quotas.index', compact('companies','quotas'));
    }

    public function create()
    {
        $companies = $this->myCompaniesQuery()->orderBy('name')->get();
        abort_if($companies->isEmpty(), 403, 'Belum ada instansi terkait bimbingan Anda.');
        return view('field_supervisor.company_quotas.create', compact('companies'));
    }

    public function store(Request $req)
    {
        $req->validate([
            'company_id' => ['required','exists:companies,id'],
            'period'     => ['required','string','max:50'],
            'quota'      => ['required','integer','min:0','max:10000'],
        ]);

        $allowedCompanyIds = $this->myCompaniesQuery()->pluck('id')->all();
        abort_unless(in_array((int)$req->company_id, $allowedCompanyIds, true), 403);

        CompanyQuota::create($req->only('company_id','period','quota'));
        return redirect()->route('field.company-quotas.index')->with('success','Kuota instansi ditambahkan.');
    }

    public function edit(CompanyQuota $company_quota)
    {
        $this->authorizeQuota($company_quota);
        $companies = $this->myCompaniesQuery()->orderBy('name')->get();
        return view('field_supervisor.company_quotas.edit', [
            'quota' => $company_quota,
            'companies' => $companies
        ]);
    }

    public function update(Request $req, CompanyQuota $company_quota)
    {
        $this->authorizeQuota($company_quota);

        $req->validate([
            'company_id' => ['required','exists:companies,id'],
            'period'     => ['required','string','max:50'],
            'quota'      => ['required','integer','min:0','max:10000'],
        ]);

        $allowedCompanyIds = $this->myCompaniesQuery()->pluck('id')->all();
        abort_unless(in_array((int)$req->company_id, $allowedCompanyIds, true), 403);

        $company_quota->update($req->only('company_id','period','quota'));
        return back()->with('success','Kuota instansi diperbarui.');
    }

    public function destroy(CompanyQuota $company_quota)
    {
        $this->authorizeQuota($company_quota);
        $company_quota->delete();
        return redirect()->route('field.company-quotas.index')->with('success','Kuota instansi dihapus.');
    }

    private function authorizeQuota(CompanyQuota $quota)
    {
        $allowedCompanyIds = $this->myCompaniesQuery()->pluck('id')->all();
        abort_unless(in_array((int)$quota->company_id, $allowedCompanyIds, true), 403);
    }
}
