<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentContactMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $fullname;
    protected $email;
    protected $phone;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->fullname = $data['full_name'];
        $this->email = $data['email'];
        $this->phone = $data['phone_number'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('investor.email.payment-contact')->subject("BestB Crowdfunding | Đăng ký liên hệ thanh toán trực tiếp")->with([
            'fullname' => $this->fullname,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);
    }
}
