<?php

namespace App\Http\Controllers\Verify;

use App\AcademicYear;
use App\Mail\VerifyAcademicYearMail;
use App\Services\ToastrServiceTrait;
use App\Services\VerifyServiceTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class AcademicYearController extends Controller
{
    use VerifyServiceTrait, ToastrServiceTrait;

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function resendMailVerifyAcademicYear(Request $request){
        $input = $request->only('email','token');

        $email = $input['email'];
        $token = $input['token'];

        if($email == null || $token == null){
            return redirect('home');
        }

        $academicYear =  AcademicYear::where('email_token', $token)->where('email', $email)->firstOrFail();

        $this->sendMailVerifyAcademicYear($academicYear);

        return redirect()->back()->with('toastr', $this->toastSuccess(trans('verification.resend', ['email' => $academicYear->email])));
    }

    /**
     * @param AcademicYear $academicYear
     */
    public function sendMailVerifyAcademicYear(AcademicYear $academicYear){
        //Generate a new email token before sending the email
        $academicYear->email_token = $this->generateEmailToken();
        $academicYear->save();

        Mail::to($academicYear->email)->send(new VerifyAcademicYearMail($academicYear));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function verifyAcademicYear(Request $request){
        $input = $request->only('email','token');

        $email = $input['email'];
        $token = $input['token'];

        if($email == null || $token == null){
            return redirect('home');
        }

        $academicYear =  AcademicYear::where('email_token', $token)->where('email', $email)->firstOrFail();

        $academicYear->verified = 1;
        $academicYear->email_token = $this->generateEmailToken();
        $academicYear->save();

        return redirect('home')->with('toastr', $this->toastSuccess('Gefeliciteerd, schooljaar is geverifieerd'));
    }}
