<?php

namespace App\Policies;

use App\User;
use App\AcademicYear;
use Illuminate\Auth\Access\HandlesAuthorization;

class AcademicYearPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->isAdmin()) {
            return true;
        }
    }
    /**
     * Determine whether the user can view the academicYear.
     *
     * @param  \App\User  $user
     * @param  \App\AcademicYear  $academicYear
     * @return mixed
     */
    public function view(User $user, AcademicYear $academicYear)
    {
        //
    }

    /**
     * Determine whether the user can create academicYears.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the academicYear.
     *
     * @param  \App\User  $user
     * @param  \App\AcademicYear  $academicYear
     * @return mixed
     */
    public function update(User $user, AcademicYear $academicYear)
    {
        return $user->id == $academicYear->user_id;
    }

    /**
     * Determine whether the user can delete the academicYear.
     *
     * @param  \App\User  $user
     * @param  \App\AcademicYear  $academicYear
     * @return mixed
     */
    public function delete(User $user, AcademicYear $academicYear)
    {
        //
    }
}
