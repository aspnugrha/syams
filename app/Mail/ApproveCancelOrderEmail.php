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
    public $url,$company_profile,$customer,$orders,$access_from;

    public function __construct($customer, $orders, $url, $access_from, $company_profile)
    {
        $this->url = $url;
        $this->company_profile = $company_profile;
        $this->customer = $customer;
        $this->orders = $orders;
        $this->access_from = $access_from;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = '';
        if($this->access_from == 'backend'){
            if($this->orders->status == 'APPROVED') {
                $subject = 'Congratulations, your '.strtolower($this->orders->order_type).' request has been accepted.';
            }else{
                $subject = 'Sorry, at this time we cannot accept your '.strtolower($this->orders->order_type).' request.';
            }
        }else{
            $subject = 'Your '.strtolower($this->orders->order_type).' request has been successfully cancelled.';
        }

        return $this->view('frontend.email.approve-cancel-order')
        ->subject($subject)
        ->with([
            'access_from' => $this->access_from,
            'url' => $this->url,
            'company_profile' => $this->company_profile,
            'customer' => $this->customer,
            'orders' => $this->orders,
        ]);
    }
}
