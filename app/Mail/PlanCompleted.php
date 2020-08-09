<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PlanCompleted extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $planName;
    private $amount;
    private $userFirstName;
    public function __construct($planName, $amount, $userFirstName)
    {
        $this->planName = $planName;
        $this->amount = $amount;
        $this->userFirstName = $userFirstName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // email needs some details about the plan, plan name and amount. then user first name.
        return $this->subject('Your Plan Is Ready For Rollover.')
            ->markdown('emails.plan.completed')->with(['planName' => $this->planName, 
            'amount' => $this->amount, 'userFirstName' => $this->userFirstName]);
    }
}
