<?php

namespace App\Http\Controllers\AcademicYear;

use App\AcademicYear;
use App\AcademicYearGoal;
use App\Services\AmountServiceClass;
use App\Services\AmountServiceTrait;
use App\Services\ToastrServiceTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoalsController extends Controller
{
    use ToastrServiceTrait, AmountServiceTrait;

    /**
     * @param AcademicYear $academicYear
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(AcademicYear $academicYear)
    {
        $this->authorize('update', $academicYear);

        return view('academic_year.goals.create', ['academicYear' => $academicYear]);
    }

    /**
     * @param Request $request
     * @param AcademicYear $academicYear
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request,AcademicYear $academicYear)
    {
        $this->authorize('update', $academicYear);

        $this->validate($request, [
            'description' => 'required',
            'amount' => 'required|is_valid_amount|min_amount:25',
        ]);

        AcademicYearGoal::create([
            'academic_year_id' => $academicYear->id,
            'description' => $request->description,
            'amount' => $this->getValidAmountForDB($request->amount),
        ]);

        return redirect()->route('academic_years.show', ['academicYear' => $academicYear, 'type' => 'doelen'])->with(['toastr' => $this->toastSuccess('Doel is succesvol opgeslagen')]);
    }

    /**
     * @param AcademicYear $academicYear
     * @param $goalID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(AcademicYear $academicYear, $goalID)
    {
        $this->authorize('update', $academicYear);

        $academicYearGoal = AcademicYearGoal::findOrFail($goalID);

        return view('academic_year.goals.edit', [
            'academicYear' => $academicYear,
            'academicYearGoal' => $academicYearGoal,
            'amountServiceClass' => new AmountServiceClass(),
        ]);
    }

    /**
     * @param Request $request
     * @param AcademicYear $academicYear
     * @param $goalID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, AcademicYear $academicYear, $goalID)
    {
        $this->authorize('update', $academicYear);

        $academicYearGoal = AcademicYearGoal::findOrFail($goalID);

        $this->validate($request, [
            'description' => 'required',
            'amount' => 'required|is_valid_amount|min_amount:25',
        ]);

        $academicYearGoal->description = $request->description;
        $academicYearGoal->amount = $this->getValidAmountForDB($request->amount);
        $academicYearGoal->save();

        return redirect()->route('academic_years.show', ['academicYear' => $academicYear, 'type' => 'doelen'])->with(['toastr' => $this->toastSuccess('Doel is succesvol geupdate')]);
    }

    /**
     * @param AcademicYear $academicYear
     * @param $goalID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(AcademicYear $academicYear, $goalID)
    {
        $this->authorize('update', $academicYear);


        $academicYearGoal = AcademicYearGoal::findOrFail($goalID);

        //Check if goal is not the last goal.
        if($academicYear->goals->count() == 1){
            return redirect()->back()->with(['toastr' => $this->toastError('Je kan het laatste doel niet verwijderen')]);
        }

        $academicYearGoal->delete();

        return redirect()->route('academic_years.show', ['academicYear' => $academicYear, 'type' => 'doelen'])->with(['toastr' => $this->toastSuccess('Doel is succesvol verwijderd')]);
    }
}
