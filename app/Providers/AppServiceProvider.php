<?php

namespace App\Providers;

use App\AcademicYearPeriod;
use App\Enrollment;
use App\School;
use App\Services\AcademicYearServiceTrait;
use App\Services\AcademicYearServiceClass;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    use AcademicYearServiceTrait;
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Check if 2 selectors: school_type and school->school_type_id are equal
        Validator::extend('has_school_type', function ($attribute, $value, $parameters, $validator) {

            //Parameters[0]
            $selected_school_type = $parameters[0];
            $check = $parameters[1];

            $check = $check == 'school' ? School::find($value) : Enrollment::find($value);

            //Return. If School type id == to selected school type
            return $check->school_type_id == $selected_school_type ? true : false;

        });

        //Check if study period is not in progress at the moment
        Validator::extend('is_period_allowed', function($attribute,$value){
            $academic_period = AcademicYearPeriod::findOrFail($value);
            return $this->isPeriodAllowed($academic_period);
        });

        //Check if number is valid amount, number valid with comma
        Validator::extend('is_valid_amount', function ($attribute, $value) {
            return preg_match('/^\d{1,13}(\,\d{1,2})?$/', $value);
        });

        //Check for the minimum amount
        Validator::extend('min_amount', function ($attribute, $value, $parameters) {
            return intval($value) >= $parameters[0];
        });

        Validator::replacer('min_amount', function($message, $attribute, $rule, $parameters) {
            $min_amount = $parameters[0];

            return str_replace(':min_amount', $min_amount, $message);
        });

        //Alphabetic characters and spaces allowed in this rule
        Validator::extend('alpha_spaces', function ($attribute, $value) {
            // This will only accept alpha and spaces.
            return preg_match('/^[\pL\s]+$/u', $value);
        });

        //Check if the mail is a student mail by the allowed extensions
        Validator::extend('is_student_mail', function ($attribute, $value, $parameters, $validator) {
            $is_student_mail = false;

            //Parameters[0] = student_school
            $student_school_id = array_get($validator->getData(), $parameters[0]);

            //Put all extensions in 1 array
            $mail_extensions = array_pluck(School::find($student_school_id)->mailExtensions, 'extension');

            // Make sure the address is valid
            $explodedEmail = explode('@', $value);
            $domain = array_pop($explodedEmail);

            if (in_array($domain, $mail_extensions)) {
                $is_student_mail = true;
            }

            return $is_student_mail;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
