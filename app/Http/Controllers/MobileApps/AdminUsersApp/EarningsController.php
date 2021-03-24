<?php

namespace App\Http\Controllers\MobileApps\AdminUsersApp;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EarningsController extends Controller
{
    public function earnings(Request $request){
        $user=$request->user;
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
            ->groupBy(DB::raw('DATE(created_at)'))
            ->whereIn('type',['text', 'image'])
            ->orderBy(DB::raw('DATE(created_at)'), 'desc')
            ->select(DB::raw('DATE(created_at) as date'))
            ->paginate(20);

        return [
            'status'=>'success',
            'data'=>compact('chats')
        ];
    }
}
