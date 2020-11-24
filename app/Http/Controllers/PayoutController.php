<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\Payout;
use App\Services\AmountServiceTrait;
use App\Services\ToastrServiceTrait;
use App\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PayoutController extends Controller
{
    use AmountServiceTrait, ToastrServiceTrait;

    public function index(){
        return view('dashboard.payouts.index');
    }


    public function store(AcademicYear $academicYear, Request $request){
        AcademicYear::findOrFail($academicYear->id);

        if(Auth::user()->bank_account->status->hasStatus(Status::unverified)){
            abort(403);
        }

        //Available payout
        $available_amount = $this->getAmountWithPercentage($academicYear->donations->where('paid', 1)->sum('amount'), 91) - $academicYear->payouts->where('status_id', '!=', Status::getStatusID(Status::cancelled))->sum('amount');

        //Basic transaction_min = 25 - 9% transaction costs
        if($available_amount < $this->getAmountWithPercentage($this->getValidAmountForDB(config('basics.transaction_min')), 91)){
            flash(trans('basics.minimum_balance', ['transaction_min' => $this->getReadableAmount($this->getAmountWithPercentage($this->getValidAmountForDB(config('basics.transaction_min')), 91))]));
            return redirect()->back();
        }

        Payout::create([
            'academic_year_id' => $academicYear->id,
            'status_id' => Status::getStatusID(Status::in_progress),
            'amount' => $available_amount,
        ]);

        return redirect()->route('dashboard.payouts')->with(['toastr' => $this->toastSuccess('Uitbetaling is aangevraagd')]);
    }

}
