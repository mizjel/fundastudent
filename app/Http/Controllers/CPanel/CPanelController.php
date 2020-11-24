<?php

namespace App\Http\Controllers\CPanel;

use App\BankAccount;
use App\Payout;
use App\Services\AmountServiceClass;
use App\Services\ToastrServiceTrait;
use App\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CPanelController extends Controller
{
    use ToastrServiceTrait;

    public function usersBankAccounts(){
        return view('c_panel.users.bank_accounts.index', ['bankAccounts' => BankAccount::all()]);
    }

    public function usersBankAccountsChangeStatus(Request $request, $user_id){
        $bankAccount = BankAccount::where('user_id', $user_id)->firstOrFail();

        $bankAccount->status_id = Status::findOrFail($request->status_id)->id;
        $bankAccount->save();

        return redirect()->back();
    }

    public function payouts(){
        return view('c_panel.payouts.index', [
            'payouts' => Payout::all(),
            'amountServiceClass' => new AmountServiceClass(),
        ]);
    }

    public function payoutsChangeStatus(Request $request, $payouts_id){
        $payout = Payout::findOrFail($payouts_id);

        $payout->status_id = Status::findOrFail($request->status_id)->id;
        $payout->save();

        return redirect()->back()->with(['toastr' => $this->toastSuccess('Status is succesvol veranderd')]);
    }

}
