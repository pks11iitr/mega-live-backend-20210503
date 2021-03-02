<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Models\LikeDislike;
use App\Models\User;
use App\Services\Notification\FCMNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AutomaticLikes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'automatic:likes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $date=date('Y-m-d H:i:s', strtotime('-1 minute'));
        $customer=Customer::where('account_type', 'USER')
            ->where('last_active', '>', $date)
            ->orderBy('last_active', 'desc')->get();
        foreach($customer as $c){

            $date=date('Y-m-d H:i:s', strtotime('-1 minute'));
            $c->refresh();
            //if user active in last minute
            if($date <= $c->last_active){
                $likes=LikeDislike::where('receiver_id', $c->id)->where('created_at', '>', $date)->first();
                //if no like received in last minute
                if(!$likes){
                    $ausers=Customer::where('account_type', 'ADMIN')
                        ->whereDoesntHave('likeddisliked', function($likes) use ($c){
                        $likes->where('receiver_id', $c->id);
                    })
                        ->inRandomOrder()
                        ->paginate(2);

                    foreach($ausers as $a){
                        LikeDislike::updateOrCreate([
                            'sender_id'=>$a->id,
                            'receiver_id'=>$c->id,
                        ], ['type'=>1]);

                        $c->notify(new FCMNotification($a->name.' likes your profile', $a->name.' likes your profile', ['type'=>'automatic-like', 'name'=>$a->name, 'image'=>$a->image], 'likes_screen'));
                    }


                }
            }
        }


    }
}
