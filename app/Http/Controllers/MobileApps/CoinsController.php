<?php

namespace App\Http\Controllers\MobileApps;

use App\Http\Controllers\Controller;
use App\Models\Coin;
use Illuminate\Http\Request;

class CoinsController extends Controller
{
    public function coins()
    {
        $coins = Coin::active()->get();
        if ($coins->count() > 0) {
            return [
                'status' => 'success',
                'message' => 'success',
                'data' => compact('coins')
            ];
        } else {
            return [
                'status' => 'failed',
                'message' => 'No Record Found',

            ];

        }

    }

}


