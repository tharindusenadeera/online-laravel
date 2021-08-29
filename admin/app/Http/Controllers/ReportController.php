<?php

namespace App\Http\Controllers;

use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\MenuOptionCategory;
use App\Models\Order;
use App\Models\Report;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    

    public function getDailyOrderSummary()
    {
        // $today = Carbon::now()->toDateString();

        // whereDate('created_at', $today)
        $orders = Order::whereIn('status',['completed','settled'])->with('customer', 'ordermenuitems')->get();
        $orders->makeHidden('ordermenuitems');
        // $canceled=$orders->where('status','canceled');
        $total = $orders->sum('total');

        // return $canceled;
        return view('reports.index', compact('orders', 'total'));
    }
}
