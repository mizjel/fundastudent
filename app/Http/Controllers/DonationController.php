<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\Donation;
use App\Mail\DonationPaidMail;
use App\Services\AmountServiceTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Mollie\Laravel\Facades\Mollie;

class DonationController extends Controller
{
    use AmountServiceTrait;

    //Return views for payments steps
    public function getDonation(Request $request){
        //Check if project exists with ID
        $academic_year = AcademicYear::findOrFail($request->id);

        $arr = [
            'id' => $academic_year->id,
            'academic_year' => $academic_year,
            'auth' => $request->auth
        ];

        //Return View if exists
        return view('donation.index', $arr);

        //View not found
        abort(404);
    }

    //Post request for payments steps
    public function postDonation(Request $request){
        //Check if project exists with ID
        $academic_year = AcademicYear::findOrFail($request->id);

        //Validate and returns if has errors..
        $this->validate($request,[
            'amount' => 'required|is_valid_amount|min_amount:5',
            'email' => 'required|email',
            'name' => '',
            'message' => '',
        ]);

        //User pays transaction costs
        //Format the amount, to number with decimal (.) + transaction costs
        $request->amount = $this->getValidAmountForDB($request->amount) + $this->getValidAmountForDB(config('basics.transaction_costs'));

        //Create the donation.
        //Donation have id and random token.
        // This is made before the payment, for a safe redirect url.

        //!ATENTION! remove paid from column, this is for testing. payment is always paid now.
        $donation = Donation::create([
            'academic_year_id' => $academic_year->id,
            'email' => $request->email,
            'message' => $request->message,
            'amount' => $request->amount,
            'paid' => 1,
            'token' => str_random(10),
        ]);

        //Start payment.
        $payment = Mollie::api()->payments()->create([
            'amount'      => $request->amount,
            'description' => 'Fund a student, donatie: ' . $academic_year->title,
            'redirectUrl' => route('donation.status', ['id' => $donation->id, 'token' => $donation->token]),
        ]);

        //Save the payment_id (Mollie generated ID) in database
        $donation->fill([
            'id' => $payment->id,
        ]);

        $donation->save();

        return redirect($payment->getPaymentUrl());

        //During payment, mollie calls the webhook (see code on: 112) to update payment status.
    }

    //The funder sees this page
    public function status(Request $request){
        $request = $request->only(['id', 'token']);

        $donation = Donation::where(['id' => $request['id'], 'token' => $request['token']])->firstOrFail();

        if($donation->aborted){
            return view('donation.aborted', ['donation' => $donation, 'amount' => $this->getReadableAmount($donation->amount)]);
        }

        return view('donation.paid', ['donation' => $donation, 'amount' => $this->getReadableAmount($donation->amount)]);
    }


    //Mollie calls this webhook when status for payment changes
    public function webhook(Request $request){
        $donation = Donation::where(['payment_id', $request->id])->firstOrFail();

        $payment = Mollie::api()->payments()->get($request->id);

        if ($payment->isPaid())
        {
            /*
             * At this point you'd probably want to start the process of delivering the product
             * to the customer.
             */
            $donation->paid = 1;
            $donation->save();

            Mail::to($donation->email)->send(new DonationPaidMail($donation));

        }
        elseif (!$payment->isOpen())
        {
            /*
             * The payment isn't paid and isn't open anymore. We can assume it was aborted.
             */
            $donation->aborted = 1;
            $donation->save();
        }

    }

}
