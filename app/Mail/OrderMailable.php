<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderMailable extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $file_contract;
    protected $invest_name;
    protected $invest_type;
    protected $amount;
    protected $order_contract_url;
    protected $full_name;
    protected $order_id;
    protected $payment_contact;

    public function __construct($file_contract, $invest_name, $invest_type, $amount, $order_contract_url, $full_name, $order_id, $payment_contact)
    {
        $this->file_contract = $file_contract;
        $this->invest_name = $invest_name;
        $this->invest_type = $invest_type;
        $this->amount = $amount;
        $this->order_contract_url = $order_contract_url;
        $this->full_name = $full_name;
        $this->order_id = $order_id;
        $this->payment_contact = $payment_contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        while (true) {
	        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $this->amount);
	        if ($replaced != $this->amount) {
	            $this->amount = $replaced;
	        } else {
	            break;
	        }
	    }

        return $this->view('investor.orderMail')->subject("BestB Crowdfunding | Xác Nhận Đầu Tư Nội dung")->with([
            'invest_name' => $this->invest_name,
            'invest_type' => $this->invest_type,
            'amount' => $this->amount,
            'order_contract_url' => $this->order_contract_url,
            'full_name' => $this->full_name,
            'order_id' => $this->order_id,
            'payment_contact' => $this->payment_contact,
        ])->attach($this->file_contract);
    }
}
