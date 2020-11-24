<?php

use Illuminate\Database\Seeder;
use App\SchoolLevel;
use App\School;
use App\SchoolMailExtension;
use App\Enrollment;

class SchoolsAndMailExtensionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Create school years
        $periods = [
            [
                'period' => '2016/2017',
                'begin_date' => '2016-09-01',
                'end_date' => '2017-07-30',
            ],
        ];
        foreach ($periods as $period) {
            \App\AcademicYearPeriod::create([
                'period' => $period['period'],
                'begin_date' => $period['begin_date'],
                'end_date' => $period['end_date'],
            ]);
        }
        
//        $mbo = SchoolLevel::create(['level' => 'MBO']);
        $hbo = SchoolLevel::create(['level' => 'HBO']);
//        $uni = SchoolLevel::create(['level' => 'Universiteit']);

//        $mbo_enrollments = ['Applicatieontwikkelaar', 'After Sales', 'Rechercheur', 'Beveiliging', 'Kapper', 'Administratie', 'Media Creation'];
//
//        foreach ($mbo_enrollments as $mbo_enrollment){
//            $a_enrollment = Enrollment::create([
//                'enrollment' => $mbo_enrollment,
//                'school_level_id' => $mbo->id,
//            ]);
//        }

        $hbo_enrollments = ['HBO ICT', 'Journalistiek', 'Communicatie', 'Hotel Management', 'Logistiek en Economie', 'Logistics Engineering'];

        foreach ($hbo_enrollments as $hbo_enrollment){
            $a_enrollment = Enrollment::create([
                'enrollment' => $hbo_enrollment,
                'school_level_id' => $hbo->id,
            ]);
        }

//        $uni_enrollments = ['Game Technology', 'Media', 'Tourism', 'Imagineering', 'Leisure', 'Middle East'];

//        foreach ($uni_enrollments as $uni_enrollment){
//            $a_enrollment = Enrollment::create([
//                'enrollment' => $uni_enrollment,
//                'school_level_id' => $uni->id,
//            ]);
//        }
//
//        //Seeding MBO SCHOOLS -BEGIN-
//        $schools =
//            [
//                [
//                    'name' => 'Cibab Zwolle',
//                    'extensions' => ['cibab.nl','student.cibab.nl'],
//                ],
//                [
//                    'name' => 'Aventus Apeldoorn',
//                    'extensions' => ['student.aventus.nl','aventus.nl'],
//                ],
//                [
//                    'name' => 'Deltion Zwolle',
//                    'extensions' => ['student.deltion.nl','deltion.nl'],
//                ]
//            ];
//
//        foreach ($schools as $school){
//
//            $a_school = factory(School::class)->create([
//                'name' => $school['name'],
//                'school_level_id' => $mbo->id,
//            ]);
//
//            foreach ($school['extensions'] as $extension){
//                SchoolMailExtension::create([
//                    'school_id' => $a_school->id,
//                    'extension' => $extension
//                ]);
//            }
//        }
        //Seeding MBO SCHOOLS -END-

        //Seeding HBO SCHOOLS -BEGIN-
        $schools =
            [
                [
                    'name' => 'Windesheim Zwolle',
                    'extensions' => ['student.windesheim.nl','windesheim.nl'],
                ],
//                [
//                    'name' => 'Windesheim Flevoland',
//                    'extensions' => ['student.windesheimflevo.nl','windesheimflevo.nl'],
//                ],
//                [
//                    'name' => 'Hanz Zwolle',
//                    'extensions' => ['student.hanz.nl','hanz.nl'],
//                ]
            ];

        foreach ($schools as $school){

            $a_school = factory(School::class)->create([
                'name' => $school['name'],
                'school_level_id' => $hbo->id,
            ]);

            foreach ($school['extensions'] as $extension){
                SchoolMailExtension::create([
                    'school_id' => $a_school->id,
                    'extension' => $extension
                ]);
            }
        }
        //Seeding HBO SCHOOLS -END-


        //Seeding UNI SCHOOLS -BEGIN-
//        $schools =
//            [
//                [
//                    'name' => 'Universiteit Leiden',
//                    'extensions' => ['student.leiden.nl','leiden.nl'],
//                ],
//                [
//                    'name' => 'Universiteit Utrecht',
//                    'extensions' => ['student.utrecht.nl','utrecht.nl'],
//                ],
//            ];
//
//        foreach ($schools as $school){
//
//            $a_school = factory(School::class)->create([
//                'name' => $school['name'],
//                'school_level_id' => $uni->id,
//            ]);
//
//            foreach ($school['extensions'] as $extension){
//                SchoolMailExtension::create([
//                    'school_id' => $a_school->id,
//                    'extension' => $extension
//                ]);
//            }
//        }
        //Seeding UNI SCHOOLS -END-
    }
}
