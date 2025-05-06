<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $customer = auth()->user();
        return view('customer.dashboard', compact('customer'));
    }
}