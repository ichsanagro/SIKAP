<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index() {
        $role = auth()->user()->role;
        return match ($role) {
            'MAHASISWA'        => to_route('kp-applications.index'),
            'ADMIN_PRODI'      => to_route('admin-prodi.index'),
            'DOSEN_SUPERVISOR' => to_route('supervisor.dashboard'),
            'PENGAWAS_LAPANGAN'=> to_route('field.activities.index'),
            'SUPERADMIN'       => to_route('super-admin.index'),
            default            => view('dashboard'),
        };
    }
}
