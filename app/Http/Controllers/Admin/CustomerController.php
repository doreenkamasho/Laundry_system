<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = User::where('role_id', 2)
            ->with('customer')
            ->paginate(10);

        return view('admin.users.customers.index', compact('customers'));
    }
}