<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderDetail extends Mailable
{
    use Queueable, SerializesModels;
    public $orderId;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($orderId)
    {
        //
        $this->orderId=$orderId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $order=Order::getAllOrder($this->orderId);
        return $this->view('page.pdf',compact('order',$order));
    }
}
