<?php


namespace App\Services;

use App\AcademicYear;

trait AcademicYearServiceTrait
{
    public function getPercentageTotalPayments(AcademicYear $academicYear){
        //Example: (totalpayments) = 1000 / (funds_required) 1500 / 100 = 15
        $percentage = round($academicYear->donations->where('paid', 1)->sum('amount') / ($academicYear->goals->sum('amount') / 100));

        //Percentage > 100, return 100 else, the percentage
        return $percentage > 100 ? 100 : $percentage;
    }
    //Return total funded amount
    public function getTotalPaidDonations(AcademicYear $academicYear){
        $donations = $academicYear->donations;
        $amountTotal = 0;
        foreach($donations as $donation){
            if($donation->paid){
                $amountTotal += $donation->amount;
            }
        }
        return $amountTotal;
    }
    public function getTimesPaid(AcademicYear $academicYear){

    }
    //Returns days left string
    public function getDaysLeftString(AcademicYear $academicYear){
        if ($this->isValidPeriod($academicYear->academic_year_period)) {
            //Period is valid, return days left
            return date_diff(date_create(date('Y-m-d')), date_create($academicYear->academic_year_period->end_date))->days;
        }else{
            // Period not valid
            return 'Periode afgelopen';
        }
    }

    //Check if today date is between the academic period.
    public function isValidPeriod($academic_year_period){
        return (date('Y-m-d') >= $academic_year_period->begin_date) && (date('Y-m-d') <= $academic_year_period->end_date);
    }
    //Check if period end date has already expired
    public function isPeriodAllowed($academic_year_period){
        return (date('Y-m-d') <= $academic_year_period->end_date);
    }

}