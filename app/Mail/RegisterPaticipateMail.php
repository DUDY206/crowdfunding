<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterPaticipateMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $fullname;
    protected $email;
    protected $phone;
    protected $dateOfBirth;
    protected $position;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->fullname = $data['fullname'];
        $this->email = $data['email'];
        $this->phone = $data['phone'];
        $this->dateOfBirth = $data['date_of_birth'];
        $this->position = $data['position'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('investor.email.register')->with([
            'fullname' => $this->fullname,
            'email' => $this->email,
            'phone' => $this->phone,
            'dateOfBirth' => $this->dateOfBirth,
            'position' => $this->position
        ]);
    }
}
