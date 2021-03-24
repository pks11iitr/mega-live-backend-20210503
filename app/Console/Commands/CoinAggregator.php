<?php

namespace App\Console\Commands;

use App\Models\CallRecord;
use App\Models\Chat;
use App\Models\CoinWallet;
use App\Models\Customer;
use App\Models\Earning;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CoinAggregator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:earnings';

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
        $date=date('Y-m-d', '-1 days');

        $users=Customer::where('account_type', 'ADMIN')->get();

        foreach($users as $user){
            $chats=Chat::where(function($chats) use ($user){
                $chats->where(function($query) use($user){
                    $query->where('user_1', $user->id)
                        ->where('direction', 1);
                })
                    ->orWhere(function($query) use($user){
                        $query->where('user_2', $user->id)
                            ->where('direction', 0);
                    });
            })
                ->where(DB::raw('DATE(created_at)'), $date)
                ->whereIn('type',['text', 'image'])
                ->count();

            if($chats>0)
                Earning::create([
                    'user_id'=>$user->id,
                    'type'=>'chat',
                    'count'=>$chats,
                    'coins'=>$chats,
                    'date'=>$date
                ]);

            $gifts=CoinWallet::where('receiver_id', $user->id)
                ->whereNotNull('gift_id')
                ->where(DB::raw('DATE(created_at)'), $date)
                ->select(DB::raw('count(*) as count'), DB::raw('sum(coins) as coins'))
                ->get();
            if(count($gifts))
                if($gifts[0]->count>0)
                    Earning::create([
                        'user_id'=>$user->id,
                        'type'=>'gifts',
                        'count'=>$gifts[0]->count,
                        'coins'=>$gifts[0]->coins,
                        'date'=>$date
                    ]);

            $videocalls=CallRecord::where(function($query)use($user){
                $query->where('caller_id',$user->id)->orWhere('callee_id', $user->id);
            })
                ->where(DB::raw('DATE(created_at)'), $date)
                ->where('minutes', '>', 0)
                ->where('type', 'VIDEO')
                ->select(DB::raw('sum(minutes) as minutes'), DB::raw('sum(coins) as coins'))
                ->get();
            if(count($videocalls))
                if($videocalls[0]->minutes>0)
                    Earning::create([
                        'user_id'=>$user->id,
                        'type'=>'gifts',
                        'count'=>$videocalls[0]->minutes,
                        'coins'=>$videocalls[0]->coins,
                        'date'=>$date
                    ]);

            $audiocalls=CallRecord::where(function($query)use($user){
                $query->where('caller_id',$user->id)->orWhere('callee_id', $user->id);
            })
                ->where(DB::raw('DATE(created_at)'), $date)
                ->where('minutes', '>', 0)
                ->where('type', 'CALL')
                ->select(DB::raw('sum(minutes) as minutes'), DB::raw('sum(coins) as coins'))
                ->get();
            if(count($audiocalls))
                if($audiocalls[0]->minutes>0)
                    Earning::create([
                        'user_id'=>$user->id,
                        'type'=>'gifts',
                        'count'=>$audiocalls[0]->minutes,
                        'coins'=>$audiocalls[0]->coins,
                        'date'=>$date
                    ]);
        }


    }
}
