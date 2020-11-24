<?php

namespace App\Mail;

use App\Donation;
use App\Services\AmountServiceTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DonationPaidMail extends Mailable
{
    use Queueable, SerializesModels, AmountServiceTrait;


    public $donation, $amount;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Donation $donation)
    {
        $this->donation = $donation;
        $this->amount = $this->getReadableAmount($donation->amount);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(trans('email.basics.subject', ['subject' => 'Bedankt voor je donatie']))->view('email.donations.paid');
    }
}
