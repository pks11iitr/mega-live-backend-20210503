<?php

namespace App\Http\Controllers\CallerAdmin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\Customer;
use App\Services\Notification\FCMNotification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::where(function ($customers) use ($request) {
            $customers->where('name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('mobile', 'LIKE', '%' . $request->search . '%')
                ->orWhere('email', 'LIKE', '%' . $request->search . '%');
        });

        if ($request->fromdate)
            $customers = $customers->where('created_at', '>=', $request->fromdate . ' 00:00:00');

        if ($request->todate)
            $customers = $customers->where('created_at', '<=', $request->todate . ' 23:59:50');

        if ($request->status)
            $customers = $customers->where('status', $request->status);

        if ($request->ordertype)
            $customers = $customers->orderBy('created_at', $request->ordertype);

        $customers = $customers->where('account_type', 'USER')
            ->orderBy('last_active', 'DESC')
            ->paginate(10);

        return view('caller-admin.customer.view', ['customers' => $customers]);
    }
}
