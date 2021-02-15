<?php

namespace App\Console\Commands;

use App\Models\Chat;
use App\Models\LikeDislike;
use App\Services\Notification\FCMNotification;
use Illuminate\Console\Command;

class AutomaticMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

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
        $date=date('Y-m-d', strtotime('-1 minute'));
        $likes=LikeDislike::with(['sender', 'receiver'])
            ->where('status', '!=', 'completed')
            ->whereHas('receiver', function($receiver) use($date){
                    $receiver->where('last_active', '>=', $date)->where('account_type','ADMIN');
                })
            ->get();

        foreach($likes as $l){
            $messages=explode('***', $l->sender->system_messages);
            if(isset($messages[$l->status])){
                $i=intval($l->status);
                while(isset($messages[$i])){
                    Chat::create([
                        'user_1'=>($l->sender->id < $l->receiver->id)?$l->sender->id:$l->receiver->id,
                        'user_2'=>($l->sender->id < $l->receiver->id)?$l->receiver->id:$l->sender->id,
                        'direction'=>($l->sender->id < $l->receiver->id)?0:1,
                        'message'=>$messages[$i],
                        'type'=>'text'
                    ]);
                    $i++;
                }

                $l->receiver->notify(new FCMNotification($l->sender->name.' send you a message', $messages[$i-1], ['type'=>'automatic-like', 'name'=>$l->sender->name, 'image'=>$l->sender->image]));

            }
            $l->status='completed';
            $l->save();
        }




    }
}
