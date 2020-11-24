<?php

namespace App\Http\Controllers\Verify;

use App\Mail\VerifyUserMail;
use App\Services\ToastrServiceTrait;
use App\Services\VerifyServiceTrait;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    use VerifyServiceTrait, ToastrServiceTrait;

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function resendMailVerifyUser(Request $request){
        $input = $request->only('email','token');

        $email = $input['email'];
        $token = $input['token'];

        if($email == null || $token == null){
            return redirect('home');
        }

        $user =  User::where('email_token', $token)->where('email', $email)->firstOrFail();

        $this->sendMailVerifyUser($user);

        return redirect()->back()->with('toastr', $this->toastSuccess(trans('verification.resend', ['email' => $user->email])));
    }

    /**
     * @param User $user
     */
    public function sendMailVerifyUser(User $user){
        //Generate a new email token before sending the email
        $user->email_token = $this->generateEmailToken();
        $user->save();

        Mail::to($user->email)->send(new VerifyUserMail($user));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function verifyUser(Request $request){
        $input = $request->only('email','token');

        $email = $input['email'];
        $token = $input['token'];

        if($email == null || $token == null){
            return redirect('home');
        }

        $user =  User::where('email_token', $token)->where('email', $email)->firstOrFail();

        $user->verified = 1;
        $user->email_token = $this->generateEmailToken();
        $user->save();

        return redirect('login')->with('toastr', $this->toastSuccess('Gefeliciteerd, je account is succesvol geverifieerd.'));
    }

}
