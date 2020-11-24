<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\Payout;
use App\Services\AcademicYearServiceClass;
use App\Services\AmountServiceClass;
use App\Services\StatusServiceClass;
use App\Status;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {

    }

    public function academicYearsVerified(){
        return view('dashboard.academic_years.verified', [
            'academicYears' => Auth::user()->academic_years->where('verified', 1)->sortByDesc('created_at'),
            'academicYearServiceClass' => new AcademicYearServiceClass(),
            'amountServiceClass' => new AmountServiceClass(),
        ]);
    }

    public function academicYearsUnverified(){
        return view('dashboard.academic_years.unverified', [
            'academicYears' => Auth::user()->academic_years->where('verified', 0)->sortByDesc('created_at'),
            'academicYearServiceClass' => new AcademicYearServiceClass(),
            'amountServiceClass' => new AmountServiceClass(),
        ]);
    }

    public function academicYearsPayoutsCreate(AcademicYear $academicYear){
        $academicYear = AcademicYear::findOrFail($academicYear->id);

        return view('dashboard.payouts.create', [
            'academicYear' => $academicYear,
            'amountServiceClass' => new AmountServiceClass(),
            'statusServiceClass' => new StatusServiceClass(),
        ]);
    }

    public function payoutsIndex(){
        return view('dashboard.payouts.index', [
            'academicYears' => Auth::user()->academic_years()->whereHas('payouts')->get(),
            'amountServiceClass' => new AmountServiceClass(),
        ]);
    }



}
