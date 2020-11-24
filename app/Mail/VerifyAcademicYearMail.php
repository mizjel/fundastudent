<?php

namespace App\Mail;

use App\AcademicYear;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyAcademicYearMail extends Mailable
{
    use Queueable, SerializesModels;

    public $academicYear;

    /**
     * VerifyAcademicYearMail constructor.
     * @param AcademicYear $academicYear
     */
    public function __construct(AcademicYear $academicYear)
    {
        $this->academicYear = $academicYear;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(trans('email.basics.subject', ['subject' => 'Aangemeld schooljaar verifiëren']))->view('email.verify.academic_year');
    }
}
