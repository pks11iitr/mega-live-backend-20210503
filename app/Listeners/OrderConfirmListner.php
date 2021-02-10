<?php

namespace App\Listeners;

use App\Events\OrderConfirmed;
use App\Mail\SendMail;
use App\Models\Notification;
use App\Models\Order;
use App\Services\Notification\FCMNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class OrderConfirmListner
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  OrderConfirmed  $event
     * @return void
     */
    public function handle(OrderConfirmed $event)
    {
        $order=$event->order;

        $this->sendNotifications($order);

    }


    public function sendNotifications($order){

        $message='';
        if($order->entity_type == 'App\Models\Coin'){
            $message='Congratulations! Your coin purchase of Rs. '.$order->amount.' at Matchon is successful. Order Reference ID: '.$order->refid;
        }else if($order->entity_type == 'App\Models\Membership'){
            $message='Congratulations! Your membership subscription of Rs. '.$order->amount.' at Matchon is successful. Order Reference ID: '.$order->refid;

        }

        $user=$order->customer;

        $user->notify(new FCMNotification('Order Successful', $message, ['type'=>'Coin']));
    }
}
