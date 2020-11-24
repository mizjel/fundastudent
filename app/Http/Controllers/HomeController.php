<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\Donation;
use App\Mail\DonationPaidMail;
use App\Mail\VerifyAcademicYearMail;
use App\Mail\VerifyUserMail;
use App\Services\AcademicYearServiceClass;
use App\Services\AcademicYearServiceTrait;
use App\Services\AmountServiceClass;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    use AcademicYearServiceTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $popularStudies = collect([]);

        $academicYears = AcademicYear::all();
        $donations = [] ;
        foreach($academicYears as $academicYear){
            $donations[$academicYear->id] = $this->getTotalPaidDonations($academicYear);
        }
        $years = AcademicYear::withCount([
            'donations',
            'donations AS paid_donation' => function($query){
                $query->where([
                    ['verified','=',true],
                    ['paid','=',true]
                ]);
            }
        ])->get();
        foreach($years as $year){
            $popularStudies->push($year);
        }
        $popularStudies = $popularStudies->sortByDesc('paid_donation_count')->take(3);
        return view('home', [
            'academicYears' => $popularStudies,
            'amountServiceClass' => new AmountServiceClass(),
            'academicYearServiceClass' => new AcademicYearServiceClass(),
        ]);
    }


    //TEST MAIL FUNCTION
    public function mail(){

        //MAIL TEST DONATION PAID.
//        $donation = Donation::findOrFail(1);
//
//        Mail::to($donation->email)->send(new DonationPaidMail($donation));

        //Verify Academic Year
//        $academicYear = AcademicYear::findOrFail(1);
//        //Send mail to the funder
//
//        Mail::to($academicYear->email)->send(new VerifyAcademicYearMail($academicYear));

//        $user = User::findOrFail(1);
//
//        Mail::to($user->email)->send(New VerifyUserMail($user));
    }
}
