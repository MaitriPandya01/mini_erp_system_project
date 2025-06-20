<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\SalesOrder;
Use App\Models\SalesOrderItems;
Use App\Models\Product;


class HomeController extends Controller
{
    public function index()
    {
        $totalOrders = SalesOrder::count();
        $confirmedOrders = SalesOrder::where('is_confirmed',1)->count();
        $totalSales = SalesOrder::sum('total');
        $lowStockProducts = Product::where('quantity', '<=', 5)->get();
        return view('dashboard',compact('totalOrders','confirmedOrders','totalSales','lowStockProducts'));

    }
}
