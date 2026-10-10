<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(): View
    {
        return view('admin.index', [
            'usersByRole' => User::selectRaw('role, count(*) as total')->groupBy('role')->pluck('total', 'role'),
            'productCount' => Product::count(),
            'orderCount' => Order::count(),
            'revenue' => Order::whereIn('status', ['paid', 'shipped', 'completed'])->sum('total'),
        ]);
    }
}
