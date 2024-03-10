<?php

namespace App\Http\Controllers;
use App\Models\Order;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
{
    $orders = Order::all();
    
    return view('dash', compact('orders'));
}

}
