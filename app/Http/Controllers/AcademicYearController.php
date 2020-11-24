<?php

namespace App\Http\Controllers;

use App\AcademicYear;
use App\AcademicYearGoal;
use App\AcademicYearPeriod;
use App\BankAccount;
use App\SchoolLevel;
use App\Services\AcademicYearServiceClass;
use App\Services\AcademicYearServiceTrait;
use App\Services\AmountServiceClass;
use App\Services\AmountServiceTrait;
use App\Services\ToastrServiceTrait;
use App\User;
use App\Enrollment;
use App\School;
use App\Mail\VerifyAcademicYearMail;
use App\Mail\VerifyUserMail;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\HttpException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;
use App\Services\VerifyServiceTrait;
use Mockery\Exception;


class AcademicYearController extends Controller
{
    use AcademicYearServiceTrait, ToastrServiceTrait, AmountServiceTrait, VerifyServiceTrait;

    private $academic_year,$school_level,$user,$bankAccount;

    public function __construct()
    {
        $this->academic_year = new AcademicYear();
        $this->school_level = new SchoolLevel();
        $this->user = new User();
        $this->bankAccount = new BankAccount();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('academic_year.index',[
            'academicYears' => AcademicYear::all()->where('verified',1)->sortByDesc('created_at'),
            'enrollments' => Enrollment::all(),
            'amountServiceClass' => new AmountServiceClass(),
            'academicYearServiceClass' => new AcademicYearServiceClass(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('academic_year.create', ['school_levels' => SchoolLevel::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //OBSOLETE
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required|max:255',
        ]);
        if($v->fails()){
            return response()->json(['errors' => $v->errors()]);
        }else {
            $project = new AcademicYear();
            $projectusers = new ProjectUser();

            $project->fill([
                'name' => $request->name,
            ]);
            $project->save();

            $projectusers->fill([
                'user_id' => $request->student_id,
                'project_id' => $project->id,
                'admin' => true,
            ]);
            $projectusers->save();
            return redirect('home');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(AcademicYear $academicYear, Request $request)
    {
        $academicYear = AcademicYear::findOrFail($academicYear->id);

        $request->type = $request->type != null ? $request->type : 'campagne';

        return view('academic_year.show',[
            'type' => $request->type,
            'academicYear' => $academicYear,
            'amountServiceClass' => new AmountServiceClass(),
            'daysLeft' => $this->getDaysLeftString($academicYear),
            'percentage' => $this->getPercentageTotalPayments($academicYear),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $this->authorize('update', $project = AcademicYear::findOrFail($id));

        //Format end_date to d-m-Y format
        $project->end_date = date_format(date_create($project->end_date), 'd-m-Y');

        //Block number in URL, view to return
        $block = $request->block;

        return view('project.edit.block' . $block, ['project' => $project]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('update', $project = AcademicYear::findOrFail($id));

        $this->validate($request, [
            'name' => 'required',
            'slogan' => 'required',
            'short_description' => 'required',
        ]);


        $project->name = $request->name;
        $project->slogan = $request->slogan;
        $project->short_description = $request->short_description;

        $project->save();

        return redirect()->route('projects.show', [$id])->with('toastr', $this->toastSuccess('Wijzigingen zijn opgeslagen'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort(404);
    }
    public function validate_goal(Request $request)
    {
        $args = [
            'new_goal_amount' => 'required|max:255|is_valid_amount|min_amount:25',
            'new_goal_description' => 'required|max:255'
        ];
        $validation = $this->validate_data($request,$args);
        return response()->json($validation);
    }
    private function validate_data(Request $request,$args)
    {
        $v = Validator::make($request->all(), $args);
        if($v->fails()){
            return ['errors' => $v->errors()];
        }else {
            return 200;
        }
    }
    public function validate_year(Request $request)
    {
        $step = $request->step;
        if($step == 1)
        {
            $args = [
                'title' => 'required|max:255',
                'school_level_id' => 'required:exists:school_levels,id',
                'short_desc' => 'required|max:255',
            ];
            $validation = $this->validate_data($request,$args);
            if($validation == 200){
                $this->academic_year->fill([
                    'title' => $request->title,
                    'short_description' => $request->short_desc,
                ]);
                try{
                    $this->school_level = SchoolLevel::findOrFail($request->school_level_id);
                    session()->put('academic_year', $this->academic_year);
                }
                catch(Exception $ex)
                {
                    return response()->json(['errors' => $ex]);
                }
                return response()->json([
                    'schools' => $this->school_level->schools,
                    'periods' => AcademicYearPeriod::all(),
                    'enrollments' => $this->school_level->enrollments
                ],200);
            }
            else
            {
                return response()->json($validation);
            }
        }
        if($step == 2)
        {
            $args = [
                'study_period' => 'required:exists:academic_year_periods,id|is_period_allowed',
                'school' => 'required:exists:schools,id',
                'enrollment' => 'required:exists:enrollments,id',
                'academic_email' => 'required|email|max:255',
                'short_description' => 'required|max:255',
                'thumbnail_url' => 'nullable|image|dimensions:min_width=100,min_height=100',
            ];
            $validation = $this->validate_data($request,$args);
            if($validation == 200){
                $args = [
                    'academic_email' => 'is_student_mail:school'
                ];
                $email_validation = $this->validate_data($request,$args);
                if($email_validation == 200){

                    $thumbnail = $request->thumbnail_url != null ? $request->file('thumbnail_url')->store('thumbnails') : null;
                    $this->academic_year = session()->get('academic_year');
                    $this->academic_year->fill([
                        'academic_year_period_id' => $request->study_period,
                        'school_id' => $request->school,
                        'enrollment_id' => $request->enrollment,
                        'email' => $request->academic_email,
                        'short_description' => $request->short_description,
                        'thumbnail_url' => $thumbnail,
                    ]);
                    session()->put('academic_year', $this->academic_year);
                }
                return response()->json($email_validation);
            }
            else
            {
                return response()->json($validation);
            }
        }
        if($step == 3)
        {
            if (!$request->has('goals')) {
                $error = new MessageBag(['errors' => ['goals' => ['Minimaal 1 doel verplicht']]]);
                return response()->json($error);
            }
            $args = [
                'full_description' => 'required',
            ];
            $validation = $this->validate_data($request,$args);
            if($validation == 200){
                $this->academic_year = session()->get('academic_year');
                $this->academic_year->fill([
                   'full_description' => $request->full_description,
                    'email_token' => $this->generateEmailToken(),
                ]);
                foreach($request->goals as $goal_object){
                    $goal = new AcademicYearGoal();
                    $goal->fill([
                        'amount' => $this->getValidAmountForDB($goal_object['amount']),
                        'description' => $goal_object['description']
                    ]);
                    session()->push('goals',$goal);
                }
                if(Auth::check()){
                    $this->user = Auth::user();
                } else if(!Auth::check()){
                    $this->user = session()->get('user');
                    $this->bankAccount = session()->get('bankAccount');
                    $this->user->save();
                    $this->bankAccount->fill([
                       'user_id' => $this->user->id
                    ]);
                    $this->bankAccount->save();
                    Mail::to($this->user->email)->send(New VerifyUserMail($this->user));
                    session()->forget('bankAccount');
                    session()->forget('user');
                }
                $this->academic_year->fill([
                   'user_id' => $this->user->id,
                ]);
                $this->academic_year->save();
                foreach(session()->get('goals') as $goal_object2){
                    $goal_object2->fill([
                        'academic_year_id' => $this->academic_year->id,
                    ]);
                    $goal_object2->save();
                }
                Mail::to($this->academic_year->email)->send(New VerifyAcademicYearMail($this->academic_year));
                session()->forget('goals');
                session()->forget('academic_year');
                return response()->json(['newPage' => 'academic_years/thanks']);
            }
            return response()->json($validation);
        }
        $error = new MessageBag(['errors' => ['unknown' => ['Onbekende fout']]]);
        return response()->json($error);
    }
    public function register_success()
    {
        return view('academic_year.thanks');
    }
}
