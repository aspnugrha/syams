<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApproveCancelOrderEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $url,$company_profile,$customer,$orders;

    public function __construct($customer, $orders, $url, $company_profile)
    {
        $this->url = $url;
        $this->company_profile = $company_profile;
        $this->customer = $customer;
        $this->orders = $orders;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('frontend.email.approve-cancel-order')
        ->subject(
            ($this->orders->status == 'APPROVED') ?
            'Congratulations, your '.strtolower($this->orders->order_type).' request has been accepted.' :
            'Sorry, at this time we cannot accept your '.strtolower($this->orders->order_type).' request.'
        )
        ->with([
            'url' => $this->url,
            'company_profile' => $this->company_profile,
            'customer' => $this->customer,
            'orders' => $this->orders,
        ]);
    }
}
