<?php

use Illuminate\Database\Seeder;

class PayoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (\App\AcademicYear::all() as $academicYear) {
            for($i = 0 ; $i < 10; $i++){
                \App\Payout::create([

                ]);
            }
        }
    }
}
