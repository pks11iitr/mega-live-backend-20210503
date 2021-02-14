<?php

namespace App\Console\Commands;

use App\Models\Customer;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AutomaticLikes extends Command
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
        //$date=
        $customer=Customer::where('account_type', 'USER')
            ->whereDoesntHave('likesdislikes', function($likedislike){
                $likedislike->where('type',1)
                    ->where(DB::raw('DATE(likes_dislikes.created_at)'), date('Y-m-d'));
            })->where('last_active', '>');
    }
}
