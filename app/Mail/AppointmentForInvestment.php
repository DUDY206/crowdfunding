<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentForInvestment extends Mailable
{
    use Queueable, SerializesModels;
    protected $array;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->array = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('investor.email.appointment-investment')->subject("BestB Crowdfunding | Hẹn lịch tư vấn")->with([
            'information' => $this->array,
        ]);
    }
}
