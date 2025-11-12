<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendHistoryBookingEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->view('mail.template')
            ->with([
                'order' => $this->order,
                'order_items' => $this->order->orderItems,
            ]);
    }
}
