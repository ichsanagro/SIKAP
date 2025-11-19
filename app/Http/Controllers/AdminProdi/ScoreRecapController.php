<?php

namespace App\Http\Controllers\AdminProdi;

use App\Http\Controllers\Controller;
use App\Models\KpApplication;
use App\Models\SeminarApplication;
use App\Models\User;
use Illuminate\Http\Request;

class ScoreRecapController extends Controller
{
    public function index()
    {
        $applications = KpApplication::with([
            'student',
            'company',
            'score',
            'supervisorScore',
            'examinerSeminarScore',
            'supervisor',
            'fieldSupervisor'
        ])
        ->latest()
        ->paginate(20);

        return view('admin_prodi.recap-scores.index', compact('applications'));
    }

    public function show(KpApplication $kpApplication)
    {
        $kpApplication->load([
            'student',
            'company',
            'score',
            'supervisorScore',
            'examinerSeminarScore',
            'supervisor',
            'fieldSupervisor'
        ]);

        return view('admin_prodi.recap-scores.show', compact('kpApplication'));
    }
}
