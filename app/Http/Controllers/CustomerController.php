<?php

namespace App\Http\Controllers;

class CustomerController extends Controller
{
    public function index()
    {
        $customer = auth('customer')->user();

        return view('customer.dashboard', compact('customer'));
    }
}
