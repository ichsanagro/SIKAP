<?php

namespace App\Policies;

use App\Models\MentoringLog;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MentoringLogPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MentoringLog $mentoringLog): bool
    {
        // Mahasiswa bisa melihat catatan bimbingannya sendiri
        if ($user->role === 'MAHASISWA' && $mentoringLog->student_id === $user->id) {
            return true;
        }

        // Dosen pembimbing bisa melihat catatan bimbingannya
        if ($user->role === 'DOSEN_SUPERVISOR' && $mentoringLog->supervisor_id === $user->id) {
            return true;
        }

        // Superadmin bisa melihat semua
        if ($user->role === 'SUPERADMIN') {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MentoringLog $mentoringLog): bool
    {
        // Dosen pembimbing bisa mengupdate catatan bimbingannya
        if ($user->role === 'DOSEN_SUPERVISOR' && $mentoringLog->supervisor_id === $user->id) {
            return true;
        }

        // Superadmin bisa update semua
        if ($user->role === 'SUPERADMIN') {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MentoringLog $mentoringLog): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MentoringLog $mentoringLog): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MentoringLog $mentoringLog): bool
    {
        return false;
    }
}
