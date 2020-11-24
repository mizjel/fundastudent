<?php

use Illuminate\Database\Seeder;
use App\AcademicYear;
use App\ProjectCategory;
use App\User;
use App\Guest;
use Illuminate\Support\Facades\DB;

class AcademicYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'verified@test.nl')->first();

        for($i = 0; $i < 20; $i++){

            //Create year
            $academic_year = factory(AcademicYear::class)->create([
                'user_id' => $user,
                'school_id' => \App\School::inRandomOrder()->first()->id,
                'enrollment_id' => \App\Enrollment::inRandomOrder()->first()->id,
                'academic_year_period_id' => \App\AcademicYearPeriod::inRandomOrder()->first()->id,
            ]);

            //Create donations
            factory(\App\Donation::class, 10)->create([
                'academic_year_id' => $academic_year->id,
            ]);

            //Create goals
            factory(\App\AcademicYearGoal::class, 5)->create([
                'academic_year_id' => $academic_year->id
            ]);

            //Create updates
            factory(\App\AcademicYearUpdate::class, 5)->create([
                'academic_year_id' => $academic_year->id
            ]);

        }
    }
}
