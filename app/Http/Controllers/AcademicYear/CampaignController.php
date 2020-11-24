<?php

namespace App\Http\Controllers\AcademicYear;

use App\AcademicYear;
use App\Services\ToastrServiceTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CampaignController extends Controller
{
    use ToastrServiceTrait;
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AcademicYear  $academicYear
     * @return \Illuminate\Http\Response
     */
    public function edit(AcademicYear $academicYear)
    {
        $this->authorize('update', $academicYear);

        return view('academic_year.campaign.edit', ['academicYear' => $academicYear]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AcademicYear  $academicYear
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AcademicYear $academicYear)
    {
        $this->authorize('update', $academicYear);

        $academicYear = AcademicYear::findOrFail($academicYear->id);

        $this->validate($request, [
            'title' => 'required',
            'short_description' => 'required',
            'thumbnail_url' => 'nullable|image|dimensions:min_width=100,min_height=100',
            'full_description' => 'required',
        ]);


        //new thumbnail is set, delete old from server and store the new one. $thumbnail holds now the path
        if($request->thumbnail_url != null){
            Storage::delete($academicYear->thumbnail_url);
            $thumbnail = $request->file('thumbnail_url')->store('thumbnails');

            $academicYear->thumbnail_url = $thumbnail;
        }

        $academicYear->title = $request->title;
        $academicYear->short_description = $request->short_description;
        $academicYear->full_description = $request->full_description;

        $academicYear->save();

        return redirect()->route('academic_years.show', ['academicYear' => $academicYear])->with(['toastr' => $this->toastSuccess('Campagne is succesvol geupdate')]);
    }

}
