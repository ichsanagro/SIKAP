<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\KpApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    /**
     * Daftar pengajuan judul KP yang perlu diverifikasi oleh supervisor
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // Get students assigned to this supervisor
        $supervisedStudentIds = User::where('supervisor_id', $user->id)->pluck('id');

        // Get KP applications that are submitted and need verification
        $applications = KpApplication::with(['student', 'company'])
            ->whereIn('student_id', $supervisedStudentIds)
            ->where('status', 'SUBMITTED') // Status after student submits
            ->latest()
            ->paginate(20);

        return view('supervisor.verifications.index', compact('applications'));
    }

    /**
     * Show detail of a KP application for verification
     */
    public function show(KpApplication $kpApplication)
    {
        $this->authorizeSupervisor($kpApplication);

        $kpApplication->load(['student', 'company']);

        // Improved similar titles detection logic
        $stopwords = ['sistem','informasi','perancangan','analisis','pengembangan','penerapan','aplikasi','berbasis','manajemen','eksternal','framework','studi','kasus','pada','pt','cv'];

        // Normalize title to lowercase and remove simple punctuation
        $normalizedTitle = strtolower($kpApplication->title);
        $normalizedTitle = preg_replace('/[^\w\s]/u', '', $normalizedTitle); // Remove punctuation

        // Extract words and filter by length > 4 and not stopwords
        $allWords = explode(' ', $normalizedTitle);
        $importantKeywords = array_filter($allWords, function($word) use ($stopwords) {
            return strlen($word) > 4 && !in_array($word, $stopwords);
        });

        if (empty($importantKeywords)) {
            // Fallback logic: get recent KP excluding current
            $query = KpApplication::with(['student', 'supervisor'])
                ->where('id', '!=', $kpApplication->id)
                ->orderBy('created_at', 'desc')
                ->limit(50)
                ->get();

            $normalizedCurrentTitle = trim(preg_replace('/[^\w\s]/u', '', strtolower($kpApplication->title)));

            $similarApplications = $query->filter(function($application) use ($normalizedCurrentTitle) {
                $title = strtolower($application->title);
                $normalizedTitle = trim(preg_replace('/[^\w\s]/u', '', $title));

                if (strpos($normalizedCurrentTitle, $normalizedTitle) !== false
                    || strpos($normalizedTitle, $normalizedCurrentTitle) !== false) {
                    return true;
                }
                return false;
            })->take(20); // Limit to top 20 after filtering
        } else {
            // Query titles containing at least one important keyword
            $query = KpApplication::with(['student', 'supervisor'])
                ->where('id', '!=', $kpApplication->id)
                ->where(function($q) use ($importantKeywords) {
                    foreach ($importantKeywords as $keyword) {
                        $q->orWhere('title', 'LIKE', '%' . $keyword . '%');
                    }
                })
                ->orderBy('created_at', 'desc')
                ->limit(50) // Get a buffer of results to filter later in PHP
                ->get();

            // Flexible filtering with dynamic threshold and substring inclusion
            $threshold = count($importantKeywords) <= 2 ? 1 : 2;

            $normalizedCurrentTitle = trim(preg_replace('/[^\w\s]/u', '', strtolower($kpApplication->title)));

            $similarApplications = $query->filter(function($application) use ($importantKeywords, $threshold, $normalizedCurrentTitle) {
                $title = strtolower($application->title);
                $normalizedTitle = trim(preg_replace('/[^\w\s]/u', '', $title));

                // Check substring inclusion rule
                if (strpos($normalizedCurrentTitle, $normalizedTitle) !== false
                    || strpos($normalizedTitle, $normalizedCurrentTitle) !== false) {
                    return true;
                }

                // Count keyword matches
                $matchCount = 0;
                foreach ($importantKeywords as $keyword) {
                    if (strpos($title, $keyword) !== false) {
                        $matchCount++;
                        if ($matchCount >= $threshold) {
                            return true;
                        }
                    }
                }
                return false;
            })->take(20); // Limit to top 20 after filtering
        }

        return view('supervisor.verifications.show', compact('kpApplication', 'similarApplications'));
    }

    /**
     * Approve the KP application title
     */
    public function approve(Request $request, KpApplication $kpApplication)
    {
        $this->authorizeSupervisor($kpApplication);

        if ($kpApplication->status !== 'SUBMITTED') {
            return back()->with('error', 'Pengajuan sudah diproses.');
        }

        $request->validate([
            'notes' => 'nullable|string|max:2000',
        ]);

        // Set assigned_supervisor_id jika belum ada (berdasarkan supervisor_id mahasiswa)
        $updateData = [
            'status' => 'APPROVED', // Move to next status
            'notes' => $request->notes,
        ];

        if (!$kpApplication->assigned_supervisor_id && $kpApplication->student->supervisor_id) {
            $updateData['assigned_supervisor_id'] = $kpApplication->student->supervisor_id;
        }

        $kpApplication->update($updateData);

        // Auto-assign field supervisor if company is selected and no field supervisor assigned yet
        if ($kpApplication->company_id && !$kpApplication->field_supervisor_id) {
            $fieldSupervisorId = \App\Models\CompanyFieldSupervisor::where('company_id', $kpApplication->company_id)
                ->value('field_supervisor_id');

            if ($fieldSupervisorId) {
                $kpApplication->update(['field_supervisor_id' => $fieldSupervisorId]);
            }
        }

        return redirect()
            ->route('supervisor.verifications.show', $kpApplication)
            ->with('success', 'Judul KP telah disetujui.');
    }

    /**
     * Reject the KP application title
     */
    public function reject(Request $request, KpApplication $kpApplication)
    {
        $this->authorizeSupervisor($kpApplication);

        if ($kpApplication->status !== 'SUBMITTED') {
            return back()->with('error', 'Pengajuan sudah diproses.');
        }

        $request->validate([
            'notes' => 'required|string|max:2000',
        ]);

        $kpApplication->update([
            'status' => 'REJECTED',
            'notes' => $request->notes,
        ]);

        return redirect()
            ->route('supervisor.verifications.show', $kpApplication)
            ->with('success', 'Judul KP telah ditolak.');
    }

    /**
     * Authorize that the KP application belongs to a student supervised by this supervisor
     */
    private function authorizeSupervisor(KpApplication $kpApplication): void
    {
        $user = Auth::user();
        $supervisedStudentIds = User::where('supervisor_id', $user->id)->pluck('id');

        if (!in_array($kpApplication->student_id, $supervisedStudentIds->toArray())) {
            abort(403, 'Anda bukan pembimbing untuk mahasiswa ini.');
        }
    }
}
