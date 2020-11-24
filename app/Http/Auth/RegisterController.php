<?php

namespace App\Http\Controllers\Auth;

use App\BankAccount;
use App\Enrollment;
use App\Services\VerifyServiceTrait;
use App\School;
use App\SchoolLevel;
use App\Status;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\MessageBag;
use App\User;
use App\Mail\VerifyUserMail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, VerifyServiceTrait;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    private $user, $student, $bankAccount;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->user = new User();
        $this->bankAccount = new BankAccount();
    }
    public function validateUser(Request $request){
        $step = $request->step;
        if($step == 1){
            $v = Validator::make($request->all(), [
                'first_name' => 'required|alpha|max:255',
                'last_name' => 'required|max:255',
                'avatar' => 'nullable|image|dimensions:min_width=100,min_height=100',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|min:8|regex:"^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]"',
                'password_confirmation' => 'required|min:8|same:password',
            ]);
            if($v->fails()){
                return response()->json(['errors' => $v->errors()]);
            }else{
                $avatar = $request->avatar != null ? $request->file('avatar')->store('avatars') : null;
                $this->user->fill([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'avatar_url' => $avatar,
                    'password' => bcrypt($request->password),
                ]);
                session()->put('user', $this->user);
                return response()->json(200);
            }
        }
        if($step == 2){
            $v = Validator::make($request->all(), [
                'iban' => 'required|max:255|unique:bank_accounts',
                'description' => 'required|max:255',
                'date_of_birth' => 'required|max:255',
            ]);
            if($v->fails()){
                return response()->json(['errors' => $v->errors()]);
            }else{

                $this->user = session()->get('user');
                $this->user->fill([
                    'email_token' => $this->generateEmailToken(),
                    'description' => $request->description,
                    'date_of_birth' => $request->date_of_birth,
                ]);
                session()->put('user', $this->user);
                $this->bankAccount->fill([
                    'status_id' => Status::getStatusID(Status::unverified),
                    'iban' => $request->iban
                ]);
                session()->put('bankAccount',$this->bankAccount);
                return response()->json(200);
            }
        }
        $error = new MessageBag(['errors' => ['unknown' => ['Onbekende fout']]]);
        return response()->json($error);
    }

    //OBSOLETE
    public function validateFunder(Request $request){
        $v = Validator::make($request->all(), [
            'first_name' => 'required|alpha|max:255',
            'prefix' => 'nullable|alpha_spaces|max:255',
            'last_name' => 'required|max:255',
            'avatar' => 'nullable|image|dimensions:min_width=100,min_height=100',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|regex:"^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]"',
            'password_confirmation' => 'required|min:8|same:password',
        ]);

        if($v->fails()){
            return response()->json(['errors' => $v->errors()]);
        }else{
            $avatar = $request->avatar != null ? $request->file('avatar')->store('avatars') : null;

            $this->user->fill([
                'first_name' => $request->first_name,
                'prefix' => $request->prefix,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'avatar_url' => $avatar,
                'password' => bcrypt($request->password),
                'email_token' => str_random(10),
            ]);

            session()->put('user', $this->user);

            return response()->json(['valid' => true]);
        }
    }

    //OBSOLETE
    public function validateStudent(Request $request){
        $v = Validator::make($request->all(), [
            'school_type' => 'required|exists:school_types,id',
            'student_school' => 'required|exists:schools,id',
            'student_enrollment' => 'required:exists:enrollments,id',
            'date_of_birth' => 'date|date_format:d-m-Y',
            'student_email' => 'required|email|unique:users,email',
        ]);

        if($v->fails()){
            return response()->json(['errors' => $v->errors()]);
        }else{
            $v2 = Validator::make($request->all(), [
                'student_email' => 'is_student_mail:student_school',
            ]);

            if($v2->fails()) {
                return response()->json(['errors' => $v2->errors()]);
            }else {
                $this->student->fill([
                    'school_id' => $request->student_school,
                    'enrollment_id' => $request->student_enrollment,
                    'email' => $request->student_email,
                    'email_token' => str_random(10),
                ]);

                session()->put('student', $this->student);

                $this->user = session()->get('user');
                $this->user->fill([
                    'date_of_birth' => date('Y-m-d', strtotime($request->date_of_birth)),
                ]);

                session()->put('user', $this->user);

                return response()->json(['valid' => true]);
            }
        }
    }

    //OBSOLETE
    //Final register method
    public function registerFinal(Request $request){
        $this->user = session()->get('user');
        $this->student = session()->get('student');

        $messageFail = 'Er is iets mis gegaan. Probeer het opnieuw';
        $messageSuccess = 'Registratie is gelukt. Bekijk uw mailbox voor verdere instructies.';

        try {
            DB::beginTransaction();

            $this->user->save();

            if($request->isStudent) {

                $this->student->fill([
                    'user_id' => $this->user->id,
                ]);

                $this->student->save();
            }

            //Send mails
            $this->sendVerifyMail($this->user);

            if($request->isStudent) {
                $this->sendVerifyMail($this->student, true);
            }

            //All good. Commit it.
            DB::commit();

            //Remove sessions
            session()->forget(['user', 'student']);

            //Return message
            return response()->json(['message' => $messageSuccess]);

        } catch (\Exception $e) {
            //Delete avatar in from server storage
            Storage::delete($this->user->avatar_url);
            DB::rollBack();

            return response()->json(['message' => $messageFail]);
        }
    }

    public function getSchoolTypes(){
        return response()->json(['school_types' => SchoolLevel::all()]);
    }

    public function getSchoolsBySchoolTypeID(Request $request){
        $id = $request->school_type_id;

        return response()->json(School::where('school_type_id', $id)->get());
    }

    public function getEnrollmentsBySchoolTypeID(Request $request){
        $id = $request->school_type_id;

        return response()->json(Enrollment::where('school_type_id', $id)->get());
    }
}
