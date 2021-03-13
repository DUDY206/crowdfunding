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

    public function __construct($file_contract,$invest_name,$invest_type,$amount,$order_contract_url)
    {
        $this->file_contract = $file_contract;
        $this->invest_name = $invest_name;
        $this->invest_type = $invest_type;
        $this->amount = $amount;
        $this->order_contract_url = $order_contract_url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('investor.orderMail')->with([
            'invest_name' => $this->invest_name,
            'invest_type' => $this->invest_type,
            'amount' => $this->amount,
            'order_contract_url' => $this->order_contract_url,
        ])->attach($this->file_contract);
    }
}
