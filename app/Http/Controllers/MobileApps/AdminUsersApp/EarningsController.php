<?php

namespace App\Http\Controllers\MobileApps\AdminUsersApp;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Earning;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EarningsController extends Controller
{
    public function earnings(Request $request){
        $user=$request->user;

        $earnings=Earning::where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->select('date', 'count', 'coins')
            ->paginate(50);

        return [
            'status'=>'success',
            'data'=>compact('earnings')
        ];
    }
}
