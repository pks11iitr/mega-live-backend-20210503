<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Services\Notification\FCMNotification;
use Illuminate\Console\Command;

class CallNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'call:notifications';

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
        $users=Customer::where('account_type', 'USER')
            ->where('last_active','<',$date)
            ->where('membership_expiry', '!=', null)
            ->where('membership_expiry', '<', date('Y-m-d'))
            ->get();

        $auser=Customer::where('account_type', 'ADMIN')
            ->inRandomOrder()
            ->first();

        foreach($users as $u){
            $u->notify(new FCMNotification('Video Call', 'Call From '.$auser->name, ['type'=>'auto-call', 'name'=>$auser->name, 'image'=>$auser->image]));
        }

    }
}
