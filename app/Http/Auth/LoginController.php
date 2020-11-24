<?php

namespace App\Http\Controllers\Auth;

use App\Services\ToastrServiceTrait;
use App\Services\VerifyServiceTrait;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, VerifyServiceTrait, ToastrServiceTrait;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    protected function authenticated(Request $request, $user)
    {
//        dd(back()->getTargetUrl());
        if ($user->verified) {
            return redirect()->intended($this->redirectPath());
        } else {
            //User is not verified.
            Auth::logout();

            return redirect()->back()->with('toastr', $this->toastError(trans('verification.not_verified', ['url' => route('verify.user.resend', ['email' => $user->email, 'token' => $user->email_token])])));
        }
    }

    public function showLoginForm()
    {
        if(!session()->has('url.intended'))
        {
            session(['url.intended' => url()->previous()]);
        }
        return view('auth.login');
    }
}
