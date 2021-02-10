<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function index(Request $request){

        $payments=Payment::with(['customer','entity'])
            ->where('is_complete', true)
            ->orderBy('id', 'desc')
            ->paginate(50);

    }
}
