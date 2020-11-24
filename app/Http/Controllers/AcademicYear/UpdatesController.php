<?php

namespace App\Http\Controllers\AcademicYear;

use App\AcademicYear;
use App\AcademicYearUpdate;
use App\Services\ToastrServiceTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdatesController extends Controller
{
    use ToastrServiceTrait;

    /**
     * @param AcademicYear $academicYear
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(AcademicYear $academicYear)
    {
        $this->authorize('update', $academicYear);

        return view('academic_year.updates.create', ['academicYear' => $academicYear]);
    }

    /**
     * @param Request $request
     * @param AcademicYear $academicYear
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, AcademicYear $academicYear)
    {
        $this->authorize('update', $academicYear);

        $this->validate($request, [
            'title' => 'required',
            'update' => 'required',
        ]);

        AcademicYearUpdate::create([
            'academic_year_id' => $academicYear->id,
            'title' => $request->title,
            'update' => $request->update,
        ]);

        return redirect()->route('academic_years.show', ['academicYear' => $academicYear, 'type' => 'updates'])->with(['toastr' => $this->toastSuccess('Update is succesvol opgeslagen')]);
    }

    /**
     * @param AcademicYear $academicYear
     * @param $updateID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(AcademicYear $academicYear, $updateID)
    {
        $this->authorize('update', $academicYear);

        $academicYearUpdate = AcademicYearUpdate::findOrFail($updateID);

        return view('academic_year.updates.edit', ['academicYear' => $academicYear, 'academicYearUpdate' => $academicYearUpdate]);
    }


    /**
     * @param Request $request
     * @param AcademicYear $academicYear
     * @param $updateID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, AcademicYear $academicYear, $updateID)
    {
        $this->authorize('update', $academicYear);

        $academicYearUpdate = AcademicYearUpdate::findOrFail($updateID);

        $this->validate($request, [
            'title' => 'required',
            'update' => 'required',
        ]);

        $academicYearUpdate->title = $request->title;
        $academicYearUpdate->update = $request->update;
        $academicYearUpdate->save();

        return redirect()->route('academic_years.show', ['academicYear' => $academicYear, 'type' => 'updates'])->with(['toastr' => $this->toastSuccess('Update is succesvol geupdate')]);
    }

    /**
     * @param AcademicYear $academicYear
     * @param $updateID
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(AcademicYear $academicYear, $updateID)
    {
        $this->authorize('update', $academicYear);

        $academicYearUpdate = AcademicYearUpdate::findOrFail($updateID);
        $academicYearUpdate->delete();

        return redirect()->route('academic_years.show', ['academicYear' => $academicYear, 'type' => 'updates'])->with(['toastr' => $this->toastSuccess('Update is succesvol verwijderd')]);
    }
}
