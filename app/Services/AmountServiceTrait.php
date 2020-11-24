<?php

namespace App\Services;


trait AmountServiceTrait
{


    //Format amount, to readable amount.
    public function getReadableAmount($amount){
        $amount = number_format($amount, 2, ',', '.');

        return '€' . $amount;
    }

    //Get percentage of amount
    public function getAmountWithPercentage($amount, $percentage = 100){

        if($percentage <= 0 || $percentage > 100){
            $percentage = 100;
        }

        //bcdiv. 5.387 becoumes 5.38 instead of 5.39 when using number_format
        /**
         * instead of floor we van use bcdiv($amount,1,2)
         */
        $amount =  $this->getValidAmountForDB(floor((($percentage / 100) * $amount) * 100) / 100);

        return $amount;
    }


    /**
     * @param $amount
     * Returns valid number for the database. Example: 5,50 = 5.50
     * str_replace because number format accepts only number with (dot) instead of (comma)
     */
    public function getValidAmountForDB($amount){
        return number_format(str_replace( ',', '.', $amount), 2, '.', '');
    }

    /**
     * @param $amount
     * Returns valid number for input field. Example. 5.50 = 5,50
     */
    public function getValidAmountForInput($amount){
        return number_format($amount, 2, ',', '');
    }
}